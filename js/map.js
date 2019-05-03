(function(jQuery) {
  var COUNTRY_TYPE = 'country';
  var PROJECT_TYPE = 'project';
  var geoCountries;
  var map;
  var selectedObject;
  var layerMarker;
  var institutionsMarker = [];
  var countryMarker;
  var dariahMapData;
  var popup;
  var themePath = '/wp-content/themes/thefox-child/';

  var projectIcon;
  var countryIcon;

  var createMarkers = function() {
    dariahMapData.institutions
      .map(function(institution) {
        if (institution.latitude === '' || institution.longitude === '') {
          return;
        }
        institutionsMarker.push(
          L.marker([institution.latitude, institution.longitude], {
            icon: projectIcon,
            institution: institution
          }).on('click', onMarkerClick)
        );
      });
    layerMarker = L.layerGroup(institutionsMarker).addTo(map);

    setTimeout(function() {
      jQuery('#mapContainer .loader').fadeOut('300', function() {
         jQuery('#mapContainer').removeClass('loading');
      });
    }, 500);
  };

  var onMarkerClick = function(event) {
    var institution = event.target.options.institution;
    var projects = institution.coordinators || institution.projects;
    if (selectedObject && institution.coordinators && institution.projects) {
      projects = institution.coordinators.concat(institution.projects);
    }
    if (projects.length > 1) {
      displayInstitutionInformation(institution, projects, event.target);
    } else {
      window.alert('No Project for ' + institution.name);
    }
  };

  var initMap = function() {
    map = L.map('dariahMap', {
      scrollWheelZoom: false,
      minZoom: 3,
      maxZoom: 16
    });
    var viewCenter = {
      lat: window.innerWidth < 768 ? 55 : 50,
      lng: window.innerWidth < 768 ? 4 : -18
    };
    map.setView(viewCenter, window.innerWidth <=768 ? 3 : 4);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map);

    geoCountries = L.geoJson(euCountries, { onEachFeature: onEachFeature}).addTo(map);
    createMarkers();

    var legend = L.control();
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
            colors = ["Member Countries", "Cooperating Partners"],
            labels = ["members", "cooperating-partners"];

        // loop through our density intervals and generate a label with a colored square for each interval
        for (var i = 0; i < colors.length; i++) {
            div.innerHTML += '<i class="' + labels[i] + '"></i> ' + colors[i] + '<br>';
        }
        return div;
    };
    legend.addTo(map);
  };

  var initWindow = function() {
    jQuery('#dariahWindow ul a').on('click', onTabClick);

    jQuery('#dariahWindow .close').on('click', function(event) {
      var scr = jQuery(window).scrollTop();
      event.preventDefault();
      event.stopPropagation();

      mapEnable();
      selectType();
      jQuery('#dariahIntro').show();
      window.location.hash = "";
      jQuery(window).scrollTop(scr);
    });

    selectType();

    if(window.location.hash) {
        onCountryAnchor(window.location.hash.substring(1).toUpperCase());
    }
  };

  function onTabClick(event) {
    event.preventDefault();
    event.stopPropagation();
    selectTab(jQuery(event.target).data('tab-id'));
  }

  function onEachFeature(feature, layer) {
    layer.on('add', onCountryAdded);
    layer.on('click', onCountryClick);
  }

  function onCountryAdded(event) {
    var layer = event.target;
    var iso3 = layer.feature.properties.ISO3;
    var country = dariahMapData.countries[iso3];
    if (country) {
      jQuery(layer._path).addClass(country.status);
    }
  }

  function onCountryClick(event) {
    var layer = event.target;
    var iso3 = layer.feature.properties.ISO3;
    var country = dariahMapData.countries[iso3];
    if (country) {
      displayCountryInformation(country);
      deleteCountryMarker();
      countryMarker = L.marker([country.capital.latitude, country.capital.longitude], {icon: countryIcon}).addTo(map);
      selectCountry([iso3]);
      window.location.hash = "#" + iso3.toLowerCase();
    }
  }

  function onCountryAnchor(iso3) {
    var country = dariahMapData.countries[iso3];
    displayCountryInformation(country);
    deleteCountryMarker();
    countryMarker = L.marker([country.capital.latitude, country.capital.longitude], {icon: countryIcon}).addTo(map);
    selectCountry([iso3]);
  }

  function centerTo(latlng) {
    var center = map.project(latlng);
    var deltaLat = window.innerWidth < 768 ? 0 : -300;
    var deltaLng = 0;
    center = new L.point(center.x + deltaLat, center.y + deltaLng);
    target = map.unproject(center);
    map.panTo(target);
  }

  function displayInstitutionInformation(institution, projectIDs, marker) {
    // jQuery('#dariahWindow').hide();
    mapDisable();
    jQuery('body').removeClass('fixed');
    var _currentCountry = '';
    for (var countryISO3 in dariahMapData.countries) {
      var country = dariahMapData.countries[countryISO3];
      if (country.id === parseInt(institution.country, 10)) {
        _currentCountry = country.name;
      }
    }
    var html = '<p>' + _currentCountry + '</p>';
    html += '<ul>';
    html +=  dariahMapData.projects
      .filter(function(project) { return projectIDs.indexOf(project.id) !== -1; })
      .map(function(project) { return '<li><a href="#" data-project-id="' + project.id + '" data-institution-id="' + institution.id + '">' + project.name + '</a></li>';})
      .join('');
    html += '</ul>';
    marker.unbindPopup();
    marker.bindPopup(html).openPopup();
  }

  function deleteCountryMarker() {
    if (countryMarker) {
      countryMarker.remove();
    }
  }

  function displayCountryInformation(country) {
    if (!country) {
      jQuery('#dariahWindow').hide();
      jQuery('body').removeClass('fixed');
      return;
    }
    mapDisable();

    showInformationWindow();
    var dariahWindow = jQuery('#dariahWindow');
    selectedCountry = country;
    jQuery(dariahWindow).removeClass();
    jQuery(dariahWindow).addClass(COUNTRY_TYPE);

    jQuery(dariahWindow).find('h1').html(selectedCountry.name + '<span>' + selectedCountry.statusName + '</span>');
    jQuery(dariahWindow).find('li:nth-child(1) a').html('National<br />Coordination');
    jQuery(dariahWindow).find('li:nth-child(2) a').html('Partner<br />Institutions');
    jQuery(dariahWindow).find('li:nth-child(3) a').html('Cooperating<br />Partners');
    jQuery(dariahWindow).find('li:nth-child(4) a').html('DARIAH<br/>nationally');

    var _selectedTab;
    if (selectedCountry.entities.length === 0 && !selectedCountry.national.persons && !selectedCountry.national.institutions && selectedCountry.nationalInstitutions.length === 0 && !selectedCountry.coordinator) {
      jQuery(dariahWindow).find('li:nth-child(1)').hide();
    } else {
      jQuery(dariahWindow).find('li:nth-child(1)').show();
      _selectedTab = 1;
    }

    if (selectedCountry.partnerInstitutions.length === 0) { jQuery(dariahWindow).find('li:nth-child(2)').hide(); }
    else { jQuery(dariahWindow).find('li:nth-child(2)').show(); _selectedTab = _selectedTab ? _selectedTab : 2; }

    if (selectedCountry.cooperatingInstitutions.length === 0) { jQuery(dariahWindow).find('li:nth-child(3)').hide(); }
    else { jQuery(dariahWindow).find('li:nth-child(3)').show(); _selectedTab = _selectedTab ? _selectedTab : 3; }

    if (selectedCountry.countryDescription.length === 0) { jQuery(dariahWindow).find('li:nth-child(4)').hide(); }
    else { jQuery(dariahWindow).find('li:nth-child(4)').show(); _selectedTab = _selectedTab ? _selectedTab : 4; }
    // jQuery(dariahWindow).find('li:nth-child(4)').hide();

    selectTab(_selectedTab);
  }

  function selectCountry(countries) {
    geoCountries.eachLayer(function (layer) {
      if (countries && countries.indexOf(layer.feature.properties.ISO3) !== -1) {
        var center = map.project(layer.getBounds().getCenter());
        if (window.innerWidth > 767) {
         center = new L.point(center.x-250,center.y+0);
        }
         var target = map.unproject(center);
         map.panTo(target);
        jQuery(layer._path).addClass('selected');
      } else {
        jQuery(layer._path).removeClass('selected');
      }
    });
  }

  function selectTab(id) {
    jQuery('#dariahWindow .content').scrollTop(0);
    jQuery('#dariahWindow li').each(function() {
      jQuery(this).removeClass();
      if (jQuery(this).find('a').data('tab-id') == id) {
        jQuery(this).addClass('selected');
      }
    });

    jQuery('#dariahWindow .content').html( contentCountryTab(id) );
    jQuery('#dariahWindow .content a').on('click', onContentLink);
  }

  function onContentLink(event) {
    event.preventDefault();
    event.stopPropagation();
    if (jQuery(event.target).data('institution-id')) {

    } else {
      window.open(jQuery(event.target).attr("href"), '_blank');
    }
  }

  function contentCountryTab(id) {
    var html= '';
    switch (id) {
      case 1:
        var logo = "";
        if(selectedCountry.countryLogo != null) {
          logo = '<img width="100" height="20" src="' + selectedCountry.countryLogo + '" alt="Logo"/>';
          html += logo;
        }

        if (selectedCountry.entities.length !== 0) {
          html += '<p class="point">Representing Entity:';
          html += selectedCountry.entities.map(function(entity) { return '<span>' + entity.name + '</span>'; }).join('');
          html += '</p>';
        }
        if (selectedCountry.national.persons || selectedCountry.national.institutions) {
          html += '<p class="point">National Representative:';
          if (selectedCountry.national.persons) {
            html += selectedCountry.national.persons.map(function(personID) {
              var person = dariahMapData.persons[parseInt(personID, 10)];
              return '<span>' + person.firstname + ' ' + person.lastname + '</span>';
            }).join('');
          }
          if (selectedCountry.national.institutions) {
            html += selectedCountry.national.institutions.map(function(institutionID) {
              var institution = dariahMapData.institutions.filter(function(institution) { return institution.id === parseInt(institutionID, 10); });
              var htmlInstitution = '<span class="ico-marker">' + institution[0].name + '</span>';
              return htmlInstitution;
            }).join('');
          }
          html += '</p>';
        }
        var nationalCoordinating = dariahMapData.institutions
          .filter(function(institution) { return selectedCountry.nationalInstitutions.indexOf(institution.id) !== -1; })
          .sort(sortByName);
        if (nationalCoordinating.length !== 0) {
          html += '<p class="point">National Coordinating Institution:';
          html += nationalCoordinating.map(function(institution) {
            var htmlInstitution = institution.website ? '<a href="' + institution.website + '" class="ico-marker">' + institution.name + '</a>' : '<span class="ico-marker">' + institution.name + '</span>';
            return htmlInstitution;
          }).join('');
          html += '</p>';
        }

        var person = dariahMapData.persons[parseInt(selectedCountry.coordinator, 10)];
        if (person) {
          html += '<p class="point">National Coordinator:';
          if (person.link !== '') {
            html += '<a href="' + person.link + '" class="ico-person">' + person.firstname + ' ' + person.lastname + '</a>';
          } else {
            html += '<span class="ico-person">' + person.firstname + ' ' + person.lastname + '</span>';
          }
          html += '</p>';
        }
        selectInstitutionMarker([]);
        break;
      case 2:
        var _institutions = dariahMapData.institutions
          .filter(function(institution) { return selectedCountry.partnerInstitutions.indexOf(institution.id) !== -1; })
          .sort(sortByName);
        html += '<h2>Partner Institutions:</h2>';
        html += '<ul class="list">';
        html += _institutions.map(function(institution) {
           var li = institution.website ? '<a href="' + institution.website + '">' + institution.name + '</a>' : institution.name;
            return '<li>' + li + '</li>';
          }).join('');
        html += '</ul>';
        selectInstitutionMarker(_institutions.map(function(institution) { return institution.id; }));
        break;
      case 3:
        var _cooperatingInstitutions = dariahMapData.institutions
          .filter(function(institution) { return selectedCountry.cooperatingInstitutions.indexOf(institution.id) !== -1; })
          .sort(sortByName);
        html += '<h2>Cooperating partners:</h2>';
        html += '<ul class="list">';
        html += _cooperatingInstitutions.map(function(institution) {
              var li = institution.website ? '<a href="' + institution.website + '">' + institution.name + '</a>' : institution.name;
              return '<li>' + li + '</li>';
          }).join('');
        html += '</ul>';
        selectInstitutionMarker([]);
        break;
      case 4:
        html += selectedCountry.countryDescription;
        selectInstitutionMarker([]);
        break;
    }

    return html;
  }

  function selectInstitutionMarker(institutionIDs) {
    institutionsMarker.map(function (marker) {
      if (!institutionIDs) {
        if (marker.options.institution.coordinators) {
          layerMarker.addLayer(marker);
        } else if (layerMarker.hasLayer(marker)) {
          layerMarker.removeLayer(marker);
        }
      } else if (institutionIDs.indexOf(marker.options.institution.id) !== -1) {
        layerMarker.addLayer(marker);
      } else if (layerMarker.hasLayer(marker)) {
        layerMarker.removeLayer(marker);
      }
    });
  }

  function selectType() {
    selectedObject = null;
    selectCountry([]);
    deleteCountryMarker();

    jQuery('#dariahWindow').hide();
    jQuery('body').removeClass('fixed');
    map.removeLayer(layerMarker);
    selectInstitutionMarker([]);
  }

  function showInformationWindow() {
    jQuery('#dariahWindow').show();
    if (window.innerWidth < 768) {
      jQuery('html,body').animate({scrollTop: jQuery('#mapContainer').offset().top - jQuery('.mt_menu').height() - 10},'slow');
    }
    jQuery('body').addClass('fixed');
    jQuery('#dariahIntro').hide();
    map.closePopup();
  }

  function mapDisable() {
    map._handlers.forEach(function(handler) {
      handler.disable();
    });
  }

  function mapEnable() {
    map._handlers.forEach(function(handler) {
      handler.enable();
    });
  }

  function sortByName(a, b) {
    var aName = a.name.toLowerCase();
    var bName = b.name.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  jQuery(window).ready(function() {
    if (jQuery('#dariahMap').length !== 0) {
      projectIcon = L.icon({ iconUrl: themePath + 'images/map-leaflet-marker-project-small.png', iconSize: [22, 28], iconAnchor: [11, 24], popupAnchor: [1, -20] });
      countryIcon = L.icon({ iconUrl: themePath + 'images/map-leaflet-marker-country.png', iconSize: [37, 47], iconAnchor: [18, 41], popupAnchor: [-3, -76] });

      jQuery.getJSON(themePath + 'map/dynamic-data.json', function(data) {
        dariahMapData= data;
        initMap();
        initWindow();
      });
    }
  });
})(jQuery);

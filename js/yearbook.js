(function(jQuery) {
  var currentPage = 0;
  var itemPerPage = 10;
  var defaultFilterToShow = 5;
  var dariahYearbookData;
  var totalPages;
  var results = [];
  var sortAZ = true;
  var themePath = '/wp-content/themes/thefox-child/';

  function sortObject(data) {
    var valueOrder;
    if (typeof Object.keys === 'function') {
      valueOrder = Object.keys(data);
    } else {
      for (var key in data) {
        valueOrder.push(key);
      }
    }
    return valueOrder.sort(function(a, b){
      if (typeof data[a] === 'object') {
        return data[a].name.localeCompare(data[b].name);
      }
      return data[a].localeCompare(data[b]);
    });
  }

  var _initFilters = function() {
    var countries = '<section>';
    countries += '<h4>Countries</h4>';
    countries += '<ul>';
    var sortedCountries = sortObject(dariahYearbookData.countries);
    for (var id in sortedCountries) {
      var countryId = sortedCountries[id];
      var country = dariahYearbookData.countries[countryId];
      var elementId = 'country' + countryId;
      countries += '<li><input id="' + elementId + '" name="countries" type="checkbox" value="' + countryId + '"/><label for="' + elementId + '">' + country + '</label></li>';
    }
    countries += '</ul>';
    countries += '<div class="more-less">';
    countries += '<a href="#" class="filter-more">+ More</a>';
    countries += '<a href="#" class="filter-less">- Less</a>';
    countries += '</div>';
    countries += '</section>';

    jQuery('#filters').append(countries);

    var institutions = '<section>';
    institutions += '<h4>Institutions</h4>';
    institutions += '<ul>';
    var sortedInstitutions = sortObject(dariahYearbookData.institutions);
    for (var id in sortedInstitutions) {
      var institutionId = sortedInstitutions[id];
      var institution = dariahYearbookData.institutions[institutionId];
      var elementId = 'institution' + institutionId;
      institutions += '<li><input id="' + elementId + '" name="institutions" type="checkbox" value="' + institutionId + '"/><label for="' + elementId + '">' + institution.name + '</label></li>';
    }
    institutions += '</ul>';
    institutions += '<div class="more-less">';
    institutions += '<a href="#" class="filter-more">+ More</a>';
    institutions += '<a href="#" class="filter-less">- Less</a>';
    institutions += '</div>';
    institutions += '</section>';

    jQuery('#filters').append(institutions);

    var positions = '<section>';
    positions += '<h4>Administrative positions</h4>';
    positions += '<ul>';
    var sortedPositions = sortObject(dariahYearbookData.positions);
    for (var id in sortedPositions) {
      var positionId = sortedPositions[id];
      var position = dariahYearbookData.positions[positionId];
      var elementId = 'position' + positionId;
      positions += '<li><input id="' + elementId + '" name="positions" type="checkbox" value="' + positionId + '"/><label for="' + elementId + '">' + position + '</label></li>';
    }
    positions += '</ul>';
    positions += '<div class="more-less">';
    positions += '<a href="#" class="filter-more">+ More</a>';
    positions += '<a href="#" class="filter-less">- Less</a>';
    positions += '</div>';
    positions += '</section>';

    jQuery('#filters').append(positions);

    jQuery('#filters input[type="checkbox"]').change(_onFilter);
    updateFilterList();
  };

  var _setResults = function(countries, institutions, positions) {
    if (countries || institutions || positions) {
      jQuery('#filters input[type="checkbox"]').parent().addClass('unavailable');
    }

    results = dariahYearbookData.persons
      .filter(function(person) {
        if (
          (countries && countries.indexOf(person.country) === -1) ||
          (institutions && institutions.indexOf(person.institution) === -1) ||
          (positions && positions.indexOf(person.position) === -1) )  {
          return false;
        }

        return true;
      })
      .map(function(person) {
        jQuery('#country' + person.country).parent().removeClass('unavailable');
        jQuery('#institution' + person.institution).parent().removeClass('unavailable');
        jQuery('#position' + person.position).parent().removeClass('unavailable');

        var html = '<li data-person-id="' + person.id + '">';
        html += '<div class="header">';
        html += '<div class="thumb"><img src="' + person.avatar + '" /></div>';
        html += '<p>';
        html += '<span class="name">' + person.firstname + ' ' + person.lastname + '</span>';
        if (person.role) { html += '<span class="role">' + person.role + '</span>'; }
        if (person.position) { html += '<span class="position">' + dariahYearbookData.positions[person.position] + '</span>'; }
        html += '</p>';
        html += '<button class="show-more" data-complete-profile="' + person.id + '">See More</button><button class="show-less">See Less</button>'
        html += '</div>';
        html += '<div class="complete">';
        html += '<ul class="tabs">';
        html += '<li class="about selected"><a href="#" data-tab="about">About</a></li>';
        html += '<li class="position"><a href="#" data-tab="position">Position</a></li>';
        html += '<li class="fields"><a href="#" data-tab="fields">Fields of expertise</a></li>';
        html += '<li class="contact"><a href="#" data-tab="contact">Contact</a></li>';
        html += '</ul>';
        html += '<ul class="content">';
        html += '<li class="about selected">' + person.about + '</li>';
        html += '<li class="position">';
        html += '<ul class="list">';
        if (person.identifiant) { html += '<li>Researcher ID : <span>' + person.identifiant + '</span></li>';}
        if (person.role) { html += '<li>Role : <span>' + person.role + '</span></li>';}
        if (person.position) { html += '<li>Administrative position : <span>' + dariahYearbookData.positions[person.position] + '</span></li>';}
        if (person.institution) { html += '<li>Institution : <span>' + dariahYearbookData.institutions[person.institution].name + '</span></li>';}
        if (person.country) { html += '<li>Country : <span>' + dariahYearbookData.countries[person.country] + '</span></li>';}
        html += '</ul>';
        html += '</li>';
        html += '<li class="fields">' + person.skills + '</li>';
        html += '<li class="contact">';
        html += '<ul class="list">';
        if (person.email) { html += '<li>Email : <span><a href="mailto:' + person.email + '">' + person.email + '</a></span></li>';}
        if (person.link) { html += '<li>Link : <span><a href="' + person.link + '" target="_blank">' + person.link + '</a></span></li>';}
        if (person.twitter) { html += '<li>Twitter : <span><a href="https://twitter.com/' + person.twitter + '" target="_blank">@' + person.twitter + '</a></span></li>';}
        html += '</ul>';
        html += '</li>';
        html += '</ul></div>';
        html += '</li>';

        return html;
      });

      if (!sortAZ) {
        results = results.reverse();
      }

      totalPages = Math.ceil(results.length / itemPerPage);
      jQuery('#pagination').empty();
      if (totalPages > 1) {
        jQuery('#pagination').append('<ul></ul>');
        jQuery('#pagination ul').append('<li id="previous"><a href="#" data-action="previous">< Previous</a></li>');
        for (var p = 0; p < totalPages; p++) {
          jQuery('#pagination ul').append('<li class="page' + p + '"><a href="#" data-action="' + p + '">' + (p+1) + '</a></li>');
        }
        jQuery('#pagination ul').append('<li id="next"><a href="#" data-action="next">Next ></a></li>');
        jQuery('#pagination').show();
      } else {
        jQuery('#pagination').hide();
      }
      _showResults(0, true);
  };

  var _sortResults = function(event) {
    sortAZ = !sortAZ;
    results = results.reverse();
    _showResults(0, false);
  }

  var _showResults = function(page, scrolltoTop) {
    jQuery('#results').empty();
    var index = page * itemPerPage;
    var text =  (index + 1) + ' - ' + Math.min(index+itemPerPage, results.length) + ' of ' + results.length;
    text += results.length > 1 ? ' peoples' : ' people';
    var sortText = 'Sort by ' + (sortAZ ? 'Z-A' : 'A-Z');
    var persons = '<div class="head">' + text + '<a href="#" data-sort="true" class="right">' + sortText + '</a></div>';
    persons += '<ul class="results">';

    persons += results.slice(index, index + itemPerPage)
      .join('');
    persons += '</ul>';

    jQuery('#pagination li').removeClass('selected');
    jQuery('#pagination .page' + page).addClass('selected');

    jQuery('#results').append(persons);
    currentPage = page;
    if (currentPage !== 0 && totalPages > 1) {
      jQuery('#previous').show();
    } else {
      jQuery('#previous').hide();
    }

    if (currentPage < totalPages - 1 && totalPages > 1) {
      jQuery('#next').show();
    } else {
      jQuery('#next').hide();
    }
    if (scrolltoTop && window.innerWidth < 768) {
      jQuery("html, body").animate({ scrollTop: 0 }, 500);
    }
  };

  var _onFilter = function(event) {
    jQuery('#filters section').removeClass('all');
    var countries = jQuery('input[name="countries"]:checked').map(function() {
      return parseInt(jQuery(this).val(), 10);
    }).get();
    var institutions = jQuery('input[name="institutions"]:checked').map(function() {
      return parseInt(jQuery(this).val(), 10);
    }).get();
    var positions = jQuery('input[name="positions"]:checked').map(function() {
      return parseInt(jQuery(this).val(), 10);
    }).get();
    currentPage = 0;
    _setResults(
      countries.length > 0 ? countries : null,
      institutions.length > 0 ? institutions : null,
      positions.length > 0 ? positions : null
    );
    updateFilterList();
  };

  var _onPagination = function(event) {
    event.preventDefault();
    event.stopPropagation();
    var action = event.target.getAttribute('data-action');
    switch(action) {
      case 'previous':
        _showResults(currentPage - 1, true);
        break;
      case 'next':
        _showResults(currentPage + 1, true);
        break;
      default:
        if (action) {
          _showResults(parseInt(action, 10), true);
        }
        break;
    }
  };

  var _onResults = function(event) {
    var tab = event.target.getAttribute('data-tab');
    var completeProfile = event.target.getAttribute('data-complete-profile');
    var sort = event.target.getAttribute('data-sort');

    if (tab) {
      event.preventDefault();
      event.stopPropagation();
      var container = jQuery(event.target).closest('.complete');

      jQuery(container).find('li').removeClass('selected');
      jQuery(container).find('.' + tab).addClass('selected');
    }

    if (completeProfile) {
      jQuery("[data-person-id]").removeClass('show-complete');
      jQuery("[data-person-id=" + completeProfile + "] li").removeClass('selected');
      jQuery("[data-person-id=" + completeProfile + "] .about").addClass('selected');
      jQuery("[data-person-id=" + completeProfile + "]").addClass('show-complete');
    }

    if (sort) {
      event.preventDefault();
      event.stopPropagation();
      _sortResults();
    }

    if (jQuery(event.target).hasClass('show-less')) {
      jQuery("[data-person-id]").removeClass('show-complete');
    }
  }

  function _onFilters(event) {
    if (jQuery(event.target).hasClass('filter-more')) {
      event.preventDefault();
      event.stopPropagation();

      var section = jQuery(event.target).closest('section');
      jQuery(section).addClass('all');
      jQuery(section).find('li:not(".unavailable")').show();
      updateFilterList();
    }

    if (jQuery(event.target).hasClass('filter-less')) {
      event.preventDefault();
      event.stopPropagation();
      var section = jQuery(event.target).closest('section');
      jQuery(section).removeClass('all');
      updateFilterList();
    }
  }

  function updateFilterList() {
    jQuery('#filters section').each(function() {
      var showAll = jQuery(this).hasClass('all');
      var notHiding = jQuery(this).find('li').not('.unavailable');

      if (jQuery(notHiding).length <= defaultFilterToShow) {
        jQuery(this).find('.more-less').hide();
      } else {
        jQuery(this).find('.more-less').show();
      }
      jQuery(notHiding).show();
      if (!showAll) {
        jQuery(notHiding).filter(function(index) {
          return index > defaultFilterToShow;
        }).hide();
      }
    });
  }

  jQuery(window).ready(function() {
    if (jQuery('#dariahYearbook').length !== 0) {
      jQuery.getJSON(themePath + 'build/yearbook.json', function(data) {
        dariahYearbookData = data;
        _initFilters();
        _setResults();
        jQuery('#pagination').on('click', _onPagination);
        jQuery('#results').on('click', _onResults);
        jQuery('#filters').on('click', _onFilters);
      });
    }
  });
})(jQuery);

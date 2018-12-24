(function(jQuery) {
  var contentBerlin = '<p class="title">DARIAH-EU Coordination Office</p>Centre Marc Bloch<br />Friedrichstraße' +
      ' 191<br />D-10117 Berlin<br />Germany';
  var contentTheHague = '<p class="title">DANS : Netherland Institute for Permanent Access to Digital Research' +
      ' Ressources</p>Anna van Saksenlaan 51<br/>2593 HW The Hague<br/>P.O. Box 93067<br/>2509 AB The' +
      ' Hague<br/>Netherlands';
  var contentParis = '<p class="title">DARIAH-EU</p>c/o TGIR Huma-Num<br/>TGIR HUMA-NUM<br/>CNRS UMS 3598<br/>54 bd' +
      ' Raspail<br/>75006 Paris<br/>France';
  var contentDublin = '<p class="title">Trinity College Dublin</p>Trinity Long Room Hub Arts and Humanities Research' +
      ' Institute<br/>The University of Dublin<br/>College Green<br/>Dublin 2<br/>Ireland';
  var positionBerlin = {
    lat: 52.5107910,
    lng: 13.3896580
  };
  var positionTheHague = {
    lat: 52.0808688,
    lng: 4.3449038
  };
  var positionParis = {
    lat: 48.850221,
    lng: 2.3267449
  };
  var positionDublin = {
    lat: 53.3436974,
    lng: -6.2566108
  };
  var dco = [];
  dco.push([contentBerlin, positionBerlin]);
  dco.push([contentTheHague, positionTheHague]);
  dco.push([contentParis, positionParis]);
  dco.push([contentDublin, positionDublin]);

  var imagesPath = '/wp-content/themes/thefox-child/images/';
  var map;

  var handleClick = function(event) {
    event.target.openPopup();
  };

  var initMap = function() {
    map = L.map('contactMap', {
      scrollWheelZoom: false,
      minZoom: 4,
      maxZoom: 18
    });
    L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png').addTo(map);
    var marker;
    var array = [];
    for (var i = 0; i < dco.length; i++) {
      var item = dco[i];
      var iconCountry = L.icon({ iconUrl: imagesPath + 'contact-marker.png', iconSize: [20, 20], iconAnchor: [10, 10], popupAnchor: [1, -20] });
      marker = new L.marker([item[1].lat,item[1].lng], {
        icon: iconCountry
      }).bindPopup(item[0]).on('click', handleClick);
      array.push(marker);
    }

    var group = L.featureGroup(array).addTo(map);
    map.fitBounds(group.getBounds());
  };

  jQuery(window).ready(function() {
    if (jQuery('#contactMap').length !== 0) {
      initMap();
    }
  });
})(jQuery);

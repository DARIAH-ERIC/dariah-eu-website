(function(jQuery) {
  var content = '<p class="title">DARIAH-EU Coordination Office</p>Centre Marc Bloch<br />Friedrichstraße 191<br />D-10117 Berlin<br />Germany';
  var defaultIcon;
  var defaultPosition = {
    lat: 52.5107910,
    lng: 13.3896580
  };
  var imagesPath = '/wp-content/themes/thefox-child/images/';
  var map;
  var marker;

  var handleClick = function(event) {
    displayPopup(event.target, content);
  }

  function displayPopup(target, text) {
    target.openPopup();
  }

  var initMap = function() {
    map = L.map('contactMap', {
      scrollWheelZoom: false,
      minZoom: 4,
      maxZoom: 18
    });
    map.setView(defaultPosition, 16);
    L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png').addTo(map);

    defaultIcon = L.icon({ iconUrl: imagesPath + 'contact-marker.png', iconSize: [20, 20], iconAnchor: [10, 10], popupAnchor: [1, -20] });
    var marker = L.marker(defaultPosition, {icon: defaultIcon});
    marker.bindPopup(content);
    marker.on('click', handleClick);
    marker.on('add', handleClick);
    marker.addTo(map);
  };

  jQuery(window).ready(function() {
    if (jQuery('#contactMap').length !== 0) {
      initMap();
    }
  });
})(jQuery);

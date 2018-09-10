(function(jQuery) {
  var selectedArea;

  var onBackToList = function(event) {
    event.preventDefault();
    event.stopPropagation();

    jQuery('#positions .contact-list').show();
    jQuery('#positions .contact-complete').hide();
    jQuery('#positions .contact-complete').empty();
  };

  var onSeeMore = function(event) {
    event.preventDefault();
    event.stopPropagation();

    jQuery('#positions .contact-complete').empty();

    var person = selectedArea.persons[jQuery(event.target).data('id')];
    if (person) {
      var _html = '';
      _html += '<div class="' + person.imageClasses + '" style="background-image: url(' + person.image + ');"></div>';
      _html += '<div class="content">';
      _html += '<h2>' + person.firstname + ' ' + person.lastname + '</h2>';
      if (person.position) { _html += '<p class="position">' + person.position + '</p>'; }
      _html += '<p class="description-full">' + person.full + '</p>';
      if (person.skills) { _html += '<p class="skills"><span class="title">Skills and research fields:</span>' + person.skills + '</p>'; }
      if (person.link) { _html += '<a href="' + person.link + '" target="_blank" class="link about">About</a>'; }
      if (person.email) { _html += '<a href="mailto:' + person.email + '" class="dariah-mail">Email</a>'; }
      _html += "</div>";
      _html += '<a href="#" class="back">< BACK TO LIST</a>';
      jQuery('#positions .contact-complete').append(_html);
      jQuery('#positions .back').on('click', onBackToList);
      jQuery('#positions .contact-list').hide();
      jQuery('#positions .contact-complete').show();
      jQuery('html,body').animate({scrollTop: jQuery('#contactComplete').offset().top - jQuery('.mt_menu').height() - 10},'slow');
    }
  };

  var onCloseClick = function(event) {
    event.preventDefault();
    event.stopPropagation();
    jQuery('#positions').hide();
    jQuery('#positions .contact-list').empty().show();
    jQuery('#positions .contact-complete').empty().hide();
  };

  var onPathClick = function(event) {
    var position = dariahPositionsData[event.currentTarget.id];
    if (!position) {
      jQuery('#positions').hide();
      selectedArea = null;
      return;
    }

    selectedArea = position;

    jQuery('#positions h2').text(position.name);
    jQuery('#positions .description').html(position.description);
    jQuery('#positions .contact-list').empty();

    if (event.currentTarget.id !== 'working-groups') {
      for (var key in position.persons) {
        var person = position.persons[key];

        var _html = '<li><div class="person-desc">';
        _html += '<div class="' + person.imageClasses + '" style="background-image: url(' + person.image + ');"></div>';
        _html += '<div class="content">';
        _html += '<p class="name">' + person.firstname + ' ' + person.lastname + '</p>';

        if (person.position) { _html += '<p class="position">' + person.position + '</p>'; }
        _html += '<p class="description-excerpt">' + person.excerpt + '</p>';
        if (person.displayMore) { _html += '<a href="#" class="link see-more" data-id="' + person.id + '">See more</a>'; }
        if (person.email) { _html += '<a href="mailto:' + person.email + '" class="dariah-mail">Email</a>'; }
        _html += "</div></div></li>";

        jQuery('#positions .contact-list').append(_html);
      }
    }

    jQuery('#positions .see-more').on('click', onSeeMore);
    jQuery('#positions').show();
    jQuery("html, body").animate({ scrollTop: jQuery('#positions').offset().top - 50 }, 1000);
  };

  jQuery(window).ready(function() {
    jQuery('svg #blocs g').on('click', onPathClick);
    jQuery('#positions .close').on('click', onCloseClick);
  });
})(jQuery);

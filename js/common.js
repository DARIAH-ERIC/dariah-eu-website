(function(jQuery) {
  var checkGA = function() {
    var GA_TRACKING_ID = 'UA-85802533-1';
    var GA_DISABLE = 'ga-disable-' + GA_TRACKING_ID;

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', GA_TRACKING_ID);

    document.dariahDisableGtm = function() {
      document.cookie = GA_DISABLE + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
      window[ GA_DISABLE ] = true;
      alert('Thanks. We have set a cookie so that Google Analytics data collection will be disabled on your next visit.');
    };

    if (document.cookie.indexOf( GA_DISABLE + '=true' ) > -1) {
      window[ GA_DISABLE ] = true;
    } else {
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://www' : 'http://www') + '.googletagmanager.com/gtag/js?id=' + GA_TRACKING_ID;

      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
    }
  };

  var onMailChimpSignup = function(event) {
    event.preventDefault();
    event.stopPropagation();

    jQuery('#mc_message').empty();
    jQuery('#mc_signup_form :input').prop('disabled', true);
    var data = {
      firstname: jQuery('#mc_mv_FNAME').val(),
      lastname: jQuery('#mc_mv_LNAME').val(),
      email: jQuery('#mc_mv_EMAIL').val(),
      institution: jQuery('#mc_mv_INSTITUTION').val()
    };
    jQuery.post(jQuery(this).attr('action'), data)
      .done(function(data) {
        jQuery('#mc_signup_form :input').prop('disabled', false);
        if (data.code < 400) {
          jQuery('#mc_signup_form :input[type=text]').val('');
        }
        jQuery('#mc_message').html('<span class="' + data.state + '">' + data.message + '</span>');
      })
      .fail(function(err) {
        jQuery('#mc_signup_form :input').prop('disabled', false);
        jQuery('#mc_message').html('<span class="error">Some problem occurred, please try again</span>');
      });
  };

  var onSeeMoreClick = function(event) {
    event.preventDefault();
    event.stopPropagation();
    jQuery('.person-desc').removeClass('full');

    jQuery(this).closest('.person-desc').addClass('full');
  };

  jQuery(window).ready(function() {
    checkGA();
    var classNames = [];
    if (navigator.userAgent.match(/(iPad|iPhone|iPod)/i)) classNames.push('device-ios');
    if (navigator.userAgent.match(/android/i)) classNames.push('device-android');

    var html = document.getElementsByTagName('html')[0];

    if (classNames.length) classNames.push('on-device');
    if (html.classList) html.classList.add.apply(html.classList, classNames);
    
    jQuery('.person-desc .see-more').on('click', onSeeMoreClick);
    jQuery('#mc_signup_form').on('submit', onMailChimpSignup);
  });
})(jQuery);

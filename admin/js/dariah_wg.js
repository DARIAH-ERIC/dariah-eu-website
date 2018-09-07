jQuery(document).ready(function($) {
  jQuery('.selectize').selectize();
  jQuery('.post-type-dariah_wg #publish').click(function(event) {
    jQuery('#dariah-error').remove();

    var errors = [];
    var title = jQuery('.post-type-dariah_wg input[name="post_title"]').val();
    var leaders = jQuery('.post-type-dariah_wg select[name="leaders[]"]').val();
    if (title === '') {
      errors.push('Title required');
    }
    if (!leaders || (leaders.length === 1 && leaders[0] === '')) {
      errors.push('Select at least one leader');
    }

    if (errors.length !== 0) {
      event.preventDefault();
      event.stopPropagation();

      jQuery('#poststuff').prepend('<div class="error" id="dariah-error"><p><strong>Mandatory field(s)</strong></p><ol>' + errors.map(function(error) { return '<li>' + error + '</li>'; }).join('') + '</ol></div>');

      jQuery('html, body').animate({
          scrollTop: jQuery("#dariah-error").offset().top
      }, 500);
    }
  });
});

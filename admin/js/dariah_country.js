jQuery(document).ready(function($) {
  jQuery("input[name=\"tax_input[dariah_country_status][]\"]").click(function () {
    selected = jQuery("input[name=\"tax_input[dariah_country_status][]\"]").filter(":checked").length;
    if (selected > 1){
        jQuery("input[name=\"tax_input[dariah_country_status][]\"]").each(function () {
                jQuery(this).attr("checked", false);
        });
        jQuery(this).attr("checked", true);
    }
  });

  jQuery('.post-type-dariah_country #publish').click(function(event) {
    jQuery('#dariah-error').remove();

    var errors = [];
    var title = jQuery('.post-type-dariah_country input[name="post_title"]').val();
    var code = jQuery('.post-type-dariah_country input[name="code"]').val();
    var coordinator = jQuery('.post-type-dariah_country select[name="coordinator"]').val();
    if (title === '') {
      errors.push('Title required');
    }
    if (code === '' || code.length !== 3 ) {
      errors.push('Country code mandatory, must be 3 chars length');
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

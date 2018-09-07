jQuery(document).ready(function($) {
  jQuery("input[name=\"tax_input[dariah_institution_country_role][]\"]").click(function () {
    selected = jQuery("input[name=\"tax_input[dariah_institution_country_role][]\"]").filter(":checked").length;
    if (selected > 1){
        jQuery("input[name=\"tax_input[dariah_institution_country_role][]\"]").each(function () {
                jQuery(this).attr("checked", false);
        });
        jQuery(this).attr("checked", true);
    }
  });

  jQuery('.post-type-dariah_institution #publish').click(function(event) {
    jQuery('#dariah-error').remove();

    var errors = [];
    var title = jQuery('.post-type-dariah_institution input[name="post_title"]').val();
    var country = jQuery('.post-type-dariah_institution select[name="country"]').val();
    var roleLength = jQuery("input[name=\"tax_input[dariah_institution_country_role][]\"]").filter(":checked").length;
    var longitude = jQuery('.post-type-dariah_institution input[name="longitude"]').val();
    var latitude = jQuery('.post-type-dariah_institution input[name="latitude"]').val();

    if (title === '') {
      errors.push('Title required');
    }
    if (country === '') {
      errors.push('Country required');
    }
    if (roleLength === 0) {
      errors.push('Role required');
    }
    if (longitude === '' || latitude === '') {
      errors.push('Complete position required');
    } else if(isNaN(longitude) || isNaN(latitude)) {
      errors.push('Position invalid');
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

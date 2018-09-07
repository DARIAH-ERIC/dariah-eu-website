jQuery(document).ready(function($) {
  jQuery('.selectize').selectize();
  jQuery("input[name=\"tax_input[dariah_project_link][]\"]").click(function () {
    selected = jQuery("input[name=\"tax_input[dariah_project_link][]\"]").filter(":checked").length;
    if (selected > 1){
        jQuery("input[name=\"tax_input[dariah_project_link][]\"]").each(function () {
                jQuery(this).attr("checked", false);
        });
        jQuery(this).attr("checked", true);
    }
  });

  jQuery('.post-type-dariah_project #publish').click(function(event) {
    jQuery('#dariah-error').remove();

    var errors = [];
    var title = jQuery('.post-type-dariah_project input[name="post_title"]').val();
    var coordinator = jQuery('.post-type-dariah_project select[name="coordinator"]').val();
    var contacts = jQuery('.post-type-dariah_project select[name="contacts[]"]').val();
    var institutions = jQuery('.post-type-dariah_project select[name="institutions[]"]').val();
    if (title === '') {
      errors.push('Title required');
    }
    if (!institutions || (institutions.length === 1 && institutions[0] === '')) {
      errors.push('Select at least one institution');
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

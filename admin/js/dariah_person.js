jQuery(document).ready(function($) {
  jQuery('.post-type-dariah_person input[name="post_title"]')
    .attr('placeholder', 'Enter firstname and lastname in fields below')
    .attr('disabled', 'disabled');
  jQuery('#title-prompt-text').hide();

  jQuery('.post-type-dariah_person input[name="firstname"], .post-type-dariah_person input[name="lastname"]').on('keyup change', function() {
    jQuery('.post-type-dariah_person input[name="post_title"]').val(
      jQuery('.post-type-dariah_person input[name="firstname"]').val() + ' ' + jQuery('.post-type-dariah_person input[name="lastname"]').val()
    );
  });
    jQuery('.post-type-dariah_person #publish').click(function(event) {
      jQuery('#dariah-error').remove();

      var errors = [];
      var firstname = jQuery('.post-type-dariah_person input[name="firstname"]').val();
      var lastname = jQuery('.post-type-dariah_person input[name="lastname"]').val();
      if (firstname === '' || lastname === '') {
        errors.push('Complete name required');
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

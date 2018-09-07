jQuery(document).ready(function($) {
  jQuery("input[name=\"tax_input[dariah_app_category][]\"]").click(function () {
    selected = jQuery("input[name=\"tax_input[dariah_app_category][]\"]").filter(":checked").length;
    if (selected > 1){
        jQuery("input[name=\"tax_input[dariah_app_category][]\"]").each(function () {
                jQuery(this).attr("checked", false);
        });
        jQuery(this).attr("checked", true);
    }
  });
});

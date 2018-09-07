<?php
  add_action( 'widgets_init', 'dariah_mailchimp__widget' );
  function dariah_mailchimp__widget() {
    register_widget( 'Dariah_Mailchimp' );
  }

class dariah_mailchimp extends WP_Widget {
  function Dariah_Mailchimp() {
    $widget_ops = array( 'classname' => 'dariah_mailchimp_widget', 'description' => __('Display Dariah Mailchimp', 'dariah') );
    $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'dariah_mailchimp_widget' );
    parent::__construct( 'dariah_mailchimp_widget', __('Dariah MailChimp', 'dariah'), $widget_ops, $control_ops );
  }

  function widget( $args, $instance ) {
    extract( $args );
?>
  <div class="widget widget_mailchimp">
    <h2>Subscribe to DARIAH’s Newsletter</h2>
    <div id="mc_signup">
      <form method="post" action="<?php echo get_stylesheet_directory_uri() . "/widget/ajax-newsletter.php"; ?>" id="mc_signup_form">
        <div class="mc_form_inside">
          <div class="mc_merge_var">
            <label for="mc_mv_EMAIL" class="mc_var_label mc_header mc_header_email">Email Address<span class="mc_required">*</span></label>
            <input type="text" size="18" placeholder="" name="mc_mv_EMAIL" id="mc_mv_EMAIL" class="mc_input">
          </div><!-- /mc_merge_var -->
          <div class="mc_merge_var">
            <label for="mc_mv_FNAME" class="mc_var_label mc_header mc_header_text">First Name</label>
            <input type="text" size="18" placeholder="" name="mc_mv_FNAME" id="mc_mv_FNAME" class="mc_input">
          </div><!-- /mc_merge_var -->
          <div class="mc_merge_var">
            <label for="mc_mv_LNAME" class="mc_var_label mc_header mc_header_text">Last Name</label>
            <input type="text" size="18" placeholder="" name="mc_mv_LNAME" id="mc_mv_LNAME" class="mc_input">
          </div><!-- /mc_merge_var -->
          <div id="mc-indicates-required">* = required field</div><!-- /mc-indicates-required -->
          <div class="updated" id="mc_message"></div><!-- /mc_message -->
          <div class="mc_signup_submit">
            <input type="submit" name="mc_signup_submit" id="mc_signup_submit" value="Subscribe" class="button">
          </div><!-- /mc_signup_submit -->
        </div><!-- /mc_form_inside -->
      </form>
    </div>
  </div>
<?php
  function update( $new_instance, $old_instance ) {
    return $old_instance;
  }

  function form( $instance ) {

  }
    /*
    $page = get_post(apply_filters('widget_title', $instance['page'] ));
    echo !empty( $before_widget ) ? $before_widget : '';
    echo '<a href="' . get_permalink($page->ID) . '" class="title">' . $page->post_title . "</a>";
    echo '<div class="links">';
    $query = new WP_Query(array(
      'post_type' => 'dariah_wg',
      'orderby' => 'title',
      'order' => 'ASC'
    ));
    for ($p = 0; $p < count($query->posts); $p++) {
      echo '<a href="' . get_permalink($query->posts[$p]->ID) . '">' . $query->posts[$p]->post_title . "</a>\n";
    }
    echo '</div>';
    echo !empty( $after_widget ) ? $after_widget : '';
    */
  }
  /*
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['page'] = strip_tags( $new_instance['page'] );
    return $instance;
  }

  function form( $instance ) {
  ?>
  <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'page' )); ?>">
      <?php _e('Page:', 'dariah') ?>
    </label>
    <select id="<?php echo esc_attr($this->get_field_id( 'page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'page' )); ?>">
      <?php
        $pages = get_pages($args);
        foreach ($pages as $page) {
      ?>
        <option value="<?php echo $page->ID; ?>" <?php if (esc_attr($instance['page']) ==  $page->ID) { echo "selected"; } ?> >
          <?php if ($page->post_parent) { ?> -- <?php } ?>
          <?php echo $page->post_title; ?>
        </option>
      <?php } ?>
    </select>
  </p>
<?php
  }
  */
}
?>

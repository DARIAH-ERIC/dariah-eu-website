<?php
  add_action( 'widgets_init', 'dariah_project_widget' );
  function dariah_project_widget() {
    register_sidebar( array(
      'name' => 'Menu Projects',
      'id' => 'menu_projects',
      'before_widget' => '<div class="dariah-menu-widget">',
      'after_widget' => '</div>'
    ));

    register_widget( 'Dariah_Menu_Project_Widget' );
  }

class dariah_menu_project_widget extends WP_Widget {
  function Dariah_Menu_Project_Widget() {
    $widget_ops = array( 'classname' => 'dariah_menu_project_widget', 'description' => __('Display Dariah Project', 'dariah') );
    $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'dariah_menu_project_widget' );
    parent::__construct( 'dariah_menu_project_widget', __('Dariah Projects', 'dariah'), $widget_ops, $control_ops );
  }

  function widget( $args, $instance ) {
    extract( $args );
    $page = get_post(apply_filters('widget_title', $instance['page'] ));
    echo !empty( $before_widget ) ? $before_widget : '';
    echo '<a href="' . get_permalink($page->ID) . '" class="title">' . $page->post_title . "</a>";
    $cat_args = array(
        'orderby'       => 'term_id',
        'order'         => 'ASC',
        'hide_empty'    => true,
    );

    $links = get_terms('dariah_project_link', $cat_args);
    foreach ($links as &$link) {
      echo '<div class="category">';
      echo '<p>' . $link->name . '</p>';
      $query = new WP_Query(array(
        'post_type' => 'dariah_project',
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => array(
          array (
              'taxonomy' => 'dariah_project_link',
              'field' => 'term_id',
              'terms' => $link->term_id,
          )
        ),
      ));
      for ($p = 0; $p < count($query->posts); $p++) {
        echo '<a href="' . get_permalink($query->posts[$p]->ID) . '">' . $query->posts[$p]->post_title . "</a>\n";
      }
      echo '</div>';
    }
    echo !empty( $after_widget ) ? $after_widget : '';
  }

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
}
?>

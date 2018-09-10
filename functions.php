<?php

  // Custom breadcrumbs
  include("functions/breadcrumb.php");
  include("functions/contact.php");
  include("functions/list-item.php");
  include("functions/encode-email.php");
  include("functions/map.php");
  include("functions/yearbook.php");
  include("shortcode/organigram.php");

  add_action('admin_head', 'admin_enqueue');
  add_action('wp_enqueue_scripts', 'theme_enqueue' );
  add_action('init', 'register_my_menu' );
  add_filter('wp_insert_post_data' , 'modify_post_title' , '99', 1 );
  add_action('save_post', 'on_post_saved');

  remove_filter('template_redirect', 'redirect_canonical');

  function register_my_menu() {
    register_nav_menu('home-menu',__( 'Home Menu' ));
  }

  function theme_enqueue() {
      if (is_page_template('single-map.php') || is_page_template('single-contact.php')) {
        wp_enqueue_style( 'leaflet-style', get_stylesheet_directory_uri() . '/map/leaflet.css' );
        wp_enqueue_script( 'leaflet-script', get_stylesheet_directory_uri() . '/map/leaflet.js');
      }

      if (is_page_template('single-map.php')) {
        wp_enqueue_script( 'dariah-map-panes', get_stylesheet_directory_uri() . '/map/europe-panes.js');
      }
      wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
      wp_enqueue_style( 'dariah-custom-style', get_stylesheet_directory_uri() . '/dariah.css' );
      wp_enqueue_script( 'dariah-custom-script', get_stylesheet_directory_uri() . '/app.min.js');
  }

  function modify_post_title($data) {
    if ($data['post_type'] === 'dariah_person') {
      $data['post_title'] =  $_POST["firstname"] . ' ' . $_POST["lastname"]; //Updates the post title to your new title.
    }
    return $data; // Returns the modified data.
  }

  function admin_enqueue() {
    wp_enqueue_style('admin_css', get_stylesheet_directory_uri() . '/css/admin.css');
    wp_enqueue_style('selectize_css', get_stylesheet_directory_uri() . '/admin/vendor/selectize.default.css');
    wp_enqueue_script('selectize', get_stylesheet_directory_uri() . '/admin/vendor/selectize.min.js');

    global $post;
    $type = get_post_type( $post );
    switch ($type) {
      case 'dariah_app':
      case 'dariah_country':
      case 'dariah_institution':
      case 'dariah_person':
      case 'dariah_project':
      case 'dariah_vcc':
      case 'dariah_wg':
        wp_enqueue_script('custom_js', get_stylesheet_directory_uri() . '/admin/js/' . $type . '.js');
        break;
    }
  }

  function on_post_saved($post_id) {
    $post = get_post($post_id);
    $type = get_post_type( $post );
    switch($type) {
      case 'dariah_country':
      case 'dariah_institution':
      case 'dariah_person':
      case 'dariah_project':
        dariah_create_json_for_map();
        dariah_create_json_for_yearbook();
        break;
    }
  }

  include( 'class/HomeWalkerMenu.php' );
  include( 'class/HTML2Text.php' );
  include( 'widget/widget-mailchimp.php' );
  include( 'widget/widget-menu-project.php' );
  include( 'widget/widget-menu-vcc.php' );
  include( 'widget/widget-menu-wg.php' );

  include( 'admin/type_app.php' );
  include( 'admin/type_country.php' );
  include( 'admin/type_institution.php' );
  include( 'admin/type_person.php' );
  include( 'admin/type_project.php' );
  include( 'admin/type_vcc.php' );
  include( 'admin/type_wg.php' );
?>

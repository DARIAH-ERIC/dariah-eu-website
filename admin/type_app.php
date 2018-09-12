<?php
  add_action( 'init', 'create_type_app' );
	add_action( 'admin_init', 'add_meta_app' );
  add_action( 'save_post', 'save_meta_app', 9);

  function create_type_app() {
    $labels = array(
			'name'               => __( 'Apps' ),
			'singular_name'      => __( 'App' ),
			'menu_name'          => __( 'Apps' ),
			'name_admin_bar'     => __( 'App' ),
			'add_new'            => __( 'Add App' ),
			'add_new_item'       => __( 'Add App' ),
			'new_item'           => __( 'New App' ),
			'edit_item'          => __( 'Edit App' ),
			'view_item'          => __( 'View App' ),
			'all_items'          => __( 'All Apps' ),
			'search_items'       => __( 'Search App' ),
			'not_found'          => __( 'No Apps found.' ),
			'not_found_in_trash' => __( 'No Apps found in trash.' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'tools-services/tools-and-services/tools' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-desktop',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_app', $args );

    $taxonomyCategory = array (
      'hierarchical'      => true,
      'label'             => 'Category',
      'query_var'         => true
    );

    register_taxonomy( 'dariah_app_category', 'dariah_app', $taxonomyCategory);
  }

  function add_meta_app() {
    add_meta_box( 'data_app', 'Informations', 'data_app', 'dariah_app', 'normal', 'high');
  }

  function data_app() {
		global $post;
		$custom = get_post_custom( $post->ID );
		echo '<p><label for="link"> Link </label><span class="field"><input class="link full" input="text" name="link" value="' . $custom["link"][0] . '" /></span></p>';
		echo '<p><label for="author"> Author: </label><span class="field"><input class="author full" input="text" name="author" value="' . $custom["author"][0] . '" /></span></p>';
		echo '<p><label for="website"> Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . $custom["website"][0] . '" /></span></p>';
  }

	function save_meta_app() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

    if ( isset($_POST['post_type']) && 'dariah_app' == $_POST['post_type'] ) {
  		update_post_meta( $post->ID, "link", $_POST["link"] );
  		update_post_meta( $post->ID, "author", $_POST["author"] );
  		update_post_meta( $post->ID, "website", $_POST["website"] );
    }
	}
?>

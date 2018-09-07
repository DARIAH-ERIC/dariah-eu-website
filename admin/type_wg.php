<?php
  add_action( 'init', 'create_type_wg' );
	add_action( 'admin_init', 'add_meta_wg' );
  add_action( 'save_post', 'save_meta_wg', 9);

  function create_type_wg() {
    $labels = array(
			'name'               => __( 'Working Groups' ),
			'singular_name'      => __( 'Working Group' ),
			'menu_name'          => __( 'Working Groups' ),
			'name_admin_bar'     => __( 'Working Group' ),
			'add_new'            => __( 'Add Working Group' ),
			'add_new_item'       => __( 'Add Working Group' ),
			'new_item'           => __( 'New Working Group' ),
			'edit_item'          => __( 'Edit Working Group' ),
			'view_item'          => __( 'View Working Group' ),
			'all_items'          => __( 'All Working Groups' ),
			'search_items'       => __( 'Search Working Group' ),
			'not_found'          => __( 'No Working Groups found.' ),
			'not_found_in_trash' => __( 'No Working Groups found in trash.' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'activities/working-groups' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-groups',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_wg', $args );
  }

  function add_meta_wg() {
    add_meta_box( 'leaders_wg', 'Leaders of the Working Group *', 'leaders_wg', 'dariah_wg', 'side', 'low');
  }

	function leaders_wg() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_person',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_key' => 'lastname',
      'nopaging' => true
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
    $leaders = explode(',', $custom["leaders"][0]);
    echo '<p>Select at least one leader for this working group</p>';
    echo '<select class="full dariah selectize" multiple name="leaders[]">';
    for ($p = 0; $p < count($query->posts); $p++) {
      echo '<option value="' . $query->posts[$p]->ID . '" ';
      if (in_array($query->posts[$p]->ID, $leaders)) {
        echo ' selected="selected"';
      }
      echo '>' . $query->posts[$p]->firstname . ' ' . $query->posts[$p]->lastname . "</option>\n";
    }
    echo '</select>';
  }

	function save_meta_wg() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

    if ( 'dariah_wg' == $_POST['post_type'] ) {
  		update_post_meta( $post->ID, "leaders", implode(',', $_POST["leaders"]) );
    }
	}
?>

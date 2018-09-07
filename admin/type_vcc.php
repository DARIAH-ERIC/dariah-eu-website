<?php
  add_action( 'init', 'create_type_vcc' );
	add_action( 'admin_init', 'add_meta_vcc' );
  add_action( 'save_post', 'save_meta_vcc', 9);

  function create_type_vcc() {
    $labels = array(
			'name'               => __( 'VCCs' ),
			'singular_name'      => __( 'VCC' ),
			'menu_name'          => __( 'VCCs' ),
			'name_admin_bar'     => __( 'VCC' ),
			'add_new'            => __( 'Add VCC' ),
			'add_new_item'       => __( 'Add VCC' ),
			'new_item'           => __( 'New VCC' ),
			'edit_item'          => __( 'Edit VCC' ),
			'view_item'          => __( 'View VCC' ),
			'all_items'          => __( 'All VCCs' ),
			'search_items'       => __( 'Search VCC' ),
			'not_found'          => __( 'No VCCs found.' ),
			'not_found_in_trash' => __( 'No VCCs found in trash.' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'activities/competence-centers' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-archive',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_vcc', $args );
  }

  function add_meta_vcc() {
    add_meta_box( 'leaders_vcc', 'Leaders of the VCC *', 'leaders_vcc', 'dariah_vcc', 'side', 'low');
  }

	function leaders_vcc() {
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

	function save_meta_vcc() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

    if ( 'dariah_vcc' == $_POST['post_type'] ) {
  		update_post_meta( $post->ID, "leaders", implode(',', $_POST["leaders"]) );
    }
	}
?>

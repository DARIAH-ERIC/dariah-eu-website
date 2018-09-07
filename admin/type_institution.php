<?php
  add_action( 'init', 'create_type_institution' );
	add_action( 'admin_init', 'add_meta_institution' );
  add_action( 'save_post', 'save_meta_institution', 9);

  function create_type_institution() {
    $labels = array (
			'name'               => __( 'Institutions' ),
			'singular_name'      => __( 'Institution' ),
			'menu_name'          => __( 'Institutions' ),
			'name_admin_bar'     => __( 'Institution' ),
			'add_new'            => __( 'Add Institution' ),
			'add_new_item'       => __( 'Add Institution' ),
			'new_item'           => __( 'New Institution' ),
			'edit_item'          => __( 'Edit Institution' ),
			'view_item'          => __( 'View Institution' ),
			'all_items'          => __( 'All Institutions' ),
			'search_items'       => __( 'Search Institution' ),
			'not_found'          => __( 'No Institutions found.' ),
			'not_found_in_trash' => __( 'No Institutions found in trash.' ),
		);

		$args = array (
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'institution' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-universal-access-alt',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_institution', $args );

    $taxonomyCountryRole = array (
      'hierarchical'      => true,
      'label'             => 'Role in the country *',
      'query_var'         => true
    );

    register_taxonomy( 'dariah_institution_country_role', 'dariah_institution', $taxonomyCountryRole);
  }

  function add_meta_institution() {
    add_meta_box( 'website_institution', 'Website', 'website_institution', 'dariah_institution', 'normal', 'high');
    add_meta_box( 'country_institution', 'Country *', 'country_institution', 'dariah_institution', 'side', 'low');
    add_meta_box( 'geoloc_institution', 'Position *', 'geoloc_institution', 'dariah_institution', 'side', 'low');
  }

	function website_institution() {
		global $post;
		$custom = get_post_custom( $post->ID );
		echo '<p><label for="website"> Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . $custom["website"][0] . '" /></span></p>';
  }

	function country_institution() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_country',
      'orderby' => 'title',
      'order' => 'ASC',
      'nopaging' => true
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
    $country = $custom["country"][0];
    echo '<p>Select a country for this intitution</p>';
    echo '<select class="full dariah" name="country">';
    echo '<option value="">------------------------------------------</option>';
      for ($p = 0; $p < count($query->posts); $p++) {
        echo '<option value="' . $query->posts[$p]->ID . '" ';
        if ($query->posts[$p]->ID == $country) {
          echo ' selected="selected"';
        }
        echo '>' . $query->posts[$p]->post_title . "</option>\n";
      }
    echo '</select>';
  }

  function geoloc_institution() {
    global $post;
		$custom = get_post_custom( $post->ID );
    echo '<div class="rd_metabox">';
		echo '<div class="rd_metabox_field"><label for="longitude"> Longitude: </label><div class="field"><input class="longitude" input="text" name="longitude" value="' . $custom["longitude"][0] . '" /></div></div>';
		echo '<div class="rd_metabox_field"><label for="latitude"> Latitude: </label><div class="field"><input class="latitude" input="text" name="latitude" value="' . $custom["latitude"][0] . '" /></div></div>';
    echo '</div>';
  }

	function save_meta_institution() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

    if ( 'dariah_institution' == $_POST['post_type'] ) {
  		update_post_meta( $post->ID, "country",$_POST["country"] );
  		update_post_meta( $post->ID, "website", $_POST["website"] );
  		update_post_meta( $post->ID, "longitude",$_POST["longitude"] );
  		update_post_meta( $post->ID, "latitude",$_POST["latitude"] );
    }
	}
?>

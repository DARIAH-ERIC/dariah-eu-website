<?php
  add_action( 'init', 'create_type_country' );
	add_action( 'admin_init', 'add_meta_country' );
  add_action( 'save_post', 'save_meta_country', 9);

  function create_type_country() {
    $labels = array(
			'name'               => __( 'Countries' ),
			'singular_name'      => __( 'Country' ),
			'menu_name'          => __( 'Countries' ),
			'name_admin_bar'     => __( 'Country' ),
			'add_new'            => __( 'Add Country' ),
			'add_new_item'       => __( 'Add Country' ),
			'new_item'           => __( 'New Country' ),
			'edit_item'          => __( 'Edit Country' ),
			'view_item'          => __( 'View Country' ),
			'all_items'          => __( 'All Countries' ),
			'search_items'       => __( 'Search Country' ),
			'not_found'          => __( 'No Countries found.' ),
			'not_found_in_trash' => __( 'No Countries found in trash.' ),
		);

		$args = array(
			'labels'             => $labels,
			'exclude_from_search'=> true,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'country' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-admin-site',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_country', $args );

    $taxonomyEntity = array (
      'hierarchical'      => false,
      'label'             => 'Representing Entities',
      'query_var'         => true
    );

    register_taxonomy( 'dariah_country_entity', 'dariah_country', $taxonomyEntity);

    $taxonomyStatus = array (
      'hierarchical'      => true,
      'label'             => 'Status',
      'query_var'         => true
    );

    register_taxonomy( 'dariah_country_status', 'dariah_country', $taxonomyStatus);
  }

  function add_meta_country() {
    add_meta_box( 'national_representative', 'National Representative', 'national_representative', 'dariah_country', 'side', 'low');
    add_meta_box( 'geoloc_capital', 'Geolocation capital', 'geoloc_capital', 'dariah_country', 'side', 'low');
    add_meta_box( 'code_country', 'Code ISO ALPHA-3 *', 'code_country', 'dariah_country', 'side', 'low');
    add_meta_box( 'coordinators_country', 'Coordinators', 'coordinators_country', 'dariah_country', 'side', 'low');
	add_meta_box( 'website_country', 'Website', 'website_country', 'dariah_country', 'normal', 'low');
	add_meta_box( 'websitename_country', 'Website name', 'websitename_country', 'dariah_country', 'normal', 'low');
  }

  function national_representative() {
    global $post;
    $custom = get_post_custom( $post->ID );

    $query = new WP_Query(array(
      'post_type' => 'dariah_person',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_key' => 'lastname',
      'nopaging' => true
    ));
    $persons = explode(',', $custom["repPersons"][0]);
    echo '<p>Persons</p>';
    echo '<select class="full dariah selectize" multiple name="repPersons[]">';
      for ($p = 0; $p < count($query->posts); $p++) {
        echo '<option value="' . $query->posts[$p]->ID . '" ';
        if (in_array($query->posts[$p]->ID, $persons)) {
          echo ' selected="selected"';
        }
        echo '>' . $query->posts[$p]->firstname . ' ' . $query->posts[$p]->lastname . "</option>\n";
      }
    echo '</select>';
  }

  function geoloc_capital() {
    global $post;
		$custom = get_post_custom( $post->ID );
    echo '<div class="rd_metabox">';
		echo '<div class="rd_metabox_field"><label for="longitude"> Longitude: </label><div class="field"><input class="longitude" input="text" name="longitude" value="' . $custom["longitude"][0] . '" /></div></div>';
		echo '<div class="rd_metabox_field"><label for="latitude"> Latitude: </label><div class="field"><input class="latitude" input="text" name="latitude" value="' . $custom["latitude"][0] . '" /></div></div>';
    echo '</div>';
  }

	function code_country() {
    global $post;
		$custom = get_post_custom( $post->ID );
		echo '<input class="code" input="text" name="code" value="' . $custom["code"][0] . '" />';
  }

	function coordinators_country() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_person',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_key' => 'lastname',
      'nopaging' => true
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
	    $coordinators = explode(',', $custom["coordinators"][0]);
	    echo '<p>Select country coordinators</p>';
	    echo '<select class="full dariah selectize" multiple name="coordinators[]">';
	    for ($p = 0; $p < count($query->posts); $p++) {
	        echo '<option value="' . $query->posts[$p]->ID . '" ';
	        if (in_array($query->posts[$p]->ID, $coordinators)) {
	          echo ' selected="selected"';
	        }
	        echo '>' . $query->posts[$p]->lastname . ' ' . $query->posts[$p]->firstname . "</option>\n";
	    }
	    echo '</select>';
  }

	function website_country() {
		global $post;
		$custom = get_post_custom( $post->ID );
		echo '<p><label for="website">Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . $custom["website"][0] . '" /></span></p>';
	}

	function websitename_country() {
		global $post;
		$custom = get_post_custom( $post->ID );
		echo '<p><label for="websitename">Website name: </label><span class="field"><input class="website full" input="text" name="websitename" value="' . $custom["websitename"][0] . '" /></span></p>';
	}

	function save_meta_country() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

	    if ( isset($_POST['post_type']) && 'dariah_country' == $_POST['post_type'] ) {
		    update_post_meta( $post->ID, "coordinators", implode(',', $_POST["coordinators"]) );
		    update_post_meta( $post->ID, "repPersons", implode(',', $_POST["repPersons"]) );
		    update_post_meta( $post->ID, "repInstitutions", implode(',', $_POST["repInstitutions"]) );
	        update_post_meta( $post->ID, "code", $_POST["code"] );
	        update_post_meta( $post->ID, "longitude",$_POST["longitude"] );
	        update_post_meta( $post->ID, "latitude",$_POST["latitude"] );
		    update_post_meta( $post->ID, "website", $_POST["website"] );
		    update_post_meta( $post->ID, "websitename", $_POST["websitename"] );
	    }
	}
?>

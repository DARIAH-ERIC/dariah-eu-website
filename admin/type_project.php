<?php
  add_action( 'init', 'create_type_project' );
	add_action( 'admin_init', 'add_meta_project' );
  add_action( 'save_post', 'save_meta_project', 9);

  function create_type_project() {
    $labels = array(
			'name'               => __( 'Projects' ),
			'singular_name'      => __( 'Project' ),
			'menu_name'          => __( 'Projects' ),
			'name_admin_bar'     => __( 'Project' ),
			'add_new'            => __( 'Add Project' ),
			'add_new_item'       => __( 'Add Project' ),
			'new_item'           => __( 'New Project' ),
			'edit_item'          => __( 'Edit Project' ),
			'view_item'          => __( 'View Project' ),
			'all_items'          => __( 'All Projects' ),
			'search_items'       => __( 'Search Project' ),
			'not_found'          => __( 'No Projects found.' ),
			'not_found_in_trash' => __( 'No Projects found in trash.' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'activities/projects-and-affiliations' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-clipboard',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_project', $args );

    $taxonomyLink = array (
      'hierarchical'      => true,
      'label'             => 'Dariah link',
      'query_var'         => true
    );

    register_taxonomy( 'dariah_project_link', 'dariah_project', $taxonomyLink);
  }

  function add_meta_project() {
    add_meta_box( 'fullname_project', 'Fullname', 'fullname_project', 'dariah_project', 'normal', 'high');
    add_meta_box( 'coordinator_project', 'Coordinator', 'coordinator_project', 'dariah_project', 'side', 'low');
    add_meta_box( 'contacts_project', 'Contacts', 'contacts_project', 'dariah_project', 'side', 'low');
    add_meta_box( 'consortium_project', 'Consortium *', 'consortium_project', 'dariah_project', 'normal', 'low');
  }

	function fullname_project() {
		global $post;
		$custom = get_post_custom( $post->ID );
		echo '<p><label for="fullname"> Full project name: </label><span class="field"><input class="fullname full" input="text" name="fullname" value="' . $custom["fullname"][0] . '" /></span></p>';
		echo '<p><label for="website"> Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . $custom["website"][0] . '" /></span></p>';
  }

	function coordinator_project() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_institution',
      'orderby' => 'title',
      'order' => 'ASC',
      'nopaging' => true
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
    $coordinator = $custom["coordinator"][0];
    echo '<p>Select a coordinator for this project</p>';
    echo '<select class="full dariah" name="coordinator">';
    echo '<option value="">------------------------------------------</option>';
      for ($p = 0; $p < count($query->posts); $p++) {
        echo '<option value="' . $query->posts[$p]->ID . '" ';
        if ($query->posts[$p]->ID == $coordinator) {
          echo ' selected="selected"';
        }
        echo '>' . $query->posts[$p]->post_title . "</option>\n";
      }
    echo '</select>';
  }

	function contacts_project() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_person',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_key' => 'lastname',
      'nopaging' => true
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
    $contacts = explode(',', $custom["contacts"][0]);
    echo '<p>Select contacts for this project</p>';
    echo '<select class="full dariah selectize" multiple name="contacts[]">';
      for ($p = 0; $p < count($query->posts); $p++) {
        echo '<option value="' . $query->posts[$p]->ID . '" ';
        if (in_array($query->posts[$p]->ID, $contacts)) {
          echo ' selected="selected"';
        }
        echo '>' . $query->posts[$p]->firstname . ' ' . $query->posts[$p]->lastname . "</option>\n";
      }
    echo '</select>';
  }

	function consortium_project() {
    $query = new WP_Query(array(
      'post_type' => 'dariah_institution',
      'orderby' => 'title',
      'order' => 'ASC',
      'nopaging' => true,
      'tax_query' => array(
        array(
          'taxonomy' => 'dariah_institution_country_role',
          'field'    => 'slug',
          'terms'    => array('partner-institutions', 'national-coordinating-institution', 'cooperating-partners', 'other')
        )
      ),
    ));
		global $post;
		$custom = get_post_custom( $post->ID );
    $institutions = explode(',', $custom["institutions"][0]);
    echo '<p>Select institutions for this project</p>';
    echo '<select class="full dariah selectize" multiple name="institutions[]">';
    for ($p = 0; $p < count($query->posts); $p++) {
      echo '<option value="' . $query->posts[$p]->ID . '" ';
      if (in_array($query->posts[$p]->ID, $institutions)) {
        echo ' selected="selected"';
      }
      echo '>' . $query->posts[$p]->post_title . "</option>\n";
    }
    echo '</select>';
  }

	function save_meta_project() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

    if ( isset($_POST['post_type']) && 'dariah_project' == $_POST['post_type'] ) {
  		update_post_meta( $post->ID, "fullname", $_POST["fullname"] );
  		update_post_meta( $post->ID, "website", $_POST["website"] );
  		update_post_meta( $post->ID, "coordinator", $_POST["coordinator"] );
  		update_post_meta( $post->ID, "contacts", implode(',', $_POST["contacts"]) );
  		update_post_meta( $post->ID, "institutions", implode(',', $_POST["institutions"]) );
    }
	}
?>

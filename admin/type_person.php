<?php
	add_action( 'init', 'create_type_person' );
	add_action( 'admin_init', 'post_type_dariah_admin_init' );
	add_action( 'save_post', 'post_type_dariah_save_custom', 9);

	function create_type_person() {
		$labels = array(
			'name'               => __( 'Persons' ),
			'singular_name'      => __( 'Person' ),
			'menu_name'          => __( 'Persons' ),
			'name_admin_bar'     => __( 'Person' ),
			'add_new'            => __( 'Add person' ),
			'add_new_item'       => __( 'Add person' ),
			'new_item'           => __( 'New person' ),
			'edit_item'          => __( 'Edit person' ),
			'view_item'          => __( 'See person' ),
			'all_items'          => __( 'All persons' ),
			'search_items'       => __( 'Search person' ),
			'not_found'          => __( 'No person found.' ),
			'not_found_in_trash' => __( 'No person found in trash' ),
		);

		$args = array(
			'labels'             => $labels,
			'exclude_from_search'=> true,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'person' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-businessman',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'dariah_person', $args );

		$taxonomyPosition = array (
			'hierarchical'      => true,
			'label'             => 'Administrative position',
			'query_var'         => true
		);

		register_taxonomy( 'dariah_person_position', 'dariah_person', $taxonomyPosition);
	}

	function post_type_dariah_admin_init() {
		add_meta_box( 'infos_person', 'Informations', 'infos_person', 'dariah_person', 'normal', 'low');
		add_meta_box( 'institution_person', 'Institution', 'institution_person', 'dariah_person', 'side', 'low');
	}

	function infos_person() {
		global $post;
		$custom = get_post_custom( $post->ID );
		$isYearbookSelected = $custom['yearbook'][0] === "1" ? ' checked="checked"' : '';
		echo $isYearbookSelected;
		echo '<div class="row"><div class="col-2">';
			echo '<p><label for="firstname"> Firstname *: </label><span class="field"><input class="firstname full" input="text" name="firstname" value="' . $custom["firstname"][0] . '" /></span></p>';
			echo '<p><label for="lastname"> Lastname *: </label><span class="field"><input class="lastname full" input="text" name="lastname" value="' . $custom["lastname"][0] . '" /></span></p>';
			echo '<p><label for="email"> Email: </label><span class="field"><input class="email full" input="text" name="email" value="' . $custom["email"][0] . '" /></span></p>';
			echo '<p><label for="twitter"> Twitter: </label><span class="field"><input class="twitter full" input="text" name="twitter" value="' . $custom["twitter"][0] . '" /></span></p>';
			echo '<p><label class="selectit"><input value="1" type="checkbox" name="yearbook"' . $isYearbookSelected . '> Show in the Annuary</label></p>';
		echo '</div><div class="col-2">';
			echo '<p><label for="identifiant"> Identifiant: </label><span class="field"><input class="identifiant full" input="text" name="identifiant" value="' . $custom["identifiant"][0] . '" /></span></p>';
			echo '<p><label for="position"> Position: </label><span class="field"><input class="position full" input="text" name="position" value="' . $custom["position"][0] . '" /></span></p>';
			echo '<p><label for="link"> Link: </label><span class="field"><input class="link full" input="text" name="link" value="' . $custom["link"][0] . '" /></span></p>';
			echo '<p><label for="skills"> Skills and research: </label><span class="field"><textarea class="skills full" name="skills">' . $custom["skills"][0] . '</textarea></span></p>';
		echo '</div></div>';
	}

	function institution_person() {
		$query = new WP_Query(array(
			'post_type' => 'dariah_institution',
			'orderby' => 'title',
			'order' => 'ASC',
			'nopaging' => true
		));
		global $post;
		$custom = get_post_custom( $post->ID );
		$institution = $custom["institution"][0];
		echo '<p>Select institution</p>';
		echo '<select class="full dariah" name="institution">';
		echo '<option value="">------------------------------------------</option>';
			for ($p = 0; $p < count($query->posts); $p++) {
				echo '<option value="' . $query->posts[$p]->ID . '" ';
				if ($query->posts[$p]->ID == $institution) {
					echo ' selected="selected"';
				}
				echo '>' . $query->posts[$p]->post_title . "</option>\n";
			}
		echo '</select>';
	}

	function post_type_dariah_save_custom() {
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		if ( 'dariah_person' == $_POST['post_type'] ) {
			update_post_meta( $post->ID, "email", $_POST["email"] );
			update_post_meta( $post->ID, "twitter", $_POST["twitter"] );
			update_post_meta( $post->ID, "firstname", $_POST["firstname"] );
			update_post_meta( $post->ID, "lastname", $_POST["lastname"] );
			update_post_meta( $post->ID, "link", $_POST["link"] );
			update_post_meta( $post->ID, "institution", $_POST["institution"] );
			update_post_meta( $post->ID, "identifiant", $_POST["identifiant"] );
			update_post_meta( $post->ID, "yearbook", $_POST["yearbook"] );
			update_post_meta( $post->ID, "position", $_POST["position"] );
			update_post_meta( $post->ID, "skills", $_POST["skills"] );
		}
	}
?>

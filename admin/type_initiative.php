<?php
add_action( 'init', 'create_type_initiative' );
add_action( 'admin_init', 'add_meta_initiative' );
add_action( 'save_post', 'save_meta_initiative', 9 );

function create_type_initiative() {
	$labels = array(
		'name'               => __( 'Initiatives' ),
		'singular_name'      => __( 'Initiative' ),
		'menu_name'          => __( 'Initiatives' ),
		'name_admin_bar'     => __( 'Initiative' ),
		'add_new'            => __( 'Add Initiative' ),
		'add_new_item'       => __( 'Add Initiative' ),
		'new_item'           => __( 'New Initiative' ),
		'edit_item'          => __( 'Edit Initiative' ),
		'view_item'          => __( 'View Initiative' ),
		'all_items'          => __( 'All Initiatives' ),
		'search_items'       => __( 'Search Initiative' ),
		'not_found'          => __( 'No Initiatives found.' ),
		'not_found_in_trash' => __( 'No Initiatives found in trash.' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'about/initiatives' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-category',
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

	register_post_type( 'dariah_initiative', $args );

	$taxonomyCategory = array(
		'hierarchical' => true,
		'label'        => 'Category',
		'query_var'    => true
	);

	register_taxonomy( 'dariah_initiative_category', 'dariah_initiative', $taxonomyCategory );
}

function add_meta_initiative() {
	add_meta_box( 'data_initiative', 'Informations', 'data_initiative', 'dariah_initiative', 'normal', 'high' );
}

function data_initiative() {
	global $post;
	$custom = get_post_custom( $post->ID );
	echo '<p><label for="link"> Link </label><span class="field"><input class="link full" input="text" name="link" value="' . ( in_array( "link", $custom ) ? $custom["link"][0] : "" ) . '" /></span></p>';
	echo '<p><label for="author"> Author: </label><span class="field"><input class="author full" input="text" name="author" value="' . ( in_array( "author", $custom ) ? $custom["author"][0] : "" ) . '" /></span></p>';
	echo '<p><label for="website"> Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . ( in_array( "website", $custom ) ? $custom["website"][0] : "" ) . '" /></span></p>';
}

function save_meta_initiative() {
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'dariah_initiative' == $_POST['post_type'] ) {
		update_post_meta( $post->ID, "link", $_POST["link"] );
		update_post_meta( $post->ID, "author", $_POST["author"] );
		update_post_meta( $post->ID, "website", $_POST["website"] );
	}
}

?>

<?php
add_action( 'init', 'create_type_document' );
add_action( 'admin_init', 'add_meta_document' );
add_action( 'save_post', 'save_meta_document', 9 );

function create_type_document() {
	$labels = array(
		'name'               => __( 'Documents' ),
		'singular_name'      => __( 'Document' ),
		'menu_name'          => __( 'Documents' ),
		'name_admin_bar'     => __( 'Document' ),
		'add_new'            => __( 'Add Document' ),
		'add_new_item'       => __( 'Add Document' ),
		'new_item'           => __( 'New Document' ),
		'edit_item'          => __( 'Edit Document' ),
		'view_item'          => __( 'View Document' ),
		'all_items'          => __( 'All Documents' ),
		'search_items'       => __( 'Search Document' ),
		'not_found'          => __( 'No Documents found.' ),
		'not_found_in_trash' => __( 'No Documents found in trash.' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'about/documents' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

	register_post_type( 'dariah_document', $args );

	$taxonomyCategory = array(
		'hierarchical' => true,
		'label'        => 'Category',
		'query_var'    => true
	);

	register_taxonomy( 'dariah_document_category', 'dariah_document', $taxonomyCategory );
}

function add_meta_document() {
	add_meta_box( 'data_document', 'Informations', 'data_document', 'dariah_document', 'normal', 'high' );
}

function data_document() {
	global $post;
	$custom = get_post_custom( $post->ID );
	echo '<p><label for="link"> Link </label><span class="field"><input class="link full" input="text" name="link" value="' . ( in_array( "link", $custom ) ? $custom["link"][0] : "" ) . '" /></span></p>';
	echo '<p><label for="author"> Author: </label><span class="field"><input class="author full" input="text" name="author" value="' . ( in_array( "author", $custom ) ? $custom["author"][0] : "" ) . '" /></span></p>';
	echo '<p><label for="website"> Website: </label><span class="field"><input class="website full" input="text" name="website" value="' . ( in_array( "website", $custom ) ? $custom["website"][0] : "" ) . '" /></span></p>';
}

function save_meta_document() {
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'dariah_document' == $_POST['post_type'] ) {
		update_post_meta( $post->ID, "link", $_POST["link"] );
		update_post_meta( $post->ID, "author", $_POST["author"] );
		update_post_meta( $post->ID, "website", $_POST["website"] );
	}
}

?>
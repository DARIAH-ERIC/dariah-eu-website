<?php
add_action( 'init', 'create_type_document' );

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

?>
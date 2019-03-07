<?php
add_action( 'init', 'create_type_initiative' );

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

?>

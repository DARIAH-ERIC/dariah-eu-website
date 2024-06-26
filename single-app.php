<?php

/*

Template Name: Dariah App

*/



/// Set the slider

$slider_page_id = $post->ID;
if(is_home() && !is_front_page()){
	$slider_page_id = get_option('page_for_posts');
}

if(get_post_meta($slider_page_id, 'rd_slider_type', true) == 'layer' && (get_post_meta($slider_page_id, 'rd_slider', true) || get_post_meta($slider_page_id, 'rd_slider', true) != 0)){

	function add_revolution_slider(){
		echo '<div>';
	    echo do_shortcode('[rev_slider '.get_post_meta(get_the_ID(), 'rd_slider', true).']');
		echo '</div>';
	}

	if(	get_post_meta($slider_page_id, 'rd_slider_position', true) == 'above'){
		add_action( '__before_header' , 'add_revolution_slider');
	}
	else{
		add_action( '__after_page_title' , 'add_revolution_slider');
	}


}
if(get_post_meta($slider_page_id, 'rd_slider_type', true) == 'layerslider' && (get_post_meta($slider_page_id, 'rd_layerslider', true) || get_post_meta($slider_page_id, 'rd_layerslider', true) != 0)){

	function add_layer_slider(){
		echo '<div>';
	    echo do_shortcode('[layerslider  id="'.get_post_meta(get_the_ID(), 'rd_layerslider', true).'"]');
		echo '</div>';
	}

	if(	get_post_meta($slider_page_id, 'rd_slider_position', true) == 'above'){
		add_action( '__before_header' , 'add_layer_slider');
	}
	else{
		add_action( '__after_page_title' , 'add_layer_slider');
	}


}


get_header('onepage');
the_post();
global $rd_data;
global $bp;
$header_top_bar = get_post_meta( $post->ID, 'rd_top_bar', true );
$header_transparent = get_post_meta( $post->ID, 'rd_header_transparent', true );
$p_sidebar = get_post_meta( $post->ID, 'rd_sidebar', true );
$title = get_post_meta($post->ID, 'rd_title', true);
$title_height = get_post_meta($post->ID, 'rd_title_height', true);
$title_color = get_post_meta($post->ID, 'rd_title_color', true);
$titlebg_color = get_post_meta($post->ID, 'rd_titlebg_color', true);
$ctbg = get_post_meta($post->ID, 'rd_ctbg', true);
$bc = get_post_meta($post->ID, 'rd_bc', true);
$sb_style = $rd_data['rd_sidebar_style'];
$content_border_color = $rd_data['rd_content_border_color'];


/// Check if need to hide header top bar
if ($header_top_bar == 'yes' ){

 echo '<style type="text/css" >#top_bar {display:none;}</style>';

}

/// Check if header is transparent
if( ( $rd_data['rd_nav_type'] == 'nav_type_1' && $header_transparent == "yes" || $rd_data['rd_nav_type'] == 'nav_type_2' && $header_transparent == "yes" || $rd_data['rd_nav_type'] == 'nav_type_3' && $header_transparent == "yes" || $rd_data['rd_nav_type'] == 'nav_type_8' && $header_transparent == "yes" || $rd_data['rd_nav_type'] == 'nav_type_9' || $rd_data['rd_nav_type'] == 'nav_type_9_c' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 90;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 133;
}
}
if( ( $rd_data['rd_nav_type'] == 'nav_type_10' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 91;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 134;
}
}

if($rd_data['rd_nav_type'] == 'nav_type_4' && $header_transparent == "yes" ){


if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 101;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 144;
}

}
if(($rd_data['rd_nav_type'] == 'nav_type_5' || $rd_data['rd_nav_type'] == 'nav_type_6' || $rd_data['rd_nav_type'] == 'nav_type_7' || $rd_data['rd_nav_type'] == 'nav_type_12'  ) && $header_transparent == "yes"){


if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 100;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 143;
}
}


if( ( $rd_data['rd_nav_type'] == 'nav_type_10' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 91;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 134;
}
}


if( ( $rd_data['rd_nav_type'] == 'nav_type_11' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 110;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 153;
}
}


if( ( $rd_data['rd_nav_type'] == 'nav_type_13' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 62;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 105;
}
}


if( ( $rd_data['rd_nav_type'] == 'nav_type_14' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 65;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 108;
}
}

if( ( $rd_data['rd_nav_type'] == 'nav_type_15' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 140;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 183;
}
}if( ( $rd_data['rd_nav_type'] == 'nav_type_16' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 160;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 203;
}
}if( ( $rd_data['rd_nav_type'] == 'nav_type_17' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 159;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 202;
}
}if( ( $rd_data['rd_nav_type'] == 'nav_type_18' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 162;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 205;
}
}
if( ( $rd_data['rd_nav_type'] == 'nav_type_19' ) && $header_transparent == "yes"){

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom + 162;

}else{
		$title_padding_bottom = 43;
	$title_padding_top = 43;
}
}


if($header_transparent == "yes" && $rd_data['rd_nav_type'] !== 'nav_type_19' && $rd_data['rd_nav_type'] !== 'nav_type_19_f' ){
 ?>
<script type="text/javascript" charset="utf-8">
		var j$ = jQuery;
		j$.noConflict();
		"use strict";


		j$('#header_container').css('position', 'absolute');
		j$('#header_container').css('width', '100%');
		j$('header').addClass('transparent_header');
		j$('.header_bottom_nav').addClass('transparent_header');

</script>






<?php

}else {

if($title_height !== ''){

	$title_padding_bottom = $title_height/2;
	$title_padding_top = $title_padding_bottom;
}else{

	$title_padding_bottom = $title_padding_top = 43;

}
}




/// Set title height
echo '<style type="text/css" >.page_title_ctn {padding-top:'.$title_padding_top.'px; padding-bottom:'.$title_padding_bottom.'px;}</style>';


/// Set the title color

if($title_color !== ''){
	$rgba= rd_hex_to_rgb_array($title_color);
	echo '<style type="text/css" >.page_title_ctn h1,.page_title_ctn h2,#crumbs,#crumbs a{color:'.$title_color.';}.page_t_boxed h1,.page_t_boxed h1{border-color:rgba('. $rgba[0].','.$rgba[1].','.$rgba[2] .',0.5); }#crumbs span{color:rgba('. $rgba[0].','.$rgba[1].','.$rgba[2] .',0.8);}</style>';
}
/// Set the title background
if($titlebg_color !== ''){
	echo '<style type="text/css" >.page_title_ctn {background:'.$titlebg_color.';}</style>';
}
if($ctbg !== ''){
	echo '<style type="text/css" >.page_title_ctn{background:url('.$ctbg.') top center; background-size: cover; border-bottom:1px solid '.$content_border_color.'; }</style>';
}

/// Check title style
if($title !== 'no'){  ?>
<div class="page_title_ctn <?php if($titlebg_color !== ''){ echo 'white'; } ?>">
  <div class="wrapper table_wrapper">
  <h1 itemprop="name"><?php the_title(); ?></h1>
  <?php if($bc !== 'no') { ?>
<div id="breadcrumbs">
  <?php if (function_exists('dariah_breadcrumbs')) dariah_breadcrumbs(); ?>
</div>
<?php } ?>
</div>
</div>
<?php }

do_action( '__after_page_title' );

?>
<div class="section def_section">
  <div class="wrapper section_wrapper">
    <?php the_content();  ?>
    <?php
			$app_categories = get_terms( 'dariah_app_category' );
			global $more;
			$tempMore = $more;
			$more = false;
			foreach ( $app_categories as $app_category ) {
			    $app_category_query = new WP_Query( array(
			        'post_type' => 'dariah_app',
							'orderby' => 'date',
							'nopaging' => true,
			        'tax_query' => array(
			            array(
			                'taxonomy' => 'dariah_app_category',
			                'field' => 'slug',
			                'terms' => array( $app_category->slug ),
			                'operator' => 'IN'
			            )
			        )
			    ) );
			    ?>
					<div class="list-category">
			    <h2><?php echo $app_category->name; ?></h2>
			    <p><?php echo $app_category->description; ?></p>
					<ul class="item-list">
			    <?php if ( $app_category_query->have_posts() ) : while ( $app_category_query->have_posts() ) : $app_category_query->the_post();  ?>
			        <li itemscope itemtype="http://schema.org/WebApplication">
								<?php
									$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
									$imagePath = !empty( $image_url[0]) ? $image_url[0] : get_stylesheet_directory_uri() . "/images/default-app-image.png";
								?>
								<a href="<?php the_permalink(); ?>">
									<div class="image-container" style="background-image: url('<?php echo $imagePath; ?>');"></div>
									<div class="app-content">
											<p class="title" itemprop="name"><?php echo the_title(); ?></p>
											<p class="description" itemprop="about"><?php echo wp_strip_all_tags(get_the_content( '' )); ?></p>
									</div>
								</a>
							</li>
			    <?php endwhile; endif; ?>
				</ul>
			    <?php
			    // Reset things, for good measure
			    $app_category_query = null;
			    wp_reset_postdata();
				?></div><?php
			}
			$more = $tempMore;
    ?>
    </div>
  </div>
</div>
<?php get_dariah_footer(); ?>

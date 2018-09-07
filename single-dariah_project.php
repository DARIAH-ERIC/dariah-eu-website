<?php


get_header();
the_post();
global $rd_data;
global $bp;
$header_top_bar = get_post_meta( $post->ID, 'rd_top_bar', true );
$hide_header = get_post_meta( $post->ID, 'rd_hide_header', true );
$hide_footer = get_post_meta( $post->ID, 'rd_hide_footer', true );
$header_transparent = get_post_meta( $post->ID, 'rd_header_transparent', true );
$p_sidebar = "right"; //get_post_meta( $post->ID, 'rd_sidebar', true );
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

/// Check if need to header
if ($hide_header == 'yes' ){

 echo '<style type="text/css" >#header_container,.mt_menu{display:none !important;}</style>';

}

/// Check if need to hide header top bar
if ($hide_footer == 'yes' ){

 echo '<style type="text/css" >#footer_bg {display:none !important;}</style>';

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
  <?php if($bc !== 'no') {  ?>
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
 <?php if ( $p_sidebar == 'right' || $p_sidebar == 'left' ) {
 ?>
    <div id="posts" class=" <?php if ( $p_sidebar == 'right' ) { echo 'left_posts '; } else { echo 'right_posts ';} if ( $sb_style == 'business_sb'){echo " business_posts";} ?>">
      <?php  }else{ ?>
<div id="fw_c" class="clearfix tf_single_page">
    <?php } ?>
    <h2><?php the_title(); ?></h2>
    <div itemprop="review">
    <?php
      the_content();
      $custom = get_post_custom( $post->ID );
    ?>
    </div>
    <div class="project-institutions">
    <?php
      if ($custom['coordinator'][0] !== '') {
        $query = new WP_Query(array(
          'post_type' => 'dariah_institution',
          'p' => $custom['coordinator'][0]
        ));
    ?>
    <div itemprop="contactPoint" itemscope itemtype="http://schema.org/ContactPoint">
    <h4>Coordinator : </h4>
    <?php
        for ($p = 0; $p < count($query->posts); $p++) {
          $website = get_post_meta($query->posts[$p]->ID, 'website', true);
          if ($website !== '') {
            echo '<a href="' . $website .'" target="_blank" itemprop="name">' . $query->posts[$p]->post_title . '</a>';
          } else {
            echo '<span itemprop="name">' . $query->posts[$p]->post_title . '</span>';
          }
        }

        wp_reset_query();
      }
    ?>
    </div>
    <?php
      if ($custom['institutions'][0] !== '') {
        $query = new WP_Query(array(
          'post_type' => 'dariah_institution',
					'post__in' => explode(',', $custom["institutions"][0]),
					'nopaging' => true,
          'orderby' => 'title',
          'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'dariah_institution_country_role',
							'field'    => 'slug',
							'terms'    => array('partner-institutions', 'national-coordinating-institution')
						)
					),
        ));
    ?>

    <h4>Partners : </h4>
    <ul class="partners-list">
    <?php
        for ($p = 0; $p < count($query->posts); $p++) {
          $website = get_post_meta($query->posts[$p]->ID, 'website', true);
          if ($website !== '') {
            echo '<li itemprop="member" itemscope itemtype="http://schema.org/Organization"> <a href="' . $website .'" target="_blank"><span itemprop="name">' . $query->posts[$p]->post_title . '</span></a></li>';
          } else {
            echo '<li itemprop="member" itemscope itemtype="http://schema.org/Organization"><span itemprop="name">' . $query->posts[$p]->post_title . '</span></li>';
          }
        }

        wp_reset_query();
      }
    ?>
    </ul>
  </div>
		<?php

	    $query = new WP_Query(array(
	      'post_type' => 'dariah_person',
	      'orderby' => 'title',
	      'order' => 'ASC',
	      'meta_key' => 'lastname',
	      'nopaging' => true,
				'post__in' => explode(',', $custom["contacts"][0])
	    ));

			if (count($query->posts) > 0) {
		?>
			<h2>Contacts</h2>
      <?php dariah_contact($query->posts); ?>
		<?php
			}
		?>
    </div>
        <?php if ( $p_sidebar == 'right' || $p_sidebar == 'left' ) { ?>
        <div id="sidebar" class=" <?php if ( $p_sidebar == 'right' ) { echo "right_sb"; } else { echo "left_sb"; } if ( $sb_style == 'business_sb'){echo " business_sidebar";} ?> ">
      <?php if ( is_active_sidebar( 'thefox_mc_sidebar' ) ) { generated_dynamic_sidebar(); } ?>
    </div>
    <div class="clearfix"></div>
    <?php  } ?>

  </div>
</div>
<?php get_footer(); ?>

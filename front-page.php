<?php

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


get_header();
the_post();
global $rd_data;
global $bp;
$header_top_bar = get_post_meta( $post->ID, 'rd_top_bar', true );
$hide_header = get_post_meta( $post->ID, 'rd_hide_header', true );
$hide_footer = get_post_meta( $post->ID, 'rd_hide_footer', true );
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
<div class="page_title_ctn">
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
 <?php if ( $p_sidebar == 'right' || $p_sidebar == 'left' ) {
 ?>
    <div id="posts" class=" <?php if ( $p_sidebar == 'right' ) { echo 'left_posts '; } else { echo 'right_posts ';} if ( $sb_style == 'business_sb'){echo " business_posts";} ?>">
      <?php  }else{ ?>
<div id="fw_c" class="clearfix tf_single_page">
    <?php } the_content();   comments_template();?>
    </div>
        <?php if ( $p_sidebar == 'right' || $p_sidebar == 'left' ) { ?>
        <div id="sidebar" class=" <?php if ( $p_sidebar == 'right' ) { echo "right_sb"; } else { echo "left_sb"; } if ( $sb_style == 'business_sb'){echo " business_sidebar";} ?> ">
      <?php if ( is_active_sidebar( 'thefox_mc_sidebar' ) ) { generated_dynamic_sidebar(); } ?>
    </div>
    <div class="clearfix"></div>
    <?php  } ?>

  </div>
</div>
    <div class="allow-space"></div>
    <div class="container" id="container-about">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-1-block about-block">
                    <div class="about-title">
                        <h2>About DARIAH</h2>
                    </div>
                    <div class="about-text">
                        <p>DARIAH-EU is distributed Research Infrastructure that supports and enhances
                            digitally-enabled research and teaching across the Arts and Humanities. It is a network bringing together people, expertise, information, knowledge, content, methods, tools and technologies from its member countries across Europe.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="allow-space"></div>
<?php
//    wp_nav_menu(array(
//        'menu' => 'home-double-menu',
//        'walker' => new Home_Walker_Nav_Menu()
//    ));
?>
    <div class="moving-background background-globe">
        <div class="opacity-film"></div>
        <div class="container-title container numbers-section-content" id="container-numbers">
            <div class="row numbers-row">
                <div class="number-row">
                    <label>18</label>
                    <span>Member Countries</span>
                </div>
                <div class="number-row">
                    <label>162</label>
                    <span>National Partner Institutions</span>
                </div>
                <div class="number-row">
                    <label>25</label>
                    <span>Cooperating Partners</span>
                </div>
            </div>
        </div>
    </div>
    <div class="allow-space blue-space"></div>
    <div class="menu-home-triple-menu-container">
        <ul id="menu-home-triple-menu" class="menu">
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
	            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("WidgetAreaRecentPosts") ) : ?>
	            <?php endif;?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
	            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("WidgetAreaEvents") ) : ?>
	            <?php endif;?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
	            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("WidgetAreaTwitter") ) : ?>
	            <?php endif;?>
            </li>
        </ul>
    </div>
    <div class="allow-space blue-space"></div>
    <div class="moving-background background-mission">
        <div class="opacity-film"></div>
        <div class="container-title">
            <h2>The DARIAH Mission</h2>
            <p>DARIAH's mission is to empower research communities with digital methods to create, connect and
                share knowledge about culture and society.</p>
        </div>
    </div>
    <div class="allow-space blue-space"></div>
<?php
    wp_nav_menu(array(
        'menu' => 'home-quadruple-menu',
        'walker' => new Home_Walker_Nav_Menu()
    ));
?>
    <div class="menu-home-quadruple-menu-container"><ul id="menu-home-quadruple-menu" class="menu">
            <li id="menu-item-1730" class="purple menu-item menu-item-type-post_type menu-item-object-page"
                itemscope="" itemtype="http://schema.org/Article"><div class="image" style="background-image: url(https://www-dev.dariah.eu/wp-content/uploads/2017/05/IMG_3923-612x459.jpg);"><a title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." href="https://www-dev.dariah.eu/tools-services/dariah-training/" itemprop="url">DARIAH Training</a></div><div class="description" itemprop="text" style="height: 300px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a class="more-btn" href="/Tools_and_Service/">More...</a></div></li>
            <li id="menu-item-1730" class="pink menu-item menu-item-type-post_type menu-item-object-page"
                itemscope="" itemtype="http://schema.org/Article"><div class="image" style="background-image: url(https://www-dev.dariah.eu/wp-content/uploads/2017/05/IMG_3923-612x459.jpg);"><a title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." href="https://www-dev.dariah.eu/tools-services/dariah-training/" itemprop="url">DARIAH Training</a></div><div class="description" itemprop="text" style="height: 300px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a class="more-btn" href="/Tools_and_Service/">More...</a></div></li>
            <li id="menu-item-1731" class="menu-item menu-item-type-post_type menu-item-object-page
            menu-item-privacy-policy" itemscope="" itemtype="http://schema.org/Article"><div class="image" style="background-image: url(https://www-dev.dariah.eu/wp-content/uploads/2017/05/IMG_3923-612x459.jpg);"><a title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." href="https://www-dev.dariah.eu/privacy-policy/" itemprop="url">Privacy Policy</a></div><div class="description" itemprop="text" style="height: 300px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a class="more-btn" href="/Tools_and_Service/">More...</a></div></li>
            <li id="menu-item-1732" class="pink menu-item menu-item-type-post_type menu-item-object-page"
                itemscope="" itemtype="http://schema.org/Article"><div class="image" style="background-image: url(https://www-dev.dariah.eu/wp-content/uploads/2017/05/IMG_3923-612x459.jpg);"><a title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." href="https://www-dev.dariah.eu/activities/working-groups-list/" itemprop="url">Working Groups</a></div><div class="description" itemprop="text" style="height: 300px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a class="more-btn" href="/Tools_and_Service/">More...</a></div></li>
        </ul></div>
    <div class="allow-space blue-space"></div>
<?php get_footer(); ?>

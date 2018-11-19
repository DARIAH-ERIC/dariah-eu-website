<?php
  class Home_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
      $classes = empty ( $item->classes ) ? array () : (array) $item->classes;
      $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
      !empty ( $class_names ) and $class_names = ' class="'. esc_attr( $class_names ) . '"';

      $output .= "<li id='menu-item-$item->ID' $class_names itemscope itemtype='http://schema.org/Article'>";

      $attributes  = '';
      ! empty( $item->attr_title )
          and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
      ! empty( $item->target )
          and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
      ! empty( $item->xfn )
          and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
      ! empty( $item->url )
          and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->object_id), 'large' );
      $thumbnail = count($image) > 0 ? $image[0] : '';
      if( isset( $args->before ) ) {
	      if ( ! isset( $item_output ) ) {
		      $item_output = "";
	      }
	      $item_output .= $args->before;
	      $item_output .= '<div class="image" style="background-image: url(' . $thumbnail . ');">';
	      $item_output .= '<a' . $attributes . ' itemprop="url">';
	      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	      $item_output .= '</a>';
	      $item_output .= '</div>';
	      $item_output .= '<div class="description" itemprop="text">' . $item->attr_title . '</div>';
	      $item_output .= $args->after;

	      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
      }
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
      $indent = str_repeat("\t", $depth);
      $output .= "\n$indent</ul></div>";
    }
  }
?>

<?php
function organigram_func( $atts ){
		$person_positions = get_terms( 'dariah_person_position' );
    $positions = array();
    foreach ( $person_positions as $person_position ) {
      $person_position_query = new WP_Query( array(
          'post_type' => 'dariah_person',
          'orderby' => 'date',
          'nopaging' => true,
          'tax_query' => array(
              array(
                  'taxonomy' => 'dariah_person_position',
                  'field' => 'slug',
                  'terms' => array( $person_position->slug ),
                  'operator' => 'IN'
              )
          )
      ) );

      $persons = array();
      for ($p = 0; $p < count($person_position_query->posts); $p++) {
        $person = $person_position_query->posts[$p];
        $custom = get_post_custom($person->ID);

        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($person->ID), 'medium' );
        $imageClasses = array('image-container');
        if (!empty( $image_url[0])) {
          $imagePath = $image_url[0];
        } else {
          $imagePath = get_stylesheet_directory_uri() . "/images/default-dariah.jpg";
          array_push($imageClasses, 'default');
        }
        $imagePath = !empty( $image_url[0]) ? $image_url[0] : get_stylesheet_directory_uri() . "/images/default-dariah.jpg";
        $stripedContent = wp_strip_all_tags($person->post_content);
        $excerpt = wp_trim_words($stripedContent, 15, '');
        $displayMore = strlen($excerpt) >= strlen($stripedContent) ? FALSE : TRUE;
        $isSkills = strlen(trim($person->skills)) !== 0;
        $isLink = strlen(trim($person->link)) !== 0;
        if (($isSkills || $isLink) && strlen($excerpt) > 100) {
          $displayMore = true;
        }
        if ($displayMore) {
          $excerpt .= '...';
        }

        $personObject = new stdClass();
        $personObject->id = $person->ID;
        if (strlen(trim($person->email)) !== 0) {  $personObject->email = $person->email; }
        $personObject->firstname = $person->firstname;
        $personObject->lastname = $person->lastname;
        $personObject->image = $imagePath;
        $personObject->imageClasses = implode($imageClasses, ' ');
        $personObject->excerpt = $excerpt;
        $personObject->full = $stripedContent;
        $personObject->displayMore = $displayMore;
        if (strlen(trim($custom['position'][0])) != 0) { $personObject->position = $custom['position'][0]; }
        if ($isLink) { $personObject->link = $person->link; }
        if ($isSkills) { $personObject->skills = $person->skills; }
        $persons[$personObject->id] = $personObject;
      }
      $position = new stdClass();
      $position->name = $person_position->name;
      $position->description = $person_position->description;
      $position->persons = $persons;
      $positions[$person_position->slug]  = $position;
    }
    $html = '</div>';
    $html .= '<script>var dariahPositionsData = ' . json_encode($positions)  . '</script>';
    $html .= file_get_contents(get_stylesheet_directory_uri() . '/images/organigram.svg');
    $html .= '</div></div>';
    $html .= '<div class="section def_section" id="positions">
      <div class="wrapper section_wrapper">
        <h2></h2>
        <p class="description"></p>
        <a href="#" class="ico-close close"></a>
        <ul class="contact-list"></ul>
        <div id="contactComplete" class="contact-complete"></div>
      </div>
    </div>
    <div class="section def_section" style="margin-bottom: 50px;">
      <div class="wrapper section_wrapper">
        <div>
    ';

    return $html;
  }
  add_shortcode( 'organigram', 'organigram_func' );
?>

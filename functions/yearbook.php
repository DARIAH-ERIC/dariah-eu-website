<?php
  if (!function_exists('dariah_create_json_for_yearbook')) {
    function dariah_create_json_for_yearbook() {
      $data = new stdClass();

      $queryInstitutions = new WP_Query(array(
        'post_type' => 'dariah_institution',
        'nopaging' => true
      ));
      $institutions = array();
      for ($p = 0; $p < count($queryInstitutions->posts); $p++) {
        $institution = $queryInstitutions->posts[$p];
        $jsonInstitution = new stdClass();
        $jsonInstitution->name = $institution->post_title;
        $jsonInstitution->country = $institution->country;
        $institutions[$institution->ID] = $jsonInstitution;
      }

      $queryCountry = new WP_Query(array(
        'post_type' => 'dariah_country',
        'nopaging' => true
      ));
      $countries = array();
      for ($p = 0; $p < count($queryCountry->posts); $p++) {
        $country = $queryCountry->posts[$p];
        $countries[intval($country->ID)] = $country->post_title;
      }

      $person_positions = get_terms('dariah_person_position');
      $positions = array();
      foreach ( $person_positions as $person_position ) {
        $positions[$person_position->term_id] = $person_position->name;
      }

      $queryPerson = new WP_Query(array(
        'post_type' => 'dariah_person',
        'post_status' => 'publish',
        'orderby' => 'lastname',
        'order' => 'ASC',
        'meta_key' => 'lastname',
        'nopaging' => true,
        'meta_query'     => array(
            array(
                'key'       => 'yearbook',
                'value'     => '1',
                'compare'   => '='
            )
        )
      ));
      $persons = array();
      $filterCountries = array();
      $filterInstitutions = array();
      $filterPositions = array();
      for ($p = 0; $p < count($queryPerson->posts); $p++) {
        $person = $queryPerson->posts[$p];
        $custom = get_post_custom($person->ID);
        $position = wp_get_post_terms($person->ID, 'dariah_person_position');
        $jsonPerson = new stdClass();
        $jsonPerson->id = $person->ID;
        $jsonPerson->identifiant = $person->identifiant;
        $jsonPerson->about = nl2br($person->post_content);
        $jsonPerson->email = $person->email;
        $jsonPerson->twitter = $person->twitter;
        $jsonPerson->firstname = $person->firstname;
        $jsonPerson->lastname = $person->lastname;
        $jsonPerson->link = $person->link;
        $jsonPerson->skills = $person->skills;
        $jsonPerson->role = $person->position;
        $jsonPerson->institution = intval($custom['institution'][0]);
        if (count($position) > 0) {
          $positionsOfPerson = array();
          for($i = 0; $i < sizeof($position); $i++) {
	          $positionsOfPerson[] = $position[$i]->term_id;
	          $filterPositions[$position[$i]->term_id] = $positions[$position[$i]->term_id];
          }
          $jsonPerson->positions = $positionsOfPerson;
        } else {
          $jsonPerson->positions = [];
        }
        if ($jsonPerson->institution) {
          $jsonPerson->country = intval($institutions[$jsonPerson->institution]->country);
          $filterInstitutions[$jsonPerson->institution] = $institutions[$jsonPerson->institution];
          $filterCountries[$jsonPerson->country] = $countries[$jsonPerson->country];
        }

        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($person->ID), 'medium' );
        if (!empty( $image_url[0])) {
          $jsonPerson->avatar = $image_url[0];
        } else {
          $jsonPerson->avatar = get_stylesheet_directory_uri() . "/images/default-yearbook.jpg";
        }

        array_push($persons, $jsonPerson);

        $positionsHtmlText[] = array();
        for($i = 0; $i < sizeof($jsonPerson->positions); $i++) {
            $positionsHtmlText[] = (new \Html2Text\Html2Text($jsonPerson->positions[$i]))->getText();
        }
      }
      $data->persons = $persons;
      $data->countries = $filterCountries;
      $data->institutions = $filterInstitutions;
      $data->positions = $filterPositions;

      $json_file = fopen(__DIR__ . "/../build/yearbook.json", "w") or die("Unable to open file!");
      $json_data = json_encode($data);
      fwrite($json_file, $json_data);
      fclose($json_file);
      wp_reset_query();
    }
  }
?>

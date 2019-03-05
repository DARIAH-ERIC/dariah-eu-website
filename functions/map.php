<?php
  if (!function_exists('dariah_create_json_for_map')) {
    function dariah_create_json_for_map() {
      $mapData = new stdClass();

      $queryPerson = new WP_Query(array('post_type' => 'dariah_person', 'nopaging' => true));
      $persons = array();
      for ($p = 0; $p < count($queryPerson->posts); $p++) {
        $person = $queryPerson->posts[$p];
        $custom = get_post_custom($person->ID);
        $jsonPerson = new stdClass();
        $jsonPerson->id = $person->ID;
        $jsonPerson->email = $person->email;
        $jsonPerson->firstname = $person->firstname;
        $jsonPerson->lastname = $person->lastname;
        $jsonPerson->link = $person->link;
        $jsonPerson->skills = $person->skills;
        $persons[$jsonPerson->id] = $jsonPerson;
      }
      $mapData->persons = $persons;

      $queryProjects = new WP_Query(array('post_type' => 'dariah_project', 'nopaging' => true));
      $projects = array();
      for ($p = 0; $p < count($queryProjects->posts); $p++) {
        $project = $queryProjects->posts[$p];
        $custom = get_post_custom($project->ID);
        $jsonProject = new stdClass();
        $jsonProject->id = $project->ID;
        $jsonProject->name = $project->post_title;
        $jsonProject->fullname = $custom['fullname'][0];
        $jsonProject->content = nl2br($project->post_content);
        if ($custom['coordinator'][0] !== '') {
          $jsonProject->coordinator = $custom['coordinator'][0];
        }
        $jsonProject->contacts = explode(',', $custom['contacts'][0]);
        $jsonProject->consortiums = explode(',', $custom['institutions'][0]);
        $jsonProject->website = $custom['website'][0];
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($project->ID), 'medium' );
        if (!empty( $image_url[0])) {
          $jsonProject->image = $image_url[0];
        }
        $jsonProject->link = get_permalink($project->ID);
        array_push($projects, $jsonProject);
      }
      $mapData->projects = $projects;

      $queryInstitutions = new WP_Query(array('post_type' => 'dariah_institution', 'nopaging' => true));
      $institutions = array();
      for ($p = 0; $p < count($queryInstitutions->posts); $p++) {
        $institution = $queryInstitutions->posts[$p];
        $custom = get_post_custom($institution->ID);
        $role = wp_get_post_terms($institution->ID, 'dariah_institution_country_role');
        $jsonInstitution = new stdClass();
        $jsonInstitution->id = $institution->ID;
        $jsonInstitution->name = $institution->post_title;
        $jsonInstitution->content = nl2br($institution->post_content);
        $jsonInstitution->country = $institution->country;
        $jsonInstitution->role = count($role) != 0 ? $role[0]->slug : null;
        $jsonInstitution->latitude = $custom['latitude'][0];
        $jsonInstitution->link = get_permalink($institution->ID);
        $jsonInstitution->longitude = $custom['longitude'][0];
        if ($custom['website'][0] !== '') {
          $jsonInstitution->website = $custom['website'][0];
        }

        $_projects = array();
        $_projectsAsCoordinator = array();
        for ($pi = 0; $pi < count($mapData->projects); $pi++) {
          if (in_array($jsonInstitution->id, $mapData->projects[$pi]->consortiums)) {
            array_push($_projects, $mapData->projects[$pi]->id);
          }
          if ($jsonInstitution->id == $mapData->projects[$pi]->coordinator) {
            array_push($_projectsAsCoordinator, $mapData->projects[$pi]->id);
          }
        }

        if (count($_projects) > 0) {
          $jsonInstitution->projects = array_unique($_projects);
        }
        if (count($_projectsAsCoordinator) > 0) {
          $jsonInstitution->coordinators = array_unique($_projectsAsCoordinator);
        }

        array_push($institutions, $jsonInstitution);
      }
      $mapData->institutions = $institutions;

      $queryCountry = new WP_Query(array('post_type' => 'dariah_country', 'nopaging' => true));
      $countries = array();
      for ($p = 0; $p < count($queryCountry->posts); $p++) {
        $country = $queryCountry->posts[$p];
        $custom = get_post_custom($country->ID);
        $status = wp_get_post_terms($country->ID, 'dariah_country_status');
        $entities = wp_get_post_terms($country->ID, 'dariah_country_entity');
        $jsonCountry = new stdClass();
        $jsonCountry->id = $country->ID;
        if ($country->coordinator !== '') {
          $jsonCountry->coordinator = $country->coordinator;
        }
        $jsonCountry->name = $country->post_title;
        $jsonCountry->code = $country->code;
        $jsonCountry->status = count($status) != 0 ? $status[0]->slug : null;
        $jsonCountry->statusName = count($status) != 0 ? $status[0]->name : null;
        $jsonCountry->entities = $entities;
        $jsonCountry->capital = new stdClass();
        $jsonCountry->capital->latitude = $custom['latitude'][0];
        $jsonCountry->capital->longitude = $custom['longitude'][0];

        $jsonCountry->national = new stdClass();
        $representativePersons = trim($custom['repPersons'][0]);
        $jsonCountry->national->persons = strlen($representativePersons) !== 0 ? explode(',', $representativePersons) : null;
        $representativeInstitutions = trim($custom['repInstitutions'][0]);
        $jsonCountry->national->institutions = strlen($representativeInstitutions) !== 0 ? explode(',', $representativeInstitutions) : null;

        $_partnerInstitutions = array();
        $_cooperatingInstitutions = array();
        $_nationalInstitutions = array();
        $_projects = array();
        for ($pi = 0; $pi < count($mapData->institutions); $pi++) {
          if ($mapData->institutions[$pi]->country == $country->ID) {
            if ($mapData->institutions[$pi]->role == 'partner-institutions') {
              array_push($_partnerInstitutions, $mapData->institutions[$pi]->id);
            } else if ($mapData->institutions[$pi]->role == 'national-coordinating-institution') {
              array_push($_nationalInstitutions, $mapData->institutions[$pi]->id);
            } else if ($mapData->institutions[$pi]->role == 'cooperating-partner') {
              array_push($_cooperatingInstitutions, $mapData->institutions[$pi]->id);
            }

            for ($pp = 0; $pp < count($mapData->projects); $pp++) {
              if ($mapData->projects[$pp]->coordinator == $mapData->institutions[$pi]->id) {
                array_push($_projects, $mapData->projects[$pp]->id);
              }
            }
          }
        }
        $jsonCountry->partnerInstitutions = $_partnerInstitutions;
        $jsonCountry->nationalInstitutions = $_nationalInstitutions;
        $jsonCountry->cooperatingInstitutions = $_cooperatingInstitutions;
        $jsonCountry->projects = $_projects;
        $jsonCountry->countryDescription = $country->post_content;
        $jsonCountry->countryLogo = wp_get_attachment_image_src( get_post_thumbnail_id( $country->ID ), 'single-post-thumbnail' )[0];

        $countries[$jsonCountry->code] = $jsonCountry;
      }
      $mapData->countries = $countries;

      $json_file = fopen(__DIR__ . "/../map/dynamic-data.json", "w") or die("Unable to open file!");
      $json_data = json_encode($mapData);
      fwrite($json_file, $json_data);
      fclose($json_file);
      wp_reset_query();
    }
  }
?>

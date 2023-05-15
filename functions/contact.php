<?php
  if (!function_exists('dariah_contact')) {
    function dariah_contact($items) {
?>
  <ul class="contact-list">
    <?php
      for ($p = 0; $p < count($items); $p++) {
        $item = $items[$p];
        $custom = get_post_custom($item->ID);
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($item->ID), 'medium' );
        $imageClasses = array('image-container');
        if (!empty( $image_url[0])) {
          $imagePath = $image_url[0];
        } else {
          $imagePath = get_stylesheet_directory_uri() . "/images/default-dariah.jpg";
          array_push($imageClasses, 'default');
        }
        $imagePath = !empty( $image_url[0]) ? $image_url[0] : get_stylesheet_directory_uri() . "/images/default-dariah.jpg";

        $stripedContent = wp_strip_all_tags($item->post_content);
        $excerpt = wp_trim_words($stripedContent, 15, '');
        $displayMore = strlen($excerpt) >= strlen($stripedContent) ? FALSE : TRUE;
        $displayLess = strlen($excerpt) >= strlen($stripedContent) ? FALSE : TRUE;
        $isSkills = strlen(trim($custom['skills'][0])) != 0;
        $isLink = strlen(trim($custom['link'][0])) != 0;
        if (($isSkills || $isLink) && strlen($excerpt) > 100) {
          $displayMore = true;
          $displayLess = true;
        }
        if ($displayMore) {
          $excerpt .= '...';
        }
        $imageClassStr = "";

        if (is_array($imageClasses)) {
            //if it is a multidimenisonal array
            if (count($imageClasses) == count($imageClasses, COUNT_RECURSIVE)) {
                foreach ($imageClasses as $k => $v) {
                    $imageClassStr .= $v . ' ';
                }
            } else {
                $imageClassStr = implode($imageClasses, ' ');
            }
        } else {
            $imageClassStr = $imageClasses;
        }
    ?>
    <li>
      <div class="person-desc" itemprop="member" itemscope itemtype="http://schema.org/Person">
        <div class="<?php echo imageClassStr; ?>" style="background-image: url('<?php echo $imagePath; ?>');"></div>
        <div class="content">
          <p class="name" itemprop="name"><?php echo $item->firstname . ' ' . $item->lastname; ?></p>
          <?php if (strlen(trim($custom['position'][0])) != 0) { ?>
            <p class="position" itemprop="jobTitle"><?php echo $custom['position'][0]; ?></p>
          <?php } ?>
          </p>
          <p class="description-excerpt"><?php echo $excerpt; ?></p>
          <p class="description-full" itemprop="description"><?php echo $stripedContent; ?></p>

          <?php if ($isSkills) { ?>
            <p class="skills"><span class="title">Skills and research fields:</span><?php echo $custom['skills'][0]; ?></p>
          <?php } ?>

          <?php if ($isLink) { ?>
            <a href="<?php echo $custom['link'][0]; ?>" target="_blank" class="link about" itemprop="url">About</a>
          <?php } ?>

          <?php if ($displayMore) { ?>
            <a href="#" class="link see-more">See more</a>
          <?php } ?>
          <?php if ($displayLess) { ?>
            <a href="#" class="link see-less">See less</a>
          <?php } ?>

          <?php if(strlen(trim($item->email)) != 0) { ?>
            <a href="mailto:<?php echo $item->email; ?>" class="dariah-mail" itemprop="email"><?php echo $item->email; ?></a>
          <?php } ?>
        </div>
      </div>
    </li>
    <?php } ?>
    </ul>

<?php
    }
  }
?>

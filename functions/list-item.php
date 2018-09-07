<?php
  if (!function_exists('list_item')) {
    function list_item($items_query) {
?>
<ul class="item-list">
<?php
if ( $items_query->have_posts() ) : while ( $items_query->have_posts() ) : $items_query->the_post(); ?>
    <li itemscope itemtype="http://schema.org/GovernmentOrganization">
      <?php
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
        $imagePath = !empty( $image_url[0]) ? $image_url[0] : get_stylesheet_directory_uri() . "/images/default-wg-image.jpg";
      ?>
      <a href="<?php the_permalink(); ?>">
        <div class="image-container" style="background-image: url('<?php echo $imagePath; ?>');"></div>
        <p class="title" itemprop="name"><?php echo the_title(); ?></p>
        <p class="description"itemprop="about"><?php echo wp_strip_all_tags(get_the_content( '' )); ?></p>
      </a>
    </li>
<?php endwhile; endif; ?>
</ul>

<?php
    }
  }
?>

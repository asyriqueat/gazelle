<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
?>

<div id="id-<?php the_ID(); ?>" <?php post_class(); ?> >
  <div class="row row-article row-<?php echo strtolower(get_cat()) ?>">
    <?php 
      $span = explode(".", get_post_meta( get_the_ID(), "_gridlock", true)); 
      $span = $span[1][1]; 

      $image_url = false;
      if ($span == 1 || $span == 2) {
        if (has_post_thumbnail()) {
          $image_url =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "thumbnail", false, ''); 
          $image_url = $image_url[0];
        } else {
          $image_url = catch_image();
        }
      } else {
        if (has_post_thumbnail()) {
          $image_url =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "large", false, ''); 
          $image_url = $image_url[0];
        } else {
          $image_url = catch_image();
        }
      }
      ?>
    <?php if ($image_url) { ?>
      <?php if ($span == 1) { ?>
        <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?>>
          <div class="article-image col-6 col-sm-12" >
            <div class="image" style="background-image: url(<?php echo $image_url ?>)">
              <div class="image-overlay">
                <div class="image-overlay-text">
                  <h5 class="article-title"> <?php echo strtoupper(get_the_title()); ?> </h5>
                </div>
              </div>
            </div>
          </div>
        </a>
        <div class="article-description col-6 col-sm-12 hidden-large">
      <?php } else if ($span == 2) { ?>
        <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?>>
          <div class="article-image col-6">
            <div class="image" style="background-image: url(<?php echo $image_url ?>)"></div>
          </div>
        </a>
        <div class="article-description col-6">
      <?php } else if ($span == 3) { ?>
        <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?>>
          <div class="article-image col-6 col-sm-8">
            <div class="image" style="background-image: url(<?php echo $image_url; ?>)"></div>
          </div>
        </a>
        <div class="article-description col-6 col-sm-4">
      <?php } } else { ?>
      <div class="article-description col-12">
    <?php } ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
          <h5 class"article-title"> <?php echo get_the_title(); ?> </h5>
        </a>
        <?php coauthors_posts_links(", ", " and "); ?>
        <?php the_excerpt(); ?>
      </div>

  </div>
</div>

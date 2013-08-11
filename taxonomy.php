<?php
/**
 * The main template file.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */

get_header(); ?>

  <div class="jumbotron">
    <?php $cat_name = get_category_by_slug(get_query_var("category_name"))->name; ?>
    <h2 class="text-<?php echo strtolower($cat_name); ?>"><?php echo $cat_name; ?></h2> 
    <h3 class="text-primary"><?php echo get_term_by("slug", get_query_var("issue"), "issue")->name; ?></h3>
  </div>
  <?php
      $meta_query = new WP_Query(array_merge(array("issue" => get_query_var("issue"), "category_name" => get_query_var("category_name"), get_option("gridlock_query")) ));
      $old_row = 0;
      while ( $meta_query->have_posts() ) : $meta_query->the_post(); ?>
          <div class='row gridlock-row'>
          <div class="article-container col-12" >
          <?php get_template_part( 'content' ); 
          // closing the column tag
          ?>
          </div>
          </div>
    <?php endwhile; 
        ?>
<?php get_footer(); ?>


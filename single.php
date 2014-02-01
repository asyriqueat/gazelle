<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

  <div class="row">
    <div id="article" class="col-12">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>


			<?php endwhile; // end of the loop. ?>
    </div>
  </div>


<?php get_footer(); ?>

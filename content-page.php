<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */

?>


<div id="id-<?php the_ID(); ?>" <?php post_class(); ?> >
  <div id="category-row" class="row">
    <div id="category-head">
      <div class="category-row header-uncategorized"></div>
      <div class="category-headline <?php if (strtolower(get_the_title()) == 'the archives') { echo 'large';} ?>">
          <h1><?php the_title(); ?></h1> 
        </div>
      </div>
    </div>
  </div>
  <div class="row list">
    <?php the_content(); ?>
  </div>
</div>


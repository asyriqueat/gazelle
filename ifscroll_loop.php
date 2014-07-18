<div class="ifscroll-head">
	<div class="ifscroll-row ifscroll-header-<?php echo strtolower($cat_name); ?>"></div>
	<div class="ifscroll-issue"><h3><?php echo get_term_by("slug", get_query_var("issue"), "issue")->name; ?></h3></div>
</div>
while ( $infinite_posts->have_posts() ) : $infinite_posts->the_post(); ?>
            <div class='row gridlock-row'>
              <div class="article-container col-12" >
                <?php get_template_part( 'content' );
                // closing the column tab?>
              </div>
            </div>
    <?php endwhile; ?>
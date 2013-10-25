<?php
  global $pick_id;
  $pick_id = get_term_by("name", "pick", "post_tag")->term_id;
  global $exclude_id;
  $exclude_id = get_term_by("name", "exclude", "post_tag")->term_id;
  // lock the current issue so that we can check for custom issues
  $currentIssue = get_query_var("issue"); ?>
  <?php if (empty($currentIssue)) { 
    $currentIssue = get_term(get_option('current_issue'), "issue"); 
  } else {
    $currentIssue = get_term_by("slug", $currentIssue, "issue");
  }
  $t_id = $currentIssue->term_id;
  global $issue_meta;
  $issue_meta = get_option( "taxonomy_term_$t_id" );
  // default editor_style
  $issue_meta['editor_style'] = $issue_meta['editor_style'] == '' ? 'default' : $issue_meta['editor_style'];
?>
<div id="home">
  <?php get_template_part('editors', $issue_meta['editor_style']); ?>
  <div class="river">
    <div class='row gridlock-row'>
    <?php 
      $finished = false;
      $max_row = get_option("gridlock_rows");
      if ($max_row == 0) {
        $max_row = 999;
      }
      $row_count = 0;
      $meta_query = new WP_Query(active_issue(array_merge(get_option("gridlock_query"), array('orderby' => 'meta_value_num', 'meta_key' => '_gridlock', 'order' => 'ASC', "post_status" => "publish", 
                        "tag__not_in" => array($exclude_id, $pick_id))
                                        
      )));
      while ( $meta_query->have_posts() ) : $meta_query->the_post(); 
            // get the grid positioning
            // Example input is 32.12, meaning row 32, index starting at 1, spanning 2
            $gridlock = explode(".", get_post_meta( get_the_ID(), "_gridlock", true)); 
            $index = $gridlock[1][0]; 
            $span = $gridlock[1][1];
          ?>
          <div class="article-container col-12 
          <?php
            // opening the span tag
            switch ($span) {
            case "1":
              echo "col-sm-4 article-small";
              break;
            case "2":
              echo "col-sm-8 article-medium";
              break;
            case "3":
              echo "col-sm12 article-large";
              break;
            }
          ?>
          ">
          <?php get_template_part( 'content', 'grid' ); 
          // closing the column tag
          ?>
          </div>
          <?php
            //get_template_part( 'content', get_post_format() );
            $finished = false;
            if ($index + $span == 4) {
              // closing the row if the post finishes it
              echo "</div>";
              // open the next post
              echo "<div class='row gridlock-row'>";
              $finished = true;
              if (++$row_count == $max_row) {
                break;
              }
            }
        endwhile; ?> 
    </div>  
    <?php if (!$finished) { // workaround for hiding the last div ?>
      <div class="gridlock-row"></div>
    <?php } ?>
  </div>
  <div id="other-row" class="row">
    <div id="other-posts" class="row">
      <div id="other-mast">
        <div id="other-bar">
        </div>
        <div id="other-headline">
          <h4>MORE ON</h4>
          <h5>THIS ISSUE</h5>
        </div>
      </div>
      <div id="other-scroll" class="col-12">
        <div class="scroller">
          <ul>
            <?php
              // other posts
              add_filter( 'posts_where', '_exclude_meta_key_in_posts_where' );    
              $params = active_issue(array_merge(get_option("gridlock_grid_query"), array('orderby' => 'date', 'order' => 'DESC', "post_status" => "publish", "tag__not_in" => array($pick_id, $exclude_id) )));
              $other_query = new WP_Query($params);
              while ( $other_query->have_posts() ) : $other_query->the_post(); ?>
                <li>
                  <div class="other-content row-<?php echo strtolower(get_cat()) ?>">
                    <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?>>
                      <h6><?php the_title(); ?></h6>
                    </a>
                    <div>
                      <?php echo(colorbox(get_cat())) ?>
                      <small class="text-muted">
                        <?php coauthors_posts_links(", ", " and "); ?>
                      </small>
                    </div>
                    <?php the_excerpt(); ?>
                  </div>
                </li>
            <?php 
              endwhile;
              remove_filter( 'posts_where', '_exclude_meta_key_in_posts_where' );
            ?>
          </ul>
        </div>
      </div>
    <div class="left carousel-control">
      <a class="icon-prev"></a>
    </div>
    <div class="right carousel-control">
      <a class="icon-next"></a>
    </div>
    </div>
  </div>
</div>

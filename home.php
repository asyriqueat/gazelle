<?php
/**
 * The main template file.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */

get_header(); ?>

  <div id="home">
    <div class='row editors-row'>
      <div class="col-12 col-sm-8">
      <?php
        // editor's pick
        $pick_id = get_term_by("name", "pick", "post_tag")->term_id;
        $other_query = new WP_Query(current_issue(array_merge(get_option("gridlock_query"), array("post_status" => "publish", "tag" => "pick" ))));
        while ( $other_query->have_posts() ) : $other_query->the_post(); ?>
            <div class="row">
              <div id="featured-image" class="col-12 col-sm-8">
                picture
              </div>
              <div class="hidden-sm col-sm-4">
                Caption
              </div>
            </div>
      <?php endwhile; ?>
      </div>
      <div class="hidden-sm col-sm-4">
        Editor's Pick
      </div>
    </div>
    <div class="river">
      <div class='row gridlock-row'>
      <?php 
        $finished = false;
        $max_row = get_option("gridlock_rows");
        if ($max_row == 0) {
          $max_row = 999;
        }
        $row_count = 0;
        $meta_query = new WP_Query(current_issue(array_merge(get_option("gridlock_query"), array('orderby' => 'meta_value', 'meta_key' => '_gridlock', 'order' => 'ASC', "post_status" => "publish", 
                          "tag__not_in" => $pick_id)
                                          
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
    <div class="row other-row">
    <?php
      // other posts
      add_filter( 'posts_where', '_exclude_meta_key_in_posts_where' );    
      $other_query = new WP_Query(current_issue(array_merge(get_option("gridlock_query"), array("post_status" => "publish", "tag__not_in" => $pick_id))));
      while ( $other_query->have_posts() ) : $other_query->the_post(); 
        echo the_title();
      endwhile;
      remove_filter( 'posts_where', '_exclude_meta_key_in_posts_where' );
      ?>
    </div>
    </div>
<?php get_footer(); ?>

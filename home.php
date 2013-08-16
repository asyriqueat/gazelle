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
      <div id="editors" class="col-12 col-sm-8">
        <?php
          // editor's pick
          $editors = array();
          $pick_id = get_term_by("name", "pick", "post_tag")->term_id;
          $editor_query = new WP_Query(current_issue(array_merge(get_option("gridlock_query"), array("post_status" => "publish", "tag" => "pick", "posts_per_page" => 4 ))));
          while ( $editor_query->have_posts() ) : $editor_query->the_post();
            global $authordata;
            $image_url = catch_image();
            $category = get_cat();
            $pick = array("title" => '<a href="' . get_permalink() . '">' . '<h6>' . get_the_title() . '</h6>' . '</a>',
                        "link" => get_permalink(),
                        "excerpt" => get_the_excerpt(),
                        "author" => '<a href="' . get_author_posts_url($authordata->ID) . '" ><small class="text-muted">' . get_the_author_meta('display_name') . '</small></a>',
                        "image" => $image_url,
                        "category" => $category );
            $editors[] = $pick;
          endwhile; ?>
        <div class="row">
          <div id="top-scroll" class="col-12 col-sm-8">
            <div class="scroller">
              <ul>
              <?php
                foreach ($editors as $pick) { ?>
                  <li>
                    <div class="item">
                      <a href="<?php echo $pick["link"]; ?>">
                        <div style="background-image: url(<?php echo $pick["image"] ?>)" class="image" ></div>
                      </a>
                      <div class="caption">
                        <span class="visible-sm">
                          <span class="text-<?php echo strtolower($pick["category"]) ?>"><?php echo $pick["title"]; ?></span>
                          <?php echo $pick["author"]; ?>
                        </span>
                        <span class="hidden-sm">
                          <?php echo $pick["excerpt"]; ?>
                        </span>
                      </div>
                    </div>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="left carousel-control">
              <a class="icon-prev active"></a>
            </div>
            <div class="right carousel-control">
              <a class="icon-next"></a>
            </div>
          </div>
              <div id="editor-labels" class="hidden-sm col-sm-4">
                <?php for ($i = 0 ; $i < 4 ; $i++) {  ?>
                  <div id="pick-<?php echo $i; ?>" class="pick-label row <?php echo ($i == 0 ? "active" : ""); ?> row-<?php echo strtolower($editors[$i]["category"])?>" >
                    <?php echo $editors[$i]["title"]; ?>
                <?php echo colorbox($editors[$i]["category"]); ?>
                <?php echo $editors[$i]["author"]; ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div id="top-side" class="hidden-sm col-sm-4">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#top-articles" data-toggle="tab">Trending</a></li>
          <li><a href="#past-issue" data-toggle="tab">Past Issues</a></li>
        </ul>
        <div class="tab-content">
          <div id="top-articles" class="tab-pane active fade in">
            <?php top_articles(); ?>
          </div>
          <div id="past-issue" class="tab-pane fade">
            <?php
            $args = array(
              'orderby'       => "slug", 
              'order'         => "ASC",
              'number'        => 4, 
              'exclude'       => get_option("exclude_issues")
            );
            $terms = get_terms("issue", $args); ?>
            <ul class="issues-list list-unstyled">
            <?php foreach ($terms as $term) { ?>
              <li class="issue-item"><a href='<?php echo site_url() . '/' . $term->slug ?>'
                title='View all posts in <?php echo $term->name ?>'><h6><?php echo $term->name ?></h6></a>
                <small class="text-muted"><?php echo $term->description; ?></small>
              </li>
            <?php } ?>
            </ul>
          </div>
        </div>
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
                $params = current_issue(array_merge(get_option("gridlock_grid_query"), array('orderby' => 'date', 'order' => 'DESC', "post_status" => "publish", "tag__not_in" => $pick_id)));
                $other_query = new WP_Query($params);
                while ( $other_query->have_posts() ) : $other_query->the_post(); ?>
                  <li>
                    <div class="other-content row-<?php echo strtolower(get_cat()) ?>">
                      <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?>>
                        <h6><?php the_title(); ?></h6>
                      </a>
                      <div>
                        <?php echo(colorbox(get_cat())) ?>
                        <?php echo the_author_posts_link(); ?>
                      </div>
                      <?php the_excerpt(); ?>
                    </div>
                  </li>
                <?php endwhile;
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
<?php get_footer(); ?>

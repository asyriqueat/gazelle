  <?php
    global $issue_meta;
    global $exclude_id;
  ?>
  <div class="row editors-row">
    <div id="small-banner" class="col-12 col-sm-8">
      <?php
        get_template_part('banner');
      ?>
    </div>
    <div id="editors" class="col-12 col-sm-8 hide-big-editors">
      <?php
        // editor's pick
        $editors = array();
        $pick_id = get_term_by("name", "pick", "post_tag")->term_id;
        $editor_query = new WP_Query(active_issue(array_merge(get_option("gridlock_query"), array("post_status" => "publish", "tag" => "pick", "tag__not_in" => $exclude_id
        ))));
        while ( $editor_query->have_posts() ) : $editor_query->the_post();
          global $authordata;
          $image_url = false;
            if (has_post_thumbnail()) {
              $image_url =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "large", false, ''); 
              $image_url = $image_url[0];
            } else {
              $image_url = catch_image();
            }
            $category = get_cat();
            ob_start();
            $pick = array("title" => '<h6>' . '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'. '</h6>' ,
                        "link" => get_permalink(),
                        "excerpt" => get_the_excerpt(),
                        "author" => "<small class='text-muted'>" . coauthors_posts_links(", ", " and ") . "</small>",
                        "image" => $image_url,
                        "category" => $category );
            $editors[] = $pick;
            ob_end_clean();
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
                <div id="pick-<?php echo $i; ?>" class="pick-label no-touch row <?php echo ($i == 0 ? "active" : ""); ?> row-<?php echo strtolower($editors[$i]["category"])?>" >
                  <?php echo $editors[$i]["title"]; ?>
                  <?php echo colorbox($editors[$i]["category"]); ?>
                  <?php echo $editors[$i]["author"]; ?>
                </div>
              <?php } ?>
            </div>
        </div>
      </div>
      <?php get_template_part( 'editors', 'rightbox'); ?>
  </div>
    <?php
        rewind_posts();
        $special_count = 0;
        ?>
        <div class='row gridlock-row six-boxes hidden-sm'>
        <?php
        while ( $editor_query->have_posts() ) : $editor_query->the_post(); ?>
          <div class="article-container col-12 col-sm-4 article-small hidden-sm">
            <?php 
              get_template_part( 'content', 'grid' ); 
              $special_count++;
            ?>
          </div>
          <?php if ($special_count == 3) {
            // we allow only 3 posts max in this view
            break;
          }
         endwhile; ?> 
        </div>

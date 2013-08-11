<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
?>

<div class="row sidebar">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#top-articles">Trending</a></li>
  </ul>
  <div class="tab-content">
    <div id="top-articles" class="tab-pane active">
      <?php top_articles(); ?>
    </div>
  </div>
</div>
<div class="row sidebar">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#top-articles">Editor's Picks</a></li>
  </ul>
  <div id="editor-box" class="tab-content">
    <div id="top-articles" class="tab-pane active">
      <ul>
        <?php 
          global $authordata;
          $editor_query = new WP_Query(get_issue(array_merge(get_option("gridlock_query"), array("post_status" => "publish", "tag" => "pick", "posts_per_page" => 4))));
          while ( $editor_query->have_posts() ) : $editor_query->the_post();
            echo "<li class='list-unstyled'>";
              echo '<a href="' . get_permalink() . '">' . '<h6>' . get_the_title() . '</h6>' . '</a>';
              echo colorbox(get_cat());
              echo '<a href="' . get_author_posts_url($authordata->ID) . '" ><small class="text-muted">' . get_the_author_meta('display_name') . '</small></a>';
            echo "</li>";
          endwhile;
        ?>
      </ul>
    </div>
  </div>
</div>

<?php
function gridster() { 
  $query = gridster_query(); 
  $max_row = 0; ?>
  <div data-root='<?php echo site_url(); ?>' class="gridster">
    <div id="grid-buttons" class="row">
      <div class="col-6">
        <button id="btn-save" type="button" class="btn btn-primary btn-block">Save Grid</button>
      </div>
      <div class="col-6">
        <button id="btn-preview" type="button" class="btn btn-success btn-block">Go To Preview</button>
      </div>
    </div>
    <ul>
  <?php
    $params = current_issue(gridlock_future(array_merge(get_option("gridlock_grid_query"), array('orderby' => 'date', 'order' => 'DESC', "post_status" => "publish", "tag__not_in" => get_term_by("name", "pick", "post_tag")->term_id))));
    $gridster_query = new WP_Query($params);
    while ( $gridster_query->have_posts() ) : $gridster_query->the_post(); 
      if (get_post_meta( get_the_ID(), "_gridlock", true) > 1) { 
          $gridlock =  explode(".", get_post_meta( get_the_ID(), "_gridlock", true)); 
          $index = $gridlock[1][0]; 
          $span = $gridlock[1][1]; 
          $row = $gridlock[0]; ?>
          <li data-row="<?php echo $row ?>" data-col="<?php echo $index ?>" data-sizex="<?php echo $span ?>" data-sizey="1" data-post_id=<?php the_ID(); ?>>
            <div class="gridster-box">
              <div class="row gridster-title">
                <?php the_title(); ?> 
              </div>
              <div class="row">
                <button type="button" class="btn btn-info btn-block toggle-btn">Toggle Size</button>
              </div>
              <div class="row">
                <button type="button" class="btn btn-danger btn-block remove-btn">Remove</button>
              </div>
            </div>
          </li>
      <?php } 
    endwhile;
    ?>
    </ul>
  </div>
<?php
}
function ungridded_posts() {
  $params = current_issue(gridlock_future(array_merge(get_option("gridlock_grid_query"), array('orderby' => 'date', 'order' => 'DESC', "post_status" => "publish", "tag__not_in" => get_term_by("name", "pick", "post_tag")->term_id))));
  $unassigned = new WP_Query($params);
  echo "<ul id='ungridded' class='list-unstyled'>";
  while ( $unassigned->have_posts() ) : $unassigned->the_post(); 
    $gridlock_meta = get_post_meta(get_the_ID(), "_gridlock", true);
    if (!isset($gridlock_meta) || $gridlock_meta < 1) {
      echo "<li><a href='#' data-post_id=" . get_the_ID() . " class='text-primary'>+" . get_the_title() . "</a></li>";
    }
  endwhile;
  echo "</ul>";
}

function _exclude_meta_key_in_posts_where( $where ) {
    global $wpdb;
    return $where . " AND $wpdb->posts.ID NOT IN ( SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = '_gridlock' AND meta_value > '' )";
}
function gazelle_set_post_views($postID) {
  $count_key = 'gazelle_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    $count = 0;
  }
  update_post_meta($postID, $count_key, ++$count);
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function gazelle_track_post_views ($post_Id) {
  if (!is_single() ) return;
  if ( empty ($post_id) ) {
    global $post;
    $post_id = $post->ID;
  }
  gazelle_set_post_views($post_id);
}
add_action( 'wp_head', 'gazelle_track_post_views');

function colorbox ($categoryname) { ?>
  <div class="colorbox colorbox-<?php echo strtolower($categoryname); ?>">
  </div>
<?php }
function get_cat() {
  $categories = get_the_category();
  if (!empty($categories)) {
   return $categories[0]->cat_name;
  } else {
   return '';
  }
}
function top_articles() {
  global $authordata;
  echo "<ul>";
  $popular = new WP_Query(get_issue(array_merge(get_option("gridlock_query"), array('posts_per_page' => 5, 'orderby' => 'meta_value', 'meta_key' => 'gazelle_views_count', 'order' => 'DESC', "post_status" => "publish", ))));
  while ( $popular->have_posts() ) : $popular->the_post();
    echo "<li class='list-unstyled'>";
      echo '<a href="' . get_permalink() . '">' . '<h6>' . get_the_title() . '</h6>' . '</a>';
      echo colorbox(get_cat());
      echo '<a href="' . get_author_posts_url($authordata->ID) . '" ><small class="text-muted">' . get_the_author_meta('display_name') . '</small></a>';
    echo "</li>";
  endwhile;
  echo "</ul>";
}

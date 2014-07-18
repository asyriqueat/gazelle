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
  $popular = new WP_Query(active_issue(array_merge(get_option("gridlock_query"), array('posts_per_page' => 5, 'orderby' => 'meta_value_num', 'meta_key' => 'gazelle_views_count', 'order' => 'DESC', "post_status" => "publish", ))));
  while ( $popular->have_posts() ) : $popular->the_post();
    echo "<li class='list-unstyled row row-" . strtolower(get_cat()) . "'>";
      echo '<a href="' . get_permalink() . '">' . '<h6>' . get_the_title() . '</h6>' . '</a>';
      echo colorbox(get_cat());
      echo '<small class="text-muted">';
      coauthors_posts_links(", ", " and ");
      echo "</small>";
    echo "</li>";
  endwhile;
  echo "</ul>";
}


function archive_list() {
  $args = array(
    'orderby'       => "slug",
    'order'         => "DESC",
    'exclude'       => get_option("exclude_issues")
  );
  $terms = get_terms("issue", $args);
  $count = 0;
  ?>
  <div id="archives" class="container">
  <?php usort($terms, "issues_sort"); ?>
  <?php foreach ($terms as $term) {  ?>
    <?php if($count % 3 == 0) { ?>
      <div class="row">
    <?php } ?>
      <div class="col-12 col-sm-4">
        <div class="issue-container">
          <a href='<?php echo site_url() . '/issue/' . $term->slug ?>'
                title='View all posts in <?php echo $term->name ?>'>
            <h3><?php echo $term->name ?></h3>
          </a>
          <h4 class="text-muted"><?php echo $term->description; ?></h4>
        </div>
      </div>
    <?php if(++$count % 3 == 0) { ?>
      </div>
    <?php } ?>
  <?php } ?>
  </div>
  <?php
}

add_shortcode('archives', 'archive_list');

function make_tooltip($atts, $content) {
  extract( shortcode_atts( array(
    "tooltip" => "",
    "href" => "#"
  ), $atts, "tooltip"));
  return "<a class='tooltip-link' href='{$href}' data-toggle='tooltip' title='{$tooltip}'>{$content}</a>"
    . "<script>$('.tooltip-link').tooltip();</script>";

}

add_shortcode('tooltip', 'make_tooltip');

function blockquote_image($atts, $content) {
  extract( shortcode_atts( array(
    "image" => "#"
  ), $atts, "image"));
  return "<div class='blockquote-image' style='background-image:url({$image})'>{$content}</div>";
}

add_shortcode('blockquote_image', 'blockquote_image');


function make_slideshow($atts, $content) {
  $slides = explode(";", $content);
  $slideCount = count($slides);
  $firstCaption = false;
  $pattern = "/^\[(.+)\]\((.+)\)/";
  $matches = array();

  ?>
  <div class="wp-caption alignnone slideshow-container">
    <div class="slideshow full-width">
      <div class="scroller">
        <ul>
  <?php
  foreach ($slides as $slide) {
    preg_match($pattern, $slide, $matches);
    if (!count($matches)) continue;
    $caption = $matches[1];
    $imgLink = $matches[2];
    if (!$firstCaption) $firstCaption = $caption;
    echo '<li class="item">';
    ?>
      <div style="background-image: url(<?php echo $imgLink; ?>)" class="image"><?php echo $caption; ?></div>
    <?php
    echo '</li>';
  }
  ?>
          </ul>
        </div>
        <div class="left carousel-control">
          <a class="icon-prev"></a>
        </div>
        <div class="right carousel-control">
          <a class="icon-next"></a>
        </div>
      </div>
      <p class="caption wp-caption-text">
        <?php echo $firstCaption; ?>
      </p>
    </div>
  </div>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/slideshow.js?v=1" type="text/javascript"></script>
  <?php
}

add_shortcode('slideshow', 'make_slideshow');

function big_image($atts, $content) {
  return "<div class='big-image'> $content </div>";
}

add_shortcode('big_image', 'big_image');

add_filter('manage_posts_columns', 'my_columns');
function my_columns($columns) {
    $columns['views'] = 'Views';
    return $columns;
}
function add_video_embed_note($html, $url, $attr) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'add_video_embed_note', 10, 3);

add_action('manage_posts_custom_column',  'my_show_columns');
function my_show_columns($name) {
    global $post;
    switch ($name) {
        case 'views':
            $views = get_post_meta($post->ID, 'gazelle_views_count', true);
            echo $views;
    }
}

function issues_sort($a, $b) {
  "sorting";
  return ((int) $a->slug < (int) $b->slug);
}

add_image_size("mt_profile_img", 500, 500, false);

// we don't want the default avatar anywhere
add_filter( 'mpp_avatar_override', '__return_true' );

// allow html in author page
remove_filter('pre_user_description', 'wp_filter_kses');

//Infinite scroll
function gazelle_infinitepaginate(){
  $contentFile  = $_POST['content_file'];
  $issuenum   = $_POST["issue_num"];
  $category   = $_POST['category'];

  $infinite_posts = new WP_Query(array_merge(array("issue" => $issuenum, "category_name" => $category), get_option("gridlock_query")) );
  echo get_object_vars($infinite_posts);
  get_template_part($contentFile);

  exit;
 }
 add_action('wp_ajax_infinite_scroll', 'gazelle_infinitepaginate');
 add_action('wp_ajax_nopriv_infinite_scroll', 'gazelle_infinitepaginate');
 ?>

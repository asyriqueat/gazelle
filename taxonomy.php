<?php
/**
 * The main template file.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */

get_header(); ?>

<?php $cat = get_query_var("category_name");
  if (!empty($cat)) { // category ?>
    <div id="category-row" class="row">
      <div id="category-head">
        <?php $cat_name = get_category_by_slug(get_query_var("category_name"))->name; ?>
        <div class="category-row header-<?php echo strtolower($cat_name); ?>"></div>
        <div class="category-headline large">
          <h1><?php echo $cat_name; ?></h1>
          <h3><?php echo get_term_by("slug", get_query_var("issue"), "issue")->name; ?></h3>
        </div>
      </div>
    </div>
<div class="list list-items">
    <?php
        if (get_query_var("category_name") == "media") {
          $meta_query = new WP_Query(array_merge(array("category_name" => get_query_var("category_name"), get_option("gridlock_query")) ));
        } else {
          $meta_query = new WP_Query(array_merge(array("issue" => get_query_var("issue"), "category_name" => get_query_var("category_name"), get_option("gridlock_query")) ));
        }
        $old_row = 0;
        while ( $meta_query->have_posts() ) : $meta_query->the_post(); ?>
            <div class='row gridlock-row'>
              <div class="article-container col-12" >
                <?php get_template_part( 'content' );
                // closing the column tab?>
              </div>
            </div>
    <?php endwhile; ?>
  <?php } else {
    // issue
  ?>
  <?php get_template_part("issue"); ?>
  <?php } ?>
</div>
<script type="text/javascript">
var count = 1;
var urlArray = $(location).attr('href').split("/");
var issueNumber = parseInt(urlArray[($.inArray("issue", urlArray) + 1)]);
var issueCategory = urlArray[($.inArray("issue", urlArray) + 2)];
$(window).scroll(function(){
    if ($(window).scrollTop() == $(document).height() - $(window).height()){
            // run our call for pagination
            console.log("Reached end!");
            console.log(issueNumber - count);
            loadScroll(issueNumber - count);
            count = count + 1;
            }
});

function loadScroll(issueNumber) {
  $.ajax({
      url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
      type:'POST',
      data: "action=infinite_scroll&issue_num="+ issueNumber + '&category=' + issueCategory,
      success: function(html){
          $(".list").append(html);    // This will be the div where our content will be loaded
      }
  });
  return false;
}
</script>

<?php get_footer(); ?>


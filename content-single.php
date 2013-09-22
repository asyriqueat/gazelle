<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */

 ?>

<div id="id-<?php the_ID(); ?>" class="article container">
  <div class="row row-date">
    <div class="col-12">
      <h5 class="text-muted"><?php the_date(); ?></h5>
    </div>
  </div>
  <div class="row row-title">
    <div class="col-12">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
  <div class="row row-byline">
    <div class="col-12">
      <?php echo colorbox(get_cat()); ?>
      <h4 class="text-muted"><?php coauthors_posts_links(", ", " and "); ?></h4>
    </div>
  </div>
  <div class="row row-content">
    <div class="col-12">
      <?php the_content(); ?>
    </div>
  </div>
  <div class="row row-share">
    <div class="col-12">
<div class="fb-like" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-width="450" data-show-faces="true" data-send="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGazelleAD" data-dnt="true">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
  </div>
  <div class="row row-author">
    <div class="author-container">
      <div class="image-container">
      <?php
        $i = new CoAuthorsIterator();
        $count = 0;
        global $authordata;
        $pattern = '/.+src="(.+?)".+/';
        while ($i->iterate()) {
            $img = mt_profile_img( get_the_author_meta( 'ID' ), array("echo" => false)); 
            if (strlen($img) > 0) {
            $parsed = preg_replace($pattern, "$1", $img);
            $count++; ?>
  
            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="Posts by <?php echo the_author_meta( 'display_name' ); ?>">
              <div class="image" style="background-image: url(<?php echo $parsed ?>)"></div>
            </a>
      <?php 
        }
      }

      ?>
      </div>
      <h5 style="padding-left: <?php echo (90 * $count + 10) . 'px' ?>"><?php coauthors_posts_links(", ", " and "); ?></h5>
    </div>
  </div>
  <div class="row row-more">
    <div class="bar bar-<?php echo strtolower(get_cat()); ?>">
      <h5>More in <?php echo get_cat(); ?></h5>
    </div>
    <div id="scroll-wrap">
      <div id="more-scroll">
        <div class="scroller">
          <ul>
            <?php
              // other posts
              $params = active_issue(array_merge(get_option("gridlock_grid_query"), array('orderby' => 'date', 'order' => 'DESC', "post_status" => "publish", "category_name" => strtolower(get_cat()))));
              $current_id = get_the_ID();
              $more_query = new WP_Query($params);
              while ( $more_query->have_posts() ) : $more_query->the_post(); ?>
                <?php if (get_the_ID() != $current_id) { 
                  $image_url = false;
                    if (has_post_thumbnail()) {
                      $image_url =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(300, 300), false, ''); 
                      $image_url = $image_url[0];
                    } else {
                      $image_url = catch_image();
                    }
                ?>
                <li>
                  <div class="more-content">
                    <a href="<?php the_permalink(); ?>" title=<?php the_title(); ?> class="row-article">
                      <div class="article-image" >
                        <div class="image" style="background-image: url(<?php echo $image_url ?>)">
                          <div class="image-overlay">
                            <div class="image-overlay-text">
                              <h5 class="article-title"> <?php echo strtoupper(get_the_title()); ?> </h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </li>
                <?php } ?>
              <?php endwhile;
              remove_filter( 'posts_where', '_exclude_meta_key_in_posts_where' );
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
    </div>
  </div>
  <div class="row row-comments">
    <?php do_shortcode('[fbcomments url="' . home_url( $wp->request ) . '"]'); ?>
  </div>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=221480151338840";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

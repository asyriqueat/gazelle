<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
  // lock the current issue so that we can check for custom issues
  $currentIssue = get_query_var("issue"); ?>
  <?php if (empty($currentIssue)) { 
    $currentIssue = get_term(get_option('current_issue'), "issue"); 
  } else {
    $currentIssue = get_term_by("slug", $currentIssue, "issue");
  }
  $t_id = $currentIssue->term_id;
  $issue_meta = get_option( "taxonomy_term_$t_id" );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
<title><?php echo bloginfo('name') . (is_home() ? "" : ' - ' . wp_title('', false)); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css?v=7" />
<link href='//fonts.googleapis.com/css?family=Lora|Roboto+Condensed' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery-2.0.3.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/iscroll.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery.fitvids.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/script.js" type="text/javascript"></script>
<meta name="description" content="The Gazelle is a weekly student publication, serving the NYU Abu Dhabi community and the greater Global Network University at NYU.">
<meta name="keywords" content="NYUAD, NYU, New York University, Abu Dhabi, Newspaper, Student, Publication, News, Features, Opinion, Middle East">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="main" class="container">
  <div id="header">
    <?php $issue = get_query_var("issue") ?>
    <?php if (empty($issue)) { 
      $issue = get_term(get_option('current_issue'), "issue"); 
    } else {
      $issue = get_term_by("slug", $issue, "issue");
    }
    $issue_url = esc_url( get_site_url() ) . '/issue/' . $issue->slug;
    ?>
    <div id="masthead">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr ( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <h1>THE GAZELLE</h1>
      </a>
      <div id="issue">
        <a href="<?php echo esc_url(get_site_url()) . '/the-archives/' ?>" title="View the archives">
          <div class="issuenumber" <?php echo $issue_meta['background'] ? "style='background-image:url(" . $issue_meta['background'] . ")'" : "" ?>><?php echo $issue->name; ?></div>
        </a>
        <div class="date text-muted"> <?php echo $issue->description; ?></div>
        <div id="social">
          <a title="Connect with us on Twitter" href="http://bit.ly/1auyZwD">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/twitter.png">
          </a>
          <a title="Connect with us on Facebook" href="http://on.fb.me/13wvSyX">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook.png">
          </a>
          <a title="Connect with us on Tumblr" href="http://bit.ly/15OqmV8">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tumblr.png">
          </a>
        </div>
      </div>	
    </div>
    <div id="nav">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr ( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <img src="<?php echo $issue_meta['logo'] ? $issue_meta['logo'] : get_stylesheet_directory_uri() . '/images/gazelle_logo.png'; ?>">
      </a>
      <div id="navbar"></div>
        <div class="nav-list">
          <a href="<?php echo $issue_url . '/news/' ?>" title="News" rel="category">
            <div class="nav-element">
              <div id="news">News</div>
            </div>
          </a>
          <a href="<?php echo $issue_url . '/features/' ?>" title="Features" rel="category">
          <div class="nav-element">
            <div id="features">Features</div>
          </div>
          </a>
          <a href="<?php echo $issue_url . '/opinion/' ?>" title="Opinion" rel="category">
          <div class="nav-element">
            <div id="opinion">Opinion</div>
          </div>
          </a>
          <a href="<?php echo esc_url( home_url( '/' ) ) . 'category/media/' ?>" title="Media" rel="category">
          <div class="nav-element">
            <div id="media">Media</div>
          </div>
          </a>
        </div>
      <?php get_search_form(); ?>
    </div>

      
  </div>
			
  <div id="body" class="container">

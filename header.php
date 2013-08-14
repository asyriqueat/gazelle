<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php echo bloginfo('name') . (is_home() ? "" : ' - ' . wp_title('', false)); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css" />
<link href='//fonts.googleapis.com/css?family=Lora|Roboto+Condensed' rel='stylesheet' type='text/css'>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery-2.0.3.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/iscroll.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/script.js" type="text/javascript"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="main" class="container">
  <div id="header">
    <?php $issue = get_query_var("issue") ?>
    <?php if(empty($issue)) { 
      $issue = get_term(get_option('current_issue'), "issue"); 
    } else {
      $issue = get_term_by("slug", $issue, "issue");
    }
    $issue_url = esc_url( get_site_url() ) . '/issue/' . $issue->slug;
    ?>
    <div id="masthead">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr ( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <img id="title" src="<?php echo get_stylesheet_directory_uri(); ?>/images/header.jpg">
      </a>
      <div id="issue">
        <a href="<?php if ( is_single() ) { echo get_site_url() . '/issue/' . $issue-> slug; } else { echo esc_url(get_site_url()) . '/issues/'; } ?>">
          <div class="issuenumber">ISSUE&nbsp;<?php echo $issue->slug; ?></div>
        </a>
        <div class="date text-muted"> <?php echo $issue->description; ?></div>
      </div>	
    </div>
    <div id="nav">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr ( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gazelle_logo.png">
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
        </div>
      <?php get_search_form(); ?>
    </div>

      
  </div>
			
  <div id="body" class="container">

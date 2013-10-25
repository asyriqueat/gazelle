<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
?>

</div><!-- closing body div -->
</div><!-- closing function div -->
<?php wp_footer(); ?>
<?php $root = esc_url( get_site_url() ) ?>
<div id="foot">
  <ul>
    <li>
      <a href="<?php echo $root . '/about-us/' ?>" title="About Us" rel="about">
        <h4>About Us</h4>
      </a>
    </li>
    <li>
      <a href="<?php echo $root . '/code-of-ethics/' ?>" title="About Us" rel="code">
        <h4>Code of Ethics</h4>
      </a>
    </li>
    <li>
      <a href="<?php echo $root . '/our-team/' ?>" title="Our Team" rel="team">
        <h4>Our Team</h4>
      </a>
    </li>
  </ul>
</div>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery-2.0.3.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/iscroll.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery.fitvids.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/script.js" type="text/javascript"></script>
</body>
</html>

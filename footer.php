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
      <a href="<?php echo $root . '/about/' ?>" title="About Us" rel="about">
        About Us
      </a>
    </li>
    <li>
      <a href="<?php echo $root . '/ethics/' ?>" title="About Us" rel="code">
        Code of Ethics
      </a>
    </li>
    <li>
      <a href="<?php echo $root . '/team/' ?>" title="Our Team" rel="team">
        <a href="#">Our Team</a>
      </a>
    </li>
  </ul>
</div>
</body>
</html>

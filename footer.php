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
    <li>
      <a href="<?php echo $root . '/the-archives/' ?>" title="The Archives" rel="archives">
        <h4>The Archives</h4>
      </a>
    </li>
  </ul>
</div>
</body>
</html>

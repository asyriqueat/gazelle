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

<div class="row sidebox">
  <div class="tab-content">
    <div id="top-articles" class="tab-pane active">
      <?php top_articles(); ?>
    </div>
  </div>
</div>

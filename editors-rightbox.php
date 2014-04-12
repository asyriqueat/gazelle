<div id="top-side" class="hidden-sm col-sm-4">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#top-articles" data-toggle="tab">Trending</a></li>
    <li><a href="#columnists" data-toggle="tab">Columnists</a></li>
  </ul>
  <div class="tab-content">
    <div id="top-articles" class="tab-pane active fade in">
      <?php top_articles(); ?>
    </div>
    <div id="columnists" class="tab-pane fade">
      <ul class="columnists-list list-unstyled">
        <li>
          <a href="<?php echo get_site_url().'/issue/author/muhammad-usman/'; ?> ">
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/12/Usman.png" class="img-circle">
            <h6>Dohl</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/muhammad-usman/'; ?> ">
            <small class="text-muted">Muhammad Usman</small>
          </a>
        </li>
        <li>
          <a href="<?php echo get_site_url().'/issue/author/massimiliano-valli/'; ?> ">
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/12/Max.png" class="img-circle">
            <h6>The International Observer</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/massimiliano-valli/'; ?> ">
            <small class="text-muted">Massimiliano Valli</small>
          </a>
        </li>
        <li>
          <a href="<?php echo get_site_url().'/issue/author/joshua-shirley/'; ?> ">
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/12/Josh.png">
            <h6>The Reasonable Observer</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/joshua-shirley/'; ?> ">
            <small class="text-muted">Joshua Shirley</small>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

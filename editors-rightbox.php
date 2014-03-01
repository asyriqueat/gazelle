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
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/10/usman.png" class="img-circle">
            <h6>Peace and Conflict</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/muhammad-usman/'; ?> ">
            <small class="text-muted">Muhammad Usman</small>
          </a>
        </li>
        <li>
          <a href="<?php echo get_site_url().'/issue/author/olivia-bergen/'; ?> ">
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/09/olivia.png" class="img-circle">
            <h6>Days of Our Lives</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/olivia-bergen/'; ?> ">
            <small class="text-muted">Olivia Bergen</small>
          </a>
        </li>
        <li>
          <a href="<?php echo get_site_url().'/issue/author/joshua-shirley/'; ?> ">
            <img src="http://thegazelle.s3.amazonaws.com/gazelle/2013/10/josh.png" class="img-circle">
            <h6>Controversial Things about Australia</h6>
          </a>
          <a href="<?php echo get_site_url().'/issue/author/joshua-shirley/'; ?> ">
            <small class="text-muted">Joshua Shirley</small>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

      <?php
        global $issue_meta;
        //checking for banner in priority order
        if ($issue_meta['youtube'] || $issue_meta['video'] || $issue_meta['video_ogg'] || $issue_meta['banner'] || $issue_meta['banner_mobile']) { ?>
          <div id="banner" <?php echo $issue_meta['editor_style'] == "small_banner" ? 'class="no-bottom-padding no-bottom-margin"' : "" ?>>
            <?php if ($issue_meta['banner_link']) { ?>
              <a href="<?php echo $issue_meta['banner_link']?>" >
            <?php } ?>
            <?php 
            //check in priority order
            // youtube case
            if ($issue_meta['youtube']) { ?>
              <div class="video-container">
                <iframe width="560" height="315" src="<?php echo $issue_meta['youtube'] ?>" frameborder="0" allowfullscreen></iframe>
              </div>
            <?php
            }
            // video case
            elseif (!wp_is_mobile() && ($issue_meta['video'] || $issue_meta['video_ogg'])) { ?>
              <video autoplay="autoplay" loop="true">
                <?php if ($issue_meta['video']) { ?>
                  <source src="<?php echo $issue_meta['video'] ?>" type="video/mp4" />
                <?php
                }
                ?>
                <?php if ($issue_meta['video_ogg']) { ?>
                <source src="<?php echo $issue_meta['video_ogg'] ?>" type="video/ogg" />
                <?php
                }
                ?>
              </video>
              <?php } 
              //standard image banner case
            elseif ($issue_meta[banner] || $issue_meta[banner_mobile]) {
            ?>
                <?php if ($issue_meta['banner']) { ?>
            <img class="hidden-sm" src="<?php echo $issue_meta['banner'] ?>" alt="<?php echo $currentIssue->name ?>">
                <?php
                }
                ?>
                <?php if ($issue_meta['banner_mobile']) { ?>
            <img class="visible-sm" src="<?php echo $issue_meta['banner_mobile'] ?>" alt="<?php echo $currentIssue->name ?>">
          <?php }} ?>
            <?php if ($issue_meta['banner_link']) { ?>
              </a>
            <?php } ?>
          </div>
        <?php
        }
      ?>

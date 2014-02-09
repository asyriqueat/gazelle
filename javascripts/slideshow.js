// slideshow javascript
$(function() {
  var slideshow = $(".slideshow");
  var slideshowScrollItems = $(".slideshow .scroller ul li");
  var oldPage = 0;
  // check that the slideshow exists
  if (slideshow.length > 0) {
    setTimeout(function() {
      slideshowScroll = new IScroll(".slideshow", {scrollY: false, scrollX: true, eventPassthrough: true, snap: true});
      var captionSelector = $(".slideshow-container .caption");
      slideshowScroll.on("scrollStart", function() {
        //captionSelector.animate({opacity: 0}, 200);
        //console.log("scroll starting");
      });
      slideshowScroll.on('scrollEnd', function() {
        check = slideshowScrollItems.length - (slideshowScroll.currentPage.pageX + 1) > 0;
        if (slideshowScroll.currentPage.pageX !== 0) {
          $(".slideshow .icon-prev").addClass("active");
        } else {
          $(".slideshow .icon-prev").removeClass("active");
        }
        if (check) {
          $(".slideshow .icon-next").addClass("active");
        } else {
          $(".slideshow .icon-next").removeClass("active");
        }
        var pageNumber = slideshowScroll.currentPage.pageX;
        var caption = slideshowScrollItems.eq(pageNumber).children("div").html();
        if (oldPage != pageNumber) {
          captionSelector.html(caption).animate({opacity: 0}, 200, function() {captionSelector.animate({opacity: 1}, 200);});
          oldPage = pageNumber;
        }
      });
      if (slideshowScrollItems.length > 1) {
        $(".slideshow .icon-next").addClass("active");
      }
      resizeSlideshowScroller(slideshowScroll);
    }, 100);

    $(document).on("click", ".slideshow .right", function(e) {
      // adding a check because there is an extra 10px to prevent overflowing the div
      if (slideshowScroll.currentPage.pageX < (slideshowScrollItems.length - 1))
        slideshowScroll.goToPage(slideshowScroll.currentPage.pageX + 1, 0);
    });
    $(document).on("click", ".slideshow .left", function(e) {
      slideshowScroll.goToPage(slideshowScroll.currentPage.pageX - 1, 0);
    });
    var oldWidth = $(window).width();
    $(window).on('resize', function(e) {
      if (($(window).width() != oldWidth)){
        resizeSlideshowScroller(slideshowScroll);
        oldWidth = $(window).width();
      }
    });
  }
  function resizeSlideshowScroller(slideshowScroll) {
    var slideshowScrollItems = $(".slideshow .scroller ul li");
    width = slideshowScrollItems.width($(".slideshow").width()).width();
    $(".slideshow .scroller").width(width * slideshowScrollItems.length + 10);
    slideshowScroll.refresh();
  }
});

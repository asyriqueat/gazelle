$(function() {
  var topScrollMoving = true;
  var otherScrollMoving = true;
  var searching = false;
  var oldWidth = $(window).width();
  setTimeout(function() {
    // top carousel
    topScroll = refreshTopScroll();
    // other items
    otherScroll = new IScroll("#other-scroll", {scrollY: false, scrollX: true, eventPassthrough: true, snap: true});
    var otherScrollItems = $("#other-scroll .scroller ul li");
    otherScroll.on('scrollEnd', function() {
      var check;
      if (innerWidth < 440) {
        check = otherScrollItems.length - (otherScroll.currentPage.pageX + 1) > 0;
      }
      else if (innerWidth < 783) {
        check = otherScrollItems.length - (otherScroll.currentPage.pageX + 1) * 2 > 0;
      } 
      else {
        check = otherScrollItems.length - (otherScroll.currentPage.pageX + 1) * 3 > 0;
      }
      if (otherScroll.currentPage.pageX !== 0) {
        $("#other-posts .icon-prev").addClass("active");
      } else {
        $("#other-posts .icon-prev").removeClass("active");
      }
      if (check) {
        $("#other-posts .icon-next").addClass("active");
      } else {
        $("#other-posts .icon-next").removeClass("active");
      }
    });
    if (otherScrollItems.length > 3) {
      $("#other-posts .icon-next").addClass("active");
    }
    resizeScroller(otherScroll);
  }, 100);

  $(document).on("click", "a", function (e) {
    e.stopPropagation();
  });
  $(document).on("click", ".pick-label", function(e) {
    $("#editor-labels .active").removeClass("active");
    var pick = $(e.target);
    pick.addClass("active");
    var newPos = pick.attr("id").split("-")[1];
    topScroll.goToPage(0, newPos);
  });

  $(document).on("blur", ".navbar-form input", function(e) {
    var searchbar = $(".navbar-form input");
    console.log("blurring");
    if (searching) {
      if (innerWidth < 783) {
        searchbar.animate({width: '35px'});
      } else {
        searchbar.animate({width: '50px'});
      }
      searching = false;
    }
  });

  $(document).on("focus", ".navbar-form input", function(e) {
    var searchbar = $(".navbar-form input");
    if (!searching) {
      var length;
      if (innerWidth < 783) {
        length = $("#navbar").width() - 50;
      } else {
        length = $("#navbar").width() - 25;
      }
      searchbar.animate({width: length});
      searching = true;
    } 
  });				
  $(window).on('resize', function(e) {
    if (($(window).width() != oldWidth)){
      resizeScroller(otherScroll);
      topScroll = refreshTopScroll(topScroll);
      oldWidth = $(window).width();
    }
  });
  $('#other-scroll .scroller').bind('mousewheel', function(e) {
    e.preventDefault();
    var delta = e.originalEvent.wheelDelta;
    if (delta > 0) {
      otherScroll.goToPage(otherScroll.currentPage.pageX - 1, 0);
    } else {
      otherScroll.goToPage(otherScroll.currentPage.pageX + 1, 0);
    }
  });
  $('#editors').bind('mousewheel', function(e) {
    e.preventDefault();
    console.log("scrolling")
    var delta = e.originalEvent.wheelDelta;
    console.log(delta)
    console.log(topScroll.currentPage.pageX);
    console.log(topScroll.currentPage.pageY);
    if (delta > 0) {
      if (innerWidth < 783) {
        topScroll.goToPage(topScroll.currentPage.pageX - 1, 0);
      } else {
        topScroll.goToPage(0, topScroll.currentPage.pageY - 1);
      }
    } else {
      if (innerWidth < 783) {
        topScroll.goToPage(topScroll.currentPage.pageX + 1, 0);
      } else {
        topScroll.goToPage(0, topScroll.currentPage.pageY + 1);
      }
    }
  });
  $(document).on("click", "#other-posts .icon-next", function(e) {
    otherScroll.goToPage(otherScroll.currentPage.pageX + 1, 0);
  });
  $(document).on("click", "#other-posts .icon-prev", function(e) {
    otherScroll.goToPage(otherScroll.currentPage.pageX - 1, 0);
  });
  $(document).on("click", "#top-scroll .icon-next", function(e) {
    topScroll.goToPage(topScroll.currentPage.pageX + 1, 0);
  });
  $(document).on("click", "#top-scroll .icon-prev", function(e) {
    topScroll.goToPage(topScroll.currentPage.pageX - 1, 0);
  });
  $(document).on("click touchstart mousewheel", "#top-scroll", function(e) {
    topScrollMoving = false;
  });
  $(document).on("click touchstart mousewheel", "#other-posts", function(e) {
    otherScrollMoving = false;
  });

  function resizeScroller(otherScroll) {
    var otherScrollItems = $("#other-scroll .scroller ul li");
    var width;
    if (innerWidth < 440) {
      width = otherScrollItems.width($("#other-scroll").width()).width();
    }
    else if (innerWidth < 783) {
      width = otherScrollItems.width($("#other-scroll").width() / 2).width();
    } else {
      width = otherScrollItems.width($("#other-scroll").width() / 3).width();
    }
    $("#other-scroll .scroller").width(width * otherScrollItems.length + 10);
    otherScroll.refresh();
  }

  function refreshTopScroll(topScroll) {
    function moveActive() {
      var oldActive = $("#editor-labels .active");
      var oldPos;
      if ( oldActive.length > 0 ) {
        oldPos = $("#editor-labels .active").attr("id").split("-")[1];
      }
      var newPos = topScroll.currentPage.pageY;
      if (innerWidth > 783) {
        if (newPos != oldPos) {
          if (oldActive.length > 0) {
            oldActive.removeClass("active");
          }
          $("#editor-labels #pick-" + newPos).addClass("active");
        }
      } else { 
        // check the arrows
        var topCheck = topScrollItems.length - (topScroll.currentPage.pageX + 1) > 0;
        if (topScroll.currentPage.pageX !== 0) {
          $("#top-scroll .icon-prev").addClass("active");
        } else {
          $("#top-scroll .icon-prev").removeClass("active");
        }
        if (topCheck) {
          $("#top-scroll .icon-next").addClass("active");
        } else {
          $("#top-scroll .icon-next").removeClass("active");
        }
      }
    }

    var topScrollItems = $("#top-scroll .scroller ul li");
    var scroller = $("#top-scroll");
    var width = topScrollItems.width(scroller.width()).width();
    var height = topScrollItems.height(scroller.height()).height();
    if (innerWidth < 783) {
      topScroll = new IScroll("#top-scroll", {scrollY: false, scrollX: true, eventPassthrough: "vertical", snap: true});
      $("#top-scroll .scroller").width(width * topScrollItems.length + 10).height(height);
    } else {
      topScroll = new IScroll("#top-scroll", {scrollY: true, scrollX: false, eventPassthrough: "horizontal", snap: true});
      $("#top-scroll .scroller").width(width).height(height * topScrollItems.length + 10);
      moveActive();
    }
    topScroll.on("scrollEnd", moveActive);

    topScroll.refresh();

    // reset horizontal arrows
    if (innerWidth < 783) {
      $("#top-scroll .active").removeClass("active");
      $("#top-scroll .icon-next").addClass("active");
    }
    return topScroll;
    
  }
  function autoscroll() {
    var topScrollLength = $("#top-scroll .scroller ul li").length;
    var currentPage;
    //scroll top
    if (topScrollMoving) {
      if (innerWidth < 783) {
        currentPage = topScroll.currentPage.pageX;
        if (currentPage + 1 < topScrollLength) {
          // haven't reached end
          topScroll.goToPage(currentPage + 1,0);
        } else {
          topScroll.goToPage(0,0);
        }
      } else {
        currentPage = topScroll.currentPage.pageY;
        if (currentPage + 1 < topScrollLength) {
          // haven't reached end
          topScroll.goToPage(0, currentPage + 1);
        } else {
          topScroll.goToPage(0,0);
        }
      }
    }
    //scroll top
    if (otherScrollMoving) {
      var hasNext = $("#other-posts .icon-next").hasClass("active");
      currentPage = otherScroll.currentPage.pageX;
      if (hasNext) {
        // haven't reached end
        otherScroll.goToPage(currentPage + 1,0);
      } else {
        otherScroll.goToPage(0,0);
      }
    }
  }
  setInterval(autoscroll, 5000);
});

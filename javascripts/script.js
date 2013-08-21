// global breakpoint checks
size = '';

// fix for all the browsers having different innerWidth
function detectSize() {
  if ($(".nav-list").css("text-align") == "left") {
    return "small";
  }
  else if ($("#issue").css("display") == "none") {
    return "medium";
  }
  else {
    return "large";
  }
}
size = detectSize();
$(window).on("resize orientationchange", function() {
  size = detectSize();
});
// header functions
$(function() {
  //searchbar logic
  var searching = false;
  var focused = false;
  $(document).on("focus", ".navbar-form input", function(e) {
    startSearch();
    focused = true;
  });				
  $(document).on("mouseenter", ".navbar-form input", function(e) {
    startSearch();
  });
  $(document).on("blur", ".navbar-form input", function(e) {
    endSearch();
    focused = false;
  });
  $(document).on("mouseleave", ".navbar-form input", function(e) {
    if (focused === false) {
      endSearch();
    }
  });
  function startSearch() {
    var searchbar = $(".navbar-form input");
    if (!searching) {
      searchbar.addClass("active");
      searching = true;
      if (size != "large") {
        searchbar.width($("#nav").width() * 0.95 - 25);
      } else {
        searchbar.width($("#nav").width() * 0.85 - 50);
      }
    }
  }
  function endSearch() {
    var searchbar = $(".navbar-form input");
    if (searching) {
      searchbar.removeClass("active");
      searchbar.attr("style", "");
      searching = false;
    }
  }
});

// functions home-scrollers
$(function() {
  var home = $("#home");
  if (home.length > 0) {
    var topScrollMoving = true;
    var otherScrollMoving = true;
    var oldWidth = $(window).width();
    setTimeout(function() {
      // top carousel
      topScroll = refreshTopScroll();
      // other items
      otherScroll = new IScroll("#other-scroll", {scrollY: false, scrollX: true, eventPassthrough: true, snap: true});
      var otherScrollItems = $("#other-scroll .scroller ul li");
      otherScroll.on('scrollEnd', function() {
        var check;
        if (size == "small") {
          check = otherScrollItems.length - (otherScroll.currentPage.pageX + 1) > 0;
        }
        else if (size == "medium") {
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
      resizeScroller(otherScroll);
    }, 100);

    $(document).on("click touchstart", ".pick-label:not('.active') a", function (e) {
      e.preventDefault();
    });
    $(document).on("click touchstart", ".pick-label:not('.active') h6", function (e) {
      e.preventDefault();
    });
    $(document).on("click touchstart", ".pick-label", function(e) {
      $("#editor-labels .active").removeClass("active");
      var pick = $(e.target);
      if (!pick.hasClass("pick-label")) {
        pick = pick.parent();
        if (!pick.hasClass("pick-label")) {
          pick = pick.parent();
        }
      }
      setTimeout(function() {
        pick.addClass("active");
        var newPos = pick.attr("id").split("-")[1];
        topScroll.goToPage(0, newPos);
      }, 200);
    });


    $(window).on('resize orientationchange', function(e) {
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
    $(document).on("click touchstart", "#editors", function(e) {
      topScrollMoving = false;
    });
    $(document).on("click touchstart mousewheel", "#other-posts", function(e) {
      otherScrollMoving = false;
    });

  }
  function resizeScroller(otherScroll) {
    var otherScrollItems = $("#other-scroll .scroller ul li");
    var width;
    if (size == "small") {
      width = otherScrollItems.width($("#other-scroll").width()).width();
    }
    else if (size == "medium") {
      width = otherScrollItems.width($("#other-scroll").width() / 2).width();
    } else {
      width = otherScrollItems.width($("#other-scroll").width() / 3).width();
    }
    $("#other-scroll .scroller").width(width * otherScrollItems.length + 10);
    if (otherScroll.currentPage.pageX === 0) {
      var itemsScrollable;
      switch (size)
      {
        case "small":
          itemsScrollable = 1;
          break;
        case "medium":
          itemsScrollable = 2;
          break;
        case "large":
          itemsScrollable = 3;
          break;
      }
      if (otherScrollItems.length > itemsScrollable) {
        $("#other-posts .icon-next").addClass("active");
      }
    }
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
      if (size == "large") {
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
    if (size != "large") {
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
    if (size != "large") {
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
      if (size != "large") {
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

// article page
$(function() { 
  var article = $("#article");
  if (article.length > 0) {
    var oldWidth = $(window).width();
    // more carousel
    setTimeout(function() {
      moreScroll = new IScroll("#more-scroll", {scrollY: false, scrollX: true, eventPassthrough: true, snap: true});
      var moreScrollItems = $("#more-scroll .scroller ul li");
      moreScroll.on('scrollEnd', function() {
        var check;
        if (size == "small") {
          check = moreScrollItems.length - (moreScroll.currentPage.pageX + 1) > 0;
        }
        else if (size == "medium") {
          check = moreScrollItems.length - (moreScroll.currentPage.pageX + 1) * 2 > 0;
        } 
        else {
          check = moreScrollItems.length - (moreScroll.currentPage.pageX + 1) * 3 > 0;
        }
        if (moreScroll.currentPage.pageX !== 0) {
          $("#more-scroll .icon-prev").addClass("active");
        } else {
          $("#more-scroll .icon-prev").removeClass("active");
        }
        if (check) {
          $("#more-scroll .icon-next").addClass("active");
        } else {
          $("#more-scroll .icon-next").removeClass("active");
        }
      });
      if (moreScrollItems.length > 3) {
        $("#more-scroll .icon-next").addClass("active");
      }
      resizeMoreScroller(moreScroll);
    }, 100);

    $(document).on("click", "a", function (e) {
      e.stopPropagation();
    });
    $('#more-scroll .scroller').bind('mousewheel', function(e) {
      e.preventDefault();
      var delta = e.originalEvent.wheelDelta;
      if (delta > 0) {
        moreScroll.goToPage(moreScroll.currentPage.pageX - 1, 0);
      } else {
        moreScroll.goToPage(moreScroll.currentPage.pageX + 1, 0);
      }
    });
    $(document).on("click", "#more-scroll .icon-next", function(e) {
      moreScroll.goToPage(moreScroll.currentPage.pageX + 1, 0);
    });
    $(document).on("click", "#more-scroll .icon-prev", function(e) {
      moreScroll.goToPage(moreScroll.currentPage.pageX - 1, 0);
    });
    $(window).on('resize', function(e) {
      if (($(window).width() != oldWidth)){
        resizeMoreScroller(moreScroll);
        oldWidth = $(window).width();
      }
    });
    // resizing facebook
    setTimeout( function() {
      $(".fb-comments span").width("100%");
      $(".fb-comments span iframe").width("100%");
    }, 1500);
  }
  function resizeMoreScroller(moreScroll) {
    var moreScrollItems = $("#more-scroll .scroller ul li");
    var width;
    if (size == "small") {
      width = moreScrollItems.width($("#more-scroll").width() - 9).width();
    }
    else if (size == "medium") {
      width = moreScrollItems.width($("#more-scroll").width() / 2 - 9).width();
    } else {
      width = moreScrollItems.width($("#more-scroll").width() / 3 - 9).width();
    }
    $("#more-scroll .scroller").width((width + 10) * moreScrollItems.length);
    moreScroll.refresh();
  }
});
// disable :hover on touch devices
if ('ontouchstart' in document) {
  $('.no-touch').removeClass('no-touch');
}
// Google Analytics
$(function() {
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43241966-1', 'thegazelle.org');
  ga('send', 'pageview');
});

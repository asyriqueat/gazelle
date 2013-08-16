$(function() {
  $(document).on("click", "a", function (e) {
    e.stopPropagation();
  });
  $(document).on("click", ".pick-label", function(e) {
    var new_row = $(e.target);
    var old_row = $(".pick-label.active");
    if (new_row != old_row) {
      new_row.toggleClass("active");
      old_row.toggleClass("active");
    }
    $('.carousel').carousel('pause');
  });
  $('.carousel').carousel({
    interval: 3000
  });
  $('#editors-pick').on("slide.bs.carousel", function() {
    var last = $('#editor-labels .active:last-child');
    if (last.length > 0) {
      last.removeClass('active');
      $("#editor-labels div:first-child").addClass('active'); 
    } else {
      $('#editor-labels .active:not(:last-child)').removeClass('active').next().addClass('active'); 
    }
  });
  setTimeout(function() {
    myScroll = new IScroll("#other-scroll", {scrollY: false, scrollX: true, eventPassthrough: true, snap: true});
    var scrollItems = $(".scroller ul li");
    myScroll.on('scrollEnd', function() {
      var check;
      if (innerWidth < 440) {
        check = scrollItems.length - (myScroll.currentPage.pageX + 1) > 0;
      }
      else if (innerWidth < 779) {
        check = scrollItems.length - (myScroll.currentPage.pageX + 1) * 2 > 0;
      } 
      else {
        check = scrollItems.length - (myScroll.currentPage.pageX + 1) * 3 > 0;
      }
      if (myScroll.currentPage.pageX !== 0) {
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
    if (scrollItems.length > 3) {
      $("#other-posts .icon-next").addClass("active");
    }

    resizeScroller(myScroll);
  }, 100);

  var searching = false;
	$(document).on("click", "input", function(e) {
    e.preventDefault();
    var searchbar = $(e.target);
    if (!searching) {
      if (innerWidth < 779) {
        var length = $("#navbar").width() - 50;
      } else {
        var length = $("#navbar").width() - 25;
      }
      console.log(length);
      searchbar.animate({width: length});
      searching = true;
    } 
    else {
      if (innerWidth < 779) {
        searchbar.animate({width: '35px'});
      } else {
        searchbar.animate({width: '50px'});
      }
      searching = false;
    }
  });
			
  //$(document).on("blur", "input", function(e) {
      //searchbar.animate({width: '2%'});
     //searching = false;
  //});

  //$(document).on("focus", "input", function(e) {
    //var searchbar = $(e.target);
    //if (!searching) {
      //// opening
      //if (innerWidth > 2000) {
        //searchbar.animate({width: '18%'});
      //} else if (innerWidth < 2000){
        //searchbar.animate({width: '15%'});
      //} else if (innerWidth > 1500){
        //searchbar.animate({width: '13%'});
      //} else if (innerWidth > 800){
        //searchbar.animate({width: '40%'});
      //} else if (innerWidth < 800){
        //searchbar.animate({width: '50%'});
      //}
    //searching = true;
    //}
  //});				
  $(window).bind('resize', function(e) {
    resizeScroller(myScroll);
  });
  $('.scroller').bind('mousewheel', function(e) {
    e.preventDefault();
    var delta = e.originalEvent.wheelDelta;
    if (delta > 0) {
      myScroll.goToPage(myScroll.currentPage.pageX - 1, 0);
    } else {
      myScroll.goToPage(myScroll.currentPage.pageX + 1, 0);
    }
  });
  $(document).on("click", "#other-posts .icon-next", function(e) {
    myScroll.goToPage(myScroll.currentPage.pageX + 1, 0);
  });
  $(document).on("click", "#other-posts .icon-prev", function(e) {
    myScroll.goToPage(myScroll.currentPage.pageX - 1, 0);
  });
});

function resizeScroller(myScroll) {
  var scrollItems = $(".scroller ul li");
  var width;
  console.log(innerWidth);
  if (innerWidth < 440) {
    width = scrollItems.width($("#other-scroll").width()).width();
  }
  else if (innerWidth < 779) {
    width = scrollItems.width($("#other-scroll").width() / 2).width();
  } else {
    width = scrollItems.width($("#other-scroll").width() / 3).width();
  }
  $(".scroller").width(width * scrollItems.length + 10);
  myScroll.refresh();
}

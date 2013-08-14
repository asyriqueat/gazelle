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
    myScroll = new iScroll("iscroll", {vscroll: false, vScrollbar: false});
    resizeScroller(myScroll);
  }, 100);
  var searching = false;
	$(document).on("click", "input", function(e) {
    e.preventDefault();
    var searchbar = $(e.target);
    if (!searching) {
      if (innerWidth > 800) {
        searchbar.animate({width: '80%'});
      } else if (innerWidth < 800){
        searchbar.animate({width: '80%'});
		}
    searching = true;
    } else {
      searchbar.animate({width: '2%'});
      searching = false;
    }
  });
			
  $(document).on("blur", "input", function(e) {
      searchbar.animate({width: '2%'});
     searching = false;
  });

  $(document).on("focus", "input", function(e) {
    if (!searching) {
      // opening
      if (innerWidth > 2000) {
        searchbar.animate({width: '18%'});
      } else if (innerWidth < 2000){
        searchbar.animate({width: '15%'});
      } else if (innerWidth > 1500){
        searchbar.animate({width: '13%'});
      } else if (innerWidth > 800){
        searchbar.animate({width: '40%'});
      } else if (innerWidth < 800){
        searchbar.animate({width: '50%'});
      }
    searching = true;
    }
  });				
  $("#iscroll").resize(function(e) {
    console.log($("#iscroll").width());
    resizeScroller(myScroll);
  });
});

function resizeScroller(myScroll) {
  var iscroll = $("#iscroll");
  var width = $(".scroller ul li").width(iscroll.width() / 3).width();
  $(".scroller").width(width);
  myScroll.refresh();
}

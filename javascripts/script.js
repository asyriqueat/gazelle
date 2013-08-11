$(function() {
  $(document).on("click", ".pick-label", function(e) {
    var new_row = $(e.target);
    var old_row = $(".pick-label.active");
    if (new_row != old_row) {
      new_row.toggleClass("active");
      old_row.toggleClass("active");
    }
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
});

$(function() {
  // hides all PO tables on load
  $(".sub-table").each(function(e) {
    $(this).hide();
  })

  // Colors expired equipment rentals red
  $(".finish-date").each(function (index, element) {
    var a = new Date($(this).text());
    var b = new Date();

    if (a < b) {
      $(this).css("color", "red");
    }
  });

  // toggles visibility of PO tables
  $(".main-info").click(function (e) {
    $(this).next().toggle(200);
  });

  // Makes job # take back to user page
  $('#job-title').click(function (e) {
    parent.location = "http://localhost/ProcurementWebApp/user-page.php";
    return false;
  })

  // Makes job # take to job page
  $('.job-button').click(function (e) {
    var job = $(this).attr('id');
    parent.location = "job-page.php?job=" + job + "&report=Budgeted+Amounts";
    return false;
  });


  // Table Widths =
  $(".description-po").css({
    'width': ($(".description").width() + 'px'),
    'padding-left' : '10px'
  });
  $(".quantity-po").css({
    'width': ($(".quantity").width() + 'px'),
    'padding-right': '25px'
  });
  $(".times-purchased-po").css({
    'width': ($(".times-purchased").width() + 'px'),
    'padding-right': '25px'
  });
  $(".purchase-price-po").css({
    'width': ($(".purchase-price").width() + 'px'),
    'padding-right': '700px'
  });


  // Popup
  $(".rental-line").click(function(e) {
    let job = $("#job-title").text();
    let po = $(this).attr('id');
    parent.location = "job-page.php?job=" + job + "&report=Rental+Tracker&po=" + po;
    return false;
  })



});
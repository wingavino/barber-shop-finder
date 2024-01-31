$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#shops-list a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $('#collapseFilter').on('show.bs.collapse', function () {
    $('#collapseFilterText').text("Filter -");
  })

  $('#collapseFilter').on('hide.bs.collapse', function () {
    $('#collapseFilterText').text("Filter +");
  })

  $('#collapseShopList').on('show.bs.collapse', function () {
    $('#collapseShopListText').text("Shops List -");
  })

  $('#collapseShopList').on('hide.bs.collapse', function () {
    $('#collapseShopListText').text("Shops List +");
  })
});

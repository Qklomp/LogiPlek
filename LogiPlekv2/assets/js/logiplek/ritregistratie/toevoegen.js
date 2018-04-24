/* 
 * ==================== BINDINGS ====================
 */
 
$( ".vervoerder" ).change(function() {
  var e = $(this).children(":selected");
  var id = e.attr( "id" );
  var target = e.attr( "data-target" );
  
  $.ajax({
    type: "GET",
    url: '/koeriers/get_kosten/' + id,
    dataType: "json",
    success: function(data) {
      $( "#" + target ).val(data);
    },
    error: function() {
      $( "#" + target ).val('1.00');
    }
  });
});
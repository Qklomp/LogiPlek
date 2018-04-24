$(document).ready(function() 
{
  $( ".onderhoud" ).dataTable({    
    iDisplayLength: 10,
    "order": [[ 0, "desc" ]],
    "sDom": 't',
    "aoColumnDefs": [ { 'bSortable': false, 'bSearchable': false, 'aTargets': [ -2, -1 ] } ],
  });   
});

/* 
 * ==================== BINDINGS ====================
 */
 
$( ".auto" ).change(function() {
  var e = $(this).children(":selected");
  var id = e.attr( "id" );
  var target = e.attr( "data-target" );
  
  $.ajax({
    type: "GET",
    url: '/autos/get_kenteken/' + id,
    dataType: "json",
    success: function(data) {
      $( "#" + target ).val(data);
    }
  });
});
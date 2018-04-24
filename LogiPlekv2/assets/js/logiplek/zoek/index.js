$(document).ready(function() 
{ 
  $( ".searchTable" ).dataTable({    
    iDisplayLength: 999,
    "order": [[ 0, "asc" ]],
    "sDom": 't',    
    "aoColumnDefs": [ { 'bSortable': false, 'bSearchable': false, 'aTargets': [ -1 ] } ],
  }); 
});
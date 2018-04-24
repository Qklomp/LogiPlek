$(document).ready(function() 
{ 
  $( ".dateTable" ).dataTable({
    "order": [[ 0, "desc" ]],
    autoWidth: false,
    "ajax": {
      "url": "/brandstof/json",
      "dataSrc": ""
    },
    "columns": [
      { "data": "datum" },
      { "data": "autonummer" },
      { "data": "chauffeur" },
      { "data": "beginstand" },
      { "data": "eindstand" },
      { "data": "liters" },
      { "data": "verbruik" },
      { "data": "koeling" },
      { "data": "adblue" },
      { "class": "text-center" },
    ],
    "columnDefs": [ 
      {
        "targets": 10,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="" class="narrow text-center open-deleteAlert" data-id="' + full.id + '" data-type="brandstof" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a>';
        } 
      },
      {
        "targets": 9,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="/brandstof/' + full.id + '" class="narrow text-center"><i class="glyphicon glyphicon-search"></i></a>';
        } 
      },
      {
        "targets" : 0,
        "type": "date-eu",
      },
      {
        "targets" : [0,1,2,3,4,5,6,7,8],
        "render": function (data, type, full) {
          if(data === null)
          {
            data = '';
          }
          return '<a href="/brandstof/' + full.id + '">' + data + '</a>';
        }
      },
    ],
    "deferRender": true,
    "fnInitComplete": function(oSettings, json) {
      $( ".open-deleteAlert" ).click( function () {
        var id = $( this ).data('id');
        var type = $( this ).data('type');
        $(".modal-body #delete").attr('href', "/" + type + "/verwijderen/" + id);
      });
    }
  });
  $( "div.dataTables_filter input" ).addClass('form-control input-sm'); 
});
$(document).ready(function() 
{  
  $( "#dataTable_extern" ).dataTable({    
    "order": [[ 0, "desc" ]],
    autoWidth: false,
    "ajax": {
      "url": "/ritregistratie/extern/json",
      "dataSrc": ""
    },
    "columns": [
      { "data": "id" },
      { "data": "datum" },
      { "data": "vervoerder" },      
      { "class": "narrow text-center" },
      { "class": "narrow text-center" },
      { "class": "narrow text-center" },
    ],
    "columnDefs": [ 
      {
        "targets": -1,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="" class="narrow text-center open-deleteAlert" data-id="' + full.id + '" data-type="ritregistratie/extern" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a>';
        } 
      },
      {
        "targets": -2,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="/ritregistratie/extern/print/' + full.id + '" class="narrow text-center" target="_blank"><i class="glyphicon glyphicon-print"></i></a>';
        } 
      },
      {
        "targets": -3,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="/ritregistratie/extern/' + full.id + '" class="narrow text-center"><i class="glyphicon glyphicon-search"></i></a>';
        } 
      },
      {
        "targets" : 0,
        "type": "date-eu",
      },
      {
        "targets" : [0,1,2],
        "render": function (data, type, full) {
          if(data === null)
          {
            data = '';
          }
          return '<a href="/ritregistratie/extern/' + full.id + '">' + data + '</a>';
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

   $( "#dataTable_intern" ).dataTable({    
    "order": [[ 0, "desc" ]],
    autoWidth: false,
    "ajax": {
      "url": "/ritregistratie/intern/json",
      "dataSrc": ""
    },
    "columns": [
      { "data": "id" },
      { "data": "datum" },
      { "data": "vervoerder" },      
      { "class": "narrow text-center" },
      { "class": "narrow text-center" },
      { "class": "narrow text-center" },
    ],
    "columnDefs": [ 
      {
        "targets": -1,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="" class="narrow text-center open-deleteAlert" data-id="' + full.id + '" data-type="ritregistratie/intern" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a>';
        } 
      },
      {
        "targets": -2,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="/ritregistratie/intern/print/' + full.id + '" class="narrow text-center" target="_blank"><i class="glyphicon glyphicon-print"></i></a>';
        } 
      },
      {
        "targets": -3,
        "sortable" : false, 
        "searchable": false, 
        "render": function(data, type, full) {
          return '<a href="/ritregistratie/intern/' + full.id + '" class="narrow text-center"><i class="glyphicon glyphicon-search"></i></a>';
        } 
      },
      {
        "targets" : 0,
        "type": "date-eu",
      },
      {
        "targets" : [0,1,2],
        "render": function (data, type, full) {
          if(data === null)
          {
            data = '';
          }
          return '<a href="/ritregistratie/intern/' + full.id + '">' + data + '</a>';
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
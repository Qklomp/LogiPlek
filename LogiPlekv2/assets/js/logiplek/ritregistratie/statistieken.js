$.get( "/ritregistratie/extern/get_statistics", function (data) {
    var chartData = {
      labels: data.labels,
      datasets: [
        {
          label: "Totaal",
          fillColor: "rgba(95,140,32,0.75)",
          strokeColor: "rgba(95,140,32,1)",
          pointColor: "rgba(95,140,32,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(95,140,32,1)",
          data: data.totals
        }
      ]
    };
    var ctx = document.getElementById("myChart").getContext("2d");  
    var myLineChart = new Chart(ctx).Line(chartData, {
      tooltipTemplate: "<%= label %>: €<%= value %>",
      scaleLabel: "€<%=value%>",
      pointHitDetectionRadius : 2,
      responsive: true,
    });

    $( "#spinner" ).hide();
    // $( "#content" ).show();
}, 'json');





<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>

  <script>
    $(document).ready(function() {
      showGraphics();
       setTimeout(getAllData,5000);
    });
    gradientChartOptionsConfigurationWithTooltipPurple = {
      maintainAspectRatio: false,
      legend: {
        display: false
      },

      tooltips: {
        backgroundColor: '#f5f5f5',
        titleFontColor: '#333',
        bodyFontColor: '#666',
        bodySpacing: 4,
        xPadding: 12,
        mode: "nearest",
        intersect: 0,
        position: "nearest"
      },
      responsive: true,
      scales: {
        yAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: 'rgba(29,140,248,0.0)',
            zeroLineColor: "transparent",
          },
          ticks: {
            suggestedMin: 60,
            suggestedMax: 125,
            padding: 20,
            fontColor: "#9a9a9a"
          }
        }],

        xAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: 'rgba(225,78,202,0.1)',
            zeroLineColor: "transparent",
          },
          ticks: {
            padding: 20,
            fontColor: "#9a9a9a"
          }
        }]
      }
    };

    gradientChartOptionsConfiguration = {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      tooltips: {
        bodySpacing: 4,
        mode: "nearest",
        intersect: 0,
        position: "nearest",
        xPadding: 10,
        yPadding: 10,
        caretPadding: 10
      },
      responsive: true,
      scales: {
        yAxes: [{
          display: 0,
          gridLines: 0,
          ticks: {
            display: false
          },
          gridLines: {
            zeroLineColor: "transparent",
            drawTicks: false,
            display: false,
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 0,
          gridLines: 0,
          ticks: {
            display: false
          },
          gridLines: {
            zeroLineColor: "transparent",
            drawTicks: false,
            display: false,
            drawBorder: false
          }
        }]
      },
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 15,
          bottom: 15
        }
      }
    };
    function showGraphics(){
        var chart_labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        var chart_data = [<?= $data['earned_dashes']['JAN']?>, <?= $data['earned_dashes']['FEB']?>, <?= $data['earned_dashes']['MAR']?>, <?= $data['earned_dashes']['APR']?>, <?= $data['earned_dashes']['MAY']?>, <?= $data['earned_dashes']['JUN']?>, <?= $data['earned_dashes']['JUL']?>, <?= $data['earned_dashes']['AUG']?>, <?= $data['earned_dashes']['SEP']?>, <?= $data['earned_dashes']['OCT']?>, <?= $data['earned_dashes']['NOV']?>, <?= $data['earned_dashes']['DEC']?>];

        var ctx = document.getElementById("chartBig1").getContext('2d');

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.1)');
        gradientStroke.addColorStop(0.4, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
        var config = {
            type: 'line',
            data: {
                labels: chart_labels,
                datasets: [{
                    label: "Earned Dashes(USD)",
                    fill: true,
                    backgroundColor: gradientStroke,
                    borderColor: '#d346b1',
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#d346b1',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#d346b1',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: chart_data,
                }]
            }
            ,options: gradientChartOptionsConfigurationWithTooltipPurple
        };
        var myChartData = new Chart(ctx, config);
        $("#0").click(function() {
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data;
            data.datasets[0].label = "Earned Dashes(USD)";
            data.labels = chart_labels;
            myChartData.update();
        });
        $("#1").click(function() {
            var chart_data = [<?= $data['infected_computers']['JAN']?>, <?= $data['infected_computers']['FEB']?>, <?= $data['infected_computers']['MAR']?>, <?= $data['infected_computers']['APR']?>, <?= $data['infected_computers']['MAY']?>, <?= $data['infected_computers']['JUN']?>, <?= $data['infected_computers']['JUL']?>, <?= $data['infected_computers']['AUG']?>, <?= $data['infected_computers']['SEP']?>, <?= $data['infected_computers']['OCT']?>, <?= $data['infected_computers']['NOV']?>, <?= $data['infected_computers']['DEC']?>];
          
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data;
            data.datasets[0].label = "Infected Computers";
            data.labels = chart_labels;
            myChartData.update();
        });
    }
    function getAllData(){
      var params = {
            action:'get_all_data',
            data: ""
           
        };

        $.ajax({
            url: "main/ajax_call",
            type: "POST",
            dataType: "json",
            data: params,
            success: function onSuccess(res){
//                console.log("Message Get Successed!");
                //console.log(res);
                $(".unread_msg").html(res.unread_msg);
                $(".all_dash").html(res.all_dash);
                $(".all_bots").html(res.all_bots);
                $(".paid_bots").html(res.paid_bots);
                $(".paid_dash").html(res.paid_dash);
                setTimeout(getAllData,5000);
            },
            error: function onError(res){
                console.log("Message Get Successed!");
                console.log(res);
                setTimeout(getAllData,5000);
            }
        });
    }
  </script>
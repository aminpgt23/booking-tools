
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        tr, th{
            /* border: 1px solid #ddd; */
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #483D8B;
            color: white;
            overflow:hidden;
            
        }
        tr{
          border: 1px solid #ddd;
          border-collapse: collapse;
        }
    </style>
  <div class="mt-3">
  <div class="col-12 col-md-6 col-lg-6">
  <div class="card-header border border-secondary" style="width:205%; height:100%;">
                  <div class="section-header ">
                        <h4>Statistics Device</h4>
                  </div>
                  <div class="card-header"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="myChart2" height="250" width="854" style="display: block; width: 427px; height: 256px;" class="chartjs-render-monitor"></canvas>
                  </div>
                  <h4>Statistics Person</h4>
                  <div class="card-header"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="myChart" height="250" width="854" style="display: block; width: 427px; height: 213px;" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
  </div>

  <script>

function chart(){  
    fetch('./Data/chart_person.php')
    .then(response => response.json())
    .then(data => {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [{
        label: 'Jumlah',
        data: data.values,
        borderWidth: 2,
        backgroundColor: 'transparent',
        borderColor: '#868e96',
        borderWidth: 2.5,
        pointBackgroundColor: '#ffffff',
        pointRadius: 4
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            stepSize: 10
          }
        }],
        xAxes: [{
          ticks: {
            display: false
          },
          gridLines: {
            display: false
          }
        }]
      },
    }
    });
    })
    .catch(error => console.error('Error fetching data:', error));
    
    // Use AJAX to fetch data from the server
    fetch('./Data/chart_device.php')
    .then(response => response.json())
    .then(data => {
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Jumlah',
                data: data.values,
                borderWidth: 2,
                backgroundColor: '#ffc107',
                borderColor: '#868e96',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });
    })
    .catch(error => console.error('Error fetching data:', error));
  }
  
//chart();
setInterval(function() {
chart();
}, 5000);
  </script>

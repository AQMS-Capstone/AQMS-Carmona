
drawBasic();

function createGraph(data_pollutant, chartNames, rolling_time)
{
    const CHART = document.getElementById(chartNames);
    let barChart = new Chart(CHART, {
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scaleShowLabels: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 9
                    },
                    gridLines: {
                        display: false
                    }
                }],
                xAxes: [{
                    barPercentage: .98,
                    categoryPercentage: .98,
                    ticks: {
                        fontSize: 9
                    },
                    gridLines: {
                        display: false
                    }
                }]
            }
        },
        type: 'bar',
        data: {
            labels: [rolling_time[0].toString(), rolling_time[1].toString(), rolling_time[2].toString(), rolling_time[3].toString(), rolling_time[4].toString(), rolling_time[5].toString(), rolling_time[6].toString(), rolling_time[7].toString(), rolling_time[8].toString(), rolling_time[9].toString(), rolling_time[10].toString(), rolling_time[11].toString(), rolling_time[12].toString(), rolling_time[13].toString(), rolling_time[14].toString(), rolling_time[15].toString(), rolling_time[16].toString(), rolling_time[17].toString(), rolling_time[18].toString(), rolling_time[19].toString(), rolling_time[20].toString(), rolling_time[21].toString(), rolling_time[22].toString(), rolling_time[23].toString()],
            datasets: [
                {
                    label: "AQI",
                    backgroundColor: [
                        determineBG(data_pollutant[0]),
                        determineBG(data_pollutant[1]),
                        determineBG(data_pollutant[2]),
                        determineBG(data_pollutant[3]),
                        determineBG(data_pollutant[4]),
                        determineBG(data_pollutant[5]),
                        determineBG(data_pollutant[6]),
                        determineBG(data_pollutant[7]),
                        determineBG(data_pollutant[8]),
                        determineBG(data_pollutant[9]),
                        determineBG(data_pollutant[10]),
                        determineBG(data_pollutant[11]),
                        determineBG(data_pollutant[12]),
                        determineBG(data_pollutant[13]),
                        determineBG(data_pollutant[14]),
                        determineBG(data_pollutant[15]),
                        determineBG(data_pollutant[16]),
                        determineBG(data_pollutant[17]),
                        determineBG(data_pollutant[18]),
                        determineBG(data_pollutant[19]),
                        determineBG(data_pollutant[20]),
                        determineBG(data_pollutant[21]),
                        determineBG(data_pollutant[22]),
                        determineBG(data_pollutant[23])
                    ],
                    data: [removeNegative(data_pollutant[0]), removeNegative(data_pollutant[1]), removeNegative(data_pollutant[2]), removeNegative(data_pollutant[3]), removeNegative(data_pollutant[4]), removeNegative(data_pollutant[5]), removeNegative(data_pollutant[6]), removeNegative(data_pollutant[7]), removeNegative(data_pollutant[8]), removeNegative(data_pollutant[9]), removeNegative(data_pollutant[10]), removeNegative(data_pollutant[11]), removeNegative(data_pollutant[12]), removeNegative(data_pollutant[13]), removeNegative(data_pollutant[14]), removeNegative(data_pollutant[15]), removeNegative(data_pollutant[16]), removeNegative(data_pollutant[17]), removeNegative(data_pollutant[18]), removeNegative(data_pollutant[19]), removeNegative(data_pollutant[20]), removeNegative(data_pollutant[21]), removeNegative(data_pollutant[22]), removeNegative(data_pollutant[23])],
                }
            ]
        }
    });
    /*
  var data = new google.visualization.DataTable();
  data.addColumn('timeofday', 'Time of Day');
  data.addColumn('number', 'AQI Level');

  for(var i = 0 ; i < 24 ; i ++)
  {
    var value = 0;

    if(i < data_pollutant.length)
    {
      value = parseInt(JSON.stringify(data_pollutant[i]).replace(/"/g, ''));
    }

    if(value == -1)
    {
      value = 0;
    }

    data.addRow([{v: [i + 1, 0, 0], f: ''}, value]);
  }

  var options = {
      width: 400,
      height: 75,
      hAxis: {
          format: 'HH',
          viewWindow: {
              min: [1, 00, 0],
              max: [24, 00, 0]
          },
          gridlines:{ color:'transparent', count:17},
      },
      vAxis:{
          gridlines:{ color:'transparent' }
      ,
      },
      legend: {position: 'none'},
      pointSize: 3,
      colors: ['#009688'],
  };

  var chart = new google.visualization.ColumnChart(
      document.getElementById(chartNames));

  chart.draw(data, options);
    */
}

function drawTheGraph(area_data)
{
  var array_draw = [];

  array_draw.push(area_data.co_aqi_values);
  array_draw.push(area_data.so2_aqi_values);
  array_draw.push(area_data.no2_aqi_values);
  array_draw.push(area_data.o3_aqi_values);
  array_draw.push(area_data.pm10_aqi_values);
  array_draw.push(area_data.tsp_aqi_values);

  if(area_data.AllDayValues_array.length != 0)
  {
    for(var i = 0 ; i < area_data.aqi_values.length; i++)
    {
      var maxValue = 0;

      switch(i)
      {
        case 0:
          maxValue = Math.max(parseInt(area_data.co_max));
          break;

        case 1:
          maxValue = Math.max(parseInt(area_data.so2_max));
          break;

        case 2:
          maxValue = Math.max(parseInt(area_data.no2_max));
          break;

        case 3:
          maxValue = Math.max(parseInt(area_data.o3_max));
          break;

        case 4:
          maxValue = Math.max(parseInt(area_data.pm10_max));
          break;

        case 5:
          maxValue = Math.max(parseInt(area_data.tsp_max));
          break;
      }

      if(maxValue > -1)
      {
        var chartNames = "chart_div_" + (i+1);
        createGraph(array_draw[i], chartNames, area_data.rolling_time);
      }
    }
  }
}

function drawBasic() {
  if(area_chosen == "Bancal")
  {
    drawTheGraph(bancal_area);
  }

  else
  {
    drawTheGraph(slex_area);
  }
}

function determineBG(AQI){
    var AirQuality = otherAir;

    if(AQI >= 0 && AQI <= 50){
        AirQuality = goodAir;
    }else if(AQI >= 51 && AQI <= 100){
        AirQuality = fairAir;
    }else if(AQI >= 101 && AQI <= 150){
        AirQuality = unhealthyAir;
    }else if(AQI >= 151 && AQI <= 200){
        AirQuality = veryUnhealthyAir;
    }else if(AQI >= 201 && AQI <= 300){
        AirQuality = acutelyUnhealthyAir;
    }else if(AQI >= 301){
        AirQuality = emergencyAir;
    }else if(AQI == -1){
        AirQuality = otherAir;
    }

    return AirQuality;
}

function removeNegative(AQI){
    if(AQI < 0){
        AQI = 0;
    }

    return AQI;
}
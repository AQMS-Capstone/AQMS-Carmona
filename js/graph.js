/**
 * Created by Skullpluggery on 10/28/2016.
 */
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function createGraph(data_pollutant, chartNames)
{
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
        createGraph(array_draw[i], chartNames);
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

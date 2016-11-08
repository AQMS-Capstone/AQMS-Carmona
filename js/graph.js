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
      vAxis:{gridlines:{ color:'transparent' }
      ,
      },
      legend: {position: 'none'},
      bar: {groupWidth: '90%'},

  };

  var chart = new google.visualization.ColumnChart(
      document.getElementById(chartNames));

  chart.draw(data, options);
}

function drawBasic() {

    var array_draw = [];

    if(area_chosen == "Bancal")
    {
      array_draw.push(bancal_co_aqi_values);
      array_draw.push(bancal_so2_aqi_values);
      array_draw.push(bancal_no2_aqi_values);
      array_draw.push(bancal_o3_aqi_values);
      array_draw.push(bancal_pm10_aqi_values);
      array_draw.push(bancal_tsp_aqi_values);

      if(bancalAllDayValues_array.length != 0)
      {
        for(var i = 0 ; i < bancal_aqi_values.length; i++)
        {
          var maxValue = 0;

          switch(i)
          {
            case 0:
              maxValue = Math.max(parseInt(bancal_co_max));
            break;

            case 1:
              maxValue = Math.max(parseInt(bancal_so2_max));
            break;

            case 2:
              maxValue = Math.max(parseInt(bancal_no2_max));
            break;

            case 3:
              maxValue = Math.max(parseInt(bancal_o3_max));
            break;

            case 4:
              maxValue = Math.max(parseInt(bancal_pm10_max));
            break;

            case 5:
              maxValue = Math.max(parseInt(bancal_tsp_max));
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

    else
    {
      array_draw.push(slex_co_aqi_values);
      array_draw.push(slex_so2_aqi_values);
      array_draw.push(slex_no2_aqi_values);
      array_draw.push(slex_o3_aqi_values);
      array_draw.push(slex_pm10_aqi_values);
      array_draw.push(slex_tsp_aqi_values);

      if(slexAllDayValues_array.length != 0)
      {
        for(var i = 0 ; i < slexAllDayValues_array.length; i++)
        {
          var maxValue = 0;

          switch(i)
          {
            case 0:
              maxValue = Math.max(parseInt(slex_co_max));
            break;

            case 1:
              maxValue = Math.max(parseInt(slex_so2_max));
            break;

            case 2:
              maxValue = Math.max(parseInt(slex_no2_max));
            break;

            case 3:
              maxValue = Math.max(parseInt(slex_o3_max));
            break;

            case 4:
              maxValue = Math.max(parseInt(slex_pm10_max));
            break;

            case 5:
              maxValue = Math.max(parseInt(slex_tsp_max));
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



    /*
    for(var i = 0 ; i < bancal_co_values.length ; i ++)
    {
      //2016-14-21 05;
      var datestamp = JSON.stringify(bancal_co_values[i].timestamp).replace(/"/g, '');
      datestamp = parseInt(datestamp.slice(11, 13));
      var value = 0;

      if((i + 1) == datestamp)
      {
        var value = parseInt(JSON.stringify(bancal_co_values[i].concentration_value).replace(/"/g, ''));
      }

      alert(value);

      data.addRow([{v: [datestamp, 0, 0], f: ''}, value]);
    }
    */

    /*
    data.addRows([
        [{v: [1, 0, 0], f: ''}, 45],
        [{v: [2, 0, 0], f: ''}, 45],
        [{v: [3, 0, 0], f: ''}, 48],
        [{v: [4, 0, 0], f: ''}, 50],
        [{v: [5, 0, 0], f: ''}, 51],
        [{v: [6, 0, 0], f: ''}, 50],
        [{v: [7, 0, 0], f: ''}, 54],
        [{v: [8, 0, 0], f: ''}, 48],
        [{v: [9, 0, 0], f: ''}, 48],
        [{v: [10, 0, 0], f: ''}, 52],
        [{v: [11, 0, 0], f: ''}, 58],
        [{v: [12, 0, 0], f: ''}, 55],

        [{v: [13, 0, 0], f: ''}, 58],
        [{v: [14, 0, 0], f: ''}, 55],
        [{v: [15, 0, 0], f: ''}, 55],
        [{v: [16, 0, 0], f: ''}, 48],
        [{v: [17, 0, 0], f: ''}, 50],
        [{v: [18, 0, 0], f: ''}, 51],
        [{v: [19, 0, 0], f: ''}, 50],
        [{v: [20, 0, 0], f: ''}, 54],
        [{v: [21, 0, 0], f: ''}, 48],
        [{v: [22, 0, 0], f: ''}, 48],
        [{v: [23, 0, 0], f: ''}, 52],
        [{v: [24, 0, 0], f: ''}, 49],
    ]);
    */


    /*
    var chart2 = new google.visualization.ColumnChart(
        document.getElementById('chart_div_2'));

    chart2.draw(data, options);

    var chart3 = new google.visualization.ColumnChart(
        document.getElementById('chart_div_3'));

    chart3.draw(data, options);
    */
}

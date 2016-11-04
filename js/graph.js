/**
 * Created by Skullpluggery on 10/28/2016.
 */
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

    var data = new google.visualization.DataTable();
    data.addColumn('timeofday', 'Time of Day');
    data.addColumn('number', 'AQI Level');

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

    var options = {
        width: 400,
        height: 23,
        hAxis: {
            format: 'H:mm',
            viewWindow: {
                min: [1, 00, 0],
                max: [24, 00, 0]
            },
            gridlines:{ color:'transparent' },
        },
        vAxis:{gridlines:{ color:'transparent' }
        , textPosition: 'none'
        },
        legend: {position: 'none'},
        bar: {groupWidth: '90%'},
        enableInteractivity: false,
    };

    var chart1 = new google.visualization.ColumnChart(
        document.getElementById('chart1_div'));

    chart1.draw(data, options);

    var chart2 = new google.visualization.ColumnChart(
        document.getElementById('chart2_div'));

    chart2.draw(data, options);

    var chart3 = new google.visualization.ColumnChart(
        document.getElementById('chart3_div'));

    chart3.draw(data, options);
}
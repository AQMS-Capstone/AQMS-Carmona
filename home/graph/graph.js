/**
 * Created by Skullpluggery on 10/15/2016.
 */
google.charts.load('current', {packages: ['corechart', 'line']})
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var jsonData = $.ajax({
        url: "home/graph/getData.php",
        dataType: "json",
        async: false
    }).responseText;

    var data = new google.visualization.DataTable(jsonData);

    var options = {
        width: '100%',
        height: '100%',
        legend: {position: 'none'},
        enableInteractivity: false,
        chartArea: {
            width: '100%',
            height: '100%'
        },
        hAxis: {

            gridlines: {
                count: -1,
                units: {
                    days: {format: ['MMM dd']},
                    hours: {format: ['HH:mm', 'ha']},
                }
            },
            minorGridlines: {
                units: {
                    hours: {format: ['hh:mm:ss a', 'ha']},
                    minutes: {format: ['HH:mm a Z', ':mm']}
                }
            },

        }
    };


    var chart = new google.visualization.LineChart(
        document.getElementById('chart_div'));
    chart.draw(data, options);
}
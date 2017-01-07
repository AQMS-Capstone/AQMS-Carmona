if(area_chosen == "Bancal")
{
    drawTheGraph2(bancal_area, bancal_area.rolling_time);
}

else
{
    drawTheGraph2(slex_area, slex_area.rolling_time);
}

function checkData(data){
    if(data < 0){
        return 0;
    }else{
        return data;
    }
}

function drawTheGraph2(area_data, rolling_time) {
    var ctx_doughnut = document.getElementById("doughnutChart");
    var doughnutChart = new Chart(ctx_doughnut, {
        type: 'doughnut',
        data: {
            labels: [pollutant_symbols[0], pollutant_symbols[1], pollutant_symbols[2]],
            datasets: [{
                data: [checkData(area_data.aqi_values[0]), checkData(area_data.aqi_values[1]), checkData(area_data.aqi_values[2])],
                backgroundColor: [
                    '#FF9800',
                    '#3F51B5',
                    '#E91E63',
                ]
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });

    document.getElementById('js-legend').innerHTML = doughnutChart.generateLegend();

    var ctx_bar = document.getElementById("barChart");
    var barChart = new Chart(ctx_bar, {
        type: 'bar',
        data: {
            labels: [area_data.rolling_time[0].toString(), rolling_time[1].toString(), rolling_time[2].toString(), rolling_time[3].toString(), rolling_time[4].toString(), rolling_time[5].toString(), rolling_time[6].toString(), rolling_time[7].toString(), rolling_time[8].toString(), rolling_time[9].toString(), rolling_time[10].toString(), rolling_time[11].toString(), rolling_time[12].toString(), rolling_time[13].toString(), rolling_time[14].toString(), rolling_time[15].toString(), rolling_time[16].toString(), rolling_time[17].toString(), rolling_time[18].toString(), rolling_time[19].toString(), rolling_time[20].toString(), rolling_time[21].toString(), rolling_time[22].toString(), rolling_time[23].toString()],
            datasets: [
                {
                    label: "NO2",
                    backgroundColor: "#FF9800",
                    data: [checkData(area_data.no2_aqi_values[0]), checkData(area_data.no2_aqi_values[1]), checkData(area_data.no2_aqi_values[2]), checkData(area_data.no2_aqi_values[3]), checkData(area_data.no2_aqi_values[4]), checkData(area_data.no2_aqi_values[5]), checkData(area_data.no2_aqi_values[6]), checkData(area_data.no2_aqi_values[7]), checkData(area_data.no2_aqi_values[8]), checkData(area_data.no2_aqi_values[9]), checkData(area_data.no2_aqi_values[10]), checkData(area_data.no2_aqi_values[11]), checkData(area_data.no2_aqi_values[12]), checkData(area_data.no2_aqi_values[13]), checkData(area_data.no2_aqi_values[14]), checkData(area_data.no2_aqi_values[15]), checkData(area_data.no2_aqi_values[16]), checkData(area_data.no2_aqi_values[17]), checkData(area_data.no2_aqi_values[18]), checkData(area_data.no2_aqi_values[19]), checkData(area_data.no2_aqi_values[20]), checkData(area_data.no2_aqi_values[21]), checkData(area_data.no2_aqi_values[22]), checkData(area_data.no2_aqi_values[23])]
                },
                {
                    label: "CO2",
                    backgroundColor: "#3F51B5",
                    data: [checkData(area_data.co_aqi_values[0]), checkData(area_data.co_aqi_values[1]), checkData(area_data.co_aqi_values[2]), checkData(area_data.co_aqi_values[3]), checkData(area_data.co_aqi_values[4]), checkData(area_data.co_aqi_values[5]), checkData(area_data.co_aqi_values[6]), checkData(area_data.co_aqi_values[7]), checkData(area_data.co_aqi_values[8]), checkData(area_data.co_aqi_values[9]), checkData(area_data.co_aqi_values[10]), checkData(area_data.co_aqi_values[11]), checkData(area_data.co_aqi_values[12]), checkData(area_data.co_aqi_values[13]), checkData(area_data.co_aqi_values[14]), checkData(area_data.co_aqi_values[15]), checkData(area_data.co_aqi_values[16]), checkData(area_data.co_aqi_values[17]), checkData(area_data.co_aqi_values[18]), checkData(area_data.co_aqi_values[19]), checkData(area_data.co_aqi_values[20]), checkData(area_data.co_aqi_values[21]), checkData(area_data.co_aqi_values[22]), checkData(area_data.co_aqi_values[23])]
                },
                {
                    label: "SO2",
                    backgroundColor: "#E91E63",
                    data: [checkData(area_data.so2_aqi_values[0]), checkData(area_data.so2_aqi_values[1]), checkData(area_data.so2_aqi_values[2]), checkData(area_data.so2_aqi_values[3]), checkData(area_data.so2_aqi_values[4]), checkData(area_data.so2_aqi_values[5]), checkData(area_data.so2_aqi_values[6]), checkData(area_data.so2_aqi_values[7]), checkData(area_data.so2_aqi_values[8]), checkData(area_data.so2_aqi_values[9]), checkData(area_data.so2_aqi_values[10]), checkData(area_data.so2_aqi_values[11]), checkData(area_data.so2_aqi_values[12]), checkData(area_data.so2_aqi_values[13]), checkData(area_data.so2_aqi_values[14]), checkData(area_data.so2_aqi_values[15]), checkData(area_data.so2_aqi_values[16]), checkData(area_data.so2_aqi_values[17]), checkData(area_data.so2_aqi_values[18]), checkData(area_data.so2_aqi_values[19]), checkData(area_data.so2_aqi_values[20]), checkData(area_data.so2_aqi_values[21]), checkData(area_data.so2_aqi_values[22]), checkData(area_data.so2_aqi_values[23])]
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
}
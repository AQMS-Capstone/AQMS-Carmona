


function createGraph(data_pollutant, chartNames, rolling_time)
{
    const CHART = document.getElementById(chartNames);
    let barChart = new Chart(CHART, {
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

        },
        options: {
            defaultFontColor: "#212121",
            hover: {animationDuration: 0},
            animation :{
                onComplete: function () {
                    var ctx = this.chart.ctx;
                    ctx.font = this.scales.font;
                    ctx.fillStyle = this.chart.config.options.defaultFontColor;
                    ctx.textAlign = 'center';

                    ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset) {
                        for (var i = 0; i < dataset.data.length; i++) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            if(data_pollutant[i] == -2){
                                ctx.fillText("400+", model.x, model.y);
                            }else if(data_pollutant[i] == -3){
                                ctx.fillText("201-", model.x, model.y);
                            }else {
                                ctx.fillText(dataset.data[i], model.x, model.y);
                            }
                        }
                    });
                }
            },
            tooltips: false,
            maintainAspectRatio: false,
            responsive: true,
            scaleShowLabels: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    display: false,
                    ticks: {
                        max: 480,
                        beginAtZero: true,
                        fontSize: 11
                    },
                    gridLines: {
                        display: false
                    }
                }],
                xAxes: [{
                    barPercentage: .98,
                    categoryPercentage: .98,
                    ticks: {

                        fontSize: 11
                    },
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });

}

function drawTheGraph(area_data) {
    var array_draw = [];

    array_draw.push(area_data.co_aqi_values);
    array_draw.push(area_data.so2_aqi_values);
    array_draw.push(area_data.no2_aqi_values);

    var url = window.location.href.toString();

    if (url.includes("daily")) {

        for (var i = 0; i < area_data.aqi_values.length; i++) {
            var maxValue = 0;
            var found = false;

            switch (i) {
                case 0:
                    maxValue = Math.max(parseInt(area_data.co_max));
                    found = true;
                    break;

                case 1:
                    maxValue = Math.max(parseInt(area_data.so2_max));
                    found = true;
                    break;

                case 2:
                    maxValue = Math.max(parseInt(area_data.no2_max));
                    found = true;
                    break;
            }

            if (found) {
                var chartNames = "chart_div_" + (i + 1);
                createGraph(array_draw[i], chartNames, area_data.rolling_time);
            }
        }
    } else {
        if (area_data.AQI != "-") {
            var index = area_data.prevalentIndex;

            var chartNames = "chart_div_" + (index + 1);
            createGraph(array_draw[index], chartNames, area_data.rolling_time);
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
    }else if(AQI == -2){
        AirQuality = emergencyAir;
    }else if(AQI == -3){
        AirQuality = goodAir;
    }

    return AirQuality;
}

function removeNegative(AQI){
    if(AQI == -3){
        AQI = 200;
    }else if(AQI == -2){
        AQI = 401;
    }else if(AQI == -1){
        AQI = 0;
    }

    return AQI;
}


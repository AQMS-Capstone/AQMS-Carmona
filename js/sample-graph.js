var ctx_doughnut = document.getElementById("doughnutChart");
var doughnutChart = new Chart(ctx_doughnut, {
    type: 'doughnut',
    data: {
        labels: ["NO2", "CO2", "SO2"],
        datasets: [{
            data: [102, 329, 243],
            backgroundColor: [
                '#FF9800',
                '#3F51B5',
                '#E91E63',
            ]
        }]
    },
    options:{
        legend:{
            display: false
        }
    }
});

document.getElementById('js-legend').innerHTML = doughnutChart.generateLegend();

var ctx_bar = document.getElementById("barChart");
var barChart = new Chart(ctx_bar, {
    type: 'bar',
    data: {
        labels: ["01", "02", "03","04", "05", "06","07", "08", "09", "10", "11", "12"],
        datasets: [
            {
                label:"NO2",
                backgroundColor: "#FF9800",
                data: [3,7,4,3,7,4,3,7,4,3,7,4]
            },
            {
                label:"CO2",
                backgroundColor: "#3F51B5",
                data: [4,3,5,4,3,5,4,3,5,4,3,5]
            },
            {
                label:"SO2",
                backgroundColor: "#E91E63",
                data: [7,2,6,7,2,6,7,2,6,7,2,6]
            }
        ]
    },
    options:{
        maintainAspectRatio: false,
        responsive: true,
        legend:{
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

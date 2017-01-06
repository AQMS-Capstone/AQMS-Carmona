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
        maintainAspectRatio: false,
        responsive: true,
        legend:{
            display: false
        }
    }
});

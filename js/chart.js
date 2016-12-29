const CHART = document.getElementById("myChart");
let barChart = new Chart(CHART,{
    options: {
        maintainAspectRatio: false,
        responsive: true,
        scaleShowLabels : false,
        legend:{
            display : false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                barPercentage: .98,
                categoryPercentage: .98
        }]
        }
    },
    type: 'bar',
    data: {
        labels: ["01", "02", "03", "04", "05", "06", "07","08", "09", "10", "11", "12"],
        datasets: [
            {
                label: "AQI",
                backgroundColor: [
                    '#4CAF50',
                    '#FFEB3B',
                    '#FF9800',
                    '#f44336',
                    '#9C27B0',
                    '#4CAF50',
                    '#b71c1c',
                    '#4CAF50',
                    '#FFEB3B',
                    '#FF9800',
                    '#f44336',
                    '#f44336'
                ],
                data: [23, 22, 21, 20, 19, 18, 17,16, 15, 14, 13, 12],
            }
        ]
    }
});
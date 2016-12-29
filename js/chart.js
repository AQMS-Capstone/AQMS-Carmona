const CHART = document.getElementById("myChart");
let barChart = new Chart(CHART,{
    options: {
        maintainAspectRatio: false,
        responsive: true,
        scaleShowLabels : false,
        legend:{
            display : false
        }
    },
    type: 'bar',
    data: {
        labels: ["BANO", "SI", "VONN", "HAHAHA", "PAKYU", "KA", "VONN"],
        datasets: [
            {
                label: "AQI",
                backgroundColor: [
                    '#4CAF50',
                    '#FFEB3B',
                    '#FF9800',
                    '#f44336',
                    '#9C27B0',
                    '#b71c1c'
                ],
                data: [65, 59, 80, 81, 56, 55, 40],
            }
        ]
    }
});
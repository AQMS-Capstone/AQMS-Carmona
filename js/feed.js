/**
 * Created by Nostos on 16/01/2017.
 */
var isSoundRunning = false;
var ctr = 0;
var ctr2 = 0;

var isTriggered = false;
var isFirstTriggered = false;
var isResumedTriggered = false;

var alertToPlay = "0";
var statusHolder = "0";

var bancal_data_holder;
var slex_data_holder;

var status_holder;
var feed_holder;

$(function()
{
    GetFeed(bancal_area, slex_area);
});

function GetFeed(bancal_area, slex_area) {
    initGraph(bancal_area, bancal_area.rolling_time, "bancal", "graph1","graph2","graph3");
    initGraph(slex_area, slex_area.rolling_time, "slex", "graph4","graph5","graph6");

    if (isTriggered) {
        if (ctr2 == 7) {
            ctr2 = 0;
            isTriggered = false;
        } else {
            ctr2++;
        }
    }

    $.ajax({
        type: "GET",
        url: 'retrieve_resumer.php',
        dataType: 'JSON',
        success: function (response) {
            var isResumed = response["isResumed"];
            if (isResumed == true) {
                isResumedTriggered = false;
            } else {
                if (isTriggered) {
                    isResumedTriggered = true;
                }
            }
        }
    });

    if (!isTriggered && !isResumedTriggered) {
        $.ajax({
            type: "GET",
            url: 'retrieve_time.php',
            dataType: 'JSON',
            success: function (response) {
                var triggered = response["isSoundTriggered"];
                var time = response["serverTime"];
                $('#serverTime').html(time);
                if (triggered == true) {
                    isTriggered = true;
                    isResumedTriggered = true;
                }
            }
        });
    }

    //enclose sa function, tas sa pag load tatawagan niya ung function, tas pag nag success
    $.ajax({
        type: "GET",
        url: 'retrieve_status.php',
        success: function (response) {
            if (JSON.stringify(response) === JSON.stringify(status_holder)) {

            } else {
                status_holder = response;
                $('#statusDiv').html(response);
            }
        },
        error: function (response) {

        }
    });


    $.ajax({
        type: "GET",
        url: 'retrieve_feed.php',
        data: {phpValue: JSON.stringify($('#cbxEntries').val()), phpValue2: JSON.stringify($('#cbxSort').val()),  phpValue3: JSON.stringify($('#cbxArea').val()),  phpValue4: JSON.stringify($('#cbxPollutant').val())},
        success: function (response) {
            if (JSON.stringify(response) === JSON.stringify(feed_holder)) {

            } else {
                feed_holder = response;
                $('#feedDiv').html(response);
            }
        }
    });


    $.ajax({
        type: "GET",
        url: 'retrieve_alert.php',
        dataType: 'JSON',
        success: function (response) {
            var container1 = response["play1"];
            var container2 = response["play2"];

            alertToPlay = container1;

            if (alertToPlay == "0") {
                if (container2 == "1" || container2 == "2") {
                    alertToPlay = container2;
                }
            } else if (alertToPlay == "1") {
                if (container2 == "2") {
                    alertToPlay = container2;
                }
            }

            if (statusHolder != alertToPlay) {
                statusHolder = alertToPlay;
                isFirstTriggered = true;
            }

            if ((isTriggered) || isFirstTriggered) {
                if (ctr == 7) {
                    ctr = 0;
                    isSoundRunning = false;
                    isFirstTriggered = false;
                    stopSound();
                    //stop
                } else {
                    if (alertToPlay == "2") {
                        playSound("res/sounds/", "Red Alert");
                    } else if (alertToPlay == "1") {
                        playSound("res/sounds/", "filling-your-inbox");
                    }

                    ctr++;
                }
            }
        }
    });

    $.ajax({
        type: "GET",
        url: 'retrieve_device_status.php',
        dataType: 'JSON',
        success: function (response) {
            var status1 = response["status1"];
            var status2 = response["status2"];

            if(status1 == "1"){
                $('#status1').html("SENDING");
                $('#status1').attr("class","green-text");
            }else{
                $('#status1').html("DISCONNECTED");
                $('#status1').attr("class","red-text");
            }

            if(status2 == "1"){
                $('#status2').html("SENDING");
                $('#status2').attr("class","green-text");
            }else{
                $('#status2').html("DISCONNECTED");
                $('#status2').attr("class","red-text");
            }
        }
    });

    myGetFeed = setTimeout('GetFeed(bancal_area, slex_area)', 1000);
}

function playSound(filePath,filename){
    document.getElementById("play-sound").innerHTML='<audio autoplay="autoplay"><source src="'+ filePath + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="'+ filePath + filename +'.mp3" /></audio>';
}

function stopSound(){
    document.getElementById("play-sound").innerHTML= '';
}

function GetCautionary(AQIStatus,element, control){

    switch (AQIStatus){
        case "No Status":{
            $("#cautionary_" + control).text("");
            break;
        }
        case "Good".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "TSP":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
            }
            break;
        }

        case "Fair".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }

                case "TSP":{
                    $("#cautionary_" + control).text("There is no cautionary statement for this category.");
                    break;
                }
            }
            break;
        }

        case "Unhealthy for Sensitive Groups".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("People with cardiovascular disease, such as angina, should limit heavy exertion and avoid sources of CO, such as heavy traffic.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "TSP":{
                    $("#cautionary_" + control).text("People with respiratory disease, such as asthma, should limit outdoor exertion.");
                    break;
                }
            }
            break;
        }

        case "Very Unhealthy".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("People should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles and avoid sources of CO, such as heavy traffic. Smokers should refrain from smoking.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
                case "TSP":{
                    $("#cautionary_" + control).text("Pedestrians should avoid heavy traffic areas. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles.");
                    break;
                }
            }
            break;
        }

        case "Acutely Unhealthy".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("People with cardiovascular disease, such as angina, should avoid exertion and sources of CO, such as heavy traffic, and should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
                case "TSP":{
                    $("#cautionary_" + control).text("People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.");
                    break;
                }
            }
            break;
        }

        case "Emergency".toUpperCase():{
            switch (element){
                case "CO":{
                    $("#cautionary_" + control).text("Everyone should avoid exertion and sources of CO, such as heavy traffic; and should stay indoors and rest as much as possible.");
                    break;
                }
                case "SO2":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "NO2":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "O3":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "O3_8":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "O3_1":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "PM 10":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
                case "TSP":{
                    $("#cautionary_" + control).text("Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed.");
                    break;
                }
            }
            break;
        }
    }
}

function initGraph(area_data, rolling_time, chartName, graph1, graph2, graph3){

    var holder;

    if(chartName == "bancal"){
        holder = bancal_data_holder;
    }else{
        holder = slex_data_holder;
    }

    if(JSON.stringify(area_data) === JSON.stringify(holder)) {
        console.log("SAME");
    }else{

        if(chartName == "bancal"){
            bancal_data_holder = area_data;
        }else{
            slex_data_holder = area_data;
        }

        var data_pollutant = checkIndex(pollutant_symbols[0], area_data);
        createGraph(data_pollutant, graph1, rolling_time);

        data_pollutant = checkIndex(pollutant_symbols[1], area_data);
        createGraph(data_pollutant, graph2, rolling_time);

        data_pollutant = checkIndex(pollutant_symbols[2], area_data);
        createGraph(data_pollutant, graph3, rolling_time);

        /*
        var ctx_doughnut = document.getElementById(doughnutChartName);
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

        if(doughnutChartName == "bancal_doughnutChart") {
            document.getElementById('js-legend_1').innerHTML = doughnutChart.generateLegend();
        }else{
            document.getElementById('js-legend_2').innerHTML = doughnutChart.generateLegend();
        }

        var ctx_bar = document.getElementById(chartName);
        var barChart = new Chart(ctx_bar, {
            type: 'bar',
            data: {
                labels: [area_data.rolling_time[0].toString(), rolling_time[1].toString(), rolling_time[2].toString(), rolling_time[3].toString(), rolling_time[4].toString(), rolling_time[5].toString(), rolling_time[6].toString(), rolling_time[7].toString(), rolling_time[8].toString(), rolling_time[9].toString(), rolling_time[10].toString(), rolling_time[11].toString(), rolling_time[12].toString(), rolling_time[13].toString(), rolling_time[14].toString(), rolling_time[15].toString(), rolling_time[16].toString(), rolling_time[17].toString(), rolling_time[18].toString(), rolling_time[19].toString(), rolling_time[20].toString(), rolling_time[21].toString(), rolling_time[22].toString(), rolling_time[23].toString()],
                datasets: [
                    {
                        label: pollutant_symbols[0],
                        backgroundColor: "#FF9800",
                        data: checkIndex(pollutant_symbols[0], area_data)
                    },
                    {
                        label: pollutant_symbols[1],
                        backgroundColor: "#3F51B5",
                        data: checkIndex(pollutant_symbols[1], area_data)
                    },
                    {
                        label: pollutant_symbols[2],
                        backgroundColor: "#E91E63",
                        data: checkIndex(pollutant_symbols[2], area_data)
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
        });*/
    }
}

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

function checkIndex(pollutant, area_data){

    var arrayContainer = [];

    if(pollutant == "CO"){
        arrayContainer = [area_data.co_aqi_values[0], area_data.co_aqi_values[1], area_data.co_aqi_values[2], area_data.co_aqi_values[3], area_data.co_aqi_values[4], area_data.co_aqi_values[5], area_data.co_aqi_values[6], area_data.co_aqi_values[7], area_data.co_aqi_values[8], area_data.co_aqi_values[9], area_data.co_aqi_values[10], area_data.co_aqi_values[11], area_data.co_aqi_values[12], area_data.co_aqi_values[13], area_data.co_aqi_values[14], area_data.co_aqi_values[15], area_data.co_aqi_values[16], area_data.co_aqi_values[17], area_data.co_aqi_values[18], area_data.co_aqi_values[19], area_data.co_aqi_values[20], area_data.co_aqi_values[21], area_data.co_aqi_values[22], area_data.co_aqi_values[23]];
    }else if(pollutant == "SO2"){
        arrayContainer = [area_data.so2_aqi_values[0], area_data.so2_aqi_values[1], area_data.so2_aqi_values[2], area_data.so2_aqi_values[3], area_data.so2_aqi_values[4], area_data.so2_aqi_values[5], area_data.so2_aqi_values[6], area_data.so2_aqi_values[7], area_data.so2_aqi_values[8], area_data.so2_aqi_values[9], area_data.so2_aqi_values[10], area_data.so2_aqi_values[11], area_data.so2_aqi_values[12], area_data.so2_aqi_values[13], area_data.so2_aqi_values[14], area_data.so2_aqi_values[15], area_data.so2_aqi_values[16], area_data.so2_aqi_values[17], area_data.so2_aqi_values[18], area_data.so2_aqi_values[19], area_data.so2_aqi_values[20], area_data.so2_aqi_values[21], area_data.so2_aqi_values[22], area_data.so2_aqi_values[23]];
    }else if(pollutant == "NO2"){
        arrayContainer = [area_data.no2_aqi_values[0], area_data.no2_aqi_values[1], area_data.no2_aqi_values[2], area_data.no2_aqi_values[3], area_data.no2_aqi_values[4], area_data.no2_aqi_values[5], area_data.no2_aqi_values[6], area_data.no2_aqi_values[7], area_data.no2_aqi_values[8], area_data.no2_aqi_values[9], area_data.no2_aqi_values[10], area_data.no2_aqi_values[11], area_data.no2_aqi_values[12], area_data.no2_aqi_values[13], area_data.no2_aqi_values[14], area_data.no2_aqi_values[15], area_data.no2_aqi_values[16], area_data.no2_aqi_values[17], area_data.no2_aqi_values[18], area_data.no2_aqi_values[19], area_data.no2_aqi_values[20], area_data.no2_aqi_values[21], area_data.no2_aqi_values[22], area_data.no2_aqi_values[23]];
    }

    return arrayContainer;
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
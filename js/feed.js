/**
 * Created by Nostos on 16/01/2017.
 */

var isRunning = false;
var isSoundRunning = false;
var ctr = 0;
var ctr2 = 0;

var isTriggered = false;
var isFirstTriggered = false;
var isResumedTriggered = false;
var isSortPicked = false;
var isAreaPicked = false;
var isEntryPicked = false;
var isPollutantPicked = false;

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
    initGraph(bancal_area, bancal_area.rolling_time, "bancal_barChart", "bancal_doughnutChart");
    initGraph(slex_area, slex_area.rolling_time, "slex_barChart", "slex_doughnutChart");

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

function initGraph(area_data, rolling_time, chartName, doughnutChartName){

    var holder;

    if(chartName == "bancal_barChart"){
        holder = bancal_data_holder;
    }else{
        holder = slex_data_holder;
    }

    if(JSON.stringify(area_data) === JSON.stringify(holder)) {
        console.log("SAME");
    }else{

        if(chartName == "bancal_barChart"){
            bancal_data_holder = area_data;
        }else{
            slex_data_holder = area_data;
        }

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
        });
    }
}

function checkIndex(pollutant, area_data){

    var arrayContainer = [];

    if(pollutant == "CO"){
        arrayContainer = [checkData(area_data.co_aqi_values[0]), checkData(area_data.co_aqi_values[1]), checkData(area_data.co_aqi_values[2]), checkData(area_data.co_aqi_values[3]), checkData(area_data.co_aqi_values[4]), checkData(area_data.co_aqi_values[5]), checkData(area_data.co_aqi_values[6]), checkData(area_data.co_aqi_values[7]), checkData(area_data.co_aqi_values[8]), checkData(area_data.co_aqi_values[9]), checkData(area_data.co_aqi_values[10]), checkData(area_data.co_aqi_values[11]), checkData(area_data.co_aqi_values[12]), checkData(area_data.co_aqi_values[13]), checkData(area_data.co_aqi_values[14]), checkData(area_data.co_aqi_values[15]), checkData(area_data.co_aqi_values[16]), checkData(area_data.co_aqi_values[17]), checkData(area_data.co_aqi_values[18]), checkData(area_data.co_aqi_values[19]), checkData(area_data.co_aqi_values[20]), checkData(area_data.co_aqi_values[21]), checkData(area_data.co_aqi_values[22]), checkData(area_data.co_aqi_values[23])];
    }else if(pollutant == "SO2"){
        arrayContainer = [checkData(area_data.so2_aqi_values[0]), checkData(area_data.so2_aqi_values[1]), checkData(area_data.so2_aqi_values[2]), checkData(area_data.so2_aqi_values[3]), checkData(area_data.so2_aqi_values[4]), checkData(area_data.so2_aqi_values[5]), checkData(area_data.so2_aqi_values[6]), checkData(area_data.so2_aqi_values[7]), checkData(area_data.so2_aqi_values[8]), checkData(area_data.so2_aqi_values[9]), checkData(area_data.so2_aqi_values[10]), checkData(area_data.so2_aqi_values[11]), checkData(area_data.so2_aqi_values[12]), checkData(area_data.so2_aqi_values[13]), checkData(area_data.so2_aqi_values[14]), checkData(area_data.so2_aqi_values[15]), checkData(area_data.so2_aqi_values[16]), checkData(area_data.so2_aqi_values[17]), checkData(area_data.so2_aqi_values[18]), checkData(area_data.so2_aqi_values[19]), checkData(area_data.so2_aqi_values[20]), checkData(area_data.so2_aqi_values[21]), checkData(area_data.so2_aqi_values[22]), checkData(area_data.so2_aqi_values[23])];
    }else if(pollutant == "NO2"){
        arrayContainer = [checkData(area_data.no2_aqi_values[0]), checkData(area_data.no2_aqi_values[1]), checkData(area_data.no2_aqi_values[2]), checkData(area_data.no2_aqi_values[3]), checkData(area_data.no2_aqi_values[4]), checkData(area_data.no2_aqi_values[5]), checkData(area_data.no2_aqi_values[6]), checkData(area_data.no2_aqi_values[7]), checkData(area_data.no2_aqi_values[8]), checkData(area_data.no2_aqi_values[9]), checkData(area_data.no2_aqi_values[10]), checkData(area_data.no2_aqi_values[11]), checkData(area_data.no2_aqi_values[12]), checkData(area_data.no2_aqi_values[13]), checkData(area_data.no2_aqi_values[14]), checkData(area_data.no2_aqi_values[15]), checkData(area_data.no2_aqi_values[16]), checkData(area_data.no2_aqi_values[17]), checkData(area_data.no2_aqi_values[18]), checkData(area_data.no2_aqi_values[19]), checkData(area_data.no2_aqi_values[20]), checkData(area_data.no2_aqi_values[21]), checkData(area_data.no2_aqi_values[22]), checkData(area_data.no2_aqi_values[23])];
    }

    return arrayContainer;
}

function checkData(data){
    if(data < 0){
        return 0;
    }else{
        return data;
    }
}
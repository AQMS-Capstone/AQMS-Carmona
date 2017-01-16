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

var alertToPlay = "0";
var statusHolder = "0";

$(function()
{
    GetFeed();
});

function GetFeed()
{
    //$('div#tryPanel').load('add.php');
    if(isTriggered) {
        if(ctr2 == 7){
            ctr2 = 0;
            isTriggered = false;
        }else{
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
            }else{
                if(isTriggered) {
                    isResumedTriggered = true;
                }
            }
        }
    });

    if(!isTriggered && !isResumedTriggered){
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
            $('#tryPanel1').html(response);
        },
        error:function(response){

        }
    });

    if(isRunning == false) {
        $.ajax({
            type: "GET",
            url: 'retrieve_feed.php',
            data: {phpValue: JSON.stringify("-1")},
            success: function (response) {
                $('#tryPanel2').html(response);
            }
        });
    }

    $.ajax({
        type: "GET",
        url: 'retrieve_alert.php',
        dataType:'JSON',
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

    myGetFeed = setTimeout('GetFeed()',1000);
}

function playSound(filePath,filename){
    document.getElementById("play-sound").innerHTML='<audio autoplay="autoplay"><source src="'+ filePath + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="'+ filePath + filename +'.mp3" /></audio>';
}

function stopSound(){
    document.getElementById("play-sound").innerHTML= '';
}

function GetFeed2() {
    isRunning = true;
    $.ajax({
        type: "GET",
        url: 'retrieve_feed.php',
        data: {phpValue: JSON.stringify($('#showEntries').val())},
        success: function (response) {
            $('#tryPanel2').html(response);
        }
    });

    myGetFeed2 = setTimeout('GetFeed2()', 1000);
}

$( document ).ready(function() {
    $('select[id=showEntries]').change(function () {

        $(function()
        {
            GetFeed2();
        });
    });
});

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
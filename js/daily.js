/**
 * Created by Skullpluggery on 11/8/2016.
 */
var mobile=false;
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var area = getUrlParameter('area');

$(document).ready(function () {

    if (area != null) {

        if (area == "SLEX") {
            GetAreaStatus2(slex_area);

        }
        else if (area == "Bancal") {
            GetAreaStatus2(bancal_area);
        }
    }
    else {
        GetAreaStatus2(bancal_area);
    }
    drawBasic();

    ScrollTo("content-holder");
});

// $('[data-click]').on('click', function (e) {
//     alert(e.data.param1);
// });

$("[data-click-accordion]").on('click', function (e) {
    var prevValue = $(this).attr('data-prevValue');
    var prevIndex = $(this).attr('data-prevIndex');

    GetAQIDetails(prevValue, pollutant_symbols[prevIndex]);
});

var AQIAirQuality;
var AQIStatus;

function GetAreaStatus2(area_data)
{
    if(area_data.name == "bancal") {
        $("#zoneName").text('Bancal Carmona, Cavite');
        $("#zoneImg").attr("src", "res/images/area/bancal.jpg");
    }else{
        $("#zoneName").text('SLEX Carmona Exit, Cavite');
        $("#zoneImg").attr("src", "res/images/area/slex_carmona-exit.jpg");
    }

    if (area_data.prevalent_value == -1 || area_data.AllDayValues_array.length == 0 || area_data.aqi_values.length == 0) {
        $("#prevalentPollutant").text("-");
        $("#aqiNum").text("-");
        $("#timeUpdated").text("-");
    }

    else {
        if(area_data.prevalent_value == -2){
            $("#aqiNum").text("400+");
        }else if(area_data.prevalent_value == -3){
            $("#aqiNum").text("201-");
        }else{
            $("#aqiNum").text(area_data.prevalent_value);
        }

        $("#prevalentPollutant").text("(" + pollutant_symbols[area_data.prevalentIndex] + ") " + pollutant_labels[area_data.prevalentIndex]);

        $("#timeUpdated").text(area_data.date_gathered);
    }

    GetAQIDetails(area_data.prevalent_value, pollutant_symbols[area_data.prevalentIndex]);

    $("#AQIStat").css("color", AQIAirQuality);
    $("#aqiColor").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);

    //if (area_data.AllDayValues_array.length != 0) {
        for (var i = 0; i < area_data.aqi_values.length; i++) {
            var found = false;

            switch (i) {
                case 0:
                    found = true;
                    break;

                case 1:
                    found = true;
                    break;

                case 2:
                    found = true;
                    break;
            }

            if (found) {

                var elementName = "e_symbol_" + (i + 1);
                var conentrationName = "concentration_value_" + (i + 1);
                var elementMin = "aqi_min_" + (i + 1);
                var elementMax = "aqi_max_" + (i + 1);

                document.getElementById(elementName).innerHTML = pollutant_labels[i];

                if (area_data.aqi_values[i] == -1) {
                    document.getElementById(conentrationName).innerHTML = "Current: -";
                } else if (area_data.aqi_values[i] == -2) {
                    document.getElementById(conentrationName).innerHTML = "Current: 400+";
                } else if (area_data.aqi_values[i] == -3) {
                    document.getElementById(conentrationName).innerHTML = "Current: 201-";
                } else {
                    document.getElementById(conentrationName).innerHTML = "Current: " + area_data.aqi_values[i];
                }

                var minValue = area_data.min_max_values[i][0];
                var maxValue =  area_data.min_max_values[i][1];

                if(i == 0){
                    if(checkArray(area_data.co_aqi_values, -2)){
                        document.getElementById(elementMax).innerHTML = "Max: 400+";
                    }else{

                        if(maxValue == -1){
                            document.getElementById(elementMax).innerHTML = "Max: -";
                        }else{
                            document.getElementById(elementMax).innerHTML = "Max: " + maxValue;
                        }
                    }

                    if(minValue == -1){
                        document.getElementById(elementMin).innerHTML = "Min: -";
                    }else{
                        document.getElementById(elementMin).innerHTML = "Min: " + minValue;
                    }
                }else if(i == 1){
                    if(checkArray(area_data.so2_aqi_values, -2)){
                        document.getElementById(elementMax).innerHTML = "Max: 400+";
                    }else{

                        if(maxValue == -1){
                            document.getElementById(elementMax).innerHTML = "Max: -";
                        }else{
                            document.getElementById(elementMax).innerHTML = "Max: " + maxValue;
                        }
                    }

                    if(minValue == -1){
                        document.getElementById(elementMin).innerHTML = "Min: -";
                    }else{
                        document.getElementById(elementMin).innerHTML = "Min: " + minValue;
                    }
                }else if(i == 2){
                    if(checkArray(area_data.no2_aqi_values, -2)){
                        document.getElementById(elementMax).innerHTML = "Max: 400+";
                    }else{

                        if(maxValue == -1){
                            document.getElementById(elementMax).innerHTML = "Max: -";
                        }else{
                            document.getElementById(elementMax).innerHTML = "Max: " + maxValue;
                        }
                    }

                    if(checkLower(area_data.no2_aqi_values)){
                        document.getElementById(elementMin).innerHTML = "Min: 201-";
                    }else{
                        if(minValue == -1){
                            document.getElementById(elementMin).innerHTML = "Min: -";
                        }else{
                            document.getElementById(elementMin).innerHTML = "Min: " + minValue;
                        }
                    }
                }
            }
        }
    //}
}

function checkLower(array_container){
    var returnBool = false;

    for (var i = 0; i < array_container.length; i++){
        if(array_container[i] == "-3"){
            returnBool = true;
            break;
        }
    }

    return returnBool;
}

function checkArray(array_container, search){
    var returnBool = false;

    for(var i = 0; i < array_container.length; i++)
    {
        if(array_container[i] == search){
            returnBool = true;
            break;
        }
    }
    return returnBool;
}

$("#prevArea").click(function () {
    if (area == "Bancal") {
        location.href = "daily.php?area=SLEX";
    }
    else if (area == "SLEX") {
        location.href = "daily.php?area=Bancal";
    }
    else {
        location.href = "daily.php?area=SLEX";
    }
})

$("#nextArea").click(function () {
    if (area == "Bancal") {
        location.href = "daily.php?area=SLEX";
    }
    else if (area == "SLEX") {
        location.href = "daily.php?area=Bancal";
    }
    else {
        location.href = "daily.php?area=SLEX";
    }
})


/**
 * Created by Skullpluggery on 11/8/2016.
 */

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

    ScrollTo("content-holder");
})


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
        $("#prevalentPollutant").text("(" + pollutant_symbols[area_data.prevalentIndex] + ") " + pollutant_labels[area_data.prevalentIndex]);
        $("#aqiNum").text(area_data.prevalent_value);
        $("#timeUpdated").text(area_data.date_gathered);
    }

    GetAQIDetails(area_data.prevalent_value, pollutant_symbols[area_data.prevalentIndex]);

    $("#AQIStat").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);

    if (area_data.AllDayValues_array.length != 0) {
        for (var i = 0; i < area_data.aqi_values.length; i++) {
            var maxValue = 0;

            switch (i) {
                case 0:
                    maxValue = Math.max(parseInt(area_data.co_max));
                    break;

                case 1:
                    maxValue = Math.max(parseInt(area_data.so2_max));
                    break;

                case 2:
                    maxValue = Math.max(parseInt(area_data.no2_max));
                    break;

                case 3:
                    maxValue = Math.max(parseInt(area_data.o3_max));
                    break;

                case 4:
                    maxValue = Math.max(parseInt(area_data.pm10_max));
                    break;

                case 5:
                    maxValue = Math.max(parseInt(area_data.tsp_max));
                    break;
            }

            if (maxValue > -1) {
                var elementName = "e_symbol_" + (i + 1);
                var conentrationName = "concentration_value_" + (i + 1);
                var elementMin = "aqi_min_" + (i + 1);
                var elementMax = "aqi_max_" + (i + 1);

                document.getElementById(elementName).innerHTML = pollutant_symbols[i];

                if (area_data.aqi_values[i] == -1) {
                    document.getElementById(conentrationName).innerHTML = "-";
                }

                else {
                    document.getElementById(conentrationName).innerHTML = area_data.aqi_values[i];
                }

                var minValue = area_data.min_max_values[i][0];

                if (minValue == -1) {
                    document.getElementById(elementMin).innerHTML = 0;
                }

                else {
                    document.getElementById(elementMin).innerHTML = minValue;
                }

                document.getElementById(elementMax).innerHTML = area_data.min_max_values[i][1];
            }
        }
    }
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


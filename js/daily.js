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


$( document ).ready(function(){

    if(area!=null){

        if(area=="SLEX"){
            GetSLEXStatus();

        }
        else if(area=="Bancal"){
            GetBancalStatus();
        }
    }
    else {
        GetBancalStatus();
    }

    ScrollTo("content-holder");
})


var AQIAirQuality;
var AQIStatus;
function GetBancalStatus() {
    $("#zoneName").text('Bancal Carmona, Cavite');
    $("#zoneImg").attr("src","res/images/area/bancal.jpg");

    if(bancal_prevalent_value == -1 || bancalAllDayValues_array.length == 0 || bancal_aqi_values.length == 0)
    {
      $("#prevalentPollutant").text("-");
      $("#aqiNum").text("-");
      $("#timeUpdated").text("-");
    }

    else
    {
      $("#prevalentPollutant").text("("+ pollutant_symbols[bancal_prevalentIndex] + ") " + pollutant_labels[bancal_prevalentIndex]);
      $("#aqiNum").text(bancal_prevalent_value);
      $("#timeUpdated").text(bancal_date_gathered);
    }

    GetAQIDetails(bancal_prevalent_value,pollutant_symbols[bancal_prevalentIndex]);
    $("#AQIStat").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);

    if(bancalAllDayValues_array.length != 0)
    {
        for(var i = 0; i < bancal_aqi_values.length; i++)
        {
            var maxValue = 0;

            switch(i)
            {
                case 0:
                    maxValue = Math.max(parseInt(bancal_co_max));
                    break;

                case 1:
                    maxValue = Math.max(parseInt(bancal_so2_max));
                    break;

                case 2:
                    maxValue = Math.max(parseInt(bancal_no2_max));
                    break;

                case 3:
                    maxValue = Math.max(parseInt(bancal_o3_max));
                    break;

                case 4:
                    maxValue = Math.max(parseInt(bancal_pm10_max));
                    break;

                case 5:
                    maxValue = Math.max(parseInt(bancal_tsp_max));
                    break;
            }

            if(maxValue > -1)
            {
                var elementName = "e_symbol_" + (i+1);
                var conentrationName = "concentration_value_" + (i+1);
                var elementMin = "aqi_min_" + (i+1);
                var elementMax = "aqi_max_" + (i+1);


                document.getElementById(elementName).innerHTML =  pollutant_symbols[i];

                if(bancal_aqi_values[i] == -1)
                {
                    document.getElementById(conentrationName).innerHTML = "-";
                }

                else
                {
                    document.getElementById(conentrationName).innerHTML =  bancal_aqi_values[i];
                }

                var minValue = parseInt(JSON.stringify(bancal_min_max_values[i][0]).replace(/"/g, ''));

                if(minValue == -1)
                {
                    document.getElementById(elementMin).innerHTML =  0;
                }

                else {
                    document.getElementById(elementMin).innerHTML = minValue;
                }


                document.getElementById(elementMax).innerHTML =  parseInt(JSON.stringify(bancal_min_max_values[i][1]).replace(/"/g, ''));
            }
        }
    }
}

function GetSLEXStatus() {
    $("#zoneName").text('SLEX Carmona Exit, Cavite');
    $("#zoneImg").attr("src","res/images/area/slex_carmona-exit.jpg");

    if(slex_prevalent_value == -1 || slexAllDayValues_array.length == 0 || slex_aqi_values.length == 0)
    {
      $("#prevalentPollutant").text("-");
      $("#aqiNum").text("-");
      $("#timeUpdated").text("-");
    }

    else
    {
      $("#prevalentPollutant").text(pollutant_labels[slex_prevalentIndex]);
      $("#aqiNum").text(slex_prevalent_value);
      $("#timeUpdated").text(slex_date_gathered);
    }

    GetAQIDetails(slex_prevalent_value,pollutant_symbols[slex_prevalentIndex]);
    $("#AQIStat").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);

    if(slexAllDayValues_array.length != 0)
    {
        for(var i = 0; i < slex_aqi_values.length; i++)
            //for(var i = 0; i < 2; i++)
        {
            var maxValue = 0;

            switch(i)
            {
                case 0:
                    maxValue = Math.max(parseInt(slex_co_max));
                    break;

                case 1:
                    maxValue = Math.max(parseInt(slex_so2_max));
                    break;

                case 2:
                    maxValue = Math.max(parseInt(slex_no2_max));
                    break;

                case 3:
                    maxValue = Math.max(parseInt(slex_o3_max));
                    break;

                case 4:
                    maxValue = Math.max(parseInt(slex_pm10_max));
                    break;

                case 5:
                    maxValue = Math.max(parseInt(slex_tsp_max));
                    break;
            }

            if(maxValue > -1)
            {
                var elementName = "e_symbol_" + (i+1);
                var conentrationName = "concentration_value_" + (i+1);
                var elementMin = "aqi_min_" + (i+1);
                var elementMax = "aqi_max_" + (i+1);

                document.getElementById(elementName).innerHTML =  pollutant_symbols[i];

                if(slex_aqi_values[i] == -1)
                {
                    document.getElementById(conentrationName).innerHTML = "-";
                }

                else
                {
                    document.getElementById(conentrationName).innerHTML =  slex_aqi_values[i];
                }

                var minValue = parseInt(JSON.stringify(slex_min_max_values[i][0]).replace(/"/g, ''));

                if(minValue == -1)
                {
                    document.getElementById(elementMin).innerHTML =  0;
                }

                else {
                    document.getElementById(elementMin).innerHTML = minValue;
                }


                document.getElementById(elementMax).innerHTML =  parseInt(JSON.stringify(slex_min_max_values[i][1]).replace(/"/g, ''));
            }
        }
    }
}

$("#prevArea").click(function () {
    if(area=="Bancal"){
        location.href = "daily.php?area=SLEX";
    }
    else if(area=="SLEX"){
        location.href = "daily.php?area=Bancal";
    }
    else{
        location.href = "daily.php?area=SLEX";
    }
})

$("#nextArea").click(function () {
    if(area=="Bancal"){
        location.href = "daily.php?area=SLEX";
    }
    else if(area=="SLEX"){
        location.href = "daily.php?area=Bancal";
    }
    else{
        location.href = "daily.php?area=SLEX";
    }
})

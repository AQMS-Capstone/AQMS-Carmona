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

    $("#prevalentPollutant").text(pollutant_labels[bancal_prevalentIndex]);
    $("#aqiNum").text(bancal_prevalent_value);
    $("#timeUpdated").text(bancal_date_gathered);


    GetAQIDetails(bancal_prevalent_value,pollutant_symbols[bancal_prevalentIndex]);
    $("#AQIStat").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);

}

function GetSLEXStatus() {
    $("#zoneName").text('SLEX Carmona Exit, Cavite');
    $("#zoneImg").attr("src","res/images/area/slex_carmona-exit.jpg");

    $("#prevalentPollutant").text(pollutant_labels[slex_prevalentIndex]);
    $("#aqiNum").text(slex_prevalent_value);
    $("#timeUpdated").text(slex_date_gathered);

    GetAQIDetails(slex_prevalent_value,pollutant_symbols[slex_prevalentIndex]);
    $("#AQIStat").css("background-color", AQIAirQuality);
    $("#aqiText").text(AQIStatus);
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

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
var mobile=true;
var area = getUrlParameter('area');

$("#prevArea").click(function () {
    if (area == "Bancal") {
        location.href = "mobile-home.php?area=SLEX";
    }
    else if (area == "SLEX") {
        location.href = "mobile-home.php?area=Bancal";
    }
    else {
        location.href = "mobile-home.php?area=SLEX";
    }
})

$("#nextArea").click(function () {
    if (area == "Bancal") {
        location.href = "mobile-home.php?area=SLEX";
    }
    else if (area == "SLEX") {
        location.href = "mobile-home.php?area=Bancal";
    }
    else {
        location.href = "mobile-home.php?area=SLEX";
    }
})

$(document).ready(function () {

    if(area=="SLEX"){
        GetAreaStatus(slex_area);
        //GetSLEXStatus();
    }
    else if(area="Bancal"){
        GetAreaStatus(bancal_area);
        //GetBancalStatus();
    }
    else{
        GetAreaStatus(bancal_area);
    }

});

function GetAreaStatus(area_data)
{

    document.getElementById("aqiText").style.color = area_data.AirQuality;
    document.getElementById("AQIStat").style.color = area_data.AirQuality;
    document.getElementById("zoneName").innerHTML = area_data.displayName;
    document.getElementById("prevalentPollutant").innerHTML = area_data.prevalentPollutant;
    document.getElementById("aqiNum").innerHTML = area_data.AQI;
    document.getElementById("aqiText").innerHTML = area_data.AQIStatus;
    document.getElementById("timeUpdated").innerHTML = area_data.d_date_gathered;

    GetAQIDetails(area_data.prevalent_value, pollutant_symbols[area_data.prevalentIndex]);

    drawBasic();
}

generateArea(slex_area);
generateArea(bancal_area);

function generateArea(area) {

    //alert(area.name);
    if(area.AllDayValues_array.length == 0 || area.aqi_values.length == 0)
    {
        area.AQI = "-";
        area.prevalentPollutant = "-";
        area.AirQuality = otherAir;
        area.AQIStatus = "No Current Data";
        area.d_date_gathered = "-";
    }

    else {
        area.AQI = area.prevalent_value;
        area.prevalentPollutant = pollutant_labels[area.prevalentIndex];
        area.d_date_gathered = area.date_gathered;

        if(area.AQI >= 0 && area.AQI <= 50){
            area.AirQuality = goodAir;
            area.AQIStatus = "Good";
        }else if(area.AQI >= 51 && area.AQI <= 100)
        {
            area.AirQuality = fairAir;
            area.AQIStatus = "Fair";
        }else if(area.AQI >= 101 && area.AQI <= 150)
        {
            area.AirQuality = unhealthyAir;
            area.AQIStatus = "Unhealthy for Sensitive Groups";
        }else if(area.AQI >= 151 && area.AQI <= 200)
        {
            area.AirQuality = veryUnhealthyAir;
            area.AQIStatus = "Very Unhealthy";
        }else if(area.AQI >= 201 && area.AQI <= 300)
        {
            area.AirQuality = acutelyUnhealthyAir;
            area.AQIStatus = "Acutely Unhealthy";
        }else if(area.AQI >= 301)
        {
            area.AirQuality = emergencyAir;
            area.AQIStatus = "Emergency";
        }else if(area.AQI == -1){
            area.AQI = "-";
            area.prevalentPollutant = "-";
            area.AirQuality = otherAir;
            area.AQIStatus = "No Current Data";
            area.d_date_gathered = "-";
        }else if(area.AQI == -2){
            area.AQI = "400+";
            area.AirQuality = emergencyAir;
            area.AQIStatus = "Emergency";
        }else if(area.AQI == -3){
            area.AQI = "201-";
            area.AirQuality = goodAir;
            area.AQIStatus = "Good";
        }
    }
}
//AREAS
var carmona=new google.maps.LatLng(14.2992809,121.0284822);
var bancal=new google.maps.LatLng(14.283559,121.007561);
var slex=new google.maps.LatLng(14.322350,121.062300);

var zoomSize = 13;

// --------- SET VALUES FOR BANCAL --------- //

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
        }
    }
}

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

function initialize()
{

    var mapProp = {
        disableDefaultUI:true,
        center:carmona,
        zoom:zoomSize,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

    var bancalMarker = new MarkerWithLabel({
        position: bancal,
        map: map,
        labelContent:  bancal_area.displayPointName,
        labelAnchor: new google.maps.Point(bancal_area.displayPointX, 80),
        labelClass: "labels", // the CSS class for the label
        labelInBackground: false,
    });

    var slexMarker = new MarkerWithLabel({
        position: slex,
        map: map,
        labelContent: slex_area.displayPointName,
        labelAnchor: new google.maps.Point(slex_area.displayPointX, 80), //ETO YUNG DAPAT ICENTER, STATIC KO MUNA
        labelClass: "labels", // the CSS class for the label
        labelInBackground: false,
    });

    var zoneBancal = new google.maps.Circle({
        center:bancal,
        radius:500,
        strokeColor: bancal_area.AirQuality,
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor: bancal_area.AirQuality,
        fillOpacity:0.5
    });

    var zoneSLEX = new google.maps.Circle({
        center:slex,
        radius:500,
        strokeColor:slex_area.AirQuality,
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:slex_area.AirQuality,
        fillOpacity:0.5
    });
    var d = new Date();
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

    google.maps.event.addListener(bancalMarker,'click',function() {
        window.location.href = "daily.php?area=Bancal";
    });

    google.maps.event.addListener(slexMarker,'click',function() {
        window.location.href = "daily.php?area=SLEX";
    });

    zoneBancal.setMap(map);
    zoneSLEX.setMap(map);
    bancalMarker.setMap(map);
    slexMarker.setMap(map);

    var bancalZoom=new google.maps.LatLng(14.283559,121.007561);
    var slexZoom=new google.maps.LatLng(14.322350,121.062300);

    function GetAreaStatus(area_data)
    {
        map.setZoom(15);

        if(area_data.name == "bancal") {
            map.setCenter(bancalZoom);
        }else{
            map.setCenter(slexZoom);
        }


        GetAQIDetails(area_data.prevalent_value, pollutant_symbols[area_data.prevalentIndex]);


    }

    var area = getUrlParameter('area');

    if(area!=null){
        if(area=="SLEX"){
            GetAreaStatus(slex_area);
            //GetSLEXStatus();
        }
        else if(area="Bancal"){
            GetAreaStatus(bancal_area);
            //GetBancalStatus();
        }
    }
}

google.maps.event.addDomListener(window, 'load', initialize);

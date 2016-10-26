//AREAS
var carmona=new google.maps.LatLng(14.2992809,121.0284822);
var bancal=new google.maps.LatLng(14.283559,121.007561);
var slex=new google.maps.LatLng(14.322350,121.062300);

var zoomSize = 13;
//Air Quality Color Indicator
var goodAir = "#2196F3";
var moderateAir = "#FFEB3B";
var unhealthy1Air = "#FF9800";
var unhealthy2Air = "#f44336";
var veryUnhealthyAir = "#9C27B0";
var hazardoussAir = "#b71c1c";

//ETO UNG BABAGUHIN , LALAGYAN NG CONDITION
var bancalAirQuality = moderateAir;
var slexAirQuality = unhealthy2Air;
var bancalAQI = 54;
var slexAQI = 152;

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
        labelContent: bancalAQI,
        labelAnchor: new google.maps.Point(20, 65),
        labelClass: "labels", // the CSS class for the label
        labelInBackground: false,
    });

    var slexMarker = new MarkerWithLabel({
        position: slex,
        map: map,
        labelContent: slexAQI,
        labelAnchor: new google.maps.Point(20, 65),
        labelClass: "labels", // the CSS class for the label
        labelInBackground: false,
    });


    var zoneBancal = new google.maps.Circle({
        center:bancal,
        radius:500,
        strokeColor: bancalAirQuality,
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor: bancalAirQuality,
        fillOpacity:0.5
    });

    var zoneSLEX = new google.maps.Circle({
        center:slex,
        radius:500,
        strokeColor:slexAirQuality,
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:slexAirQuality,
        fillOpacity:0.5
    });
    var d = new Date();
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

    google.maps.event.addListener(bancalMarker,'click',function() {
       GetBancalStatus();
    });

    google.maps.event.addListener(slexMarker,'click',function() {
        GetSLEXStatus();
    });

    google.maps.event.addListener(map, 'dragend', function() { $("#zoneStatus").hide(); } );

    document.getElementById("drpBancal").onclick = function(){
        GetBancalStatus();
    };

    document.getElementById("drpSLEX").onclick = function(){
        GetSLEXStatus();
    };

    zoneBancal.setMap(map);
    zoneSLEX.setMap(map);
    bancalMarker.setMap(map);
    slexMarker.setMap(map);

    var bancalZoom=new google.maps.LatLng(14.283969,121.015671);
    function GetBancalStatus() {
        map.setZoom(16);
        map.setCenter(bancalZoom);

        $("#zoneStatus").show();
        document.getElementById("AQIStat").style.backgroundColor = bancalAirQuality;
        document.getElementById("zoneName").innerHTML = 'Bancal, Carmona, Cavite';
        document.getElementById("aqiNum").innerHTML = bancalAQI;
        document.getElementById("aqiText").innerHTML = 'Moderate';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }
    var slexZoom=new google.maps.LatLng(14.32274,121.071688);
    //noinspection JSAnnotator
    function GetSLEXStatus() {
        map.setZoom(16);
        map.setCenter(slexZoom);

        $("#zoneStatus").show();
        document.getElementById("AQIStat").style.backgroundColor = slexAirQuality;
        document.getElementById("zoneName").innerHTML = 'SLEX Carmona Exit, Cavite';
        document.getElementById("aqiNum").innerHTML = slexAQI;
        document.getElementById("aqiText").innerHTML = 'Unhealthy';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }
}

google.maps.event.addDomListener(window, 'load', initialize);

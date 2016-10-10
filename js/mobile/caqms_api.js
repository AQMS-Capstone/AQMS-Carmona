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
var bancalAQI = 50;
var slexAQI = 152;

document.addEventListener( 'DOMContentLoaded', function () {
   initialize();

}, false );

function initialize()
{
    var d = new Date();
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

    GetSLEXStatus();

    document.getElementById("drpBancal").onclick = function(){

        GetBancalStatus();
    };

    document.getElementById("drpSLEX").onclick = function(){
        GetSLEXStatus();
    };

    function GetBancalStatus() {

        document.getElementById("zoneStatus").style.visibility = 'visible';
        document.getElementById("AQIStat").style.backgroundColor = bancalAirQuality;
        document.getElementById("zoneName").innerHTML = 'Bancal, Carmona, Cavite';
        document.getElementById("aqiNum").innerHTML = bancalAQI;
        document.getElementById("aqiText").innerHTML = 'Moderate';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }

    function GetSLEXStatus() {
        document.getElementById("zoneStatus").style.visibility = 'visible';
        document.getElementById("AQIStat").style.backgroundColor = slexAirQuality;
        document.getElementById("zoneName").innerHTML = 'SLEX Carmona Exit, Cavite';
        document.getElementById("aqiNum").innerHTML = slexAQI;
        document.getElementById("aqiText").innerHTML = 'Unhealthy';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }
}

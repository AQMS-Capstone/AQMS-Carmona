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
//var bancalAirQuality = moderateAir;
//var slexAirQuality = unhealthy2Air;
//var bancalAQI = 54;
//var slexAQI = 152;

var bancalAirQuality = "";
var slexAirQuality = "";

//We can optimize this code once we put the values in DB

switch(bancalMap.p_id)
{
  case 0: // TSP
    if(bancalMap.p_value >= 0 && bancalMap.p_value <= 80){
      bancalAirQuality = goodAir;
    }else if(bancalMap.p_value >= 81 && bancalMap.p_value <= 230){
      bancalAirQuality = moderateAir;
    }else if(bancalMap.p_value >= 231 && bancalMap.p_value <= 349){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalMap.p_value >= 350 && bancalMap.p_value <= 599){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalMap.p_value >= 600 && bancalMap.p_value <= 899){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalMap.p_value >= 900){
      bancalAirQuality = hazardoussAir;
    }else {
      bancalAirQuality = hazardoussAir;
    }
    break;

  case 1: // PM 10
    if(bancalMap.p_value >= 0 && bancalMap.p_value <= 54){
      bancalAirQuality = goodAir;
    }else if(bancalMap.p_value >= 55 && bancalMap.p_value <= 154){
      bancalAirQuality = moderateAir;
    }else if(bancalMap.p_value >= 155 && bancalMap.p_value <= 254){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalMap.p_value >= 255 && bancalMap.p_value <= 354){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalMap.p_value >= 355 && bancalMap.p_value <= 424){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalMap.p_value >= 425 && bancalMap.p_value <= 504){
      bancalAirQuality = hazardoussAir;
    }
    break;

    case 2: // SO2
      if(bancalMap.p_value >= 0.000 && bancalMap.p_value <= 0.034){
        bancalAirQuality = goodAir;
      }else if(bancalMap.p_value >= 0.035 && bancalMap.p_value <= 0.144){
        bancalAirQuality = moderateAir;
      }else if(bancalMap.p_value >= 0.145 && bancalMap.p_value <= 0.224){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalMap.p_value >= 0.225 && bancalMap.p_value <= 0.304){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalMap.p_value >= 0.305 && bancalMap.p_value <= 0.604){
        bancalAirQuality = veryUnhealthyAir;
      }else if(bancalMap.p_value >= 0.605 && bancalMap.p_value <= 0.804){
        bancalAirQuality = hazardoussAir;
      }
      break;

  case 3: // O3

    if(bancalMap.p_value > 0.375){ // O3 1hr
      if(bancalMap.p_value >= 0.000 && bancalMap.p_value <= 0.124){

      }else if(bancalMap.p_value >= 0.125 && bancalMap.p_value <= 0.164){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalMap.p_value >= 0.165 && bancalMap.p_value <= 0.204){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalMap.p_value >= 0.205 && bancalMap.p_value <= 0.404){
        bancalAirQuality = veryUnhealthyAir;
      }else if(bancalMap.p_value >= 0.405 && bancalMap.p_value <= 0.504){
        bancalAirQuality = hazardoussAir;
      }
    }

    else { // O3 8 hr
      if(bancalMap.p_value >= 0.000 && bancalMap.p_value <= 0.064){
        bancalAirQuality = goodAir;
      }else if(bancalMap.p_value >= 0.065 && bancalMap.p_value <= 0.084){
        bancalAirQuality = moderateAir;
      }else if(bancalMap.p_value >= 0.085 && bancalMap.p_value <= 0.104){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalMap.p_value >= 0.105 && bancalMap.p_value <= 0.124){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalMap.p_value >= 0.125 && bancalMap.p_value <= 0.374){
        bancalAirQuality = veryUnhealthyAir;
      }
    }
    break;

  case 4: // CO
    if(bancalMap.p_value >= 0.0 && bancalMap.p_value <= 4.4){
      bancalAirQuality = goodAir;
    }else if(bancalMap.p_value >= 4.5 && bancalMap.p_value <= 9.4){
      bancalAirQuality = moderateAir;
    }else if(bancalMap.p_value >= 9.5 && bancalMap.p_value <= 12.4){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalMap.p_value >= 12.5 && bancalMap.p_value <= 15.4){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalMap.p_value >= 15.5 && bancalMap.p_value <= 30.4){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalMap.p_value >= 30.5 && bancalMap.p_value <= 40.4){
      bancalAirQuality = hazardoussAir;
    }
    break;

  case 5: // NO2
    if(bancalMap.p_value >= 0.00 && bancalMap.p_value <= 0.64){

    }else if(bancalMap.p_value >= 1.25 && bancalMap.p_value <= 1.64){
      bancalAirQuality = hazardoussAir;
    }
    break;
}

switch(slexMap.p_id)
{
  case 0: // TSP
    if(slexMap.p_value >= 0 && slexMap.p_value <= 80){
      slexAirQuality = goodAir;
    }else if(slexMap.p_value >= 81 && slexMap.p_value <= 230){
      slexAirQuality = moderateAir;
    }else if(slexMap.p_value >= 231 && slexMap.p_value <= 349){
      slexAirQuality = unhealthy1Air;
    }else if(slexMap.p_value >= 350 && slexMap.p_value <= 599){
      slexAirQuality = unhealthy2Air;
    }else if(slexMap.p_value >= 600 && slexMap.p_value <= 899){
      slexAirQuality = veryUnhealthyAir;
    }else if(slexMap.p_value >= 900){
      slexAirQuality = hazardoussAir;
    }else {
      slexAirQuality = hazardoussAir;
    }
    break;

  case 1: // PM 10
    if(slexMap.p_value >= 0 && slexMap.p_value <= 54){
      slexAirQuality = goodAir;
    }else if(slexMap.p_value >= 55 && slexMap.p_value <= 154){
      slexAirQuality = moderateAir;
    }else if(slexMap.p_value >= 155 && slexMap.p_value <= 254){
      slexAirQuality = unhealthy1Air;
    }else if(slexMap.p_value >= 255 && slexMap.p_value <= 354){
      slexAirQuality = unhealthy2Air;
    }else if(slexMap.p_value >= 355 && slexMap.p_value <= 424){
      slexAirQuality = veryUnhealthyAir;
    }else if(slexMap.p_value >= 425 && slexMap.p_value <= 504){
      slexAirQuality = hazardoussAir;
    }
    break;

    case 2: // SO2
      if(slexMap.p_value >= 0.000 && slexMap.p_value <= 0.034){
        slexAirQuality = goodAir;
      }else if(slexMap.p_value >= 0.035 && slexMap.p_value <= 0.144){
        slexAirQuality = moderateAir;
      }else if(slexMap.p_value >= 0.145 && slexMap.p_value <= 0.224){
        slexAirQuality = unhealthy1Air;
      }else if(slexMap.p_value >= 0.225 && slexMap.p_value <= 0.304){
        slexAirQuality = unhealthy2Air;
      }else if(slexMap.p_value >= 0.305 && slexMap.p_value <= 0.604){
        slexAirQuality = veryUnhealthyAir;
      }else if(slexMap.p_value >= 0.605 && slexMap.p_value <= 0.804){
        slexAirQuality = hazardoussAir;
      }
      break;

  case 3: // O3

    if(slexMap.p_value > 0.375){ // O3 1hr
      if(slexMap.p_value >= 0.000 && slexMap.p_value <= 0.124){

      }else if(slexMap.p_value >= 0.125 && slexMap.p_value <= 0.164){
        slexAirQuality = unhealthy1Air;
      }else if(slexMap.p_value >= 0.165 && slexMap.p_value <= 0.204){
        slexAirQuality = unhealthy2Air;
      }else if(slexMap.p_value >= 0.205 && slexMap.p_value <= 0.404){
        slexAirQuality = veryUnhealthyAir;
      }else if(slexMap.p_value >= 0.405 && slexMap.p_value <= 0.504){
        slexAirQuality = hazardoussAir;
      }
    }

    else { // O3 8 hr
      if(slexMap.p_value >= 0.000 && slexMap.p_value <= 0.064){
        slexAirQuality = goodAir;
      }else if(slexMap.p_value >= 0.065 && slexMap.p_value <= 0.084){
        slexAirQuality = moderateAir;
      }else if(slexMap.p_value >= 0.085 && slexMap.p_value <= 0.104){
        slexAirQuality = unhealthy1Air;
      }else if(slexMap.p_value >= 0.105 && slexMap.p_value <= 0.124){
        slexAirQuality = unhealthy2Air;
      }else if(slexMap.p_value >= 0.125 && slexMap.p_value <= 0.374){
        slexAirQuality = veryUnhealthyAir;
      }
    }
    break;

  case 4: // CO
    if(slexMap.p_value >= 0.0 && slexMap.p_value <= 4.4){
      slexAirQuality = goodAir;
    }else if(slexMap.p_value >= 4.5 && slexMap.p_value <= 9.4){
      slexAirQuality = moderateAir;
    }else if(slexMap.p_value >= 9.5 && slexMap.p_value <= 12.4){
      slexAirQuality = unhealthy1Air;
    }else if(slexMap.p_value >= 12.5 && slexMap.p_value <= 15.4){
      slexAirQuality = unhealthy2Air;
    }else if(slexMap.p_value >= 15.5 && slexMap.p_value <= 30.4){
      slexAirQuality = veryUnhealthyAir;
    }else if(slexMap.p_value >= 30.5 && slexMap.p_value <= 40.4){
      slexAirQuality = hazardoussAir;
    }
    break;

  case 5: // NO2
    if(slexMap.p_value >= 0.00 && slexMap.p_value <= 0.64){

    }else if(slexMap.p_value >= 1.25 && slexMap.p_value <= 1.64){
      slexAirQuality = hazardoussAir;
    }
    break;
}

var bancalAQI = bancalMap.p_value;
var slexAQI = slexMap.p_value;

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

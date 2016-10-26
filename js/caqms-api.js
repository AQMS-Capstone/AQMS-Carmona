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
switch(bancalPrevalentPollutant)
{
  case 0: // TSP
    if(bancalAQIValue >= 0 && bancalAQIValue <= 80){
      bancalAirQuality = goodAir;
    }else if(bancalAQIValue >= 81 && bancalAQIValue <= 230){
      bancalAirQuality = moderateAir;
    }else if(bancalAQIValue >= 231 && bancalAQIValue <= 349){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalAQIValue >= 350 && bancalAQIValue <= 599){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalAQIValue >= 600 && bancalAQIValue <= 899){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalAQIValue >= 900){
      bancalAirQuality = hazardoussAir;
    }else {
      bancalAirQuality = hazardoussAir;
    }
    break;

  case 1: // PM 10
    if(bancalAQIValue >= 0 && bancalAQIValue <= 54){
      bancalAirQuality = goodAir;
    }else if(bancalAQIValue >= 55 && bancalAQIValue <= 154){
      bancalAirQuality = moderateAir;
    }else if(bancalAQIValue >= 155 && bancalAQIValue <= 254){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalAQIValue >= 255 && bancalAQIValue <= 354){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalAQIValue >= 355 && bancalAQIValue <= 424){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalAQIValue >= 425 && bancalAQIValue <= 504){
      bancalAirQuality = hazardoussAir;
    }
    break;

    case 2: // SO2
      if(bancalAQIValue >= 0.000 && bancalAQIValue <= 0.034){
        bancalAirQuality = goodAir;
      }else if(bancalAQIValue >= 0.035 && bancalAQIValue <= 0.144){
        bancalAirQuality = moderateAir;
      }else if(bancalAQIValue >= 0.145 && bancalAQIValue <= 0.224){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalAQIValue >= 0.225 && bancalAQIValue <= 0.304){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalAQIValue >= 0.305 && bancalAQIValue <= 0.604){
        bancalAirQuality = veryUnhealthyAir;
      }else if(bancalAQIValue >= 0.605 && bancalAQIValue <= 0.804){
        bancalAirQuality = hazardoussAir;
      }
      break;

  case 3: // O3

    if(bancalAQIValue > 0.375){ // O3 1hr
      if(bancalAQIValue >= 0.000 && bancalAQIValue <= 0.124){

      }else if(bancalAQIValue >= 0.125 && bancalAQIValue <= 0.164){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalAQIValue >= 0.165 && bancalAQIValue <= 0.204){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalAQIValue >= 0.205 && bancalAQIValue <= 0.404){
        bancalAirQuality = veryUnhealthyAir;
      }else if(bancalAQIValue >= 0.405 && bancalAQIValue <= 0.504){
        bancalAirQuality = hazardoussAir;
      }
    }

    else { // O3 8 hr
      if(bancalAQIValue >= 0.000 && bancalAQIValue <= 0.064){
        bancalAirQuality = goodAir;
      }else if(bancalAQIValue >= 0.065 && bancalAQIValue <= 0.084){
        bancalAirQuality = moderateAir;
      }else if(bancalAQIValue >= 0.085 && bancalAQIValue <= 0.104){
        bancalAirQuality = unhealthy1Air;
      }else if(bancalAQIValue >= 0.105 && bancalAQIValue <= 0.124){
        bancalAirQuality = unhealthy2Air;
      }else if(bancalAQIValue >= 0.125 && bancalAQIValue <= 0.374){
        bancalAirQuality = veryUnhealthyAir;
      }
    }
    break;

  case 4: // CO
    if(bancalAQIValue >= 0.0 && bancalAQIValue <= 4.4){
      bancalAirQuality = goodAir;
    }else if(bancalAQIValue >= 4.5 && bancalAQIValue <= 9.4){
      bancalAirQuality = moderateAir;
    }else if(bancalAQIValue >= 9.5 && bancalAQIValue <= 12.4){
      bancalAirQuality = unhealthy1Air;
    }else if(bancalAQIValue >= 12.5 && bancalAQIValue <= 15.4){
      bancalAirQuality = unhealthy2Air;
    }else if(bancalAQIValue >= 15.5 && bancalAQIValue <= 30.4){
      bancalAirQuality = veryUnhealthyAir;
    }else if(bancalAQIValue >= 30.5 && bancalAQIValue <= 40.4){
      bancalAirQuality = hazardoussAir;
    }
    break;

  case 5: // NO2
    if(bancalAQIValue >= 0.00 && bancalAQIValue <= 0.64){

    }else if(bancalAQIValue >= 1.25 && bancalAQIValue <= 1.64){
      bancalAirQuality = hazardoussAir;
    }
    break;
}

var bancalAQI = bancalAQIValue;
var slexAQI = slexAQIValue;

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

    google.maps.event.addListener(map, 'dragend', function() { document.getElementById("zoneStatus").style.visibility = 'hidden'; } );

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

    var bancalZoom=new google.maps.LatLng(14.2816712,121.0147383);
    function GetBancalStatus() {
        map.setZoom(16);
        map.setCenter(bancalZoom);

        document.getElementById("zoneStatus").style.visibility = 'visible';
        document.getElementById("AQIStat").style.backgroundColor = bancalAirQuality;
        document.getElementById("zoneName").innerHTML = 'Bancal, Carmona, Cavite';
        document.getElementById("aqiNum").innerHTML = bancalAQI;
        document.getElementById("aqiText").innerHTML = 'Moderate';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }
    var slexZoom=new google.maps.LatLng(14.3203282,121.0711943);
    //noinspection JSAnnotator
    function GetSLEXStatus() {
        map.setZoom(16);
        map.setCenter(slexZoom);

        document.getElementById("zoneStatus").style.visibility = 'visible';
        document.getElementById("AQIStat").style.backgroundColor = slexAirQuality;
        document.getElementById("zoneName").innerHTML = 'SLEX Carmona Exit, Cavite';
        document.getElementById("aqiNum").innerHTML = slexAQI;
        document.getElementById("aqiText").innerHTML = 'Unhealthy';
        document.getElementById("timeUpdated").innerHTML =  days[d.getDay()] + " " +d.getHours() + ":" + d.getMinutes();
    }
}

google.maps.event.addDomListener(window, 'load', initialize);

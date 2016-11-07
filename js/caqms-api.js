//AREAS
var carmona=new google.maps.LatLng(14.2992809,121.0284822);
var bancal=new google.maps.LatLng(14.283559,121.007561);
var slex=new google.maps.LatLng(14.322350,121.062300);

var zoomSize = 13;

// --------- SET VALUES FOR BANCAL --------- //

var bancalAQIStatus = "";
var bancalAirQuality = "";
var bancalAQI = "";
var bancalprevalentPollutant = "";

if(bancalAllDayValues_array.length == 0)
{
  bancalAQI = "-";
  bancalprevalentPollutant = "-";
  bancalAirQuality = otherAir;
  bancalAQIStatus = "No Available Data";
  bancal_date_gathered = "-";
}

else {
  bancalAQI = bancal_prevalent_value;
  bancalprevalentPollutant = pollutant_labels[bancal_prevalentIndex];

  if(bancalAQI >= 0 && bancalAQI <= 50){
    bancalAirQuality = goodAir;
    bancalAQIStatus = "Good";
  }else if(bancalAQI >= 51 && bancalAQI <= 100)
  {
    bancalAirQuality = fairAir;
    bancalAQIStatus = "Fair";
  }else if(bancalAQI >= 101 && bancalAQI <= 150)
  {
    bancalAirQuality = unhealthyAir;
    bancalAQIStatus = "Unhealthy for Sensitive Groups";
  }else if(bancalAQI >= 151 && bancalAQI <= 200)
  {
    bancalAirQuality = veryUnhealthyAir;
    bancalAQIStatus = "Very Unhealthy";
  }else if(bancalAQI >= 201 && bancalAQI <= 300)
  {
    bancalAirQuality = acutelyUnhealthyAir;
    bancalAQIStatus = "Acutely Unhealthy";
  }else if(bancalAQI >= 301 && bancalAQI <= 400)
  {
    bancalAirQuality = emergencyAir;
    bancalAQIStatus = "Emergency";
  }else if(bancalAQI == -1){
    bancalAQI = "-";
    bancalprevalentPollutant = "-";
    bancalAirQuality = otherAir;
    bancalAQIStatus = "No Available Data";
    bancal_date_gathered = "-";
  }
}

// --------- SET VALUES FOR SLEX --------- //

var slexAQIStatus = goodAir;
var slexAirQuality = "Good";
var slexAQI = 21;
var slexprevalentPollutant = "CO";

//var bancalAQIStatus = prevalentValues_bancal_array[0].p_aqi_status;
//var bancalAirQuality = prevalentValues_bancal_array[0].p_airqualiy;
//var bancalAQI = parseInt(prevalentValues_bancal_array[0].concentration_value);
//var bancalprevalentPollutant = prevalentValues_bancal_array[0].e_name;

//var slexAQIStatus = prevalentValues_slex_array[0].p_aqi_status;
//var slexAirQuality = prevalentValues_slex_array[0].p_airqualiy;
//var slexAQI = parseInt(prevalentValues_slex_array[0].concentration_value);
//var slexprevalentPollutant = prevalentValues_slex_array[0].e_name;

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
        window.location.href = "index.php?area=Bancal";
        //GetBancalStatus();
    });

    google.maps.event.addListener(slexMarker,'click',function() {
        window.location.href = "index.php?area=SLEX";
        //GetSLEXStatus();
    });

    google.maps.event.addListener(map, 'dragend', function() { $("#zoneStatus").hide(); } );


    zoneBancal.setMap(map);
    zoneSLEX.setMap(map);
    bancalMarker.setMap(map);
    slexMarker.setMap(map);

    var bancalZoom=new google.maps.LatLng(14.283969,121.015671);
    function GetBancalStatus() {
        map.setZoom(16);
        map.setCenter(bancalZoom);

        $("#zoneStatus").show();
        document.getElementById("aqiText").style.color = bancalAirQuality;
        document.getElementById("AQIStat").style.backgroundColor = bancalAirQuality;
        document.getElementById("zoneName").innerHTML = 'Bancal Carmona, Cavite';
        document.getElementById("prevalentPollutant").innerHTML = bancalprevalentPollutant;
        document.getElementById("aqiNum").innerHTML = bancalAQI;
        document.getElementById("aqiText").innerHTML = bancalAQIStatus;
        document.getElementById("timeUpdated").innerHTML = bancal_date_gathered;

        //document.getElementById("e_symbol_1").innerHTML =  "HII";
        //document.getElementById("concentration_value_1").innerHTML =  "5";

        //alert(bancalAllDayValues_array.length);

        if(bancalAllDayValues_array.length != 0)
        //if(bancal_prevalent_value != -1 && bancalAllDayValues_array.length != 0) // --------- CHECK IF DB VALUES FOR BANCAL IS EMPTY AND IF PREVALENT VALUE IS NOT EQUAL TO 0 --------- //
        {
          for(var i = 0; i < bancal_aqi_values.length; i++)
          {
              var maxValue = 0;

              switch(i)
              {
                case 0:
                  maxValue = Math.max(parseInt(bancal_co_max));
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
        /*
         document.getElementById("e_symbol_1").innerHTML =  bancalValues_array[0].e_symbol;
         document.getElementById("e_symbol_2").innerHTML =  bancalValues_array[1].e_symbol;
         document.getElementById("e_symbol_3").innerHTML =  bancalValues_array[2].e_symbol;
         document.getElementById("e_symbol_4").innerHTML =  bancalValues_array[3].e_symbol;
         document.getElementById("e_symbol_5").innerHTML =  bancalValues_array[4].e_symbol;
         document.getElementById("e_symbol_6").innerHTML =  bancalValues_array[5].e_symbol;
         document.getElementById("e_symbol_7").innerHTML =  bancalValues_array[6].e_symbol;

         document.getElementById("concentration_value_1").innerHTML =  slexValues_array[0].e_symbol;
         document.getElementById("concentration_value_2").innerHTML =  slexValues_array[1].e_symbol;
         document.getElementById("concentration_value_3").innerHTML =  slexValues_array[2].e_symbol;
         document.getElementById("concentration_value_4").innerHTML =  slexValues_array[3].e_symbol;
         document.getElementById("concentration_value_5").innerHTML =  slexValues_array[4].e_symbol;
         document.getElementById("concentration_value_6").innerHTML =  slexValues_array[5].e_symbol;
         document.getElementById("concentration_value_7").innerHTML =  slexValues_array[6].e_symbol;
         */
    }
    var slexZoom=new google.maps.LatLng(14.32274,121.071688);
    //noinspection JSAnnotator
    function GetSLEXStatus() {
        map.setZoom(16);
        map.setCenter(slexZoom);

        $("#zoneStatus").show();
        document.getElementById("aqiText").style.color = slexAirQuality;
        document.getElementById("AQIStat").style.backgroundColor = slexAirQuality;
        document.getElementById("zoneName").innerHTML = 'SLEX Carmona Exit, Cavite';
        document.getElementById("prevalentPollutant").innerHTML = slexprevalentPollutant;
        document.getElementById("aqiNum").innerHTML = slexAQI;
        document.getElementById("aqiText").innerHTML = slexAQIStatus;
        document.getElementById("timeUpdated").innerHTML =  bancal_date_gathered;

        //document.getElementById("e_symbol_1").innerHTML =  "HI";
        //document.getElementById("concentration_value_1").innerHTML =  "7";

        //alert(bancal_aqi_values[0]);

        for(var i = 0; i < bancal_aqi_values.length; i++)
        {
            var elementName = "e_symbol_" + (i+1);
            var conentrationName = "concentration_value_" + (i+1);

            var elementMin = "aqi_min_" + (i+1);
            var elementMax = "aqi_max_" + (i+1);

            document.getElementById(elementName).innerHTML =  pollutant_symbols[i];
            document.getElementById(conentrationName).innerHTML =  bancal_aqi_values[i];

            document.getElementById(elementMin).innerHTML =  parseInt(JSON.stringify(bancal_min_max_values[i][0]).replace(/"/g, ''));
            document.getElementById(elementMax).innerHTML =  parseInt(JSON.stringify(bancal_min_max_values[i][1]).replace(/"/g, ''));
        }

        /*
        for(var i = 0; i < slexValues_array.length; i++)
        {
            var elementName = "e_symbol_" + (i+1);
            var conentrationName = "concentration_value_" + (i+1);

            document.getElementById(elementName).innerHTML =  slexValues_array[i].e_symbol;
            document.getElementById(conentrationName).innerHTML =  slexValues_array[i].concentration_value;
        }
        */

        /*
         document.getElementById("e_symbol_1").innerHTML =  bancalValues_array[0].e_symbol;
         document.getElementById("e_symbol_2").innerHTML =  bancalValues_array[1].e_symbol;
         document.getElementById("e_symbol_3").innerHTML =  bancalValues_array[2].e_symbol;
         document.getElementById("e_symbol_4").innerHTML =  bancalValues_array[3].e_symbol;
         document.getElementById("e_symbol_5").innerHTML =  bancalValues_array[4].e_symbol;
         document.getElementById("e_symbol_6").innerHTML =  bancalValues_array[5].e_symbol;
         document.getElementById("e_symbol_7").innerHTML =  bancalValues_array[6].e_symbol;

         document.getElementById("concentration_value_1").innerHTML =  bancalValues_array[0].e_symbol;
         document.getElementById("concentration_value_2").innerHTML =  bancalValues_array[1].e_symbol;
         document.getElementById("concentration_value_3").innerHTML =  bancalValues_array[2].e_symbol;
         document.getElementById("concentration_value_4").innerHTML =  bancalValues_array[3].e_symbol;
         document.getElementById("concentration_value_5").innerHTML =  bancalValues_array[4].e_symbol;
         document.getElementById("concentration_value_6").innerHTML =  bancalValues_array[5].e_symbol;
         document.getElementById("concentration_value_7").innerHTML =  bancalValues_array[6].e_symbol;
         */
    }

    var area = getUrlParameter('area');

    if(area!=null){
        if(area=="SLEX"){
            GetSLEXStatus();
        }
        else if(area="Bancal"){
            GetBancalStatus();
        }
    }

}

google.maps.event.addDomListener(window, 'load', initialize);

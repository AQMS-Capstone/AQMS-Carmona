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
        else if(area="Bancal"){
            GetBancalStatus();
        }
    }
})

function GetBancalStatus() {

    $("#zoneName").text('Bancal Carmona, Cavite');


}
//
// function GetSLEXStatus() {
//     map.setZoom(16);
//     map.setCenter(slexZoom);
//
//     $("#zoneStatus").show();
//     document.getElementById("aqiText").style.color = slexAirQuality;
//     document.getElementById("AQIStat").style.backgroundColor = slexAirQuality;
//     document.getElementById("zoneName").innerHTML = 'SLEX Carmona Exit, Cavite';
//     document.getElementById("prevalentPollutant").innerHTML = slexprevalentPollutant;
//     document.getElementById("aqiNum").innerHTML = slexAQI;
//     document.getElementById("aqiText").innerHTML = slexAQIStatus;
//     document.getElementById("timeUpdated").innerHTML =  bancal_date_gathered;
//
//     //document.getElementById("e_symbol_1").innerHTML =  "HI";
//     //document.getElementById("concentration_value_1").innerHTML =  "7";
//
//     //alert(bancal_aqi_values[0]);
//
//     for(var i = 0; i < bancal_aqi_values.length; i++)
//     {
//         var elementName = "e_symbol_" + (i+1);
//         var conentrationName = "concentration_value_" + (i+1);
//
//         var elementMin = "aqi_min_" + (i+1);
//         var elementMax = "aqi_max_" + (i+1);
//
//         document.getElementById(elementName).innerHTML =  pollutant_symbols[i];
//         document.getElementById(conentrationName).innerHTML =  bancal_aqi_values[i];
//
//         document.getElementById(elementMin).innerHTML =  parseInt(JSON.stringify(bancal_min_max_values[i][0]).replace(/"/g, ''));
//         document.getElementById(elementMax).innerHTML =  parseInt(JSON.stringify(bancal_min_max_values[i][1]).replace(/"/g, ''));
//     }
//
//     /*
//      for(var i = 0; i < slexValues_array.length; i++)
//      {
//      var elementName = "e_symbol_" + (i+1);
//      var conentrationName = "concentration_value_" + (i+1);
//
//      document.getElementById(elementName).innerHTML =  slexValues_array[i].e_symbol;
//      document.getElementById(conentrationName).innerHTML =  slexValues_array[i].concentration_value;
//      }
//      */
//
//     /*
//      document.getElementById("e_symbol_1").innerHTML =  bancalValues_array[0].e_symbol;
//      document.getElementById("e_symbol_2").innerHTML =  bancalValues_array[1].e_symbol;
//      document.getElementById("e_symbol_3").innerHTML =  bancalValues_array[2].e_symbol;
//      document.getElementById("e_symbol_4").innerHTML =  bancalValues_array[3].e_symbol;
//      document.getElementById("e_symbol_5").innerHTML =  bancalValues_array[4].e_symbol;
//      document.getElementById("e_symbol_6").innerHTML =  bancalValues_array[5].e_symbol;
//      document.getElementById("e_symbol_7").innerHTML =  bancalValues_array[6].e_symbol;
//
//      document.getElementById("concentration_value_1").innerHTML =  bancalValues_array[0].e_symbol;
//      document.getElementById("concentration_value_2").innerHTML =  bancalValues_array[1].e_symbol;
//      document.getElementById("concentration_value_3").innerHTML =  bancalValues_array[2].e_symbol;
//      document.getElementById("concentration_value_4").innerHTML =  bancalValues_array[3].e_symbol;
//      document.getElementById("concentration_value_5").innerHTML =  bancalValues_array[4].e_symbol;
//      document.getElementById("concentration_value_6").innerHTML =  bancalValues_array[5].e_symbol;
//      document.getElementById("concentration_value_7").innerHTML =  bancalValues_array[6].e_symbol;
//      */
// }
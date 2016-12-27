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
    var slexZoom=new google.maps.LatLng(14.32274,121.071688);

    function GetAreaStatus(area_data)
    {
        map.setZoom(16);

        if(area_data.name == "bancal") {
            map.setCenter(bancalZoom);
        }else{
            map.setCenter(slexZoom);
        }

        document.getElementById("aqiText").style.color = area_data.AirQuality;
        document.getElementById("AQIStat").style.color = area_data.AirQuality;
        document.getElementById("zoneName").innerHTML = area_data.displayName;
        document.getElementById("prevalentPollutant").innerHTML = area_data.prevalentPollutant;
        document.getElementById("aqiNum").innerHTML = area_data.AQI;
        document.getElementById("aqiText").innerHTML = area_data.AQIStatus;
        document.getElementById("timeUpdated").innerHTML = area_data.d_date_gathered;

        if(area_data.AllDayValues_array.length != 0)
        {
            for(var i = 0; i < area_data.aqi_values.length; i++)
            {
                var maxValue = 0;

                switch(i)
                {
                    case 0:
                        maxValue = Math.max(parseInt(area_data.co_max));
                        break;

                    case 1:
                        maxValue = Math.max(parseInt(area_data.so2_max));
                        break;

                    case 2:
                        maxValue = Math.max(parseInt(area_data.no2_max));
                        break;

                    case 3:
                        maxValue = Math.max(parseInt(area_data.o3_max));
                        break;

                    case 4:
                        maxValue = Math.max(parseInt(area_data.pm10_max));
                        break;

                    case 5:
                        maxValue = Math.max(parseInt(area_data.tsp_max));
                        break;
                }

                if(maxValue > -1)
                {
                    var elementName = "e_symbol_" + (i+1);
                    var conentrationName = "concentration_value_" + (i+1);
                    var elementMin = "aqi_min_" + (i+1);
                    var elementMax = "aqi_max_" + (i+1);

                    document.getElementById(elementName).innerHTML =  pollutant_symbols[i];

                    if(area_data.aqi_values[i] == -1)
                    {
                        document.getElementById(conentrationName).innerHTML = "-";
                    }

                    else
                    {
                        document.getElementById(conentrationName).innerHTML =  area_data.aqi_values[i];
                    }

                    var minValue = area_data.min_max_values[i][0];

                    if(minValue == -1)
                    {
                        document.getElementById(elementMin).innerHTML =  "0";
                    }

                    else {
                        document.getElementById(elementMin).innerHTML = minValue;
                    }


                    document.getElementById(elementMax).innerHTML =  area_data.min_max_values[i][1];
                }
            }
        }

        $("#zoneStatus").show(1000);
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

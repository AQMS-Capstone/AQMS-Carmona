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

if(area == null)
{
  area = "Bancal";
  GetBancalStatus();

  alert(bancal_prevalent_value);
}

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
})

function GetBancalStatus() {
    $("#zoneName").text('Bancal Carmona, Cavite');
    $("#zoneImg").attr("src","res/images/area/bancal.jpg");
}

function GetSLEXStatus() {
    $("#zoneName").text('SLEX Carmona Exit, Cavite');
    $("#zoneImg").attr("src","res/images/area/slex_carmona-exit.jpg");
}

$("#prevArea").click(function () {
    if(area=="Bancal"){
        location.href = "daily.php?area=SLEX";
    }
    else if(area=="SLEX"){
        location.href = "daily.php?area=Bancal";
    }
})

$("#nextArea").click(function () {
    if(area=="Bancal"){
        location.href = "daily.php?area=SLEX";
    }
    else if(area=="SLEX"){
        location.href = "daily.php?area=Bancal";
    }
})

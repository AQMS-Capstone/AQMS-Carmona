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
    $("#zoneImg").attr("src","res/images/area/bancal.jpg");
}

function GetSLEXStatus() {
    $("#zoneName").text('SLEX Carmona Exit, Cavite');
    $("#zoneImg").attr("src","res/images/area/slex_carmona-exit.jpg");
}
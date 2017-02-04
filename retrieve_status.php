<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 1/12/2017
 * Time: 12:17 AM
 */

Init();

function Init(){
    include('include/Map.php');

    date_default_timezone_set('Asia/Manila');
    $date_now_feed = date("Y-m-d H:i:s");


    displayAQIMonitoring($date_now_feed, $bancal);
    displayAQIMonitoring($date_now_feed, $slex);

}

function displayCautionary($AQIStatus, $element, $control){
    echo "<script type='text/javascript'>";
    echo "GetCautionary('$AQIStatus', '$element', '$control')";

    //$hi = "#cautionary_1";
    //echo "$('$control').text('renjo is pogi')";
    echo "</script>";
}

function determineLastHourAQI($area){
    return max($area->co_aqi_values[22], $area->no2_aqi_values[22], $area->so2_aqi_values[22]);
}

//function displayAQILevelChangeMonitoring($date, $area){
//    date_default_timezone_set('Asia/Manila');
//    $date_yesterday_feed = date("Y-m-d H a", strtotime($date) - 3600);
//
//    $dateDisplay = date("F d, Y @ h a", strtotime($date));
//    $dateYesterdayDisplay = date("F d, Y @ h a", strtotime($date_yesterday_feed));
//
//    echo "AQI Level Change Monitor as of ".strtoupper($dateDisplay)." in ".strtoupper($area->name);
//    echo "<br/>";
//    echo "LAST HOUR LEVEL: ".returnAQIStstus(determineLastHourAQI($area))." (".strtoupper($dateYesterdayDisplay).")";
//    echo "<br/>";
//    echo "CURRENT LEVEL: ".returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]);
//    echo "<br/>";
//    echo "STATUS: ".displayAQIDesc(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]]);
//}

function displayAQIDesc($prevAQI, $curAQI){
    $AQIDesc = "";

    if($prevAQI>$curAQI){
        $AQIDesc = "AQI level became lower";
    }
    else if($prevAQI==$curAQI){
        $AQIDesc = "No changes";
    }
    else{
        $AQIDesc = "AQI level became higher";
    }

    return $AQIDesc;

}
function displayAQIMonitoring($date,$area){
    include('include/guidelines.php');
    $color1 = returnAQIColor($area->aqi_values[$area->prevalentIndex[0]]);

    echo "<div class='col s12 m6'>
        <div class='card z-depth-0'>
            <div id='aqiColor' class='col s12' style='margin-bottom: 15px; background: $color1;'>
                <p style='font-size: 1em;' class='white-text'><b id='aqiText'>".returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]])."</b></p>
            </div>
            <div class='card-content'>
                <div class='row'>
                   <p class='card-title teal-text' style='font-weight: bold' id='zoneName'>".strtoupper($area->name)."</p>  
                    <div class='divider'></div>
                    <br>";

    if($area->aqi_values[$area->prevalentIndex[0]] == -1) {
        echo "
                        <div class='col s12' style='padding: 0;'>
                            <p style='font-weight: bold; font-size: 2em;'>AQI: <span id='aqiNum'>-</span ></p>
                        </div>
        
                        <div class='col s12' style='padding: 0;'>
                    
                        <p><b>Prevalent Air Pollutant: </b> <span id='prevalentPollutant'>-</span></p>
                        <p><b>Recorded on: </b><span id='timeUpdated'>-</span></p>
                        <p><b>Change in AQI Status: </b><span id='timeUpdated'>-</span></p>
                        ";
    }else{
        echo "
                        <div class='col s12' style='padding: 0;'>
                            <p style='font-weight: bold; font-size: 2em;'>AQI: <span id='aqiNum'>".negateZero($area->aqi_values[$area->prevalentIndex[0]])."</span ></p>
                        </div>
        
                        <div class='col s12' style='padding: 0;'>
                    
                        <p><b>Prevalent Air Pollutant: </b> <span id='prevalentPollutant'>".$pollutant_labels[$area->prevalentIndex[0]]."</span></p>
                        <p><b>Recorded on: </b><span id='timeUpdated'>$area->date_gathered</span></p>
                        <p><b>Change in AQI Status: </b><span id='timeUpdated'>".displayAQIStatusChange(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]])."</span></p>
                        ";
    }

    echo"
                    </div>
                </div>
            </div>
            <div id='aqiColor' class='col s12' style='background: $color1'>
                <p style='font-size: 1em;' class='white-text'><b id='aqiText'>Action: ".displayAction($area->aqi_values[$area->prevalentIndex[0]])."</b></p>
            </div>
        </div>
    </div>
    ";

    if($area->name == "bancal") {
        $controlName = "1";
        displayCautionary(returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]), $pollutant_symbols[$area->prevalentIndex[0]], $controlName);
    }else{
        $controlName = "2";
        displayCautionary(returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]), $pollutant_symbols[$area->prevalentIndex[0]], $controlName);
    }
}
function displayAction($curAQI){
    $curStatus = returnAQIStstus($curAQI);

    if($curStatus == "EMERGENCY" || $curStatus == "VERY UNHEALTHY" || $curStatus == "ACUTELY UNHEALTHY"){
        $action = "Needs immediate attention";
    }else if($curStatus == "NO STATUS") {
        $action = "-";
    }else{
        $action = "No action needed";
    }

    return strtoupper($action);
}
function returnAQIColor($AQI){
    $AQIStatus = "";

    $goodAir = "#4CAF50";
    $fairAir = "#FFEB3B";
    $unhealthyAir = "#FF9800";
    $veryUnhealthyAir = "#f44336";
    $acutelyUnhealthyAir = "#9C27B0";
    $emergencyAir = "#b71c1c";
    $otherAir = "#212121";

    if ($AQI >= 0 && $AQI <= 50) {
        $AQIStatus = $goodAir;
    } else if ($AQI >= 51 && $AQI <= 100) {
        $AQIStatus = $fairAir;
    } else if ($AQI >= 101 && $AQI <= 150) {
        $AQIStatus = $unhealthyAir;
    } else if ($AQI >= 151 && $AQI <= 200) {
        $AQIStatus = $veryUnhealthyAir;
    } else if ($AQI >= 201 && $AQI <= 300) {
        $AQIStatus = $acutelyUnhealthyAir;
    } else if ($AQI >= 301) {
        $AQIStatus = $emergencyAir;
    } else if ($AQI == -1) {
        $AQIStatus = $otherAir;
    }else if ($AQI == -2) {
        $AQIStatus = $emergencyAir;
    }else if ($AQI == -3) {
        $AQIStatus = $goodAir;
    }

    return strtoupper($AQIStatus);
}
function returnAQIStstus($AQI)
{
    $AQIStatus = "";

    if ($AQI >= 0 && $AQI <= 50) {
        $AQIStatus = "Good";
    } else if ($AQI >= 51 && $AQI <= 100) {
        $AQIStatus = "Fair";
    } else if ($AQI >= 101 && $AQI <= 150) {
        $AQIStatus = "Unhealthy for Sensitive Groups";
    } else if ($AQI >= 151 && $AQI <= 200) {
        $AQIStatus = "Very Unhealthy";
    } else if ($AQI >= 201 && $AQI <= 300) {
        $AQIStatus = "Acutely Unhealthy";
    } else if ($AQI >= 301) {
        $AQIStatus = "Emergency";
    } else if ($AQI == -1) {
        $AQIStatus = "No Status";
    }else if ($AQI == -2) {
        $AQIStatus = "Emergency";
    }else if ($AQI == -3) {
        $AQIStatus = "Good";
    }

    return strtoupper($AQIStatus);
}
function displayAQIStatusChange($prevAQI, $curAQI){
    $prevStatus = returnAQIStstus($prevAQI);
    $curStatus = returnAQIStstus($curAQI);
    $change = "";

    if($prevStatus == $curStatus){
        $change = "Same with previous hour";
    }else{
        $change = "From ".$prevStatus. " (last hour) to ".$curStatus;
    }

    return $change;
}
function negateZero($AQI){
    if($AQI == -3){
        return "201-";
    } if($AQI == -2){
        return "400+";
    } if($AQI == -1){
        return "-";
    }
    return $AQI;
}
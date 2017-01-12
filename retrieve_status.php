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
    echo "<div class='section no-pad-bot'>";
    echo "<div class = 'container'>";
    echo "<div class='row row-no-after'>";

    displayAQIMonitoring($date_now_feed, $bancal);
    displayAQIMonitoring($date_now_feed, $slex);

    echo "</div>";
    echo "</div>";
    echo "</div>";
}

function determineLastHourAQI($area){
    return max($area->co_aqi_values[22], $area->no2_aqi_values[22], $area->so2_aqi_values[22]);
}

function displayAQILevelChangeMonitoring($date, $area){
    date_default_timezone_set('Asia/Manila');
    $date_yesterday_feed = date("Y-m-d H a", strtotime($date) - 3600);

    $dateDisplay = date("F d, Y @ h a", strtotime($date));
    $dateYesterdayDisplay = date("F d, Y @ h a", strtotime($date_yesterday_feed));

    echo "AQI Level Change Monitor as of ".strtoupper($dateDisplay)." in ".strtoupper($area->name);
    echo "<br/>";
    echo "LAST HOUR LEVEL: ".returnAQIStstus(determineLastHourAQI($area))." (".strtoupper($dateYesterdayDisplay).")";
    echo "<br/>";
    echo "CURRENT LEVEL: ".returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]);
    echo "<br/>";
    echo "STATUS: ".displayAQIDesc(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]]);
}
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

    echo "<div class='col s6'>";
    echo "<div class = 'card' style='padding:0; margin-bottom:0; box-shadow:0px 0px 0px; background: $color1';>";
    echo "<div class = 'card-content'>";
    echo "<h6 class='white-text center-align' style='margin-bottom: 0;'>";
    echo "<b>".returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]])."</b>";
    echo "</h6>";
    echo "</div>";
    echo "</div>";
    echo "<div class = 'card' style='margin-top:0; margin-bottom:0'>";
    echo "<div class = 'card-content'>";
    //echo "AQI as of ". strtoupper(date("F d, Y @ h a", strtotime($date))) . " in " . strtoupper($area->name);
    //echo negateZero($area->aqi_values[$area->prevalentIndex[0]]) . " [".returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]])."]";
    echo "<p class='teal-text center-align' style='font-size:1.5em; margin-bottom: 0;'><b>".strtoupper($area->name)."</b></p>";
    echo "<div class='center-align'>
    <p class='material-icons' style='font-size: 6em;margin-bottom: 0;margin-top: 0; color: $color1;'>
           cloud</p>";

    if($area->aqi_values[$area->prevalentIndex[0]] < 0){
        echo "
    <p style='font-size: 1.5em;margin-top: 0;'><b>AQI: </b><span>-</span></p>
    <p><b>Prevalent Air Pollutant: </b> <span>-</span></p>
    <p><b>Recorded on: </b><span>-</span></p>
    <p><b>Change in AQI Status: </b><span>-</span></p>
    </div>";
        //<p><b>Status: </b><span>-</span></p>
    }else{
        echo "
    <p style='font-size: 1.5em;margin-top: 0;'><b>AQI: </b><span>".negateZero($area->aqi_values[$area->prevalentIndex[0]])."</span></p>
    <p><b>Prevalent Air Pollutant: </b> <span>".$pollutant_labels[$area->prevalentIndex[0]]."</span></p>
    <p><b>Recorded on: </b><span>$area->date_gathered</span></p>
    <p><b>Change in AQI Status: </b><span>".displayAQIStatusChange(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]])."</span></p>
    </div>";
        //<p><b>Status: </b><span>".displayAQIDesc(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]])."</span></p>

    }

    echo "</div>";
    echo "</div>";
    echo "<div class = 'card' style='padding:0; margin-top:0; box-shadow:0px 0px 0px; background: $color1';>";
    echo "<div class = 'card-content'>";
    echo "<h6 class='white-text center-align' style='margin-bottom: 0;'>";
    echo "<b>Action: ".displayAction($area->aqi_values[$area->prevalentIndex[0]])."</b>";
    echo "</h6>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

}
function displayAction($curAQI){
    $curStatus = returnAQIStstus($curAQI);
    $action = "";

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
    }

    return strtoupper($AQIStatus);
}
function displayAQIStatusChange($prevAQI, $curAQI){
    $prevStatus = returnAQIStstus($prevAQI);
    $curStatus = returnAQIStstus($curAQI);
    $change = "";



    if($prevStatus == $curStatus){
        $change = "No change";
    }else{
        $change = "From ".$prevStatus. " (last hour) to ".$curStatus;
    }

    return $change;
}
function negateZero($AQI){
    if($AQI < 0){
        return 0;
    }

    return $AQI;
}
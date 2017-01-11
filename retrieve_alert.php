<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 1/12/2017
 * Time: 1:46 AM
 */
Init();


function Init(){
    include('include/guidelines.php');
    include('include/Map.php');

    $play1 = returnPlay(determineLastHourAQI($bancal),$bancal->aqi_values[$bancal->prevalentIndex[0]]);
    $play2 = returnPlay(determineLastHourAQI($bancal),$bancal->aqi_values[$bancal->prevalentIndex[0]]);

    echo json_encode(array("play1"=>$play1, "play2"=>$play2));

//    $play_container = array();
//
//    array_push($play_container, $play1);
//    array_push($play_container, $play2);
}

function returnPlay($prevAQI, $curAQI){
    $prevStatus = returnAQIStstus($prevAQI);
    $curStatus = returnAQIStstus($curAQI);
    $action = "";

    if($prevStatus == $curStatus){
        $action = "no-play";
    }else{
        $action = "play";
    }

    return $action;
}
function determineLastHourAQI($area){
    return max($area->co_aqi_values[22], $area->no2_aqi_values[22], $area->so2_aqi_values[22]);
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
        $AQIStatus = "No Current Data";
    }

    return strtoupper($AQIStatus);
}
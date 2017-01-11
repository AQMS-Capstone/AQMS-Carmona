<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 06/01/2017
 * Time: 11:59 PM
 */


//for($i = 0; $i < count($bancal->co_aqi_values); $i++){
//    echo $bancal->co_aqi_values[$i];
//    echo "<br/>";
//}

//echo $date_now_feed;
//echo "<br/>";
//echo $date_yesterday_feed;
//echo "<br/>";

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

//        echo "============================";
//        echo "<br/>";
//        displayAQILevelChangeMonitoring($date_now_feed, $bancal);
//        echo "<br/><br/>";
//        displayAQILevelChangeMonitoring($date_now_feed, $slex);
//        echo "<br/>";
//        echo "============================";
        include('include/db_connect.php');

        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);

        if ($result) {

            if (mysqli_num_rows($result) == 0) {
                echo "NO FEED";
            } else {
                $ctr = 0;
                echo "<br/>";
                while ($row = mysqli_fetch_array($result)) {
                    //              echo "<tr>";
                    echo "[" . date("F d, Y @ h:i:s a", strtotime($row['timestamp'])) . "] - " . strtoupper($row['area_name']) . " - " . $row['e_symbol'] . " Sensor has entered a concentration value of " . $row['concentration_value'] . "<br/>";
//                echo "<td>" . $row['area_name'] . "</td>";
//                echo "<td>" . $row['e_name'] . "</td>";
//                echo "<td>" . $row['e_symbol'] . "</td>";
//                echo "<td>" . $row['concentration_value'] . "</td>";
//                echo "</tr>";
                }
            }
        }
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
    <p><b>Change in AQI Status: </b><span>".displayAQIStatusChange(returnAQIStstus(determineLastHourAQI($area)),returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]))."</span></p>
    </div>";
    //<p><b>Status: </b><span>".displayAQIDesc(determineLastHourAQI($area),$area->aqi_values[$area->prevalentIndex[0]])."</span></p>

    }

    echo "</div>";
    echo "</div>";
    echo "<div class = 'card' style='padding:0; margin-top:0; box-shadow:0px 0px 0px; background: $color1';>";
    echo "<div class = 'card-content'>";
    echo "<h6 class='white-text center-align' style='margin-bottom: 0;'>";
    echo "<b>Action: ".displayAction(returnAQIStstus(determineLastHourAQI($area)),returnAQIStstus($area->aqi_values[$area->prevalentIndex[0]]))."</b>";
    echo "</h6>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

}

function displayAction($prevAQI, $curAQI){
    $prevStatus = returnAQIStstus($prevAQI);
    $curStatus = returnAQIStstus($curAQI);
    $action = "";

    if($prevStatus == "" || $prevStatus = "" || $prevStatus = "" && $curStatus = "EMERGENCY" || $curStatus = "VERY UNHEALTHY" || $curStatus = "ACUTELY UNHEALTHY"){
        $action = "Needs immediate attention";
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
        $AQIStatus = "No Current Data";
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
        $change = "From ".$prevStatus. " level to ".$curStatus;
    }

    return strtoupper($change);
}
function negateZero($AQI){
    if($AQI < 0){
        return 0;
    }

    return $AQI;
}
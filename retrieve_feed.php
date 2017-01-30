<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 06/01/2017
 * Time: 11:59 PM
 */

$limiter = "5";
$sortOption = "TIMESTAMP";
$filterArea = "";
$filterPollutants = "";


if(isset($_REQUEST['phpValue'])){
    $limiter = json_decode($_REQUEST['phpValue']);

    if($limiter == "1"){
        $limiter = "5";
    }else if($limiter == "2"){
        $limiter = "10";
    }else if($limiter == "3"){
        $limiter = "25";
    }else if($limiter == "4"){
        $limiter = "50";
    }else if($limiter == "5"){
        $limiter = "100";
    }else{
        $limiter = "5";
    }
}
if(isset($_REQUEST['phpValue2'])){
    $sortOption = json_decode($_REQUEST['phpValue2']);
    if($sortOption == "1"){
        $sortOption = "TIMESTAMP";
    }else if($sortOption == "2"){
        $sortOption = "MASTER.E_ID, TIMESTAMP";
    }else if($sortOption == "3"){
        $sortOption = "MASTER.CONCENTRATION_VALUE, TIMESTAMP";
    }else{
        $sortOption = "TIMESTAMP";
    }
}
if(isset($_REQUEST['phpValue3'])){
    $filterArea = json_decode($_REQUEST['phpValue3']);

    if($filterArea == "1"){
        $filterArea = "bancal";
    }else if($filterArea == "2"){
        $filterArea = "slex";
    }elsE{
        $filterArea = "";
    }
}
if(isset($_REQUEST['phpValue4'])){
    $filterPollutants = json_decode($_REQUEST['phpValue4']);

    if($filterPollutants == "CO"){
        $filterPollutants = "1";
    }else if($filterPollutants == "NO2"){
        $filterPollutants = "3";
    }else if($filterPollutants == "SO2"){
        $filterPollutants = "2";
    }else{
        $filterPollutants = "";
    }
}

displayFeed($limiter, $sortOption, $filterArea, $filterPollutants);

function displayFeed($limiter, $sortOption, $filterArea, $filterPollutants){

    include('include/db_connect.php');

    $sortOption =  filter_var($sortOption, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if($filterArea != "" && $filterPollutants == ""){

        $query = $con->prepare("SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID WHERE AREA_NAME = ?
              ORDER BY $sortOption DESC LIMIT ?");

        $query->bind_param("ss", $filterArea, $limiter);

        $query->execute();
        $result = $query->get_result();
        fetchFeed($result);
        $query->close();
    }
    else if($filterPollutants != "" && $filterArea == ""){

        $query = $con->prepare("SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID WHERE MASTER.E_ID = ?
              ORDER BY $sortOption DESC LIMIT ?");

        $query->bind_param("ss", $filterPollutants, $limiter);
        $query->execute();
        $result = $query->get_result();
        fetchFeed($result);
        $query->close();
    }
    else if($filterPollutants != "" && $filterArea != ""){

        $query = $con->prepare("SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID WHERE AREA_NAME = ? AND MASTER.E_ID = ? 
              ORDER BY $sortOption DESC LIMIT ?");

        $query->bind_param("sss", $filterArea, $filterPollutants, $limiter);
        $query->execute();
        $result = $query->get_result();
        fetchFeed($result);
        $query->close();
    }
    else{
        $query = $con->prepare("SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              ORDER BY $sortOption DESC LIMIT ?");

        $query->bind_param("s", $limiter);

        $query->execute();
        $result = $query->get_result();
        fetchFeed($result);
        $query->close();
    }


    $con->close();
}

function fetchFeed($result){

    if ($result) {

        if (mysqli_num_rows($result) == 0) {
            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
            echo "<div class = 'card-content'>";
            echo "NO FEED";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {

            while ($row = $result->fetch_assoc()) {

                echo "<div class='col s12'>";
                echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
                echo "<div class = 'card-content'>";
                echo "<p style='color:gray'>".date("F d, Y - h:i a", strtotime($row['timestamp']))."</p>";
                echo "<p style='color:gray; font-size:11px; margin-bottom: 10px'>".strtoupper($row['area_name'].", Carmona")."</p>";
                echo $row['e_symbol'] . " sensor has entered a concentration value of <b>" . $row['concentration_value'] . "</b><br/>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }

        }
    }

}
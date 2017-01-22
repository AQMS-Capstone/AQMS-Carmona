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
    if($limiter == ""){
        $limiter = "5";
    }
}
if(isset($_REQUEST['phpValue2'])){
    $sortOption = json_decode($_REQUEST['phpValue2']);
    if($sortOption == ""){
        $sortOption = "TIMESTAMP";
    }
}
if(isset($_REQUEST['phpValue3'])){
    $filterArea = json_decode($_REQUEST['phpValue3']);
}
if(isset($_REQUEST['phpValue4'])){
    $filterPollutants = json_decode($_REQUEST['phpValue4']);
}


//echo $limiter, $sortOption, $filterArea, $filterPollutants;


displayFeed($limiter, $sortOption, $filterArea, $filterPollutants);

function displayFeed($limiter, $sortOption, $filterArea, $filterPollutants){

    include('include/db_connect.php');

    $whereClause = "";

    if($filterArea != "" && $filterPollutants == ""){
        $whereClause = "WHERE AREA_NAME = '$filterArea'";
    }
    else if($filterPollutants != "" && $filterArea == ""){
        $whereClause = "WHERE MASTER.E_ID = '$filterPollutants'";
    }
    else if($filterPollutants != "" && $filterArea != ""){
        $whereClause = "WHERE AREA_NAME = '$filterArea' AND MASTER.E_ID = '$filterPollutants'";
    }

    $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ".$whereClause."
              ORDER BY $sortOption DESC LIMIT $limiter";

    $result = mysqli_query($con, $query);

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

            while ($row = mysqli_fetch_array($result)) {

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
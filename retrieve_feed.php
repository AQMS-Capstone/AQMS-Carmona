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
        $sortOption = "2";
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

        if($sortOption == "2"){
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
              FROM MASTER WHERE AREA_NAME = ?
              ORDER BY CO DESC, SO2 DESC, NO2 DESC LIMIT ?");
        }else{
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
              FROM MASTER WHERE AREA_NAME = ?
              ORDER BY $sortOption DESC LIMIT ?");
        }

        $query->bind_param("ss", $filterArea, $limiter);

        $query->execute();
        $query->store_result();
        fetchFeed($query);
        $query->close();
    }
    else if($filterPollutants != "" && $filterArea == ""){

        if($sortOption == "2") {
            if($filterPollutants == "1"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
                  FROM MASTER
                  ORDER BY CO DESC LIMIT ?");
            }else if($filterPollutants == "2"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
                  FROM MASTER
                  ORDER BY SO2 DESC LIMIT ?");
            }else if($filterPollutants == "3"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
                  FROM MASTER
                  ORDER BY NO2 DESC LIMIT ?");
            }else{
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
                  FROM MASTER
                  ORDER BY CO DESC, SO2 DESC, NO2 DESC LIMIT ?");
            }
        }else{
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
              FROM MASTER
              ORDER BY $sortOption DESC LIMIT ?");
        }

        $query->bind_param("s", $limiter);
        $query->execute();
        $query->store_result();
        fetchFeed2($query, $filterPollutants);
        $query->close();
    }
    else if($filterPollutants != "" && $filterArea != ""){

        if($sortOption == "2") {
            if($filterPollutants == "1"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
                  FROM MASTER WHERE AREA_NAME = ? 
                  ORDER BY CO DESC LIMIT ?");
            }else if($filterPollutants == "2"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
                  FROM MASTER WHERE AREA_NAME = ? 
                  ORDER BY SO2 DESC LIMIT ?");
            }else if($filterPollutants == "3"){
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
                  FROM MASTER WHERE AREA_NAME = ? 
                  ORDER BY NO2 DESC LIMIT ?");
            }else{
                $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
                  FROM MASTER WHERE AREA_NAME = ? 
                  ORDER BY CO DESC, SO2 DESC, NO2 DESC LIMIT ?");
            }
        }else{
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2
              FROM MASTER WHERE AREA_NAME = ? 
              ORDER BY $sortOption DESC LIMIT ?");
        }

        $query->bind_param("ss", $filterArea, $limiter);
        $query->execute();
        $query->store_result();
        fetchFeed2($query, $filterPollutants);
        $query->close();
    }
    else{
        if($sortOption == "2") {
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
              FROM MASTER
              ORDER BY CO DESC, SO2 DESC, NO2 DESC LIMIT ?");
        }else{
            $query = $con->prepare("SELECT timestamp, area_name, CO, SO2, NO2 
              FROM MASTER
              ORDER BY $sortOption DESC LIMIT ?");
        }

        $query->bind_param("s", $limiter);

        $query->execute();
        $query->store_result();
        fetchFeed($query);
        $query->close();
    }

    $con->close();
}

function fetchFeed2($result, $filterPollutants){

    $num_of_rows = $result->num_rows;
    $result->bind_result($timestamp, $area_name, $CO, $SO2, $NO2);

    if ($num_of_rows == 0) {
        echo "<div class='col s12'>";
        echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
        echo "<div class = 'card-content'>";
        echo "NO FEED";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {

        while ($result->fetch()) {

            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
            echo "<div class = 'card-content'>";
            echo "<p style='color:gray'>".date("F d, Y - h:i:s a", strtotime($timestamp))."</p>";
            echo "<p style='color:gray; font-size:11px; margin-bottom: 10px'>".strtoupper($area_name.", Carmona")."</p>";

            if($filterPollutants == "1"){
                echo "CO" . " sensor has entered a concentration value of <b>" . $CO . "</b><br/>";
            }else if($filterPollutants == "2"){
                echo "SO2" . " sensor has entered a concentration value of <b>" . $SO2 . "</b><br/>";
            }else{
                echo "NO2" . " sensor has entered a concentration value of <b>" . $NO2 . "</b><br/>";
            }

            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

    }

    $result->free_result();
}

function fetchFeed($result){

    $num_of_rows = $result->num_rows;
    $result->bind_result($timestamp, $area_name, $CO, $SO2, $NO2);

    if ($num_of_rows == 0) {
        echo "<div class='col s12'>";
        echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
        echo "<div class = 'card-content'>";
        echo "NO FEED";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {

        while ($result->fetch()) {

            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
            echo "<div class = 'card-content'>";
            echo "<p style='color:gray'>".date("F d, Y - h:i:s a", strtotime($timestamp))."</p>";
            echo "<p style='color:gray; font-size:11px; margin-bottom: 10px'>".strtoupper($area_name.", Carmona")."</p>";
            echo "CO" . " sensor has entered a concentration value of <b>" . $CO . "</b><br/>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
            echo "<div class = 'card-content'>";
            echo "<p style='color:gray'>".date("F d, Y - h:i:s a", strtotime($timestamp))."</p>";
            echo "<p style='color:gray; font-size:11px; margin-bottom: 10px'>".strtoupper($area_name.", Carmona")."</p>";
            echo "SO2" . " sensor has entered a concentration value of <b>" . $SO2 . "</b><br/>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0 feed-divider' style='margin-top:0; margin-bottom:0;'>";
            echo "<div class = 'card-content'>";
            echo "<p style='color:gray'>".date("F d, Y - h:i:s a", strtotime($timestamp))."</p>";
            echo "<p style='color:gray; font-size:11px; margin-bottom: 10px'>".strtoupper($area_name.", Carmona")."</p>";
            echo "NO2" . " sensor has entered a concentration value of <b>" . $NO2 . "</b><br/>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

    }

    $result->free_result();
}
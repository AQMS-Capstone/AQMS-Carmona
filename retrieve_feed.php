<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 06/01/2017
 * Time: 11:59 PM
 */

$limiter = "";

if(isset($_REQUEST['phpValue2'])){
    if(isset($_REQUEST['phpValue'])){
        $limiter = json_decode($_REQUEST['phpValue']);
        $sortOption = json_decode($_REQUEST['phpValue2']);
        $filterOption = 0;

        Init($limiter, $sortOption, $filterOption);
    }
}else if(isset($_REQUEST['phpValue3'])){
    if(isset($_REQUEST['phpValue'])){
        $limiter = json_decode($_REQUEST['phpValue']);
        $filterOption = json_decode($_REQUEST['phpValue3']);
        $sortOption = 0;

        Init($limiter, $sortOption, $filterOption);
    }
}else if(isset($_REQUEST['phpValue3'])){
    if(isset($_REQUEST['phpValue2'])) {
        if (isset($_REQUEST['phpValue'])) {
            $limiter = json_decode($_REQUEST['phpValue']);
            $sortOption = json_decode($_REQUEST['phpValue2']);
            $filterOption = json_decode($_REQUEST['phpValue3']);

            Init($limiter, $sortOption, $filterOption);
        }
    }
} else{
    if(isset($_REQUEST['phpValue'])){
        $limiter = json_decode($_REQUEST['phpValue']);
        $sortOption = 0;
        $filterOption = 0;
        Init($limiter, $sortOption, $filterOption);
    }
}

function Init($limiter, $sortOption, $filterOption){

    echo "<div class='section no-pad-bot'>";
    echo "<div class = 'container'>";
    echo "<div class='row row-no-after'>";
    displayFeed($limiter, $sortOption, $filterOption);
    endDiv();
    endDiv();
    endDiv();
}

function endDiv(){
    echo "</div>";
}

function displayFeed($limiter, $sortOption, $filterOption){

    include('include/db_connect.php');

    $query = "";
    $sortProcedure = "";
    $filterProcedure = "";

    if($sortOption == 1){
        $sortProcedure = 'TIMESTAMP';
    }else if($sortOption == 2){
        $sortProcedure = 'MASTER.E_ID, TIMESTAMP';
    }else if($sortOption == 3){
        $sortProcedure = 'MASTER.CONCENTRATION_VALUE, TIMESTAMP';
    }

    if($filterOption == 1){
        $filterProcedure = 'bancal';
    }else if($filterOption == 2){
        $filterProcedure = 'slex';
    }


    if($limiter == 0 && $sortOption == 0 && $filterOption == 0){ //0-0-0
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              ORDER BY TIMESTAMP DESC LIMIT 5";
    }
    else if($limiter > 0 && $sortOption == 0 && $filterOption == 0){ //1-0-0
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              ORDER BY TIMESTAMP DESC LIMIT $limiter";
    }
    else if($limiter > 0 && $sortOption > 0 && $filterOption == 0){ //1-1-0
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              ORDER BY $sortProcedure DESC LIMIT $limiter";
    }
    else if($limiter > 0 && $sortOption == 0 && $filterOption > 0){ //1-0-1
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              WHERE area_name = '$filterProcedure' 
              ORDER BY TIMESTAMP DESC LIMIT $limiter";
    }
    else if($limiter > 0 && $sortOption > 0 && $filterOption > 0){ //1-1-1
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              WHERE area_name = '$filterProcedure' 
              ORDER BY $sortProcedure DESC LIMIT $limiter";
    }
    else if($limiter == 0 && $sortOption > 0 && $filterOption == 0){ //0-1-0
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              ORDER BY $sortProcedure DESC LIMIT 5";
    }
    else if($limiter == 0 && $sortOption > 0 && $filterOption > 0){ //0-1-1
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              WHERE area_name = '$filterProcedure' 
              ORDER BY $sortProcedure DESC LIMIT 5";
    }
    else if($limiter == 0 && $sortOption == 0 && $filterOption > 0){ //0-0-1
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID 
              WHERE area_name = '$filterProcedure' 
              ORDER BY TIMESTAMP DESC LIMIT 5";
    }

    $result = mysqli_query($con, $query);

    if ($result) {

        if (mysqli_num_rows($result) == 0) {
            echo "<div class='col s12'>";
            echo "<div class = 'card z-depth-0' style='margin-top:0em;'>";
            echo "<div class = 'card-content'>";
            echo "NO FEED";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            $ctr = 0;

            while ($row = mysqli_fetch_array($result)) {

                echo "<div class='col s12'>";
                echo "<div class = 'card' style='margin-top:0em;'>";
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

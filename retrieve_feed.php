<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 06/01/2017
 * Time: 11:59 PM
 */

$limiter = json_decode($_REQUEST['phpValue']);

Init($limiter);

function Init($limiter){

    echo "<div class='section no-pad-bot'>";
    echo "<div class = 'container'>";
    echo "<div class='row row-no-after'>";
    displayFeed($limiter);
    endDiv();
    endDiv();
    endDiv();
}

function endDiv(){
    echo "</div>";
}
function displayFeed($limiter){

    include('include/db_connect.php');

    if($limiter < 0){
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ORDER BY TIMESTAMP DESC LIMIT 5";
    }
    else{
        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, 
              ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id 
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ORDER BY TIMESTAMP DESC LIMIT $limiter";
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
                echo "<div class = 'card z-depth-0' style='margin-top:0em;'>";
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

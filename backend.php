<?php

$statusMessage = ["", ""];

function insertPollutant($e_id, $area, $value, $date_now_string, $symbol, $statusMessage)
{
    include('include/db_connect.php');

    $query = $con->prepare("SELECT timestamp FROM MASTER 
                            WHERE E_ID = ? and area_name= ? and timestamp = ? 
                            ORDER BY timestamp desc limit 1");
    $query->bind_param("sss", $e_id, $area, $date_now_string);
    $query->execute();
    $result = $query->get_result();

    if($result) {

        if (mysqli_num_rows($result) == 0) {
            $query = $con->prepare("INSERT INTO MASTER (area_name, e_id, concentration_value, timestamp) VALUES (?,?,?,?)");
            $query->bind_param("ssss", $area, $e_id, $value, $date_now_string);

            if(!$query->execute()){
                die('Error: ' . mysqli_error($con));
            }else{
                if($statusMessage[1] == "") {
                    $statusMessage[1] = $symbol;
                }
                else{
                    $statusMessage[1] = $statusMessage[1].", ".$symbol;
                }
            }
        }

        else
        {
            if($statusMessage[0] == "") {
                $statusMessage[0] = $symbol;
            }
            else{
                $statusMessage[0] = $statusMessage[0].", ".$symbol;
            }
        }
    }

    $query->close();
    $con->close();

    return $statusMessage;

}

if (isset($_POST['btnSubmit'])) {
    $area = $_POST['area'];
    $time = $_POST['time'];

    date_default_timezone_set('Asia/Manila');

    //$date = date("Y-m-d H", strtotime($time));
    //$time = $date.":00:00";

    //$date_now = date("Y-m-d H");
    //$date_now_string = $date_now.":00:00";

    $date = date("Y-m-d H:i:s", strtotime($time));
    $time = $date;

    $date_now = date("Y-m-d H:i:s");
    $date_now_string = $date_now;

    $co_value = $_POST['co_value'];
    $so2_value = $_POST['so2_value'];
    $no2_value = $_POST['no2_value'];

    if($co_value == "" && $so2_value == "" && $no2_value == "")
    {
        echo "<script language = 'javascript'>alert('Input a value for at-least one pollutant. Try again.')</script>";
    }

    else {
        if (strtotime($time) <= strtotime($date_now_string)) {
            if ($co_value != null) {
                $e_id = '1';
                $statusMessage = insertPollutant($e_id, $area, $co_value, $time, "CO", $statusMessage);
            }

            if ($so2_value != null) {
                $e_id = '2';
                $statusMessage = insertPollutant($e_id, $area, $so2_value, $time, "SO2", $statusMessage);
            }

            if ($no2_value != null) {
                $e_id = '3';
                $statusMessage = insertPollutant($e_id, $area, $no2_value, $time, "NO2", $statusMessage);
            }
            
            if ($statusMessage[0] != "") {
                $statusMessage[0] = "Values entered for " . $statusMessage[0] . " was not inserted because there's already a value for the time you've specified. If you wish to edit the data, please go to edit function.";
            }

            if ($statusMessage[1] != "") {
                $statusMessage[1] = "Values entered for " . $statusMessage[1] . " was successfuly inserted.";
            }
        } else {
            echo "<script language = 'javascript'>alert('You cannot insert a value for time that is greater than now. Please try again.')</script>";
        }
    }

}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Backend - Air Quality Monitoring System</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/flatpickr.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">
    <style>
        .centered-nav{
            left: -37%;
        }
    </style>

</head>

<body>

<div>
    <nav class="z-depth-1" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="index.php"><img class="brand-logo center" src="res/logo.png"> </a>
        </div>
    </nav>
</div>

<div>
    <nav id="nav">
        <div class="nav-wrapper">
            <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
                <li><a href="backend.php" id="home-tab"><span class="material-icons">bug_report</span> Developer Option</a>
                </li>
                <li><a href="edit.php" id=""><span class="material-icons">list</span> Concentration Table</a></li>
            </ul>
        </div>
    </nav>
</div>

<div id="content-holder">
    <div class="section">
        <br><br>
        <h1 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons" style="font-size: 2em;">bug_report</span></h1>
        <h2 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b>Developer Option</b></h2>
        <div class="row center">
            <h6 class="header col s12">Proceed with caution! This page would act as a simulation of the IOT device</h6>
            <h6 class="header col s12 red-text"><b><?php if (isset($_POST['btnSubmit'])){echo $statusMessage[0];} ?></b></h6>
            <h6 class="header col s12 teal-text"><b><?php if (isset($_POST['btnSubmit'])){echo $statusMessage[1];}  ?></b></h6>
        </div>
    </div>
    <br>
    <br>
    <div class="section no-pad-bot">
        <div class="container">
            <?php

            require 'include/guidelines.php';

            echo "
            <div class='row'>
                <div class='col s12'>
                    <form method='post' action=''>
                        <div class='row'>
                            <div class='col s12'>
                                <div class='input-field col s12'>
                                    <select id='area' name='area' required>
                                        <option value='' disabled selected>Select an area</option>
                                        <option value='slex'>SLEX Entrance/Exit Carmona, Cavite</option>
                                        <option value='bancal'>Bancal Carmona, Cavite</option>
                                    </select>
                                    <label>Area</label>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col s12'>
                                <div class='input-field col s10'>
                                    <input id='co_value' name='co_value' type='number' class='validate' step='$co_step'
                                           min='$co_min'>
                                    <label>Carbon Monoxide</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$co_unit</label>
                                </div>";

                                if($unit_used == "old"){
                                echo "
                                <div class='input-field col s10'>
                                    <input id='so2_value' name='so2_value' type='number' class='validate' step='$sulfur_step' min='$sulfur_min'>
                                    <label>Sulfur Dioxide</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$sulfur_unit</label>
                                </div>
                                
                                <div class='input-field col s10'>
                                    <input id='no2_value' name='no2_value' type='number' class='validate' step='$no2_step'
                                           min='0'>
                                    <label>Nitrogen Dioxide</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$no2_unit</label>
                                </div>
                                ";
                                }
                                echo"
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class='col s12'>
                                <div class='input-field col s12'>
                                    <p class='flatpickr input-date-time'>
                                        <label for='time'>Time</label>
                                        <input id='time' name='time' class='date col s12'
                                               placeholder='YYYY-MM-DD'
                                               data-input>
                                    </p>
            
                                </div>
                                <div class='input-field col s12'>
                                    <button class='btn waves-effect waves-light' type='submit'
                                            style='width: 100%; margin-top:3%;' name='btnSubmit'>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
            
                </div>
            </div>";

            ?>

        </div>
    </div>
</div>

</div>
<?php include('include/footer.php'); ?>
<script src="js/flatpickr.min.js"></script>
<script type="text/javascript">

    $('#co_value').val('');
    $('#so2_value').val('');
    $('#no2_value').val('');
    $('#o3_value').val('');
    $('#pm10_value').val('');
    $('#tsp_value').val('');
</script>
</body>
</html>
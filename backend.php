<?php

$statusMessage = ["", ""];

function insertPollutant($e_id, $area, $value, $date_now_string, $symbol, $statusMessage)
{
    include('include/db_connect.php');

    $query = "SELECT timestamp FROM MASTER WHERE E_ID = '$e_id' and area_name='$area' and timestamp = '$date_now_string' ORDER BY timestamp desc limit 1";
    $result = mysqli_query($con, $query);

    if($result) {

        if (mysqli_num_rows($result) == 0) {
            $query = "INSERT INTO MASTER (area_name, e_id, concentration_value, timestamp) VALUES ('$area', '$e_id', '$value', '$date_now_string')";
            if (!mysqli_query($con, $query)) {
                die('Error: ' . mysqli_error($con));
            }

            else
            {
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

    return $statusMessage;

}

if (isset($_POST['btnSubmit'])) {
    $area = $_POST['area'];
    $time = $_POST['time'];

    $date = date("Y-m-d H", strtotime($time));
    $time = $date.":00:00";

    date_default_timezone_set('Asia/Manila');
    $date_now = date("Y-m-d H");
    $date_now_string = $date_now.":00:00";

    $co_value = $_POST['co_value'];
    $so2_value = $_POST['so2_value'];
    $no2_value = $_POST['no2_value'];
    $o3_value = $_POST['o3_value'];
    $pm10_value = $_POST['pm10_value'];
    $tsp_value = $_POST['tsp_value'];

    if($co_value == "" && $so2_value == "" && $no2_value == "" && $o3_value == "" && $pm10_value == "" && $tsp_value == "")
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

            if ($o3_value != null) {
                $e_id = '4';
                $statusMessage = insertPollutant($e_id, $area, $o3_value, $time, "O3", $statusMessage);
            }

            if ($pm10_value != null) {
                $e_id = '5';
                $statusMessage = insertPollutant($e_id, $area, $pm10_value, $time, "PM 10", $statusMessage);
            }

            if ($tsp_value != null) {
                $e_id = '6';
                $statusMessage = insertPollutant($e_id, $area, $tsp_value, $time, "TSP", $statusMessage);
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
            <div class="row">
                <div class="col s12">
                    <form method="post" action="">
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col s12">
                                    <select id="area" name="area" required>
                                        <option value="" disabled selected>Select an area</option>
                                        <option value="slex">SLEX Entrance/Exit Carmona, Cavite</option>
                                        <option value="bancal">Bancal Carmona, Cavite</option>
                                    </select>
                                    <label>Area</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 l6">
                                <div class="input-field col s10">
                                    <input id="co_value" name="co_value" type="number" class="validate" step="0.1"
                                           min="0.0"
                                           max="40.4">
                                    <label>Carbon Monoxide</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ppm</label>
                                </div>


                                <div class="input-field col s10">
                                    <input id="so2_value" name="so2_value" type="number" class="validate" step="0.001"
                                           min="0.000" max="0.804">
                                    <label>Sulfur Dioxide</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ppm</label>
                                </div>

                                <div class="input-field col s10">
                                    <input id="no2_value" name="no2_value" type="number" class="validate" step="0.01"
                                           min="0.65"
                                           max="1.64">
                                    <label>Nitrogen Oxide</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ppm</label>
                                </div>
                            </div>

                            <div class="col s12 l6">
                                <div class="input-field col s10">
                                    <input id="o3_value" name="o3_value" type="number" class="validate" step="0.001"
                                           min="0.000"
                                           max="0.504">
                                    <label>Ozone</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ppm</label>
                                </div>

                                <div class="input-field col s10">
                                    <input id="pm10_value" name="pm10_value" type="number" class="validate" min="0"
                                           max="504">
                                    <label>Particulate Matter 10</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ug/m3</label>
                                </div>

                                <div class="input-field col s10">
                                    <input id="tsp_value" name="tsp_value" type="number" class="validate" min="0">
                                    <label>Total Suspended Particles</label>
                                </div>
                                <div class="input-field col s2">
                                    <label id="unit">ug/m3</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col s12">
                                    <p class="flatpickr input-date-time">
                                        <label for="time">Time</label>
                                        <input id="time" name="time" class="date col s12"
                                               placeholder="YYYY-MM-DD"
                                               data-input>
                                    </p>

                                </div>
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light" type="submit"
                                            style="width: 100%; margin-top:3%;" name="btnSubmit">Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

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
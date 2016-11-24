<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

require_once 'public/include/db_connect.php';

$error = false;
$areaName = array('Select an area', 'SLEX', 'Bancal', 'All');

if(isset($_POST["btnGenerate"]))
{

    // CODE HERE TO DETERMINE IF MAY LAMAN BA UNG DB BASED SA GANERN OK OK


    $area = $_POST["drpArea"];
    $pollutant = $_POST["drpPollutant"];
    $dateTimeFrom = $_POST["txtDateTimeFrom"];
    $dateTimeTo = $_POST["txtDateTimeTo"];
    $order = $_POST["drpOrder"];

if($area == 3) {
    if ($pollutant == 7) {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";

        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);
        mysqli_close($con);

    } else {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE MASTER.e_id = '$pollutant' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);

        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);

        mysqli_close($con);
    }
}
else{
    if ($pollutant == 7) {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$areaName[$area]' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";

    } else {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$areaName[$area]' and MASTER.e_id = '$pollutant' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);
    }
    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    mysqli_close($con);
}
    if($row == 0){
        $error = true;
    }else{
        $error = false; // THEN SET THIS TO TRUE / FALSE OK OK
    }

    if($error)
    {
        $errorMessage = "No available data!";
        $error = false;
    }

    else {

        session_start();

        $_SESSION['drpArea'] = $_POST["drpArea"];
        $_SESSION['drpPollutant'] = $_POST["drpPollutant"];
        $_SESSION['txtDateTimeFrom'] = $_POST["txtDateTimeFrom"];
        $_SESSION['txtDateTimeTo'] = $_POST["txtDateTimeTo"];
        $_SESSION['drpOrder'] = $_POST["drpOrder"];

        header("Location: generatepdf.php");

    }


}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <meta name="generator" content="HTML Tidy for Linux (vers 25 March 2009), see www.w3.org">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>History - Air Quality Monitoring System</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/flatpickr.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">
    <script type ="text/javascript">
        var errorMessage = "<?= $errorMessage ?>";

        if(errorMessage == "No available data!")
        {
            alert(errorMessage);
            errorMessage = "";
        }

        errorMessage = "";
       // alert(errorMessage);

    </script>

</head>

<body>

<?php  include('public/_header.php'); ?>


<div id="content-holder">
    <br>
    <br>
   <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s6 offset-s3">
                    <div class="form-card z-depth-1" style="width:100%;">
                        <form method = "post" action="">
                        <!--<form method = "post" action="generatepdf.php">-->
                            <div class="input-field col s12">
                                <select name = "drpArea" required>
                                    <option value="" disabled selected>Select an area</option>
                                    <option value="1">SLEX, Carmona Exit</option>
                                    <option value="2">Bancal</option>
                                    <option value="3">All</option>
                                </select>
                                <label>Area</label>
                            </div>
                            <div  class="input-field col s12">
                                <select name = "drpPollutant" required>
                                    <option value="" disabled selected>Select a pollutant</option>
                                    <option value="1">CO</option>
                                    <option value="2">SO2</option>
                                    <option value="3">NO2</option>
                                    <option value="4">O3</option>
                                    <option value="5">Pb</option>
                                    <option value="6">PM10</option>

                                    <option value="7">All</option>
                                </select>
                                <label>Pollutant</label>
                            </div>

                            <div  class="input-field col s12">
                                <select name = "drpOrder" required>
                                    <option value="" disabled selected>Select order of data</option>
                                    <option value="1">Timestamp</option>
                                    <option value="2">Element</option>

                                </select>
                                <label>Order By</label>
                            </div>

                            <div class="input-field s12">
                                <div class="input-field col s12">
                                    <p class="flatpickr input-date">
                                        <label for="time">From</label>
                                        <input id="txtDateTimeFrom" name="txtDateTimeFrom" class="date col s12"
                                               placeholder="YYYY-MM-DD"
                                               data-input>
                                    </p>

                                </div>
                            </div>
                            <div class="input-field s12">
                                <div class="input-field col s12">
                                    <p class="flatpickr input-date">
                                        <label for="time">To</label>
                                        <input id="txtDateTimeTo" name="txtDateTimeTo" class="date col s12"
                                               placeholder="YYYY-MM-DD"
                                               data-input>
                                    </p>

                                </div>
                            </div>

                            <div class="input-field center col s12">
                                <button class="btn waves-effect waves-light" type="submit" name="btnGenerate" style="width: 100%;">
                                    Generate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php  include('public/_footer.php'); ?>


<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/flatpickr.min.js"></script>
<script src="js/init.js"></script>

<script type="text/javascript">
    $( document ).ready(function(){
        $("#legends").remove();
    })
</script>
</body>
</html>

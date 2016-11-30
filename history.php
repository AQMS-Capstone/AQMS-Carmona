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
$a_name = "";

if(isset($_POST["btnGenerate"]))
{

    // CODE HERE TO DETERMINE IF MAY LAMAN BA UNG DB BASED SA GANERN OK OK


    $area = $_POST["drpArea"];
    $pollutant = $_POST["drpPollutant"];
    $dateTimeFrom = $_POST["txtDateTimeFrom"];
    $dateTimeTo = $_POST["txtDateTimeTo"];
    $order = $_POST["drpOrder"];

if($area == 3) {
    if ($pollutant == 'All') {
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
                          WHERE ELEMENTS.e_symbol = '$pollutant' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);

        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);

        mysqli_close($con);
    }
}
else{
    if ($pollutant == 'All') {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$areaName[$area]' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";

    } else {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$areaName[$area]' and ELEMENTS.e_symbol = '$pollutant' and DATE(timestamp) BETWEEN DATE('$dateTimeFrom') and DATE('$dateTimeTo')
                          ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);
    }
    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    mysqli_close($con);
}
    if($row == 0){
        //$error = true;
        echo "<script>alert('No available data')</script>";

    }else{
        //$error = false; // THEN SET THIS TO TRUE / FALSE OK OK

        session_start();

        $_SESSION['drpArea'] = $_POST["drpArea"];
        $_SESSION['drpPollutant'] = $_POST["drpPollutant"];
        $_SESSION['txtDateTimeFrom'] = $_POST["txtDateTimeFrom"];
        $_SESSION['txtDateTimeTo'] = $_POST["txtDateTimeTo"];
        $_SESSION['drpOrder'] = $_POST["drpOrder"];



    }

    unset($_POST['btnGenerate']);
    header("Location: generatepdf.php");
}
?>

<!DOCTYPE html>
<html>
<head>
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


    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type ="text/javascript">

        /*function getData(area) {
            $.ajax({
                type: 'POST',
                url: 'history.php',
                data: {
                    get_option:area
                },
                success: function (response) {
                    document.getElementById("drpPollutant").innerHTML=response;
                }
            });
        }*/


//        var errorMessage = "<?//= $errorMessage    ?>//";
//
//        if(errorMessage == "No available data!")
//        {
//            alert(errorMessage);
//            $errorMessage = "";
//        }
//
//        errorMessage = "";
       // alert(errorMessage);

    </script>

</head>

<body>

<?php  include('public/_header.php'); ?>


<div id="content-holder">
    <br>
    <h1 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons" style="font-size: 2em;">library_books</span></h1>
    <h2 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b>History Report</b></h2>
    <p class="header center grey-text" style="margin-top: 0; padding-top: 0;">By filling out and submitting this form, the page would generate a PDF file.</p>

   <div class="section no-pad-bot">
        <div class="container">
            <div class="divider"></div>
            <br>
            <div class="row">
                <div class="col s12">
                    <div>
                        <form method = "post" action="">
                        <!--<form method = "post" action="generatepdf.php">-->
                            <div id = "woah" class="input-field col s12">
                                <!--<select name = "drpArea" id = "drpArea" required onchange="getData(this.value)">-->
                                <select name = "drpArea" id = "drpArea" required>
                                    <option value="" disabled selected>Select an area</option>
                                    <option value="1">SLEX Carmona</option>
                                    <option value="2">Bancal</option>

                                    <option value="3">All</option>
                                </select>
                                <label>Area</label>
                            </div>
                            <div  class="input-field col s12">
                                <select name = "drpPollutant" id = "drpPollutant" required>
                                    <option value="" disabled selected>Select a pollutant</option>
                                </select>
                                <label>Pollutant</label>
                            </div>

                            <div  class="input-field col s12">
                                <select name = "drpOrder" required>
                                    <option value="1" selected>Timestamp</option>
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
                                <button class="btn btn-large waves-effect waves-light" type="submit" name="btnGenerate" style="width: 100%;">
                                    Generate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>


<?php  include('public/_footer.php'); ?>

<!--<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/flatpickr.min.js"></script>
<script src="js/init.js"></script>

<script type="text/javascript">
    var area_name = ["slex", "bancal", "all"];

    $( document ).ready(function(){
        $("#legends").remove();

        $('select').material_select();

        $(document).on('change','#drpArea',function(){
            var val = $(this).val();

            $.ajax({
                url: 'getPollutants.php',
                data: {area:area_name[val-1]},
                type: 'GET',
                dataType: 'html',
                success: function(result){
                    var $selectDropdown = $("#drpPollutant").empty().html(' ');
                    $('#drpPollutant').html(result);
                    $selectDropdown.trigger('contentChanged');
                }
            });
        });

        var val = $("#drpArea").val();

        $.ajax({
            url: 'getPollutants.php',
            data: {area:area_name[val-1]},
            type: 'GET',
            dataType: 'html',
            success: function(result){
                var $selectDropdown = $("#drpPollutant").empty().html(' ');
                $('#drpPollutant').html(result);
                $selectDropdown.trigger('contentChanged');
            }
        });

            $('select').on('contentChanged', function() {
            // re-initialize (update)
            $(this).material_select();
        });

    })


</script>
</body>
</html>

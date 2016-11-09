<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

if(isset($_POST['btnGenerate'])){
  $area = $_POST["drpArea"];
  $pollutant = $_POST["drpPollutant"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />


</head>

<body>


<?php  include('public/_header.php'); ?>


<div id="content-holder">
    <br>
    <br>
   <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col m6 offset-m3">
                    <div class="form-card z-depth-1">
                        <form method = "post" action="generatepdf.php">
                            <div class="input-field col s12">
                                <select name = "drpArea">
                                    <option value="" disabled selected>Select an area</option>
                                    <option value="1">SLEX, Carmona Exit</option>
                                    <option value="2">Bancal</option>
                                    <option value="3">All</option>
                                </select>
                                <label>Area</label>
                            </div>
                            <div  class="input-field col s12">
                                <select name = "drpPollutant">
                                    <option value="" disabled selected>Select a pollutant</option>
                                    <option value="1">CO</option>
                                    <option value="2">Bancal</option>
                                    <option value="3">All</option>
                                </select>
                                <label>Pollutant</label>
                            </div>

                            <div class="input-field col s4">
                                <input id="year" type="number" min="2000" max="3000" class="validate">
                                <label for="year">Year</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="month" type="number" min="1" max="12" class="validate">
                                <label for="month">Month</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="day" type="number" min="1" max="31" class="validate">
                                <label for="day">Day</label>
                            </div>

                            <div class="input-field col s12">
                                <button class="btn waves-effect waves-light" type="submit" name="btnGenerate">Generate
                                    <i class="material-icons right">library_books</i>
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
<script src="js/init.js"></script>

<script type="text/javascript">
    $( document ).ready(function(){
        $("#legends").remove();
    })
</script>
</body>
</html>

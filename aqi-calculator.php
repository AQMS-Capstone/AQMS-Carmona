<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

//$bancalPrevalentPollutant = 0;
//$slexPrevalentPollutant = 3;
//$bancalAQIValue = 40;
//$slexAQIValue = 10;
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
    <div class="section">
        <br><br>
        <h1 class="header center teal-text"><span class="material-icons" style="font-size: 2em;">cloud</span></h1>
        <h2 class="header center teal-text"><b>AQI Calculator</b></h2>
    </div>
    <br>
    <br>
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <form>
                        <div class="input-field col s8">
                            <select>
                                <option value="" disabled selected>Select a pollutant</option>
                                <option value="1">CO</option>
                                <option value="2">SO2</option>
                                <option value="3">NO2</option>
                                <option value="3">O3</option>
                                <option value="3">PM10</option>
                                <option value="3">TSP</option>
                            </select>
                            <label>Pollutant</label>
                        </div>
                        <div class="input-field col s1">
                            <input id="concentration" type="number" class="validate" value="0">
                            <label for="number">Concentration</label>
                        </div>
                        <div class="input-field col s1">
                            <label id="unit">µg/m3</label>
                        </div>
                        <div class="input-field col s2">
                          <button class="btn waves-effect waves-light">CALCULATE</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="divider"></div>
            <br>
            <div class="row">
                <div class="col s12 m4 l4">
                    <div class="card" style="min-height: 328px;">
                        <div class="card-content">
                            <div class="card-title teal-text"><b>Sensitive Groups</b></div>
                            <p>
                                People with respiratory or heart disease, the elderly and children are the groups most at risk.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="card" style="min-height: 328px;">
                        <div class="card-content">
                            <div class="card-title teal-text"><b>Health Effects</b></div>
                            <p>
                                Serious aggravation of heart or lung disease and premature mortality in persons with cardiopulmonary disease and the elderly;
                                serious risk of respiratory effects in general population.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="card" style="min-height: 328px;">
                        <div class="card-content">
                            <div class="card-title teal-text"><b>Sensitive Groups</b></div>
                            <p>
                                Everyone should avoid any outdoor exertion;
                                people with respiratory or heart disease, the elderly and children should remain indoors.
                            </p>
                        </div>

                    </div>
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

</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */
include("class/Map.php");
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
                <div class="col s4">
                    <div class="card" style="min-height: 591px;">
                        <div class="card-image">
                            <img id="zoneImg" src="res/images/area/slex_carmona-exit.jpg">
                        </div>
                        <div class="card-content">
                            <h5 class="teal-text"><b id="zoneName">Zone Name</b></h5>

                            <p><b>Prevalent Air Pollutant: </b> <p id="prevalentPollutant">NaN</p></p>
                            <p><b>AQI: </b><span id="aqiNum">NaN</span></p>
                            <p><b>Last Updated: </b><span id="timeUpdated">NaN</span></p>
                        </div>
                        <div class="center bottom">
                            <div class="divider"></div>
                            <br>
                            <a id ="prevArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                            <a id ="nextArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="col s8">
                    <div class="row-no-after">
                        <div class="card" style="min-height: 288px;">

                            <div id="AQIStat" class="center" style="padding: 15px;">
                                <h5><b id="aqiText">NaN</b></h5>
                            </div>

                            <div class="card-content">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#synthesis">Synthesis</a></li>
                                    <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>
                                    <li class="tab col s3"><a href="#cautionary">Cautionary</a></li>
                                </ul>
                                <br>

                                <div id="synthesis" class="col s12"> </div>
                                <div id="health-effects" class="col s12"> </div>
                                <div id="cautionary" class="col s12"> </div>

                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="row-no-after">
                        <div class="card" style="min-height: 288px;">


                            <div class="card-content">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<?php  include('public/_footer.php'); ?>


<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<!--<script src="js/graph.js"></script>-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>
<script src="js/daily.js"></script>
<script src="js/aqi-calculator.js"></script>

</body>
</html>

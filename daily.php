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


<?php  include('public/header.php'); ?>

<div id="content-holder">
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s4">
                    <div class="card" style="min-height: 528px;">
                        <div class="card-image">
                            <img id="" src="res/images/area/slex_carmona-exit.jpg">

                        </div>
                        <div class="card-content">
                            <h5><b id="">SLEX, Carmona Exit</b></h5>

                            <p><b>Prevalent Air Pollutant: </b> <span id="">NaN</span></p>
                            <p><b>AQI: </b><span id="">NaN</span></p>
                            <p><b>Time Updated: </b><span id="">NaN</span></p>
                        </div>
                        <div class="center">
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
                    <div class="card" style="min-height: 528px;">

                        <div id="" class="center yellow" style="padding: 15px;">
                            <h5 id="">AQI STATUS</h5>
                        </div>
                        <div class="carousel carousel-slider">

                            <div class="card-content carousel-item">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#synthesis">Synthesis</a></li>
                                    <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>
                                    <li class="tab col s3"><a href="#cautionary">Cautionary</a></li>
                                </ul>
                                <br>

                                <div id="synthesis" class="col s12">EXPLANATION TEXT HERE 1</div>
                                <div id="health-effects" class="col s12">EXPLANATION TEXT HERE 2</div>
                                <div id="cautionary" class="col s12">EXPLANATION TEXT HERE 3</div>

                                <br>
                            </div>

                            <div class="card-content carousel-item">
                                <table>
                                    <thead>
                                    <tr>
                                        <th> </th>
                                        <th> </th>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>E_ID</td>
                                        <td>GRAPH HERE</td>
                                        <td>000</td>
                                        <td>999</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="center">
                            <div class="divider"></div>
                            <br>
                            <a id ="prevStatus" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                            <a id ="nextStatus" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<?php  include('public/footer.php'); ?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/graph.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>


</body>
</html>

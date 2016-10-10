<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 3:13 AM
 */?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location = "mobile.php";
        }

        $(document).ready(function(){
          $("#dataClick").click(function(){
            $("#home").hide();
            $("#data").show();
          });

          $("#drpBancal").click(function(){
            $("#home").show();
            $("#data").hide();
          });

          $("#drpSLEX").click(function(){
            $("#home").show();
            $("#data").hide();
          });

          $("#tab-1-clicked").click(function(){
            $("#tabs-1").show();
            $("#tabs-2").hide();
          });

          $("#tab-2-clicked").click(function(){
            $("#tabs-2").show();
            $("#tabs-1").hide();
          });

          $( document ).ready(function() {
            $("#home").show();
            $("#data").hide();
            $("#tabs-1").show();
            $("#tabs-2").hide();
          });


      });
    </script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/vonn.css" rel="stylesheet">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
    <script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
    <script src="js/caqms_api.js"></script>

</head>

<body id ="mybody">
<!--<body style="overflow: hidden; will-change: overflow;">-->

  <nav class="navbar navbar-default" style="background-color: #009688; height: 65px;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="brand-centered">
                <a class="navbar-brand" href="index.php"><img src="res/logo.png" alt="AQMS"></a>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-default navbar-centered"style="background-color: #009688;">
        <ul class="nav navbar-nav">
            <li><a href="index.php" id = "homeClick"><span class="glyphicon glyphicon-home" style="vertical-align:middle; padding-right: 5px;"></span>Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-map-marker" style="vertical-align:middle; padding-right: 5px;"></span>Sensors Map
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a id="drpBancal" href="#">Bancal</a></li>
                    <li><a id="drpSLEX" href="#">SLEX - Carmona Exit</a></li>
                </ul>
            </li>

            <li><a href="#" id = "dataClick"><span class="glyphicon glyphicon-globe" style="vertical-align:middle; padding-right: 5px;"></span>Data</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-envelope" style="vertical-align:middle; padding-right: 5px;"></span>About Us</a></li>
        </ul>
    </nav>
<div id = "home">
<nav class="navbar navbar-default navbar-centered shadow " style="text-align: center; z-index: 3">
    <ul class="nav navbar-nav nonres-nav">
        <li ><a style="color: #2196F3;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Good</a></li>
        <li><a style="color: #FFEB3B;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Moderate</a></li>
        <li><a style="color: #FF9800;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Unhealthy for Sensitive Groups</a></li>
        <li><a style="color: #f44336;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Unhealthy</a></li>
        <li><a style="color: #9C27B0;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Very Unhealthy</a></li>
        <li><a style="color: #b71c1c;"><span class="glyphicon glyphicon-cloud" style="vertical-align:middle; padding-right: 5px;"></span>Hazardous</a></li>
    </ul>
</nav>
<!--Zone Status Card-->
<div id="zoneStatus" class="card">
    <div>
        <div class="col-md-6">
            <div class="AQIStat" id="AQIStat">
                <span id="aqiNum" style="font-size: 90px;"></span>
            </div>
        </div>
        <div class="col-md-6">
            <p style="font-weight: bold; font-size: x-large; word-break: break-all;" id="zoneName"></p>
            <p style="font-weight: bold; font-size: large; word-break: break-all;" id="aqiText"></p>
            <p><span>Prevalent Air Pollutant: </span><span id="prevalentPollutant">N02</span></p>
            <p id="timeUpdated"></p>
        </div>
        <div class="col-md-12">
            <p style="font-weight: bold" id="zoneRisk"></p>
        </div>
    </div>

    <div class="">
      <ul class="nav navbar-nav">
          <li ><a href="#tabs-1" id = "tab-1-clicked" style="color:black; padding-left: 162px; padding-right: 162px">AQI Plot</a></li>
          <li ><a href="#tabs-2" id="tab-2-clicked" style="color:black; padding-left: 150px; padding-right: 150px">Concentration Plot</a></li>
      </ul>


      </div>
      <div id="tabs-1">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>Current</th>
                    <th></th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CO</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>NO2</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>O3</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                </tbody>
            </table>
        </div>

        <p style="padding: 20px; padding-top: 20px">Synthesis: Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>


    </div>
      <div id="tabs-2">

        <div class="col-md-12" style="margin-bottom: 10px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>Current</th>
                    <th></th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CO</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>NO2</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>O3</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                </tbody>
            </table>
        </div>


        <p style="padding: 20px; padding-top: 20px">Synthesis: Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
      </div>

    </div>



<div class="map-container">
    <div id="googleMap" class="mapAPI"></div>
</div>
</div>

<div id = "data">
    <?php include_once('data.php');?>
</div>

<!--
<nav class="footer" style="position: fixed;">
    <div class="container">
        <ul>
            <li style="vertical-align:middle; color:white">© 2016 AQMS</li>
        </ul>
    </div>
</nav>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

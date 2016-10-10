<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/17/2016
 * Time: 2:30 AM
 */?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />
    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location = "mobile.php";
        }
    </script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
    <script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
    <script src="js/caqms_api.js"></script>

</head>

<body style="overflow:hidden;">

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

<nav class="navbar navbar-default navbar-centered shadow"style="background-color: #009688;">
    <ul class="nav navbar-nav">
        <li><a href="index.php"><span class="glyphicon glyphicon-home" style="vertical-align:middle; padding-right: 5px;"></span>Home</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-map-marker" style="vertical-align:middle; padding-right: 5px;"></span>Sensors Map
                <span class="caret"></span></a>
            <ul class=  "dropdown-menu">
                <li><a id="drpBancal" href="#">Bancal</a></li>
                <li><a id="drpSLEX" href="#">SLEX - Carmona Exit</a></li>
            </ul>
        </li>

        <li><a href="#"><span class="glyphicon glyphicon-globe" style="vertical-align:middle; padding-right: 5px;"></span>EPA National Ambient Air Quality Standards</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-exclamation-sign" style="vertical-align:middle; padding-right: 5px;"></span>Air Pollution Health Effects</a></li>
    </ul>
</nav>

<!--Zone Status Card-->
<div id="zoneStatus" class="card">

    <div>
        <div class="col-md-12">
            <p style="font-weight: bold" id="zoneName"></p>
        </div>
        <div class="col-md-6">
            <div class="AQIStat" id="AQIStat">
                <span id="aqiNum"></span>
            </div>
        </div>
        <div class="col-md-6">
            <p style="font-weight: bold; font-size: x-large; word-break: break-all;" id="aqiText"></p>
            <p><span>Prevalent Air Pollutant: </span><span id="prevalentPollutant">N02</span></p>
            <p id="timeUpdated"></p>
        </div>
        <div class="col-md-12">
            <p style="font-weight: bold" id="zoneRisk"></p>
        </div>
    </div>

    <div class="col-md-12">
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

</div>

<div class="map-container">
    <div id="googleMap" class="mapAPI"></div>
</div>

<nav class="footer">
    <div class="container">
        <ul>
            <li><a href="#"><span class="glyphicon glyphicon-envelope" style="vertical-align:middle; padding-right: 5px;"></span>About us</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-lock" style="vertical-align:middle; padding-right: 5px;"></span>Privacy Policy</a></li>
        </ul>
    </div>
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>



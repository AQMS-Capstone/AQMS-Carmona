<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="../res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<nav>
    <div class="nav-wrapper">
        <a href="#"><img class="brand-logo center" src="../res/logo.png"> </a>
    </div>
</nav>
<nav>
    <div class="nav-wrapper">
        <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
            <li><a href="home.php"><span class="material-icons">home</span> Home</a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><span class="material-icons">location_on</span> Sensors Map<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a href="data-and-reports.html"><span class="material-icons">trending_up</span> Data and Reports</a></li>
            <li><a href="about.html"><span class="material-icons">email</span> About Us</a></li>
        </ul>
    </div>
</nav>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a id="drpBancal">SLEX - Carmona Exit</a></li>
    <li><a id="drpSLEX">Bancal</a></li>
</ul>

<nav>
    <div class="nav-wrapper white">
        <ul id="nav-mobile" class="centered-nav nav-status hide-on-med-and-down black-text">
            <li><a style="color: #2196F3;"><span class="material-icons">cloud</span> Good</a></li>
            <li><a style="color: #FFEB3B;"><span class="material-icons">cloud</span> Moderate</a></li>
            <li><a style="color: #FF9800;"><span class="material-icons">cloud</span> Unhealthy for Sensitive Groups</a></li>
            <li><a style="color: #f44336;"><span class="material-icons">cloud</span> Unhealthy</a></li>
            <li><a style="color: #9C27B0;"><span class="material-icons">cloud</span> Very Unhealthy</a></li>
            <li><a style="color: #b71c1c;"><span class="material-icons">cloud</span> Hazardous</a></li>
        </ul>
    </div>
</nav>

<div class="map-container">
    <div id="googleMap" class="mapAPI"></div>
</div>

<!--  Scripts-->
<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/init.js"></script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="../js/caqms-api.js"></script>
</body>
</html>

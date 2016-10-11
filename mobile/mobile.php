<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/15/2016
 * Time: 8:15 PM
 */?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="../res/favicon.ico" type="image/x-icon" />

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="../js/mobile/caqms_api.js"></script>

</head>
<body>
<nav class="navbar navbar-default" style="background-color: #009688;">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="brand-centered">
                <a class="navbar-brand" href="../index.php"><img src="../res/logo.png" alt="AQMS"></a>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-default navbar-centered shadow" style="background-color: #009688;">

    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-map-marker" style="vertical-align:middle; padding-right: 5px;"></span>Sensors Map
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="drpBancal" href="#">Bancal</a></li>
                <li><a id="drpSLEX" href="#">SLEX - Carmona Exit</a></li>
            </ul>
        </li>
    </ul>
</nav>

<br>

<div class="mobile-card">
    <div class="col-sm-12">
        <p style="font-weight: bold" id="zoneName"></p>
    </div>
    <div class="col-sm-6">
        <div class="AQIStat" id="AQIStat">
            <span id="aqiNum"></span>
        </div>
    </div>
</div>

<br>
<div id="zoneStatus" class="mobile-card">

    <div>
        <div class="col-sm-6">
            <p style="font-weight: bold; font-size: x-large; word-break: break-all;" id="aqiText"></p>
            <p><span>Prevalent Air Pollutant: </span><span id="prevalentPollutant">N02</span></p>
            <p id="timeUpdated"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th>CUR</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>CO</td>
                <td>999</td>
                <td><img src="../res/sampleData.png"></td>
            </tr>
            <tr>
                <td>NO2</td>
                <td>999</td>
                <td><img src="../res/sampleData.png"></td>
            </tr>
            <tr>
                <td>O3</td>
                <td>999</td>
                <td><img src="../res/sampleData.png"></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>




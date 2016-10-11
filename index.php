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
            window.location = "mobile/mobile.php";
        }

        $(document).ready(function(){
            $("html, body").animate({ scrollTop: 0 }, "fast");

            $("#homeClick").click(function(){
                $("html, body").animate({ scrollTop: 0 }, "slow");
            });

          $("#dataClick").click(function(){
            $("#home").hide();
            $("#data").show();
              $("#body-div").css({'overflow':'visible'});
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

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
    <script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
    <script src="js/caqms-api.js"></script>

</head>

<body id="body-div" style="overflow: hidden">

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

            <li><a href="#" id = "dataClick"><span class="glyphicon glyphicon-globe" style="vertical-align:middle; padding-right: 5px;"></span>Data and Summary Reports</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-envelope" style="vertical-align:middle; padding-right: 5px;"></span>About Us</a></li>
        </ul>
    </nav>
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

<!--Home Php-->
<div id = "home">
    <?php include_once('home/home.php');?>
</div>
<!--Data Php-->
<div id = "data">
    <?php include_once('home/data-and-reports.php');?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

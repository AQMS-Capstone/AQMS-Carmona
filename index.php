<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */
 include("class/Map.php");

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
    <link rel="icon" href="/res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <script type = "text/javascript">
    function DashClicked(var1)
    {

      phpValue = var1;

      $.ajax( {
          type: "GET",
          url: 'setter/include_files.php',
          //data: $('#mainForm').serialize(),
          data: {phpValue: JSON.stringify(phpValue)},
          success: function(response) {
              $('#ContentPanel').html(response);
          }
      });
    }
    </script>
</head>

<body onload="DashClicked('Home')">

    <!--   Header  -->
    <?php  include('public/header.php'); ?>
    <!--   Header  -->

    <div id="ContentPanel" class="content-holder">
        <?php  //include('public/map.php'); ?>
        <?php  //include('public/history.php'); ?>
    </div>

    <!--   Content  -->
    <!--   Content  -->

    <!--   Footer  -->
    <!--   Footer  -->

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/graph.js"></script>
<script src="js/init.js"></script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="js/caqms-api.js"></script>
</body>
</html>

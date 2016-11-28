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

    <title>Air Quality Monitoring System</title>
    <link rel="icon" href="/res/favicon.ico" type="image/x-icon"/>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <meta property="og:url"                content="http://aqms.mcl-ccis.net/" />
    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="Air Quality Monitoring System" />
    <meta property="og:description"        content="The Air Quality Monitoring System (AQMS) promotes Air Pollution awareness and provide a unified Air Quality information for the municipality of Carmona. " />
    <meta property="og:image"              content="http://aqms.mcl-ccis.net/res/facebook_og.jpg" />
</head>

<body>


<?php include('public/_header.php'); ?>

<div id="content-holder">
    <?php include('public/map.php'); ?>
</div>


<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="js/caqms-api.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/graph.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

</body>
</html>

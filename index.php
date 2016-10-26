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
    <link rel="icon" href="/res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    
</head>

<body>
<div class="flex">

    <!--   Header  -->
    <?php  include('public/header.php'); ?>
    <!--   Header  -->

    <!--   Content  -->
    <?php  include('public/map.php'); ?>
    <?php  include('public/reports.php'); ?>
    <!--   Content  -->

    <!--   Footer  -->
    <!--   Footer  -->

</div>


<!--  Scripts-->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="js/caqms-api.js"></script>
</body>
</html>

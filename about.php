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
    <meta name="generator" content="HTML Tidy for Linux (vers 25 March 2009), see www.w3.org">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About - Air Quality Monitoring System</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">


</head>

<body>


<?php  include('public/_header.php'); ?>

<div id="content-holder">
    <br>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">About</h3>
            <h5 class="teal-text text-lighten-2">Learn about Carmona, Cavite and our Project Team.</h5>
        </div>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="res/images/parallax/carmona_1.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">Municipality of Carmona</h3>
            <p class="gray-text text-lighten-3 caption">
                Carmona is located on the south-eastern part of the province of Cavite, approximately 36 kilometres south of Manila and 24 kilometres from Trece Martires City, Cavite’s provincial capital.
                It is bounded on the north, east and south by the City of Biñan, Laguna, Municipality of General Mariano Alvarez (GMA) on the north-west and Silang on the south-west.
                The geographic coordinates of Carmona are about 14.32° latitude and 121.06° longitude.
            </p>
        </div>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="res/images/parallax/carmona_2.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">Meet the Team</h3>
            <p class="gray-text text-lighten-3 caption">We are a team of students from Malayan Colleges Laguna.</p>
            <div class="divider"></div>
            <br>
            <br>
            <div class="row">
                <div class="col s3">
                    <div>
                        <a href="https://www.facebook.com/VCMesina" target="_blank"><img class="img-circle img-small" src="res/images/team/vonn.jpg" alt="Vonn"></a>
                    </div>
                </div>
                <div class="col s9 left-align">
                    <h4>Vonn Mesina</h4>
                    <p>Vonn is an Information Technology major with a specialization in web and mobile development.
                        He is currently working at Gleent Inc. as an iOS Developer</p>
                </div>
            </div>

            <div class="row">
                <div class="col s3">
                    <div>
                        <a href="https://www.facebook.com/rairulyle" target="_blank"><img class="img-circle img-small" src="res/images/team/lyle.jpg" alt="Lyle"></a>
                    </div>
                </div>
                <div class="col s9 left-align">

                    <h4>Lyle Dela Cuesta</h4>
                    <p>Lyle is an Information Technology major with a specialization in web and mobile development.
                        He is currently working at NXP, Philips Inc. as a Front End and Back End Developer</p>
                </div>
            </div>

            <div class="row">
                <div class="col s3">
                    <div>
                        <a href="https://www.facebook.com/krismariano30" target="_blank"><img class="img-circle img-small" src="res/images/team/kris.jpg" alt="Kris"></a>
                    </div>
                </div>
                <div class="col s9 left-align">
                    <h4>Kris Mariano</h4>
                    <p>Kris is an Information Technology major with a specialization in web and mobile development.
                        He is currently working at NXP, Philips Inc. as a Front End and Back End Developer.</p>
                </div>
            </div>
        </div>

    </div>
    </div>

</div>



<?php  include('public/_footer.php'); ?>


<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/graph.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

<script type="text/javascript">
    $( document ).ready(function(){
        $("#legends").remove();
    })
</script>
</body>
</html>

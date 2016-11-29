<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 11/29/2016
 * Time: 10:25 PM
 */
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>The HTML5 Herald</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <div class="center">
        <h1 id="main-text">AQI to CV</h1>
        <button id="main-btn" class="btn waves-effect waves-light" type="submit" name="action">AQI to CV</button>
    </div>

    <div id="aqi-cv">
        <input placeholder="AQI to CV" id="first_name" type="text" class="validate">
    </div>
    <div id="cv-aqi" hidden>
        <input placeholder="CV to AQI" id="first_name" type="text" class="validate">
    </div>
</div>



<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>

<script>
    $( "#main-btn" ).click(function() {
        if($('#main-text').text() == 'AQI to CV')
        {
            $("#aqi-cv").hide();
            $("#cv-aqi").show();
            $("#main-text").text("CV to AQI");
            $("#main-btn").text("CV to AQI");
        }
        else if($('#main-text').text() == 'CV to AQI'){

            $("#cv-aqi").hide();
            $("#aqi-cv").show();
            $("#main-text").text("AQI to CV");
            $("#main-btn").text("AQI to CV");
        }

    });

</script>
</body>
</html>

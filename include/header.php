<?php
include("include/BASE_URL.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo WEB_TITLE; ?></title>
    <link rel="icon" href="<?php echo BASE_URL; ?>/res/favicon.ico" type="image/x-icon"/>


    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/flatpickr.css" type="text/css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL; ?>/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL; ?>/css/style.css" type="text/css" rel="stylesheet" media="screen">

    <meta property="og:url" content="http://aqms.mcl-ccis.net/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Air Quality Monitoring System"/>
    <meta property="og:description"
          content="The Air Quality Monitoring System (AQMS) promotes Air Pollution awareness and provides a unified Air Quality information for the municipality of Carmona. "/>
    <meta property="og:image" content="http://aqms.mcl-ccis.net/res/facebook_og.jpg"/>
</head>

<body>
<div>
    <nav class="z-depth-1" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="http://aqms.mcl-ccis.net/"><img class="brand-logo center" alt="Brand Logo"
                                                               src="<?php echo BASE_URL; ?>/res/logo.png"> </a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="side-nav" id="mobile-demo">
                <li class="teal z-depth-1"><a id="logo" href="index.php"><img alt="Brand Logo" class="center"
                                                                              src="res/logo.png" style="height: 45px;">
                    </a></li>
                <li><a href="index.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
                <li><a id="sensor"><span class="material-icons">location_on</span> Sensors Map<i
                                class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <div hidden id="sensor-content">
                    <li><a href="index.php?area=SLEX" id="drpSLEX">SLEX - Carmona Exit</a></li>
                    <li><a href="index.php?area=Bancal" id="drpBancal">Bancal</a></li>
                </div>

                <li><a href="daily.php"><span class="material-icons">access_time</span> Daily</a></li>
                <li><a href="history.php"><span class="material-icons">trending_up</span> History</a></li>
                <li><a id="calculator"><span class="material-icons">timeline</span>Calculators<i
                                class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <div hidden id="calculator-content">
                    <li><a href="aqi-calculator.php?calculator=CVA" id="drpCVA">AQI Calculator</a></li>
                    <li><a href="aqi-calculator.php?calculator=ACV" id="drpACV">Concentration Value Calculator</a></li>
                </div>

                <li><a href="about.php" id="about-tab"><span class="material-icons">email</span> About</a></li>
            </ul>

        </div>
    </nav>
</div>

<div>
    <nav id="nav" class="hide-on-med-and-down">
        <div class="nav-wrapper">

            <ul class="centered-nav">
                <li><a href="index.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
                <li><a class="dropdown-button" data-beloworigin="true" data-activates="dropdown1"><span
                                class="material-icons">location_on</span> Sensors Map<i class="material-icons right"
                                                                                        style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <li><a href="daily.php"><span class="material-icons">access_time</span> Daily</a></li>
                <li><a href="history.php"><span class="material-icons">trending_up</span> History</a></li>
                <li><a class="dropdown-button" data-beloworigin="true" data-activates="dropdown2"><span
                                class="material-icons">timeline</span>Calculators<i class="material-icons right"
                                                                                    style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <li><a href="about.php" id="about-tab"><span class="material-icons">email</span> About</a></li>

            </ul>


        </div>
    </nav>
</div>
<!-- Dropdown Structure -->
<ul id="dropdown2" class="dropdown-content">
    <li><a href="aqi-calculator.php?calculator=CVA" id="drpCVA">AQI Calculator</a></li>
    <li><a href="aqi-calculator.php?calculator=ACV" id="drpACV">Concentration Value Calculator</a></li>
</ul>
<ul id="dropdown1" class="dropdown-content">
    <li><a href="index.php?area=SLEX" id="drpSLEX">SLEX - Carmona Exit</a></li>
    <li><a href="index.php?area=Bancal" id="drpBancal">Bancal</a></li>
</ul>
<div id="legends">
    <nav class="navbar-fixed hide-on-med-and-down">
        <div class="nav-wrapper white">
            <ul class="centered-legend">
                <li style="color: #4CAF50;"><span class="material-icons">cloud</span> Good</li>
                <li style="color: #FFEB3B;"><span class="material-icons">cloud</span> Fair</li>
                <li style="color: #FF9800;"><span class="material-icons">cloud</span> Unhealthy for Sensitive Groups
                </li>
                <li style="color: #f44336;"><span class="material-icons">cloud</span> Very Unhealthy</li>
                <li style="color: #9C27B0;"><span class="material-icons">cloud</span> Acutely Unhealthy</li>
                <li style="color: #b71c1c;"><span class="material-icons">cloud</span> Emergency</li>
            </ul>
        </div>
    </nav>
</div>

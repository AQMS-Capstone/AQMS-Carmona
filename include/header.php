<!DOCTYPE html>
<html>
<head>
    <?php
    include('header-meta.php');
    ?>
</head>

<body>
<div>
    <nav class="z-depth-1" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="http://aqms.mcl-ccis.net/"><img class="brand-logo center" alt="Brand Logo"
                                                               src="res/logo.png"> </a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="side-nav" id="mobile-demo">
                <li class="teal z-depth-1"><a id="logo" href="index.php"><img alt="Brand Logo" class="center"
                                                                                      src="res/logo.png"
                                                                                      style="height: 45px;"> </a></li>
                <li><a href="mobile-home.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
                <li><a id="sensor"><span class="material-icons">location_on</span> Sensors Map<i
                                class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <div hidden id="sensor-content">
                    <li><a href="mobile-home.php?area=SLEX" id="drpSLEX">SLEX - Carmona Exit</a></li>
                    <li><a href="mobile-home.php?area=Bancal" id="drpBancal">Bancal</a></li>
                </div>

                <li><a href="mobile-daily.php"><span class="material-icons">access_time</span> Daily</a></li>
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

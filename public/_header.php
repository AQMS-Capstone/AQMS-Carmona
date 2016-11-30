<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

?>

<div>
    <nav class="z-depth-0" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="index.php"><img class="brand-logo center" src="res/logo.png"> </a>
        </div>
    </nav>
</div>


<div>
    <nav id="nav">
        <div class="nav-wrapper">
            <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
                <li><a href="index.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
                <li><a class="dropdown-button" data-beloworigin="true" data-activates="dropdown1"><span
                            class="material-icons">location_on</span> Sensors Map<i class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a>
                </li>
                <li><a href="daily.php" id=""><span class="material-icons">access_time</span> Daily</a></li>
                <li><a href="history.php"><span class="material-icons">trending_up</span> History</a></li>
<!--                <li><a href="aqi-calculator.php" id=""><span class="material-icons">timeline</span> AQI Calculator</a>-->
                <li><a class="dropdown-button" data-beloworigin="true" data-activates="dropdown2"><span
                            class="material-icons">timeline</span>Calculators<i class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a>
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
    <nav class="navbar-fixed">
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

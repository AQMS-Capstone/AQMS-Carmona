<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

?>
<div>
    <nav class="z-depth-0">
        <div class="nav-wrapper">
            <a href="#"><img class="brand-logo center" src="res/logo.png"> </a>
        </div>
    </nav>
</div>

<div>
    <nav id="nav">
        <div class="nav-wrapper">
            <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
                <li><a href="#home" id="home-tab"><span class="material-icons">home</span> Home</a></li>
                <li><a class="dropdown-button" data-beloworigin="true" data-activates="dropdown1"><span class="material-icons">location_on</span> Sensors Map<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="#data-reports" id="reports-tab"><span class="material-icons">trending_up</span> Data and Reports</a></li>
                <li><a id="about-tab"><span class="material-icons">email</span> About Us</a></li>
            </ul>
        </div>
    </nav>
</div>

<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="#home_SLEX" id="drpSLEX">SLEX - Carmona Exit</a></li>
    <li><a href="#home_Bancal" id="drpBancal">Bancal</a></li>
</ul>
<div>
    <nav id ="legends" class="navbar-fixed">
        <div class="nav-wrapper white">
            <ul id="nav-mobile" class="centered-nav nav-status hide-on-med-and-down black-text">
                <li><a style="color: #2196F3;"><span class="material-icons">cloud</span> Good</a></li>
                <li><a style="color: #FFEB3B;"><span class="material-icons">cloud</span> Fair</a></li>
                <li><a style="color: #FF9800;"><span class="material-icons">cloud</span> Unhealthy for Sensitive Groups</a></li>
                <li><a style="color: #f44336;"><span class="material-icons">cloud</span> Very Unhealthy</a></li>
                <li><a style="color: #9C27B0;"><span class="material-icons">cloud</span> Acutely Unhealthy</a></li>
                <li><a style="color: #b71c1c;"><span class="material-icons">cloud</span> Emergency</a></li>
            </ul>
        </div>
    </nav>
</div>

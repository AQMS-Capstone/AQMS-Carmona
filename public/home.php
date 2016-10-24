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
    <link rel="icon" href="../res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
<div class="header">
    <div>
        <nav class="z-depth-0">
            <div class="nav-wrapper">
                <a href="#"><img class="brand-logo center" src="../res/logo.png"> </a>
            </div>
        </nav>
    </div>

    <div>
        <nav class="z-depth-0 small-nav">
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
                    <li><a href="home.php"><span class="material-icons">home</span> Home</a></li>
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><span class="material-icons">location_on</span> Sensors Map<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a href="data-and-reports.html"><span class="material-icons">trending_up</span> Data and Reports</a></li>
                    <li><a href="about.html"><span class="material-icons">email</span> About Us</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
        <li><a id="drpBancal">SLEX - Carmona Exit</a></li>
        <li><a id="drpSLEX">Bancal</a></li>
    </ul>
    <div>
        <nav class="navbar-fixed">
            <div class="nav-wrapper white">
                <ul id="nav-mobile" class="centered-nav nav-status hide-on-med-and-down black-text">
                    <li><a style="color: #2196F3;"><span class="material-icons">cloud</span> Good</a></li>
                    <li><a style="color: #FFEB3B;"><span class="material-icons">cloud</span> Moderate</a></li>
                    <li><a style="color: #FF9800;"><span class="material-icons">cloud</span> Unhealthy for Sensitive Groups</a></li>
                    <li><a style="color: #f44336;"><span class="material-icons">cloud</span> Unhealthy</a></li>
                    <li><a style="color: #9C27B0;"><span class="material-icons">cloud</span> Very Unhealthy</a></li>
                    <li><a style="color: #b71c1c;"><span class="material-icons">cloud</span> Hazardous</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="map-container">

        <div class="card float-card">
            <div class="card-content black-text">
                <div class="row">
                    <div id="AQIStat" class="col s12 m4">
                        <span class="center-align"><h3>12345</h3></span>
                    </div>
                    <div class="col s12 m8">
                        <div class="row">
                            <div id="ZoneName" class="col s12">
                                <span class="card-title"><b>Zone Name</b></span>
                            </div>
                            <div id="AQIStat_txt" class="col s12">
                                <span>AQI Status</span>
                            </div>
                            <div id="timeUpdated" class="col s12">
                                <span>DateToday TimeToday</span>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="carousel carousel-slider">
                            <div class="carousel-item black-text" href="#one!">
                                <table>
                                    <thead>
                                    <tr>
                                        <th data-field="id">Current</th>
                                        <th data-field="name">Min</th>
                                        <th data-field="price">Max</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>Alvin</td>
                                        <td>Eclair</td>
                                        <td>$0.87</td>
                                    </tr>
                                    <tr>
                                        <td>Alan</td>
                                        <td>Jellybean</td>
                                        <td>$3.76</td>
                                    </tr>
                                    <tr>
                                        <td>Jonathan</td>
                                        <td>Lollipop</td>
                                        <td>$7.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="carousel-item black-text-text" href="#two!">
                                <div class="row">
                                    <div class="col s12 m12">
                                        <p><h5>Synthesis</h5></p>
                                    </div>
                                    <div class="col s12 m12">
                                        <p>The burning of fossil fuels to power industries and vehicles is a major cause of pollution.
                                            Generating electrical power through thermal power stations releases huge amounts of carbon dioxide into the atmosphere.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="center-align">
                    <a id ="prevItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_left</i></a>
                    <a id ="nextItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_right</i></a>
                </div>
            </div>
            <div id="plotOption">
                <div class="divider"></div>
                    <div class="card-action">
                        <a href="#">AQI Plot</a>
                        <a href="#">Concentration Plot</a>
                    </div>
            </div>
            
        </div>

        <div id="googleMap"></div>
    </div>
</div>


<!--  Scripts-->
<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/init.js"></script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="../js/caqms-api.js"></script>
</body>
</html>

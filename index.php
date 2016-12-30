<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring System</title>
    <link rel="icon" href="/res/favicon.ico" type="image/x-icon"/>

    <?php

    include("include/Map.php");
    ?>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">

    <meta property="og:url"                content="http://aqms.mcl-ccis.net/" />
    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="Air Quality Monitoring System" />
    <meta property="og:description"        content="The Air Quality Monitoring System (AQMS) promotes Air Pollution awareness and provides a unified Air Quality information for the municipality of Carmona. " />
    <meta property="og:image"              content="http://aqms.mcl-ccis.net/res/facebook_og.jpg" />
</head>

<body>


<?php include('include/header.php'); ?>

<div id="content-holder">
    <?php
    $data = "";
    if(isset($_GET["area"]))
    {
        $data = $_GET["area"];
    }
    ?>
    <div id="home">
        <div id="googleMap" class="hide-on-med-and-down"></div>
        <div class="container">

            <div id="zoneStatus" class="card float-card" hidden>
                <div class="card-content black-text">
                    <div class="row">
                        <div class="col s12 m4">
                            <div class="center-align">
                                <p><span class="material-icons" style="font-size: 5em;" id="AQIStat">cloud</span></p>
                                <p style="font-weight: bold; font-size: 1.5em;">AQI: <span id="aqiNum"></span></p>
                            </div>
                        </div>
                        <div  >
                            <div class="col s12 m7">
                                <div class="row-no-after left-align-on-med-and-up center-align">
                                    <div class="col s12">
                                        <p style="font-weight: bold; font-size: 1.5em;" id="aqiText">AQI Status</p>
                                        <span style="font-size: x-large"><b class="teal-text" id="zoneName">Zone Name</b></span>
                                    </div>
                                    <div id="AQIStat_txt" class="col s12">
                                        <b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">Prevalent Air Pollutant</span>
                                    </div>
                                    <div class="col s12">
                                        <b>Recorded on: </b>  <span id="timeUpdated">DateToday TimeToday</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col s12 m12">
                            <div class="hide-on-med-and-up center">
                                <p class="orange-text center">Touch and Swipe for more info.</p>
                                <br>
                            </div>
                            <div class="scroll">
                                <table>
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Current</th>
                                        <th></th>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    function getAreaStatus($area_data)
                                    {
                                        $untilValue = $area_data->aqi_values;

                                        if (count($area_data->AllDayValues_array) != 0) {
                                            for ($x = 0; $x < count($untilValue); $x++) {
                                                $maxValue = 0;

                                                switch ($x) {
                                                    case 0:
                                                        $maxValue = $area_data->co_max;
                                                        break;

                                                    case 1:
                                                        $maxValue = $area_data->so2_max;
                                                        break;

                                                    case 2:
                                                        $maxValue = $area_data->no2_max;
                                                        break;

                                                    case 3:
                                                        $maxValue = $area_data->o3_max;
                                                        break;

                                                    case 4:
                                                        $maxValue = $area_data->pm10_max;
                                                        break;

                                                    case 5:
                                                        $maxValue = $area_data->tsp_max;
                                                        break;
                                                }

                                                if ($maxValue > -1) {
                                                    $elementName = "e_symbol_" . ($x + 1);
                                                    $conentrationName = "concentration_value_" . ($x + 1);
                                                    $chartName = "chart_div_" . ($x + 1);
                                                    $elementNameMin = "aqi_min_" . ($x + 1);
                                                    $elementNameMax = "aqi_max_" . ($x + 1);

                                                    echo "<tr>";
                                                    echo "<td class='elementName' id='$elementName'>NaN</td>";
                                                    echo "<td class='elementCurrent' id='$conentrationName'>NaN</td>";
                                                    echo "<td><div class='chart'><canvas id='$chartName'></canvas></div></td>";
                                                    echo "<td class='elementMin' id='$elementNameMin'>NaN</td>";
                                                    echo "<td class='elementMax' id='$elementNameMax'>NaN</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                    }

                                    if(isset($_GET["area"]))
                                    {
                                        $data = $_GET["area"];
                                        $untilValue = array();

                                        if($data == "SLEX") {
                                            getAreaStatus($slex);
                                        }

                                        else if($data == "Bancal") {
                                            getAreaStatus($bancal);
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div id="plotOption" class="center-align">
                        <div class="divider"></div>
                        <form action="daily.php" style="height: 100%;">
                            <a class="waves-effect orange-text btn-flat" href="daily.php?area=<?php echo "$data"?>" style="width:100%">VIEW MORE</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>



    </div>

    <div class="hide-on-med-and-up container">

        <div class="row center card">
            <div class="col s12 card-content">
                <div>
                    <a href="index.php?area=SLEX"><img class="img-circle img-small" src="res/images/area/slex_carmona-exit.jpg" alt="SLEX"></a>
                </div>
            </div>
            <div class="col s12">
                <h4>SLEX - Carmona, Exit</h4>
            </div>
        </div>

        <div class="row center card">
            <div class="col s12 card-content">
                <div>
                    <a href="index.php?area=Bancal"><img class="img-circle img-small" src="res/images/area/bancal.jpg" alt="Bancal"></a>
                </div>
            </div>
            <div class="col s12">
                <h4>Bancal</h4>
            </div>
        </div>

    </div>


</div>


<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="js/caqms-api.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<!--<script src="js/chart.js"></script>-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

</body>
</html>

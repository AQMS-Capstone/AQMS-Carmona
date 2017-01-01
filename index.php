<?php
define("PAGE_TITLE", "Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>

<div id="content-holder">
    <?php
    $data = "";
    if (isset($_GET["area"])) {
        $data = $_GET["area"];
    }
    ?>
    <div id="home">
        <div id="googleMap"></div>
        <div class="container">

            <div id="zoneStatus" class="card float-card">
                <div class="card-content black-text">
                    <div class="row">
                        <div class="col s12 m4">
                            <div class="center-align">
                                <p><span class="material-icons" style="font-size: 5em;" id="AQIStat">cloud</span></p>
                                <p style="font-weight: bold; font-size: 1.5em;">AQI: <span id="aqiNum"></span></p>
                            </div>
                        </div>
                        <div>
                            <div class="col s12 m7">
                                <div class="row-no-after left-align-on-med-and-up center-align">
                                    <div class="col s12">
                                        <p style="font-weight: bold; font-size: 1.5em;" id="aqiText">AQI Status</p>
                                        <span style="font-size: x-large"><b class="teal-text"
                                                                            id="zoneName">Zone Name</b></span>
                                    </div>
                                    <div id="AQIStat_txt" class="col s12">
                                        <b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">Prevalent Air Pollutant</span>
                                    </div>
                                    <div class="col s12">
                                        <b>Recorded on: </b> <span id="timeUpdated">DateToday TimeToday</span>
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
                            <div style="min-height: 150px">
                                <!--Synthesis-->
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#synthesis">Sensitive Groups</a></li>
                                    <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>
                                    <li class="tab col s3"><a href="#cautionary">Cautionary</a></li>
                                </ul>
                                <div class="divider"></div>
                                <br>

                                <div id="synthesis" class="col s12"> </div>
                                <div id="health-effects" class="col s12"> </div>
                                <div id="cautionary" class="col s12"> </div>

                                <br>
                            </div>
                            <div>
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

//                                                echo "<tr>";
//                                                echo "<td class='elementName' id='$elementName'>NaN</td>";
//                                                echo "<td class='elementCurrent' id='$conentrationName'>NaN</td>";
                                                echo "<div class='chart'><canvas id='$chartName'></canvas></div>";
//                                                echo "<td class='elementMin' id='$elementNameMin'>NaN</td>";
//                                                echo "<td class='elementMax' id='$elementNameMax'>NaN</td>";
//                                                echo "</tr>";
                                            }
                                        }
                                    }
                                }

                                if (isset($_GET["area"])) {
                                    $data = $_GET["area"];
                                    $untilValue = array();

                                    if ($data == "SLEX") {
                                        getAreaStatus($slex);
                                    } else if ($data == "Bancal") {
                                        getAreaStatus($bancal);
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


    </div>

    <div class="hide-on-med-and-up container">

        <div class="row center card">
            <div class="col s12 card-content">
                <div>
                    <a href="index.php?area=SLEX"><img class="img-circle img-small"
                                                       src="res/images/area/slex_carmona-exit.jpg" alt="SLEX"></a>
                </div>
            </div>
            <div class="col s12">
                <h4>SLEX - Carmona, Exit</h4>
            </div>
        </div>

        <div class="row center card">
            <div class="col s12 card-content">
                <div>
                    <a href="index.php?area=Bancal"><img class="img-circle img-small" src="res/images/area/bancal.jpg"
                                                         alt="Bancal"></a>
                </div>
            </div>
            <div class="col s12">
                <h4>Bancal</h4>
            </div>
        </div>

    </div>


</div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/materialize.js"></script>
<script src="js/caqms-api.js"></script>
<script src="js/aqi-calculator.js"></script>
<script src="js/init.js"></script>
</body>
</html>

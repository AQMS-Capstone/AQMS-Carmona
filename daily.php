<?php

define('WEB_TITLE', 'Daily - Air Quality Monitoring System');
include("include/Map.php");
include('include/header.php');
?>

<div id="content-holder">
    <br>
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s12 l4">
                    <div class="card" style="min-height: 591px;">
                        <div class="card-image">
                            <img id="zoneImg" src="res/images/area/slex_carmona-exit.jpg">
                        </div>
                        <div class="card-content">
                            <h5 class="teal-text"><b id="zoneName">Zone Name</b></h5>

                            <p><b>Prevalent Air Pollutant: </b> <p id="prevalentPollutant">NaN</p></p>
                            <p><b>AQI: </b><span id="aqiNum">NaN</span></p>
                            <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>
                        </div>
                        <div class="center bottom">
                            <div class="divider"></div>
                            <br>
                            <a id ="prevArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                            <a id ="nextArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="col s12 l8">
                    <div class="row-no-after">
                        <div class="card" style="min-height: 288px;">

                            <div id="AQIStat" class="center" style="padding: 15px;">
                                <h5><b id="aqiText">NaN</b></h5>
                            </div>

                            <div class="card-content">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#synthesis">Sensitive Groups</a></li>
                                    <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>
                                    <li class="tab col s3"><a href="#cautionary">Cautionary</a></li>
                                </ul>
                                <br>

                                <div id="synthesis" class="col s12"> </div>
                                <div id="health-effects" class="col s12"> </div>
                                <div id="cautionary" class="col s12"> </div>

                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="row-no-after">
                        <div class="card" style="min-height: 288px;">
                            <div class="card-content">
                                <div class="hide-on-med-and-up">
                                    <p class="orange-text center">Touch and Swipe for more info.</p>
                                    <br>
                                </div>
                                <div class="scroll" style="height:250px;">
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
                                    function getAreaStatus2($area_data)
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
                                                    echo "<td include='elementName' id='$elementName'>NaN</td>";
                                                    echo "<td include='elementCurrent' id='$conentrationName'>NaN</td>";
                                                    echo "<td><div include='chart'><canvas id='$chartName'></canvas></div></td>";
                                                    echo "<td include='elementMin' id='$elementNameMin'>NaN</td>";
                                                    echo "<td include='elementMax' id='$elementNameMax'>NaN</td>";
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
                                            getAreaStatus2($slex);
                                        }

                                        else if($data == "Bancal") {
                                            getAreaStatus2($bancal);
                                        }
                                    }else{
                                        getAreaStatus2($bancal);
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php  include('include/footer.php'); ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/daily.js"></script>
<script src="js/aqi-calculator.js"></script>
</body>
</html>

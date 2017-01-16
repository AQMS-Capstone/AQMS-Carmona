<?php
define("PAGE_TITLE", "Daily - Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>

<div id="content-holder">

    <div id="googleMap" class="map-daily"></div>

    <div class="section no-pad-bot" style="margin-top: 300px;">
        <div class="container">
            <div class="row row-no-after">
                <div class="col s12">
                    <div class="card">
                        <div id="aqiColor" class="col s12 center">
                            <p style="font-size: 2em; margin: 15px;" class="white-text"><b id="aqiText">NaN</b></p>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 center">
                                    <br>
                                    <p style="font-weight: bold; font-size: 2em;">AQI: <span id="aqiNum"></span ></p>
                                    <p class="card-title teal-text" style="font-weight: bold" id="zoneName">Zone Name</p>
                                    <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                                    <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>
                                </div>
                            </div>


                        </div>
                        <div class="card-action center">
                            <a id ="prevArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                            <a id ="nextArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-no-after">
                <div class="col s3">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s9">
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                                <div class="col s2">
                                    <div id="js-legend" class="chart-legend"></div>
                                </div>
                            </div>
                            <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Current
                                    Distribution</b>
                        </div>
                    </div>
                </div>
                <div class="col s9">
                    <div class="card" style="min-height: 215px;">
                        <div class="card-content">
                            <div style="width: 100%; height: 150px;">
                                <canvas id="barChart"></canvas>
                            </div>

                            <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Rolling 24 hrs
                                    Distribution</b>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row row-no-after">
                <div class="col s12">
                    <div class="card" style="height: 215px;">
                        <div class="card-content">
                            <ul class="tabs">
<!--                                <li class="tab col s3"><a href="#synthesis">Sensitive Groups</a></li>-->
<!--                                <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>-->
                                <li class="tab col s3"><a href="#cautionary">Cautionary Statement</a></li>
                            </ul>
                            <br>

<!--                            <div id="synthesis" class="col s12"> </div>-->
<!--                            <div id="health-effects" class="col s12"> </div>-->
                            <div id="cautionary" class="col s12"> </div>

                            <br>
                        </div>
                    </div>
                </div>

            </div>
            <?php
                function getAreaStatus2($area_data)
                {
                    $untilValue = $area_data->aqi_values;

                    $ind = $area_data->prevalentIndex[0];

                    $elementName = "e_symbol_" . ($ind + 1);
                    $conentrationName = "concentration_value_" . ($ind + 1);
                    $chartName = "chart_div_" . ($ind + 1);
                    $elementNameMin = "aqi_min_" . ($ind + 1);
                    $elementNameMax = "aqi_max_" . ($ind + 1);

                    $value = $area_data->aqi_values[$ind];

                    echo "<div class='row'>
                        <div class='col s12'>
                            <ul class='collapsible' data-collapsible='accordion'>
                                <li data-click-accordion = '' data-prevValue = '$value' data-prevIndex = '$ind'>
                                    <div class='collapsible-header active'>
                                        <div class='row-no-after'>
                                            <div class='col s5'>
                                                <i class='material-icons'>settings_input_svideo</i>
                                                <b id = '$elementName'>Prevalent Element Name Here</b>
                                            </div>
                                            <div class='col s7 right-align'>
                                                <div style='font-weight: bold'>
                                                    <span class='teal-text' id = '$conentrationName'>Current: 00</span> | <span
                                                            class='blue-text' id = '$elementNameMin'>Min: 00</span> | <span class='red-text' id = '$elementNameMax'>Max: 00</span>
                                                </div>
                    
                                            </div>
                                        </div>
                    
                                    </div>
                                    <div class='collapsible-body'>
                                        <div class='chart'><canvas id='$chartName'></canvas></div>
                                    </div>
                                </li>";

                    //if (count($area_data->AllDayValues_array) != 0) {
                        for ($x = 0; $x < count($untilValue); $x++) {
                            $found = false;

                            if ($x != $ind) {
                                switch ($x) {
                                    case 0:
                                        $found = true;
                                        break;

                                    case 1:
                                        $found = true;
                                        break;

                                    case 2:
                                        $found = true;
                                        break;

//                                case 3:
//                                    $maxValue = $area_data->o3_max;
//                                    break;
//
//                                case 4:
//                                    $maxValue = $area_data->pm10_max;
//                                    break;
//
//                                case 5:
//                                    $maxValue = $area_data->tsp_max;
//                                    break;
                                }

                                if ($found) {
                                    $elementName = "e_symbol_" . ($x + 1);
                                    $conentrationName = "concentration_value_" . ($x + 1);
                                    $chartName = "chart_div_" . ($x + 1);
                                    $elementNameMin = "aqi_min_" . ($x + 1);
                                    $elementNameMax = "aqi_max_" . ($x + 1);

                                    $value = $area_data->aqi_values[$x];

                                    echo "<li data-click-accordion = '' data-prevValue = '$value' data-prevIndex = '$x'>
                                    <div class='collapsible-header'>
                                        <div class='row-no-after'>
                                            <div class='col s5'>
                                                <i class='material-icons'>settings_input_svideo</i>
                                                <b id = '$elementName'></b>
                                            </div>
                                            <div class='col s7 right-align'>
                                                <div style='font-weight: bold'>
                                                    <span class='teal-text' id = '$conentrationName'>Current: 00</span> | <span
                                                            class='blue-text' id = '$elementNameMin'>Min: 00</span> | <span class='red-text' id = '$elementNameMax'>Max: 00</span>
                                                </div>
                    
                                            </div>
                                        </div>
                    
                                    </div>
                                    <div class='collapsible-body'>
                                    
                                        <div class='chart'><canvas id='$chartName'></canvas></div>
                                    </div>
                                </li>
                                </li>";
                                }
                            }
                        }
                    //}

                    echo "
                            </ul>
                        </div>
                    </div>
                    ";
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
        </div>

    </div>
</div>
</div>
<?php include('include/footer.php'); ?>
<!--Additional Scripts-->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="js/caqms-daily-api.js"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/daily-graph.js"></script>
<script src="js/daily.js"></script>
<script src="js/aqi-calculator.js"></script>
</body>
</html>

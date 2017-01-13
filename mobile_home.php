<?php
define("PAGE_TITLE", "Mobile Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>
<?php
$data = "";
if (isset($_GET["area"])) {
    $data = $_GET["area"];
}
?>
<div id="content-holder">
<div class="container">
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-image">
                    <img  id="zoneImg" class="img-circle" src="res/images/area/slex_carmona-exit.jpg"">
                    <span class="card-title teal-text" style="font-weight: bold" id="zoneName">Zone Name</span>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col s3 center">
                            <p><span class="material-icons" style="font-size: 4em;" id="AQIStat">cloud</span></p>
                            <p style="font-weight: bold; font-size: 1em;">AQI: <span id="aqiNum"></span ></p>
                        </div>
                        <div class="col s9">
                            <p style="font-size: 1.5em"><b id="aqiText">NaN</b></p>
                        </div>
                    </div>
                    <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                    <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>

                </div>
                <div class="card-action center">
                    <a id ="prevArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                    <a id ="nextArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
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

                                    echo "<div class='chart'><canvas id='$chartName'></canvas></div>";
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
                    <div class="card-action center">
                        <a>VIEW MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5 class="teal-text" style="margin-top: 0;"><b>Sensitive Groups</b></h5>
                    <div class="divider"></div>
                    <br>
                    <div id="synthesis"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5 class="teal-text" style="margin-top: 0;"><b>Health Effects</b></h5>
                    <div class="divider"></div>
                    <br>
                    <div id="health-effects"> </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row row-no-after">
       <div class="col s12">
           <div class="card">
               <div class="card-content">
                   <h5 class="teal-text" style="margin-top: 0;"><b>Cautionary</b></h5>
                   <div class="divider"></div>
                   <br>
                   <div id="cautionary"> </div>
               </div>
           </div>
       </div>
   </div>

</div>
</div>

<?php include('include/footer.php'); ?>
<!--Additional Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/mobile.js"></script>
<script src="js/materialize.js"></script>
<script src="js/caqms-api.js"></script>
<script src="js/aqi-calculator.js"></script>
<script src="js/init.js"></script>
</body>
</html>

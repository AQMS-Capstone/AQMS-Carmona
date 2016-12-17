<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 10/26/2016
 * Time: 8:34 PM
 */

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
                                                echo "<td><div id='$chartName'></div></td>";
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


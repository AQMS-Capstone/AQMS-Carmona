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
    <div id="googleMap"></div>
    <div id="zoneStatus" class="card float-card">
        <div class="card-content black-text">
            <div class="row">
                <div id="AQIStat" class="col s12 m4">
                    <span class="center-align">
                        <h6 class="margin-5">AQI</h6>
                        <h2 class="margin-5" id="aqiNum">12345</h2>
                    </span>
                </div>
                <div class="center-align">
                    <div class="col s12 m8">
                        <div class="row-no-after">
                            <div class="col s12">
                                <h5 class="margin-5" style="font-weight: bold;" id="aqiText">AQI Status</h5>
                                <span class="card-title"><b id="zoneName">Zone Name</b></span>
                            </div>
                            <div id="AQIStat_txt" class="col s12">
                                <b>Prevalant Air Pollutant: </b> <span id="prevalentPollutant">Prevalant Air Pollutant</span>
                            </div>
                            <div class="col s12">
                              <b>Time updated: </b>  <span id="timeUpdated">DateToday TimeToday</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col s12 m12">
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

                            if(isset($_GET["area"]))
                            {
                                $data = $_GET["area"];
                                $untilValue = array();

                                if($data == "SLEX")
                                {
                                    //$untilValue = count($bancal_aqi_values);
                                    //$untilValue = count($bancal_aqi_values);

                                    $untilValue = $bancal_aqi_values;
                                }

                                else if($data == "Bancal")
                                {
                                    //$untilValue = count($bancal_aqi_values);
                                    //$untilValue = count($bancal_aqi_values);

                                    $untilValue = $bancal_aqi_values;
                                }

                                //echo $bancal_prevalentIndex[0];

                                if(count($bancalAllDayValues_array) != 0)
                                //if($bancal_aqi_values[$bancal_prevalentIndex[0]] != -1 && count($bancalAllDayValues_array) != 0)
                                {
                                  //for ($x = 0; $x < 1; $x++) {
                                  for ($x = 0; $x < count($untilValue); $x++) {
                                  //for ($x = 0; $x < 2; $x++) {
                                    //if($untilValue[$x] > -1)
                                    //{
                                      $maxValue = 0;

                                      switch($x)
                                      {
                                        case 0:
                                            $maxValue = $bancal_co_max;
                                        break;

                                        case 1:
                                            $maxValue = $bancal_so2_max;
                                        break;

                                        case 2:
                                            $maxValue = $bancal_no2_max;
                                        break;

                                        case 3:
                                            $maxValue = $bancal_o3_max;
                                        break;

                                        case 4:
                                            $maxValue = $bancal_pm10_max;
                                        break;
                                      }

                                      if($maxValue > -1)
                                      {
                                        $elementName = "e_symbol_".($x+1);
                                        $conentrationName = "concentration_value_".($x+1);
                                        $chartName = "chart_div_".($x+1);
                                        $elementNameMin = "aqi_min_".($x+1);
                                        $elementNameMax = "aqi_max_".($x+1);

                                        echo "<tr>";
                                        echo "<td class='elementName' id='$elementName'>NaN</td>";
                                        echo "<td class='elementCurrent' id='$conentrationName'>NaN</td>";
                                        echo "<td><div id='$chartName'></div></td>";
                                        echo "<td class='elementMin' id='$elementNameMin'>NaN</td>";
                                        echo "<td class='elementMax' id='$elementNameMax'>NaN</td>";
                                        echo "</tr>";
                                      }
                                    //}
                                  }
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
                    <form action="daily.php">
                        <button class="waves-effect orange-text btn-flat" type="submit" name="e_id" value="element-to-be-submitted">VIEW MORE</button>
                    </form>
                </div>
            </div>

        </div>


    </div>

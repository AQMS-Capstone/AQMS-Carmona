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
                                <span class="card-title"><b class="teal-text" id="zoneName">Zone Name</b></span>
                            </div>
                            <div id="AQIStat_txt" class="col s12">
                                <b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">Prevalent Air Pollutant</span>
                            </div>
                            <div class="col s12">
                              <b>Last updated: </b>  <span id="timeUpdated">DateToday TimeToday</span>
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

                                    $untilValue = $slex_aqi_values;

                                    if(count($slexAllDayValues_array) != 0)
                                //if($slex_aqi_values[$slex_prevalentIndex[0]] != -1 && count($slexAllDayValues_array) != 0)
                                {
                                  //for ($x = 0; $x < 1; $x++) {
                                  for ($x = 0; $x < count($untilValue); $x++)
                                  {
                                  //for ($x = 0; $x < 2; $x++) {
                                    //if($untilValue[$x] > -1)
                                    //{
                                      $maxValue = 0;

                                      switch($x)
                                      {
                                        case 0:
                                            $maxValue = $slex_co_max;
                                        break;

                                        case 1:
                                            $maxValue = $slex_so2_max;
                                        break;

                                        case 2:
                                            $maxValue = $slex_no2_max;
                                        break;

                                        case 3:
                                            $maxValue = $slex_o3_max;
                                        break;

                                        case 4:
                                            $maxValue = $slex_pm10_max;
                                        break;

                                        case 5:
                                            $maxValue = $slex_tsp_max;
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

                                else if($data == "Bancal")
                                {
                                    //$untilValue = count($bancal_aqi_values);
                                    //$untilValue = count($bancal_aqi_values);

                                    $untilValue = $bancal_aqi_values;

                                    if(count($bancalAllDayValues_array) != 0)
                                    //if($bancal_aqi_values[$bancal_prevalentIndex[0]] != -1 && count($bancalAllDayValues_array) != 0)
                                    {
                                      //for ($x = 0; $x < 1; $x++) {
                                      for ($x = 0; $x < count($untilValue); $x++)
                                      {
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

                                            case 5:
                                                $maxValue = $bancal_tsp_max;
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

                                //echo $bancal_prevalentIndex[0];


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
                        <a class="waves-effect orange-text btn-flat" href="daily.php?area=<?php echo "$data"?>" style="width:100%">VIEW MORE</a>
                    </form>
                </div>
            </div>

        </div>


    </div>

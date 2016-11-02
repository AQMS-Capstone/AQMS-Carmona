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

    <div id="zoneStatus" class="card float-card">
        <div class="card-content black-text">
            <div class="row">
                <div id="AQIStat" class="col s12 m4">
                    <span class="center-align">
                        <h6 class="margin-5">AQI</h6>
                        <h2 class="margin-5" id="aqiNum">12345</h2>
                        <h5 class="margin-5" id="aqiText">AQI Status</h5>
                    </span>
                </div>
                <div class="center-align">
                <div class="col s12 m8">
                    <div class="row-no-after">
                        <div class="col s12">
                            <span class="card-title"><b id="zoneName">Zone Name</b></span>
                        </div>
                        <div id="AQIStat_txt" class="col s12">
                           <b>Prevalant Air Pollutant: </b> <span id="prevalentPollutant">Prevalant Air Pollutant</span>
                        </div>
                        <div class="col s12">
                            <span id="timeUpdated">DateToday TimeToday</span>
                        </div>
                    </div>
                </div>
                </div>

            </div>

            <div class="row">
                    <div class="col s12 m12">
                        <div class="carousel carousel-slider">

                             <div class="carousel-item black-text" href="#one!">
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
                                            $untilValue = 0;

                                            if($data == "SLEX")
                                            {
                                                $untilValue = count($slexValues);
                                            }

                                            else if($data == "Bancal")
                                            {
                                                $untilValue = count($bancalValues);
                                            }

                                            for ($x = 0; $x < $untilValue; $x++) {
                                              $elementName = "e_symbol_".($x+1);
                                              $conentrationName = "concentration_value_".($x+1);

                                              echo "<tr>";
                                                echo "<td class='elementName' id='$elementName'>NaN</td>";
                                                echo "<td class='elementCurrent' id='$conentrationName'>NaN</td>";
                                                echo "<td><div id='chart1_div'></div></td>";
                                                echo "<td class='elementMin'>NaN</td>";
                                                echo "<td class='elementMax'>NaN</td>";
                                              echo "</tr>";
                                            }
                                      }
                                      ?>
                                    <!--
                                    <tr>
                                        <td class="elementName" id="e_symbol_1">CO</td>
                                        <td class="elementCurrent" id="concentration_value_1">NaN</td>
                                        <td><div id="chart1_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_2">SO2</td>
                                        <td class="elementCurrent" id="concentration_value_2">NaN</td>
                                        <td><div id="chart2_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_3">NO2</td>
                                        <td class="elementCurrent" id="concentration_value_3">NaN</td>
                                        <td><div id="chart3_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_4">O3</td>
                                        <td class="elementCurrent" id="concentration_value_4">NaN</td>
                                        <td><div id="chart#_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_5">Pb</td>
                                        <td class="elementCurrent" id="concentration_value_5">NaN</td>
                                        <td><div id="chart#_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_6">PM 10</td>
                                        <td class="elementCurrent" id="concentration_value_6">NaN</td>
                                        <td><div id="chart#_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                    <tr>
                                        <td class="elementName" id="e_symbol_7">TSP</td>
                                        <td class="elementCurrent" id="concentration_value_7">NaN</td>
                                        <td><div id="chart#_div"></div></td>
                                        <td class="elementMin">NaN</td>
                                        <td class="elementMax">NaN</td>
                                    </tr>
                                  -->
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <!--
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
                          -->
                    </div>
                </div>

            </div>

            <!--
            <div class="center-align">
                <a id ="prevItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_left</i></a>
                <a id ="nextItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_right</i></a>
            </div>
          -->
        </div>
        <div id="plotOption" class="center-align">
            <div class="divider"></div>
            <div class="card-action">
                <a href="daily.php">VIEW MORE</a>
            </div>
        </div>

    </div>

    <div id="googleMap"></div>
</div>

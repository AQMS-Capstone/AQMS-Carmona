<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 10/26/2016
 * Time: 8:56 PM
 */
?>

<div id="reports" xmlns="http://www.w3.org/1999/html">

    <div id="index-banner" class="parallax-container" style="height: 350px;">
        <div class="section no-pad-bot">
            <div class="container">
                <br><br>
                <h1 class="header center teal-text text-lighten-2">Air Quality Monitoring System</h1>
                <div class="row center">
                    <h5 class="header white-text col s12 light">Be a part of the solution, not part of the pollution. Know the air that you are breathing.</h5>
                </div>
            </div>


            <div class="row center">
                <a href="#goto-reports"class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
            </div>
            <br><br>
        </div>
        <div class="parallax parallax-css"><img src="res/images/map.jpg"></div>
    </div>

    <div class="white">
        <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>
                        <h5 class="center">Speeds up development</h5>

                        <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">group</i></h2>
                        <h5 class="center">User Experience Focused</h5>

                        <p class="light">By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.</p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">settings</i></h2>
                        <h5 class="center">Easy to work with</h5>

                        <p class="light">We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="goto-reports" class="section no-pad-bot">
        </br>
            <div class="row">

                <form class="col s6 offset-s3">
                    <div class="title"><h3>Generate Reports</h3></div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select>
                                <option value="" disabled selected>Choose an Area</option>
                                <option value="1">SLEX - Carmona Exit</option>
                                <option value="2">Bancal</option>
                            </select>
                            <label>Area</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select multiple>
                                <option value="" disabled selected>Choose a pollutant</option>
                                <option value="1">PSI</option>
                                <option value="2">PM2.5</option>
                                <option value="4">PM10</option>
                                <option value="5">O3</option>
                                <option value="6">NO2</option>
                                <option value="7">SO2</option>
                                <option value="8">CO</option>
                            </select>
                            <label>Pollutant</label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="input-field col s4">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Year</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Month</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Day</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn">Generate</a>
                        </div>
                    </div>

                </form>
            </div>

    </div>
        <div class="section white no-pad-bot">
            <div class="container">
                <div class="row">
                    <div class="col s6">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">

                                    <div class="col s12">
                                        <b id="zoneName" style="font-size: 50px">Zone Name</b>
                                        </br>
                                        <b>Generated on: </b><span id="timeUpdated">DateToday TimeToday</span>
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
                                                        <tr>
                                                            <td class="elementName">PSI</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart1_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">PM2.5</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart2_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">PM10</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart3_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">O3</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart#_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">NO2</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart#_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">SO2</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart#_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="elementName">CO</td>
                                                            <td class="elementCurrent">55</td>
                                                            <td><div id="chart#_div"></div></td>
                                                            <td class="elementMin">55</td>
                                                            <td class="elementMax">60</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
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
                            </div>
                        </div>
                    </div>

                    <div class="col s6">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">

                                    <div class="col s12">
                                        <b style="font-size: 32px">Synthesis</b>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div

        <?php  include('footer.php'); ?>

</div>

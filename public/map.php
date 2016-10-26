<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 10/26/2016
 * Time: 8:34 PM
 */
?>
<div id="home" class="map-container">

    <div id="zoneStatus" class="card float-card">
        <div class="card-content black-text">
            <div class="row">
                <div id="AQIStat" class="col s12 m4">
                    <span class="center-align"><h2  id="aqiNum">12345</h2></span>
                </div>
                <div class="col s12 m8">
                    <div class="row-no-after">
                        <div class="col s12">
                            <span class="card-title"><b id="zoneName">Zone Name</b></span>
                        </div>
                        <div class="col s12">
                            <span id="aqiText">AQI Status</span>
                        </div>
                        <div id="AQIStat_txt" class="col s12">
                            <span>Prevalant Air Pollutant: ##</span>
                        </div>
                        <div class="col s12">
                            <span id="timeUpdated">DateToday TimeToday</span>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="carousel carousel-slider">
                        <div class="carousel-item black-text" href="#one!">
                            <table>
                                <thead>
                                <tr>
                                    <th data-field="id">Current</th>
                                    <th data-field="name">Min</th>
                                    <th data-field="price">Max</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                                </tbody>
                            </table>
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
            <div class="center-align">
                <a id ="prevItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_left</i></a>
                <a id ="nextItem" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_right</i></a>
            </div>
        </div>
        <div id="plotOption">
            <div class="divider"></div>
            <div class="card-action">
                <a href="#">AQI Plot</a>
                <a href="#">Concentration Plot</a>
            </div>
        </div>

    </div>

    <div id="googleMap"></div>
</div>



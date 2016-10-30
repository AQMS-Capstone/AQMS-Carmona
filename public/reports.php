<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 10/26/2016
 * Time: 8:56 PM
 */
?>

<div id="reports">
    <div class="row">
        
        <div class="col s5">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div id="AQIStat-reports" class="col s12">
                            <span class="center-align"><h2  id="aqiNum-reports">12345</h2></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <span class="center-align">
                                <h5 id="zoneName-reports">
                                    <a id ="prevZone-reports" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_left</i></a>
                                    <b>Zone Name</b>
                                    <a id ="nextZone-reports" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_right</i></a>
                                </h5>
                            </span>
                        </div>
                    </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
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
                    <div class="center-align">
                        <a id ="prevItem-reports" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_left</i></a>
                        <a id ="nextItem-reports" class="waves-effect waves-teal"><i class="material-icons">keyboard_arrow_right</i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s7">
            <div class="row">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s4"><a class ="active" href="#test1">Sensitive Groups</a></li>
                                    <li class="tab col s4"><a href="#test2">Health Effects Statements</a></li>
                                    <li class="tab col s4"><a href="#test3">Cautionary Statements</a></li>
                                </ul>
                                <div class="divider"></div>
                                <br>
                            </div>

                            <div id="test1" class="col s12">
                                People with respiratory or heart disease, the elderly and children are the groups most at risk.
                            </div>
                            <div id="test2" class="col s12">
                                Increasing likelihood of respiratory symptoms in sensitive individuals, aggravation of heart or lung disease and premature mortality in persons with cardiopulmonary disease and the elderly.
                            </div>
                            <div id="test3" class="col s12">
                                People with cardiovascular disease, such as angina, should avoid exertion and sources of CO, such as heavy traffic; everyone else should limit heavy exertion.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col s12">
                                    <select multiple>
                                        <option value="" disabled selected>Pollutant</option>
                                        <option value="1">CO2</option>
                                        <option value="2">NO2</option>
                                        <option value="3">O3</option>
                                    </select>
                                    <label>Select a Pollutant</label>
                                </div>

                                <div class="input-field col s12">
                                    <select multiple>
                                        <option value="" disabled selected>Area</option>
                                        <option value="1">Bancal</option>
                                        <option value="2">SLEX</option>
                                    </select>
                                    <label>Select an Area</label>
                                </div>

                                <div class="col s12">
                                    <a class="waves-effect waves-light btn">Get Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

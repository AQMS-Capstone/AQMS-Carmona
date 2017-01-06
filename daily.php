<?php
define("PAGE_TITLE", "Daily - Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>


<div id="content-holder">

    <br>
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row row-no-after">
                <div class="col s3">
                    <div class="card" style="min-height: 260px;">
                        <div class="card-content">
                            <img id="zoneImg" class="img-circle" src="res/images/area/slex_carmona-exit.jpg"
                                 height="150">
                            <br>
                            <div class="center">
                                <a id ="prevArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                                <a id ="nextArea" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                            </div>
                            <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Zone Name</b></h6>
                        </div>
                    </div>

                </div>
                <div class="col s9">
                    <div class="card" style="min-height: 260px;">
                        <div class="card-content">
                            <div class="center-align">
                                <p class="material-icons" style="font-size: 6em;margin-bottom: 0;margin-top: 0;"
                                   id="AQIStat">
                                    cloud</p>
                                <p style="font-size: 1.5em;margin-top: 0;"><b>AQI: </b><span id="aqiNum">NaN</span></p>
                                <p style="font-size: 2em"><b id="aqiText">NaN</b></p>
                                <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                                <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>
                            </div>
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
                            <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Daily
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

                            <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">24 hrs
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
                                <li class="tab col s3"><a href="#synthesis">Sensitive Groups</a></li>
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

            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header active">
                                <div class="row-no-after">
                                    <div class="col s5">
                                        <i class="material-icons">settings_input_svideo</i>
                                        <b>Prevalent Element Name Here</b>
                                    </div>
                                    <div class="col s7 right-align">
                                        <div style="font-weight: bold">
                                            <span class="teal-text">Current: 00</span> | <span
                                                    class="blue-text">Min: 00</span> | <span class="red-text">Max: 00</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="collapsible-body">
                                <p>
                                    Graph only here
                                </p>

                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header">
                                <div class="row-no-after">
                                    <div class="col s5">
                                        <i class="material-icons">settings_input_svideo</i>
                                        <b>Other Element Name Here</b>
                                    </div>
                                    <div class="col s7 right-align">
                                        <div style="font-weight: bold">
                                            <span class="teal-text">Current: 00</span> | <span
                                                    class="blue-text">Min: 00</span> | <span class="red-text">Max: 00</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="collapsible-body">
                                <p>
                                    Graph only here
                                </p>

                            </div>
                        </li>
                        </li>
                        <li>
                            <div class="collapsible-header">
                                <div class="row-no-after">
                                    <div class="col s5">
                                        <i class="material-icons">settings_input_svideo</i>
                                        <b>Other Element Name Here</b>
                                    </div>
                                    <div class="col s7 right-align">
                                        <div style="font-weight: bold">
                                            <span class="teal-text">Current: 00</span> | <span
                                                    class="blue-text">Min: 00</span> | <span class="red-text">Max: 00</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="collapsible-body">
                                <p>
                                    Graph only here
                                </p>

                            </div>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<?php include('include/footer.php'); ?>
<!--Additional Scripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/sample-graph.js"></script>
<script src="js/daily.js"></script>
<script src="js/aqi-calculator.js"></script>
</body>
</html>

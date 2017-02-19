<?php
define("PAGE_TITLE", "Feed - Air Quality Monitoring System");
include('include/Map.php');
?>
<?php include('include/admin-header.php'); ?>
<main>
    <div class="row row-no-after" id="statusDiv">

    </div>

    <div class="row row-no-after">

        <div class="col s12 m6">
            <div class="card z-depth-0">
                <div class="card-content">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#">Cautionary Statement</a></li>
                    </ul>
                    <br>
                    <div id="cautionary_1"> </div>
                    <br>
                </div>
            </div>
        </div>

        <div class="col s12 m6">
            <div class="card z-depth-0">
                <div class="card-content">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#">Cautionary Statement</a></li>
                    </ul>
                    <br>
                    <div id="cautionary_2"> </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-no-after">
        <div class="col s12">
            <ul class='collapsible' data-collapsible='accordion'>
                <li>
                    <div class='collapsible-header active'>
                        <div class='row-no-after'>
                            <div class='col s5'>
                                <i class='material-icons'>settings_input_svideo</i>
                                <b>Bancal 24 Rolling Graph</b>
                            </div>
                        </div>
                    </div>
                    <div class='collapsible-body'>
                        <div class="card-content">
                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph1"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Carbon Monoxide</b>
                                </div>
                            </div>

                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph2"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Sulfur Dioxide</b>
                                </div>
                            </div>

                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph3"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Nitrogen Dioxide</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
            <ul class='collapsible' data-collapsible='accordion'>
                <li>
                    <div class='collapsible-header active'>
                        <div class='row-no-after'>
                            <div class='col s5'>
                                <i class='material-icons'>settings_input_svideo</i>
                                <b>SLEX 24 Rolling Graph</b>
                            </div>
                        </div>
                    </div>
                    <div class='collapsible-body'>
                        <div class="card-content">
                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph4"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Carbon Monoxide</b>
                                </div>
                            </div>

                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph5"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Sulfur Dioxide</b>
                                </div>
                            </div>

                            <div class="card z-depth-0">
                                <div class="card-content">
                                    <div>
                                        <canvas id="graph6"></canvas>
                                    </div>

                                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Nitrogen Dioxide</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>

<!--    <div class="row row-no-after">-->
<!--        <div class="col s12 m9">-->
<!--            <div class="card z-depth-0" style="min-height: 231.55px">-->
<!--                <div class="card-content">-->
<!--                    <div style="width: 100%; height: 150px;">-->
<!--                        <canvas id="bancal_barChart"></canvas>-->
<!--                    </div>-->
<!---->
<!--                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Bancal Rolling 24 hrs-->
<!--                            Distribution</b>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col s12 m3">-->
<!--            <div class="card z-depth-0">-->
<!--                <div class="card-content">-->
<!--                    <div class="row">-->
<!--                        <div class="col s9">-->
<!--                            <canvas id="bancal_doughnutChart"></canvas>-->
<!--                        </div>-->
<!--                        <div class="col s2">-->
<!--                            <div id="js-legend_1" class="chart-legend"></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">B Current-->
<!--                            Distribution</b>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="row row-no-after">-->
<!--        <div class="col s12 m9">-->
<!--            <div class="card z-depth-0" style="min-height: 231.55px">-->
<!--                <div class="card-content">-->
<!--                    <div style="width: 100%; height: 150px;">-->
<!--                        <canvas id="slex_barChart"></canvas>-->
<!--                    </div>-->
<!---->
<!--                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">SLEX Rolling 24 hrs-->
<!--                            Distribution</b>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="col s12 m3">-->
<!--            <div class="card z-depth-0">-->
<!--                <div class="card-content">-->
<!--                    <div class="row">-->
<!--                        <div class="col s9">-->
<!--                            <canvas id="slex_doughnutChart"></canvas>-->
<!--                        </div>-->
<!--                        <div class="col s2">-->
<!--                            <div id="js-legend_2" class="chart-legend"></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">S Current-->
<!--                            Distribution</b>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="row row-no-after">
        <div class="col s12">
            <div class="divider"></div>
            <br>
        </div>
    </div>
    <div class="col s12">
        <div class="card z-depth-1">
            <div class="card-content">
                <div class="row row-no-after">
                    <div class="col s2">
                        <select id="cbxEntries">
                            <option value="" disabled selected>Show entries</option>
                            <option value = "1">5</option>
                            <option value = "2">10</option>
                            <option value = "3">25</option>
                            <option value = "4">50</option>
                            <option value = "5">100</option>
                        </select>
                    </div>
                    <div class="col s2">
                        <select id="cbxArea">
                            <option value="" disabled selected>Area</option>
                            <option value = "1">Bancal</option>
                            <option value = "2">SLEX</option>
                            <option value = "">All</option>
                        </select>
                    </div>
                    <div class="col s2">
                        <select id="cbxPollutant">
                            <option value="" disabled selected>Pollutants</option>
                            <option value = "CO">CO</option>
                            <option value = "SO2">SO2</option>
                            <option value = "NO2">NO2</option>
                            <option value = "">All</option>
                        </select>
                    </div>
                    <div class="col s2">
                        <select id="cbxSort">
                            <option value="" disabled selected>Sort by</option>
                            <option value = "1">Timestamp</option>
                            <option value = "2">Concentration Value</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll" style="height: 700px;">
        <div class="row">
            <div id="feedDiv"></div>
        </div>
    </div>

    <div id="play-sound"></div>
</main>

<?php include('include/footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/feed.js"></script>
<script>
    $( "#home-tab" ).addClass( "active" );
</script>
</body>
</html>
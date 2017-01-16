<?php
define("PAGE_TITLE", "Feed - Air Quality Monitoring System");
include('include/header_feed.php');
include('include/Map.php');
?>

<html>
<head>
    <script src = "js/jquery-3.1.1.min.js" type="text/javascript"></script>
</head>
<body>

<div id="statusDiv"></div>
<div class="container">
    <div class="row row-no-after">
        <div class="col s6">
            <div class="card" style="height: 215px;">
                <div class="card-content">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#">Cautionary Statement</a></li>
                    </ul>
                    <br>
                    <div id="cautionary_1" class="col s12"> </div>
                    <br>
                </div>
            </div>
        </div>

        <div class="col s6">
            <div class="card" style="height: 215px;">
                <div class="card-content">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#">Cautionary Statement</a></li>
                    </ul>
                    <br>
                    <div id="cautionary_2" class="col s12"> </div>
                    <br>
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
                            <canvas id="bancal_doughnutChart"></canvas>
                        </div>
                        <div class="col s2">
                            <div id="js-legend_1" class="chart-legend"></div>
                        </div>
                    </div>
                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">B Current
                            Distribution</b>
                </div>
            </div>
        </div>

        <div class="col s9">
            <div class="card" style="min-height: 215px;">
                <div class="card-content">
                    <div style="width: 100%; height: 150px;">
                        <canvas id="bancal_barChart"></canvas>
                    </div>

                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">Bancal Rolling 24 hrs
                            Distribution</b>
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
                            <canvas id="slex_doughnutChart"></canvas>
                        </div>
                        <div class="col s2">
                            <div id="js-legend_2" class="chart-legend"></div>
                        </div>
                    </div>
                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">S Current
                            Distribution</b>
                </div>
            </div>
        </div>

        <div class="col s9">
            <div class="card" style="min-height: 215px;">
                <div class="card-content">
                    <div style="width: 100%; height: 150px;">
                        <canvas id="slex_barChart"></canvas>
                    </div>

                    <h6 class="teal-text center-align" style="margin-bottom: 0;"><b id="zoneName">SLEX Rolling 24 hrs
                            Distribution</b>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <br><br>
    <div class="divider"></div>
</div>
<div class="container">
    <div class="col s12">
        <h3 class="header teal-text center-align">Input Feed</h3>
    </div>
    <div class='row row-no-after'>
        <div class="col s2">
            <select id="showEntries">
                <option value="" disabled selected>Show entries</option>
                <option value = "5">5</option>
                <option value = "10">10</option>
                <option value = "25">25</option>
                <option value = "50">50</option>
                <option value = "100">100</option>
            </select>
        </div>
        <div class="col s2">
            <select id="sortBy">
                <option value="" disabled selected>Sort by</option>
                <option value = "1">Timestamp</option>
                <option value = "2">Element</option>
                <option value = "3">Concentration Value</option>
            </select>
        </div>
    </div>
</div>
<div id="feedDiv"></div>
<div id="play-sound"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/feed.js"></script>
</body>
</html>
<?php
include('include/footer_feed.php');
?>
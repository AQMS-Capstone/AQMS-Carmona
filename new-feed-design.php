<?php
define("PAGE_TITLE", "Feed - Air Quality Monitoring System");
include('include/Map.php');
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('include/header-meta.php'); ?>
    <style>
        header, main, footer {
            padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {
            header, main, footer {
                padding-left: 0;
            }
        }
        .container{
            width: 95%!important;;
        }
    </style>

<!--    PHPStorm is having a bug displaying css intellisense so I included this when I am coding this shit.-->
<!--    Remove this comment if you want to edit css class-->
<!--    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">-->
<!--    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">-->
</head>
<body style="background-color: #f0f0f0">
<header>
    <ul id="slide-out" class="side-nav fixed">
        <li class="teal z-depth-1" ><a id="logo" href="index.php"><img alt="Brand Logo" class="center" src="res/logo.png" style="height: 45px;"> </a>
        <li><a href="index.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
        <li><a href="maintenance.php" id="home-tab"><span class="material-icons">build</span> Maintenance</a></li>
        <div class="divider"></div>
        <li><a><span class="material-icons">settings_input_svideo</span> Highest AQI: <span class="red-text">400</span></a></li>
        <li><a><span class="material-icons">settings_input_svideo</span> Lowest AQI: <span class="blue-text">00</span></a></li>
        <li><a><span class="material-icons">select_all</span> SLEX Sensor: <span class="green-text">Online</span></a></li>
        <li><a><span class="material-icons">select_all</span> Bancal Sensor: <span class="green-text">Online</span></a></li>
        <li><a><span class="material-icons">access_time</span> Server Time: <span class="black-text">00:00</span></a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse hide-on-med-and-up"><i class="material-icons">menu</i></a>
</header>
<main>
    <div class="row row-no-after">
        <div id="statusDiv"></div>


        <div class="col s4">
            <div class="row row-no-after">
                <div class="col s12" style="padding:0;">
                    <div class="card z-depth-0">
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
            </div>
            <div class="row row-no-after">
                <div class="col s12" style="padding:0;">
                    <div class="card z-depth-0">
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
            </div>

        </div>

        <div class="col s4">
            <div class="card z-depth-0" style="height: 215px;">
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

        <div class="col s4">
            <div class="card z-depth-0" style="height: 215px;">
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
        <div class="col s12">
            <div class="card z-depth-0">
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
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card z-depth-0">
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
        </div>
    </div>
    <div class="scroll" style="height: 500px;">
        <div class="row">
            <div id="feedDiv"></div>
<!--            <div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div><div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s12">-->
<!--                <div class="card z-depth-0">-->
<!--                    <div class="card-content">-->
<!--                        FEED HERE-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>

    <div id="feedDiv"></div>
    <div id="play-sound"></div>

</main>
    <?php include('include/footer.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/feed2.js"></script>
</body>
</html>
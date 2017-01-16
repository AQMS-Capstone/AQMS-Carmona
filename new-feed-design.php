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
        <div class="col s4">
            <div class="card z-depth-0">
                <div id="aqiColor" class="col s12 grey" style="margin-bottom: 15px;">
                    <p style="font-size: 1em;" class="white-text"><b id="aqiText">No Status</b></p>
                </div>
                <div class="card-content">
                    <div class="row">
                       <p class="card-title teal-text" style="font-weight: bold" id="zoneName">SLEX</p>


                        <div class="divider"></div>
                        <br>

                        <div class="col s12" style="padding: 0;">
                            <p style="font-weight: bold; font-size: 2em;">AQI: <span id="aqiNum"></span ></p>
                        </div>

                        <div class="col s12" style="padding: 0;">
                            <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                            <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>
                            <p><b>Change in AQI Status: </b><span id="timeUpdated">NaN</span></p>
                        </div>
                    </div>
                </div>
                <div id="aqiColor" class="col s12 grey">
                    <p style="font-size: 1em;" class="white-text"><b id="aqiText">Action</b></p>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card z-depth-0">
                <div id="aqiColor" class="col s12 grey" style="margin-bottom: 15px;">
                    <p style="font-size: 1em;" class="white-text"><b id="aqiText">No Status</b></p>
                </div>
                <div class="card-content">
                    <div class="row">
                        <p class="card-title teal-text" style="font-weight: bold" id="zoneName">Bancal</p>


                        <div class="divider"></div>
                        <br>

                        <div class="col s12" style="padding: 0;">
                            <p style="font-weight: bold; font-size: 2em;">AQI: <span id="aqiNum"></span ></p>
                        </div>

                        <div class="col s12" style="padding: 0;">
                            <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                            <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>
                            <p><b>Change in AQI Status: </b><span id="timeUpdated">NaN</span></p>
                        </div>
                    </div>
                </div>
                <div id="aqiColor" class="col s12 grey">
                    <p style="font-size: 1em;" class="white-text"><b id="aqiText">Action</b></p>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="row row-no-after">
                <div class="col s12" style="padding:0;">
                    <div class="card z-depth-0">
                        <div class="card-content">
                            SLEX PIE GRAPH
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-no-after">
                <div class="col s12" style="padding:0;">
                    <div class="card z-depth-0">
                        <div class="card-content">
                            BANCAL PIE GRAPH
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card z-depth-0">
                <div class="card-content">
                    SLEX GRAPH HERE
                </div>
            </div>
        </div>
    </div>
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card z-depth-0">
                <div class="card-content">
                    BANCAL GRAPH HERE
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
                DROP DOWN CONTROLS HERE
            </div>
        </div>
    </div>
    <div class="scroll" style="height: 500px;">
        <div class="row">
            <div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div><div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card z-depth-0">
                    <div class="card-content">
                        FEED HERE
                    </div>
                </div>
            </div>

        </div>
    </div>


</main>
    <?php include('include/footer.php'); ?>
</body>
</html>
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
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
</head>
<body style="background-color: #f0f0f0">
<header>
    <ul id="slide-out" class="side-nav fixed">
        <li class="teal z-depth-1" ><a id="logo" href="index.php"><img alt="Brand Logo" class="center" src="res/logo.png" style="height: 45px;"> </a>
        <li><a href="feed.php" id="home-tab"><span class="material-icons">home</span> Home</a></li>
        <li><a href="maintenance.php" id="home-tab"><span class="material-icons">build</span> Maintenance</a></li>
        <div class="divider"></div>
        <!--        <li><a><span class="material-icons">settings_input_svideo</span> Highest AQI: <span class="red-text">400</span></a></li>-->
        <!--        <li><a><span class="material-icons">settings_input_svideo</span> Lowest AQI: <span class="blue-text">00</span></a></li>-->
        <li><a><span class="material-icons">select_all</span> Bancal Sensor: <span id="status1">Online</span></a></li>
        <li><a><span class="material-icons">select_all</span> SLEX Sensor: <span id="status2">Online</span></a></li>
        <li><a><span class="material-icons">access_time</span> Server Time: <span class="black-text" id="serverTime">00:00</span></a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse hide-on-med-and-up"><i class="material-icons">menu</i></a>
</header>
<main>

</main>
<?php include('include/footer.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/maintenance.js"></script>
</body>
</html>
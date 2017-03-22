<!doctype html>
<html lang="en">
<head>
    <link rel='stylesheet' type='text/css' href='css/jquery.dataTables.css'>
    <?php include('include/header-meta.php'); ?>
    <style>
        li.link { cursor: pointer; cursor: hand; }
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

        <li class="link"><a id="account"><span class="material-icons">account_circle</span> <?php echo $_SESSION["USERNAME"];?> <i
                    class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a></li>
        <div hidden id="account-content">
            <?php
                if($_SESSION["PRIVILEGE"] == "0")
                {
                    echo "<li><a href=\"manage-accounts.php\" id=\"drpManageAcc\">Manage Accounts</a></li>";
                }
            ?>

            <li><a href="logout.php" id="drpLogout">Logout</a></li>
        </div>


        <li  id="home-tab"><a href="feed.php"><span class="material-icons">home</span> Home</a></li>
        <li><a href="history.php" target="_blank"><span class="material-icons">trending_up</span> History</a>
        <li class="link"><a id="calculators"><span class="material-icons">timeline</span>Calculators<i
                        class="material-icons right" style="margin-left: 5px!important;">arrow_drop_down</i></a></li>
        <div hidden id="calculators-content">
            <li><a href="aqi-calculator.php?calculator=CVA" target="_blank" id="drpCVA">AQI Calculator</a></li>
            <li><a href="aqi-calculator.php?calculator=ACV" target="_blank" id="drpACV">Concentration Value Calculator</a></li>
        </div>
        <li id="maintenance-tab"><a href="maintenance.php"><span class="material-icons">build</span> Maintenance</a></li>


        <div class="divider"></div>

        <li><a><span class="material-icons">select_all</span> Bancal Sensor: <span id="status1">Online</span></a></li>
        <li><a><span class="material-icons">select_all</span> SLEX Sensor: <span id="status2">Online</span></a></li>

        <li><a><span class="material-icons">access_time</span> Server Time: <span class="black-text" id="serverTime">00:00</span></a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse hide-on-med-and-up"><i class="material-icons">menu</i></a>
</header>
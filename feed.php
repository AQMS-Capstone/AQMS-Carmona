<?php
define("PAGE_TITLE", "Feed - Air Quality Monitoring System");
include('include/header_feed.php');

?>

<html>
<head>
    <script src = "js/jquery-3.1.1.min.js" type="text/javascript"></script>
</head>
<body>

<div id = "trigger"></div>
<div id="tryPanel1"></div>
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
    </div>
</div>
<div id="tryPanel2"></div>
<div id="play-sound"></div>

<script src="js/feed.js"></script>
</body>
</html>
<?php
include('include/footer_feed.php');
?>
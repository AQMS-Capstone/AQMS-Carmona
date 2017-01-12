<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 06/01/2017
 * Time: 11:10 PM
 */
define("PAGE_TITLE", "Feed - Air Quality Monitoring System");
include('include/header_feed.php');

?>

<html>
<head>
    <script src = "jquery-3.1.1.min.js" type="text/javascript"></script>
    <script type = "text/javascript">

        var isRunning = false;
        var isSoundRunning = false;
        var ctr = 0;

        var isTriggered = true;

    $(function()
    {
        GetFeed();
    });

    function GetFeed()
    {
        //$('div#tryPanel').load('add.php');

        $.ajax({
            type: "GET",
            url: 'retrieve_time.php',
            dataType:'JSON',
            success: function (response) {
                var triggered = response["isSoundTriggered"];
                if(triggered == true){
                    isTriggered = true;
                }
            }
        });

        $.ajax({
            type: "GET",
            url: 'retrieve_status.php',
            success: function (response) {
                $('#tryPanel1').html(response);
            }
        });

        if(isRunning == false) {
            $.ajax({
                type: "GET",
                url: 'retrieve_feed.php',
                data: {phpValue: JSON.stringify("-1")},
                success: function (response) {
                    $('#tryPanel2').html(response);
                }
            });
        }

        $.ajax({
            type: "GET",
            url: 'retrieve_alert.php',
            dataType:'JSON',
            success: function (response) {
                var container1 = response["play1"];
                var container2 = response["play2"];

                if(container1 == "1" || container2 == "1"){
                    isSoundRunning = true;
                }

                if(isSoundRunning && isTriggered){
                    if(ctr == 7){
                        ctr = 0;
                        isSoundRunning = false;
                        isTriggered = false;
                        stopSound();
                        //stop
                    }else {
                        playSound("res/Sounds/", "Red Alert");
                        ctr++;
                    }
                }
            }
        });

        myGetFeed = setTimeout('GetFeed()',1000);
    }

    function playSound(filePath,filename){
        document.getElementById("play-sound").innerHTML='<audio autoplay="autoplay"><source src="'+ filePath + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="'+ filePath + filename +'.mp3" /></audio>';
    }

    function stopSound(){
        document.getElementById("play-sound").innerHTML= '';
    }
    </script>
</head>
<body>
<div id = "trigger"></div>
<div id="tryPanel1"></div>
<div class="container">
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
<script type="text/javascript">

    function GetFeed2() {
        console.log("SENPAI 2");
        isRunning = true;
        $.ajax({
            type: "GET",
            url: 'retrieve_feed.php',
            data: {phpValue: JSON.stringify($('#showEntries').val())},
            success: function (response) {
                $('#tryPanel2').html(response);
            }
        });

        myGetFeed2 = setTimeout('GetFeed2()', 1000);
    }

    $( document ).ready(function() {
        $('select[id=showEntries]').change(function () {

            $(function()
            {
                GetFeed2();
            });
        });
    });
</script>
</body>
</html>
<?php
include('include/footer_feed.php');
?>
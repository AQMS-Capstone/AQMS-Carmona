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
        var ctr2 = 0;

        var isTriggered = false;
        var isFirstLoad = true;
        var isFirstTriggered = false;
        var isResumedTriggered = false;

        var alertToPlay = "0";
        var statusHolder = "0";

    $(function()
    {
        GetFeed();
    });

    function GetFeed()
    {
        //$('div#tryPanel').load('add.php');
        if(isTriggered) {
            if(ctr2 == 7){
                ctr2 = 0;
                isTriggered = false;
            }else{
                ctr2++;
            }
        }

        $.ajax({
            type: "GET",
            url: 'retrieve_resumer.php',
            dataType: 'JSON',
            success: function (response) {
                var isResumed = response["isResumed"];
                if (isResumed == true) {
                    isResumedTriggered = false;
                }else{
                    if(isTriggered) {
                        isResumedTriggered = true;
                    }
                }
            }
        });

        if(!isTriggered && !isResumedTriggered){
            $.ajax({
                type: "GET",
                url: 'retrieve_time.php',
                dataType: 'JSON',
                success: function (response) {
                    var triggered = response["isSoundTriggered"];
                    if (triggered == true) {
                        isTriggered = true;
                        isResumedTriggered = true;
                    }
                }
            });
        }

        //enclose sa function, tas sa pag load tatawagan niya ung function, tas pag nag success
        $.ajax({
            type: "GET",
            url: 'retrieve_status.php',
            success: function (response) {
                $('#tryPanel1').html(response);
            },
            error:function(response){

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

                alertToPlay = container1;

                if (alertToPlay == "0") {
                    if (container2 == "1" || container2 == "2") {
                        alertToPlay = container2;
                    }
                } else if (alertToPlay == "1") {
                    if (container2 == "2") {
                        alertToPlay = container2;
                    }
                }

                if (statusHolder != alertToPlay) {
                    statusHolder = alertToPlay;
                    isFirstTriggered = true;
                }

                if ((isTriggered) || isFirstTriggered) {
                    if (ctr == 7) {
                        ctr = 0;
                        isSoundRunning = false;
                        isFirstTriggered = false;
                        stopSound();
                        //stop
                    } else {
                        if (alertToPlay == "2") {
                            playSound("res/Sounds/", "Red Alert");
                        } else if (alertToPlay == "1") {
                            playSound("res/Sounds/", "filling-your-inbox");
                        }

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
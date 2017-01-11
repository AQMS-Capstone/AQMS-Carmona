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

    $(function()
    {
        GetFeed();
    });

    function GetFeed()
    {
        //$('div#tryPanel').load('add.php');

        $.ajax({
            type: "GET",
            url: 'retrieve_status.php',
            success: function (response) {
                $('#tryPanel1').html(response);
            }
        });

        if(isRunning == false) {
            console.log("KRIS SENPAI");
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
            success: function (response) {
                var container = response.play1;
                console.log("CONTAINER IS: " + container);
                if(container == "1"){
                    console.log("SENPAI <3");
                    playSound("res/Sounds/","Red Alert");
                }else{

                }
            }
        });

        myGetFeed = setTimeout('GetFeed()',1000);
    }

    function playSound(filePath,filename){
        document.getElementById("play-sound").innerHTML='<audio autoplay="autoplay"><source src="'+ filePath + filename + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="'+ filePath + filename +'.mp3" /></audio>';
    }
    </script>
</head>
<body>
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
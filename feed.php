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

    $(function()
    {
        GetFeed();
    });

    function GetFeed()
    {
        //$('div#tryPanel').load('add.php');

        $.ajax({
            type: "GET",
            url: 'retrieve_feed.php',
            success: function (response) {
                $('#tryPanel').html(response);
            }
        });

        myGetFeed = setTimeout('GetFeed()',1000);
    }
    </script>
</head>
<body>
<div id="tryPanel"></div>

</body>
</html>
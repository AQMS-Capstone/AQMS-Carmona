<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 25/11/2016
 * Time: 2:05 PM
 */

include('public/include/db_connect.php');

?>

<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
</head>
<body>
<!-- Modal Trigger -->
<button data-target="modal1" class="btn modal-trigger">Modal</button>

<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>Modal Header</h4>
        <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
    </div>
</div>


<!--- comment the above modal structure and uncomment this if you want the modal bottom sheet
<!--<div id="modal1" class="modal bottom-sheet">-->
<!--    <div class="modal-content">-->
<!--        <h4>Modal Header</h4>-->
<!--        <p>A bunch of text</p>-->
<!--    </div>-->
<!--    <div class="modal-footer">-->
<!--        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
<!--    </div>-->
<!--</div>-->

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>
</body>
</html>

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
<a class="waves-effect waves-light btn" href="#modal1">Modal</a>

<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>Modal Header</h4>
        <p>Hello World</p>
    </div>
    <div class="modal-footer">
        <button data-target="modal1" class="btn">Modal</button>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script src="js/init.js"></script>
</body>
</html>

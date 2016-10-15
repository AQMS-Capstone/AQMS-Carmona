<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 3:13 AM
 */?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>

<body>
</br>
<div class="card">

        <div>
            <div class="col-md-12">
                <p style="font-weight: bold">Bancal, Carmona, Cavite</p>
            </div>
            <div class="col-md-6">
                <div class="AQIStat">
                    <span>50</span>
                </div>

            </div>
            <div class="col-md-6">
                <p style="font-weight: bold; font-size: x-large;">GG</p>
                <p>Updated on Sunday 00:00</p>
            </div>
        </div>

            <div class="col-md-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th>Current</th>
                <th></th>
                <th>Min</th>
                <th>Max</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>CO</td>
                <td>999</td>
                <td><img src="res/sampleData.png"></td>
                <td>0</td>
                <td>999</td>
            </tr>
            <tr>
                <td>NO2</td>
                <td>999</td>
                <td><img src="res/sampleData.png"></td>
                <td>0</td>
                <td>999</td>
            </tr>
            <tr>
                <td>O3</td>
                <td>999</td>
                <td><img src="res/sampleData.png"></td>
                <td>0</td>
                <td>999</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

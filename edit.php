<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit - Air Quality Monitoring System</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <!-- CSS  -->
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <style>
        select {
            width: 100px;
            display: inline;
        }

        input[type=search] {
            width: 150px;
        }

        .centered-nav {
            left: -37%;
        }
    </style>
</head>
<body>

<div>
    <nav class="z-depth-1" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="index.php"><img class="brand-logo center" src="res/logo.png"> </a>
        </div>
    </nav>
</div>
<div>
    <nav id="nav">
        <div class="nav-wrapper">
            <ul id="nav-mobile" class="centered-nav hide-on-med-and-down">
                <li><a href="backend.php" id="home-tab"><span class="material-icons">bug_report</span> Developer Option</a>
                </li>
                <li><a href="edit.php" id=""><span class="material-icons">list</span> Concentration Table</a></li>
            </ul>
        </div>
    </nav>
</div>
<div class="section">
    <br><br>
    <h1 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons"
                                                                                           style="font-size: 2em;">cloud</span>
    </h1>
    <h2 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b>AQMS Concentration Table</b></h2>
</div>
<div class='container'>
    <table id='example' class='highlight' width='100%'>
        <thead>
        <tr>
            <th data-field='time'>Timestamp</th>
            <th data-field='area'>Area</th>
            <th data-field='pollutant'>Pollutant</th>
            <th data-field='symbol'>Symbol</th>
            <th data-field='value'>Concentration Value</th>
            <th data-field='function'></th>
        </tr>
        </thead>
        <tbody>

        <?php
        /**
         * Created by PhpStorm.
         * User: Nostos
         * Date: 25/11/2016
         * Time: 2:05 PM
         */

        include('public/include/db_connect.php');

        $timestamp_array = array();

        $query = "SELECT timestamp, area_name, ELEMENTS.e_name as e_name, ELEMENTS.e_symbol as e_symbol, concentration_value, MASTER.e_id as e_id FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);

        if ($result) {

            if (mysqli_num_rows($result) == 0) {
                echo "NO DATA";
            } else {
                $ctr = 0;
                while ($row = mysqli_fetch_array($result)) {

                    //array_push($timestamp_array, $row['timestamp']);

                    $identifier = "ROW_" . $ctr;
                    $identifier_input = "I_ROW_" . $ctr;

                    echo "<tr>";
                    echo "<td>" . $row['timestamp'] . "</td>";
                    echo "<td>" . $row['area_name'] . "</td>";
                    echo "<td>" . $row['e_name'] . "</td>";
                    echo "<td>" . $row['e_symbol'] . "</td>";
                    echo "<td>" . $row['concentration_value'] . "</td>";
                    echo "<td><button data-target='" . $identifier . "' class='waves-effect orange-text btn-flat modal-trigger'>Edit</button></td>";
                    echo "</tr>";

                    $step = 0;
                    $min = 0;
                    $max = 0;
                    $unit = "";

                    if ($row['e_symbol'] == "CO") {
                        $step = 0.1;
                        $min = 0.0;
                        $max = 40.4;
                        $unit = "ppm";
                    } else if ($row['e_symbol'] == "SO2") {
                        $step = 0.001;
                        $min = 0.000;
                        $max = 0.804;
                        $unit = "ppm";
                    } else if ($row['e_symbol'] == "NO2") {
                        $step = 0.01;
                        $min = 0.65;
                        $max = 1.64;
                        $unit = "ppm";
                    } else if ($row['e_symbol'] == "O3") {
                        $step = 0.001;
                        $min = 0.000;
                        $max = 0.504;
                        $unit = "ppm";
                    } else if ($row['e_symbol'] == "PM 10") {
                        $min = 0;
                        $max = 504;
                        $unit = "ug/m3";
                    } else if ($row['e_symbol'] == "TSP") {
                        $min = 0;
                        $unit = "ug/m3";
                    }

                    echo "
            <div id='" . $identifier . "' class='modal'>
                <div class='modal-content'>
                  <h4>Edit concentration value for: </h4>
                  <div class='row'>
                      <div class='col s12'>
                          <p class = 'teal-text col s4'>Timestamp: </p>
                          <p class = 'col s8'>" . $row['timestamp'] . "</p>
                          <p class = 'teal-text col s4'>Area Name: </p>
                          <p class = 'col s8'>" . $row['area_name'] . "</p>
                          <p class = 'teal-text col s4'>Element Name: </p>
                          <p class = 'col s8'>" . $row['e_name'] . "</p>
                          <p class = 'teal-text col s4'>Element Symbol: </p>
                          <p class = 'col s8'>" . $row['e_symbol'] . "</p>
                          <p class = 'teal-text col s4'>Concentration Value:</p>
                          <p class = 'col s8'>" . $row['concentration_value'] . "</p>
                          ";

                    if ($row['e_symbol'] == "TSP") {
                        echo "
                                <div class='input-field col s10'>
                                    <input id='$identifier_input' name='so2_value' type='number' class='validate'
                                           min='$min'>
                                    <label>Enter new concentration value</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$unit</label>
                                </div>
                            ";
                    } else if ($row['e_symbol'] == "PM 10") {
                        echo "
                                <div class='input-field col s10'>
                                    <input id='$identifier_input' name='so2_value' type='number' class='validate'
                                           min='$min' max='$max'>
                                    <label>Enter new concentration value</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$unit</label>
                                </div>
                            ";
                    } else {
                        echo "
                                <div class='input-field col s10'>
                                    <input id='$identifier_input' name='so2_value' type='number' class='validate' step='$step'
                                           min='$min' max='$max'>
                                    <label>Enter new concentration value</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$unit</label>
                                </div>
                            ";
                    }

                    $value_time = json_encode($row['timestamp']);
                    $value_element = json_encode($row['e_symbol']);
                    $area = json_encode($row['area_name']);
                    $e_id = json_encode($row['e_id']);

                    echo "
                  </div>
                </div>
                <div class='modal-footer'>
                    <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cancel</a>
                    <button id='btnSave' onclick='myFunction($value_time, $value_element, $identifier_input, $area, $e_id)' class='modal-action waves-effect waves-green btn-flat'>Save</button>
                </div>
            </div>
            ";

                    $ctr++;
                }
            }
        }
        ?>
        </tbody>
    </table>
    <br><br>
</div>

<?php include('public/_footer.php'); ?>
<script src='https://code.jquery.com/jquery-2.1.1.min.js'></script>
<script type='text/javascript' charset='utf8' src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.js'></script>
<script src='js/materialize.min.js'></script>
<!--<script src='js/init.js'></script>-->
<script type='text/javascript'>
    function myFunction(timestamp, symbol, iden2, area, e_id) {
        var concentration_value = iden2.value;

        if (symbol == 'CO') {
            var step = 0.1;
            var min = 0.0;
            var max = 40.4;
            var unit = 'ppm';
        } else if (symbol == 'SO2') {
            var step = 0.001;
            var min = 0.000;
            var max = 0.804;
            var unit = 'ppm';
        } else if (symbol == 'NO2') {
            var step = 0.01;
            var min = 0.65;
            var max = 1.64;
            var unit = 'ppm';
        } else if (symbol == 'O3') {
            var step = 0.001;
            var min = 0.000;
            var max = 0.504;
            var unit = 'ppm';
        } else if (symbol == 'PM 10') {
            var step = 1;
            var min = 0;
            var max = 504;
            var unit = 'ug/m3';
        } else if (symbol == 'TSP') {
            var step = 1;
            var min = 0;
            var unit = 'ug/m3';
        }

        var proceed = false;

        if (symbol == 'TSP') {
            if (concentration_value >= min) {
                proceed = true;
            }

            else {
                proceed = false;
            }
        }

        else {
            if (concentration_value >= min && concentration_value <= max) {
                proceed = true;
            }

            else {
                proceed = false;
            }
        }

        if (proceed) {
            $.ajax
            ({
                type: 'POST',
                url: 'edit_saver.php',
                data: {timestamp: timestamp, concentration_value: concentration_value, area: area, e_id: e_id},
                success: function (response) {
                    if (response == 'Success') {
                        document.location.reload();
                    }

                    else {
                        alert(response);
                    }
                }
            });
        }

        //document.location.reload()
    }

    $(document).ready(function () {
        $('#example').DataTable({
            'order': [[3, 'desc']],
            'columnDefs': [{'targets': '_all'}],
            stateSave: true
        });

        $('.modal-trigger').leanModal({});
    });

    $(document).on('click', function () {
        $('.modal-trigger').leanModal({});
    });
</script>
</body>
</html>

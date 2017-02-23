<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit - Air Quality Monitoring System</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <!-- CSS  -->
    <link rel='stylesheet' type='text/css' href='css/jquery.dataTables.css'>
    <link href="css/iconfont/material-icons.css" rel="stylesheet">
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
            <th data-field='pollutant'>CO (ppm)</th>
            <th data-field='symbol'>SO2 (ppm)</th>
            <th data-field='value'>NO2 (ppm)</th>
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

        include('include/db_connect.php');
        require 'include/guidelines.php';

        $timestamp_array = array();

        $query = "SELECT timestamp, area_name, CO, SO2, NO2 FROM MASTER ORDER BY TIMESTAMP DESC";
        $result = mysqli_query($con, $query);

        if ($result) {

            if (mysqli_num_rows($result) == 0) {
                echo "NO DATA";
            } else {
                $ctr = 0;
                while ($row = mysqli_fetch_array($result)) {

                    $identifier = "ROW_" . $ctr;
                    $identifier_input1 = "I_ROW_A" . $ctr;
                    $identifier_input2 = "I_ROW_B" . $ctr;
                    $identifier_input3 = "I_ROW_C" . $ctr;

                    echo "<tr>";
                    echo "<td>" . $row['timestamp'] . "</td>";
                    echo "<td>" . $row['area_name'] . "</td>";
                    echo "<td>" . $row['CO'] . "</td>";
                    echo "<td>" . $row['SO2'] . "</td>";
                    echo "<td>" . $row['NO2'] . "</td>";
                    echo "<td><a data-target='" . $identifier . "' class='waves-effect waves-light btn modal-trigger'>Edit</a></td>";
                    echo "</tr>";

                    $step_co = $co_step;
                    $unit_co = $co_unit;
                    $co = $row['CO'];

                    $step_so2 = $sulfur_step;
                    $unit_so2 = $sulfur_unit;
                    $so2 = $row['SO2'];

                    $step_no2 = $no2_step;
                    $unit_no2 = $no2_unit;
                    $no2 = $row['NO2'];

                    $min = 0;

                    echo "
                    <div id='" . $identifier . "' class='modal'>
                          <div class='modal-content' style='padding: 24px 24px 0px 24px;'>
                              <div class='row-no-after'>
                                <div class='col s12'>
                                   <div class='row'>
                                      <div class='col s12'>
                                          <h4>Edit Concentration Value</h4>
                                          <div class='divider'></div>
                                      </div>
                                   </div>
                            
                                   <div class='row'>
                                      <div class='col s3'>
                                          <label class='teal-text emphasize-text'>Timestamp :</label>
                                      </div>
                                      <div class='col s7'>
                                          <span>" . $row['timestamp'] . "</span>
                                      </div>
                                  </div>
                            
                                  <div class='row'>
                                      <div class='col s3'>
                                          <label class='teal-text emphasize-text'>Area Name :</label>
                                      </div>
                                      <div class='col s7'>
                                          <span>" . $row['area_name'] . "</span>
                                      </div>
                                  </div>
                                  
                                  <div class='row' style='margin-bottom: 0px;'>
                                    <div class='input-field col s10'>
                                        <input id='$identifier_input1' name='so2_value' type='number' class='validate' step='$step_co'
                                               min='$min' value='$co'>
                                        <label>Carbon Monoxide value</label>
                                    </div>
                                    <div class='input-field col s2'>
                                        <label id='unit'>$unit_co</label>
                                    </div>
                                  </div>
                                  
                                  <div class='row' style='margin-bottom: 0px;'>
                                    <div class='input-field col s10'>
                                        <input id='$identifier_input2' name='so2_value' type='number' class='validate' step='$step_so2'
                                               min='$min' value='$so2'>
                                        <label>Sulfur Dioxide value</label>
                                    </div>
                                    <div class='input-field col s2'>
                                        <label id='unit'>$unit_so2</label>
                                    </div>
                                  </div>
                                  
                                  <div class='row' style='margin-bottom: 0px;'>
                                    <div class='input-field col s10'>
                                        <input id='$identifier_input3' name='so2_value' type='number' class='validate' step='$step_no2'
                                               min='$min' value='$no2'>
                                        <label>Nitrogen Dioxide value</label>
                                    </div>
                                    <div class='input-field col s2'>
                                        <label id='unit'>$unit_no2</label>
                                    </div>
                                  </div>

                    ";

                    $value_time = json_encode($row['timestamp']);
                    $area = json_encode($row['area_name']);

                    echo "
                    </div>
                </div>
            </div>
        <div class='modal-footer'>
                    <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cancel</a>
                    <button id='btnSave' onclick='myFunction($value_time, $identifier_input1, $identifier_input2, $identifier_input3, $area)' class='modal-action waves-effect waves-green btn-flat'>Save</button>
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

<?php include('include/footer.php'); ?>
<script type='text/javascript' charset='utf8' src='js/dataTables.min.js'></script>
<script type='text/javascript'>
    function myFunction(timestamp, identifier_input1, identifier_input2, identifier_input3, area) {
        var concentration_value_co = identifier_input1.value;
        var concentration_value_so2 = identifier_input2.value;
        var concentration_value_no2 = identifier_input3.value;

        var min = 0;
        var proceed = false;

        if (concentration_value_co >= min && concentration_value_so2 >= min && concentration_value_no2 >= min) {
            proceed = true;
        }
        else {
            proceed = false;
        }

        if (proceed) {
            $.ajax
            ({
                type: 'POST',
                url: 'edit_saver.php',
                data: {timestamp: timestamp, concentration_value_co: concentration_value_co, concentration_value_so2: concentration_value_so2, concentration_value_no2: concentration_value_no2, area: area},
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

<?php


    function insertPollutant($e_id, $area, $co_value)
    {
        include('public/include/db_connect.php');

        $query = "SELECT timestamp  FROM MASTER WHERE E_ID = '$e_id' and area_name='$area' ORDER BY timestamp desc limit 1";
        $result = mysqli_query($con,$query);

        $time_now = "";

        if(mysqli_num_rows($result)==0){
            $time_now = date("Y-m-d H:i:s", strtotime("00:00:00")+3600);
        }
        else{
            while($row = mysqli_fetch_array($result)) {
                $time_now = date("Y-m-d H:i:s", strtotime($row['timestamp']) + 3600);
            }
        }

        $query = "INSERT INTO MASTER (m_id, area_name, e_id, concentration_value, timestamp) VALUES (NULL, '$area', '$e_id', '$co_value', '$time_now')";

        if (!mysqli_query($con,$query))
        {
            die('Error: ' . mysqli_error($con));
        }

        else {
            $statusMessage = "CO record added successfully.";
        }
    }

    if(isset($_POST['btnSubmit']))
    {
        $area = $_POST['area'];

        $co_value = $_POST['co_value'];
        $so2_value = $_POST['so2_value'];
        $no2_value = $_POST['no2_value'];
        $o3_value = $_POST['o3_value'];
        $pm10_value = $_POST['pm10_value'];
        $tsp_value = $_POST['tsp_value'];

        if($area == "1")
        {
            $area = "slex";
        }

        else
        {
            $area = "bancal";
        }

        if($co_value != null)
        {
            $e_id = '1';
            insertPollutant($e_id, $area, $co_value);
        }

        if($so2_value != null)
        {
            $e_id = '2';
            insertPollutant($e_id, $area, $so2_value);
        }

        if($no2_value != null)
        {
            $e_id = '3';
            insertPollutant($e_id, $area, $no2_value);
        }

        if($o3_value != null)
        {
            $e_id = '4';
            insertPollutant($e_id, $area, $o3_value);
        }

        if($pm10_value != null)
        {
            $e_id = '5';
            insertPollutant($e_id, $area, $pm10_value);
        }

        if($tsp_value != null)
        {
            $e_id = '6';
            insertPollutant($e_id, $area, $tsp_value);
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Backend - Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <script type="text/javascript">
        $('#co_value').val('');
        $('#so2_value').val('');
        $('#no2_value').val('');
        $('#o3_value').val('');
        $('#pm10_value').val('');
        $('#tsp_value').val('');
    </script>
</head>

<body>

<div id="content-holder">
    <div class="section">
        <br><br>
        <h2 class="header center teal-text"><b>Developer Option</b></h2>
        <div class="row center">
            <h6 class="header col s12">This page would act as a simulation of the IOT device</h6>
        </div>
    </div>
    <br>
    <br>
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <form method="post" action="">

                        <div class="input-field col s12">
                            <select id="area" name="area" required>
                                <option value="" disabled selected>Select a pollutant</option>
                                <option value="1">SLEX Entrance/Exit Carmona, Cavite</option>
                                <option value="2">Bancal Carmona, Cavite</option>
                            </select>
                            <label>Pollutant</label>
                        </div>

                        <div class="input-field col s10">
                            <input id="co_value" name="co_value" type="number" class="validate" step="0.1" min="0.0" max="40.4">
                            <label>Carbon Monoxide</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ppm</label>
                        </div>


                        <div class="input-field col s10">
                            <input id="so2_value" name="so2_value" type="number" class="validate" step="0.001" min="0.000" max="0.804">
                            <label>Sulfur Dioxide</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ppm</label>
                        </div>

                        <div class="input-field col s10">
                            <input id="no2_value" name="no2_value" type="number" class="validate" step="0.01" min="0.65" max="1.64">
                            <label>Nitrogen Dioxide</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ppm</label>
                        </div>

                        <div class="input-field col s10">
                            <input id="o3_value" name="o3_value" type="number" class="validate" step="0.001" min="0.000" max="0.504">
                            <label>Ozone</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ppm</label>
                        </div>

                        <div class="input-field col s10">
                            <input id="pm10_value" name="pm10_value" type="number" class="validate" min="0" max="504">
                            <label>Particulate Matter 10</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ug/m3</label>
                        </div>

                        <div class="input-field col s10">
                            <input id="tsp_value" name="tsp_value" type="number" class="validate" min="0">
                            <label>Total Suspended Particles</label>
                        </div>
                        <div class="input-field col offset-s1">
                            <label id="unit">ug/m3</label>
                        </div>

                        <div class="input-field col s12">
                                <button class="btn waves-effect waves-light" type="submit" style="width: 100%; margin-top:3%;" name="btnSubmit">Submit</button>
                        </div>


                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</div>


<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>

</body>
</html>
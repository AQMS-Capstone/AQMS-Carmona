<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 25/11/2016
 * Time: 2:05 PM
 */

include('public/include/db_connect.php');

echo "
<!DOCTYPE html>
<html>
<head>
     <!-- CSS  -->
    <link type='text/css' rel='stylesheet' href='css/materialize.min.css'  media='screen,projection'/>
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css'>
</head>
<body>

<table id='example' class='display cell-border' cellspacing='0' width='100%'>
<thead class = 'dt-head-center'>
<tr>
    <th data-field='time'>Timestamp</th>
    <th data-field='area'>Area</th>
    <th data-field='pollutant'>Pollutant</th>
    <th data-field='symbol'>Symbol</th>
    <th data-field='value'>Concentration Value</th>
    <th data-field='function'>Function</th>
</tr>
</thead>
<tbody class = 'dt[-head|-body]-center'>
";

$query = "SELECT timestamp, area_name, elements.e_name as e_name, elements.e_symbol as e_symbol, concentration_value FROM MASTER INNER JOIN ELEMENTS ON MASTER.E_ID = ELEMENTS.E_ID ORDER BY TIMESTAMP DESC";
$result = mysqli_query($con, $query);

if($result) {

    if (mysqli_num_rows($result) == 0) {
        echo "NO DATA";
    }

    else
    {
        $ctr = 0;
        while ($row = mysqli_fetch_array($result)) {

            $identifier = "ROW_".$ctr;
            echo "<tr>";
                echo "<td>".$row['timestamp']."</td>";
                echo "<td>".$row['area_name']."</td>";
                echo "<td>".$row['e_name']."</td>";
                echo "<td>".$row['e_symbol']."</td>";
                echo "<td>".$row['concentration_value']."</td>";
                //echo "<td><button data-target='".$row['timestamp']."' class='btn modal-trigger'>Edit</button></td>";
                echo "<td><button data-target='".$identifier."' class='btn modal-trigger'>Edit</button></td>";
            echo "</tr>";

            $step = 0;
            $min = 0;
            $max = 0;
            $unit = "";

            if($row['e_symbol'] == "CO"){
                $step = 0.1;
                $min = 0.0;
                $max = 40.4;
                $unit = "ppm";
            }else if($row['e_symbol'] == "SO2") {
                $step = 0.001;
                $min = 0.000;
                $max = 0.804;
                $unit = "ppm";
            }else if($row['e_symbol'] == "NO2"){
                $step = 0.01;
                $min = 0.65;
                $max = 1.64;
                $unit = "ppm";
            }else if($row['e_symbol'] == "O3"){
                $step = 0.001;
                $min = 0.000;
                $max = 0.504;
                $unit = "ppm";
            }else if($row['e_symbol'] == "PM 10"){
                $step = 1;
                $min = 0;
                $max = 504;
                $unit = "ug/m3";
            }else if($row['e_symbol'] == "TSP"){
                $step = 1;
                $min = 0;
                $unit = "ug/m3";
            }

            echo"
            <div id='".$identifier."' class='modal'>
                <div class='modal-content'>
                  <h4>Edit concentration value for: </h4>
                  <div class='row'>
                      <div class='col s12'>
                          <p class = 'teal-text col s4'>Timestamp: </p>
                          <p class = 'col s8'>".$row['timestamp']."</p>
                          <p class = 'teal-text col s4'>Area Name: </p>
                          <p class = 'col s8'>".$row['area_name']."</p>
                          <p class = 'teal-text col s4'>Element Name: </p>
                          <p class = 'col s8'>".$row['e_name']."</p>
                          <p class = 'teal-text col s4'>Element Symbol: </p>
                          <p class = 'col s8'>".$row['e_symbol']."</p>
                          <p class = 'teal-text col s4'>Concentration Value:</p>
                          <p class = 'col s8'>".$row['concentration_value']."</p>
                          ";

                        if($row['e_symbol'] == "TSP")
                        {
                            echo"
                                <div class='input-field col s10'>
                                    <input id='so2_value' name='so2_value' type='number' class='validate' step='$step'
                                           min='$min'>
                                    <label>Enter new concentration value</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$unit</label>
                                </div>
                            ";
                        }

                        else
                        {
                            echo"
                                <div class='input-field col s10'>
                                    <input id='so2_value' name='so2_value' type='number' class='validate' step='$step'
                                           min='$min' max='$max'>
                                    <label>Enter new concentration value</label>
                                </div>
                                <div class='input-field col s2'>
                                    <label id='unit'>$unit</label>
                                </div>
                            ";
                        }

                        echo"
                  </div>
                </div>
                <div class='modal-footer'>
                    <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cancel</a>
                    <button id='btnSave' onclick='myFunction()' class='modal-action waves-effect waves-green btn-flat'>Save</button>
                </div>
            </div>
            ";

            $ctr++;
        }
    }

    echo "
</tbody>
</table>
  
  <script src='https://code.jquery.com/jquery-2.1.1.min.js'></script>
  <script type='text/javascript' charset='utf8' src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.js'></script>
  <script src='js/materialize.min.js'></script>
  <!--<script src='js/init.js'></script>-->
  <script type='text/javascript'>
  function myFunction() {
    alert('BANO SI VONN... BAOG DIN hehe.');
}
        $(document).ready(function() {
            $('#example').DataTable( {
                    'order': [[ 3, 'desc']],
                    'columnDefs': [{'className': 'dt-body-center dt-head-center', 'targets': '_all'}],
                } );
        } );
        
        $(document).on('click', function() {
            $('.modal-trigger').leanModal({
              
              /*
              ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                //alert(trigger);
                //alert(\"Ready\");
                //console.log(modal, trigger);
              },
              
              complete: function() 
              { 
                alert('Closed'); 
              } 
               */
            });
        });
        
        
  </script>
</body>
</html>
";
}

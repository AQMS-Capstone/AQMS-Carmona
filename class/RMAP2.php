<?php

  require_once '../public/include/db_connect.php';

  class Map{

    var $area_name = "";
    var $e_id = "";
    var $concentration_value = "";
    var $timestamp = "";
    var $e_name = "";
    var $e_symbol = "";

    function Map(){}
  }

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d");

  $bancalAllDayValues_array = array();
  $slexAllDayValues_array = array();

  $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE TIMESTAMP LIKE '%$date_now%' ORDER BY MASTER.E_ID";
  $result =  mysqli_query($con,$sql);

  while($row=mysqli_fetch_assoc($result))
  {
    $dataClass = new Map();

    $dataClass->area_name = $row['area_name'];
    $dataClass->e_id = $row['e_id'];
    $dataClass->concentration_value = $row['concentration_value'];
    $dataClass->timestamp = $row['timestamp'];
    $dataClass->e_name = $row['e_name'];
    $dataClass->e_symbol = $row['e_symbol'];

    if($row['area_name'] == "bancal")
    {
      array_push($bancalAllDayValues_array, $dataClass);
    }

    else if($row['area_name'] == "slex")
    {
      array_push($slexAllDayValues_array, $dataClass);
    }
  }

  $bancalThisDayValues_array = array();
  $slexThisDayValues_array = array();

  for($i = 0; $i < count($bancalAllDayValues_array); $i++)
  {
    if(strpos($bancalAllDayValues_array[$i]->timestamp, $date_now) !== false )
    {
      array_push($bancalThisDayValues_array, $bancalAllDayValues_array[$i]);
    }
  }

  for($i = 0; $i < count($slexAllDayValues_array); $i++)
  {
    if(strpos($slexAllDayValues_array[$i]->timestamp, $date_now) !== false )
    {
      array_push($slexThisDayValues_array, $slexAllDayValues_array[$i]);
    }
  }

  $bancalThisHourValues_array = array();
  $slexThisHourValues_array = array();

  $new_date = date("Y-m-d H");
  $new_date2 = $new_date.":00:00";

  for($i = 0; $i < count($bancalThisDayValues_array); $i++)
  {
    if(strpos($bancalThisDayValues_array[$i]->timestamp, $new_date2) !== false )
    {
      array_push($bancalThisHourValues_array, $bancalThisDayValues_array[$i]);
    }
  }

  for($i = 0; $i < count($slexThisDayValues_array); $i++)
  {
    if(strpos($slexThisDayValues_array[$i]->timestamp, $new_date2) !== false )
    {
      array_push($slexThisHourValues_array, $slexThisDayValues_array[$i]);
    }
  }

  $bancalPrevalent = array();
  $slexPrevalent = array();

  $carbon_monoxide_aqi = 0;
  $sulfur_dioxide_aqi = 0;
  $nitrogen_dioxide_aqi = 0;
  $ozone_aqi = 0;
  $lead_aqi = 0; // None
  $pm_10_aqi = 0;
  $tsp_aqi = 0;

  $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // ppm
  $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // ppm
  $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // ppm
  $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // ppm
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // ppm
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // ppm
  $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // ug/m3
  $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, - 899], [900, -1]];
  $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

  for($i = 0; $i < count($bancalThisHourValues_array); $i++)
  {
    switch($bancalThisHourValues_array[$i]->e_id)
    {
        case 1: // CO
          for($x = 0; $x < count($co_guideline_values); $x++)
          {
            if($bancalThisHourValues_array[$i]->concentration_value >= $co_guideline_values[$x][0] && $bancalThisHourValues_array[$i]->concentration_value <= $co_guideline_values[$x][1])
            {
              $roundedValue = floorDec(4.56777124, $precision = 1);
              $carbon_monoxide_aqi = (($aqi_values[$x][1] - $aqi_values[$x][0])/($co_guideline_values[$x][1] - $co_guideline_values[$x][0])) * ($roundedValue + $aqi_values[$x][0]);

              echo floorDec($carbon_monoxide_aqi, $precision = 0);
              break;
            }
          }
        break;

        case 2: // SO2
        break;

        case 3: // NO2
        break;

        case 4: // O3
        break;

        case 5: // Pb - None
        break;

        case 6: // PM 10
        break;

        case 7: // TSP
        break;
    }
  }

  function floorDec($val, $precision = 2) {
    if ($precision < 0) { $precision = 0; }
    $numPointPosition = intval(strpos($val, '.'));
    if ($numPointPosition === 0) { //$val is an integer
        return $val;
    }
    return floatval(substr($val, 0, $numPointPosition + $precision + 1));
}
?>

<script type="text/javascript">
  var goodAir = "#2196F3";
  var fairAir = "#FFEB3B";
  var unhealthy1Air = "#FF9800";
  var veryunhealthyAir = "#f44336";
  var acutelyUnhealthyAir = "#9C27B0";
  var emergencyAir = "#b71c1c";

  var bancalAllDayValues_array = <?= json_encode($bancalAllDayValues_array) ?>;
  var slexAllDayValues_array = <?= json_encode($slexAllDayValues_array) ?>;

  var bancalThisDayValues_array = <?= json_encode($bancalThisDayValues_array) ?>;
  var slexThisDayValues_array = <?= json_encode($slexThisDayValues_array) ?>;

  var bancalThisHourValues_array = <?= json_encode($bancalThisHourValues_array) ?>;
  var slexThisHourValues_array = <?= json_encode($slexThisHourValues_array) ?>;
</script>

<?php

  require_once 'public/include/db_connect.php';

  class Map{

    var $m_id = "";
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
  $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
  $date_tomorrow = $date_tomorrow." 00:00:00";

  $date_gathered = date("Y-m-d H")." 00:00";

  //$date_now = "2016-11-05";

  $bancalAllDayValues_array = array();
  $slexAllDayValues_array = array();

  $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE TIMESTAMP LIKE '%$date_now%' OR TIMESTAMP = '$date_tomorrow' ORDER BY TIMESTAMP";
  $result =  mysqli_query($con,$sql);

  while($row=mysqli_fetch_assoc($result))
  {
    $dataClass = new Map();

    $dataClass->m_id = $row['m_id'];
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

  $bancal_co_values = array();
  $bancal_so2_values = array();
  $bancal_no2_values = array();
  $bancal_o3_values = array();
  $bancal_pb_values = array();
  $bancal_pm10_values = array();
  $bancal_tsp_values = array();

  for($i = 0; $i < count($bancalAllDayValues_array); $i++)
  {
      switch($bancalAllDayValues_array[$i]->e_id)
      {
          case 1: // CO
            array_push($bancal_co_values, $bancalAllDayValues_array[$i]);
          break;

          case 2: // SO2
            array_push($bancal_so2_values, $bancalAllDayValues_array[$i]);
          break;

          case 3: // NO2
            array_push($bancal_no2_values, $bancalAllDayValues_array[$i]);
          break;

          case 4: // O3
            array_push($bancal_o3_values, $bancalAllDayValues_array[$i]);
          break;

          case 5: // Pb
            array_push($bancal_pb_values, $bancalAllDayValues_array[$i]);
          break;

          case 6: // PM 10
            array_push($bancal_pm10_values, $bancalAllDayValues_array[$i]);
          break;

          case 7: // TSP
            array_push($bancal_tsp_values, $bancalAllDayValues_array[$i]);
          break;
      }
  }

  $carbon_monoxide_ave = 0;
  $carbon_monoxide_ctr = 0;

  $sulfur_dioxide_ave = 0;
  $sulfur_dioxide_ctr = 0;

  $nitrogen_dioxide_ave = 0;
  $nitrogen_dioxide_ctr = 0;

  $ozone_8_ave = 0;
  $ozone_8_ave = 0;

  $ozone_1_ctr = 0;
  $ozone_1_ave = 0;

  $ozone_8_ctr = 0;
  $ozone_8_ave = 0;

  $lead_ave = 0; // None
  $lead_ctr = 0;

  $pm_10_ave = 0;
  $pm_10_ctr = 0;

  $tsp_ave = 0;
  $tsp_ctr = 0;

  //$hour_value = 24;
  $data_tomorrow = date("Y-m-d", strtotime('tomorrow'));

  $vonn_controller = 17;

  $bancal_co_aqi_values = array();
  $bancal_so2_aqi_values = array();
  $bancal_no2_aqi_values = array();
  $bancal_o3_aqi_values = array();
  $bancal_o3_1_aqi_values = array();
  $bancal_pm10_aqi_values = array();
  $bancal_tsp_aqi_values = array();

  $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
  $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
  $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
  $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
  $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3

  $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

  for($i = 0; $i < count($bancal_co_values); $i++) // 8hr - ppm
  {
    //$hour_value = $vonn_controller;
    $hour_value = date("H");
    $data_date_tomorrow = substr($bancal_co_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_co_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_co_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //echo "VALUES ARE: ".$bancal_co_values[$i]->concentration_value."<br/>";
        //$carbon_monoxide_ave += $bancal_co_values[$i]->concentration_value;
        //$carbon_monoxide_ctr++;
      }

      else
      {
        //echo "VALUES ARE: ".$bancal_co_values[$i]->concentration_value."<br/>";
        if($data_hour_value > 0)
        {
          if((($i + 1) % 8) == 1)
          {
            $carbon_monoxide_ctr = 0;
            $carbon_monoxide_ave = 0;
          }

          $carbon_monoxide_ave += $bancal_co_values[$i]->concentration_value;
          $carbon_monoxide_ctr++;

          $ave = $carbon_monoxide_ave / $carbon_monoxide_ctr;
          $aqi_value = round(calculateAQI($co_guideline_values, $ave, 1, $aqi_values));
          array_push($bancal_co_aqi_values, $aqi_value);
        }
      }
    }
  }

  for($i = 0; $i < count($bancal_so2_values); $i++) // 24hr - ppm
  {
    //$hour_value = $vonn_controller;
    $hour_value = date("H");
    $data_date_tomorrow = substr($bancal_so2_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_so2_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_so2_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //echo "VALUES ARE: ".$bancal_so2_values[$i]->concentration_value."<br/>";
        //$sulfur_dioxide_ave += $bancal_so2_values[$i]->concentration_value;
        //$sulfur_dioxide_ctr++;
      }

      else
      {
        //echo "SO VALUES ARE: ".$bancal_so2_values[$i]->concentration_value."<br/>";
        $sulfur_dioxide_ave += $bancal_so2_values[$i]->concentration_value;
        $sulfur_dioxide_ctr++;

        $ave = $sulfur_dioxide_ave / $sulfur_dioxide_ctr;
        $aqi_value = round(calculateAQI($sufur_guideline_values, $ave, 3, $aqi_values));
        array_push($bancal_so2_aqi_values, $aqi_value);
      }
    }
  }

  for($i = 0; $i < count($bancal_no2_values); $i++) // 1 hr - ppm
  {
    //$hour_value = $vonn_controller;
    $hour_value = date("H");
    $data_date_tomorrow = substr($bancal_no2_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_no2_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_no2_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //echo "NO VALUES ARE: ".$bancal_no2_values[$i]->concentration_value."<br/>";
        //$nitrogen_dioxide_ave = $bancal_no2_values[$i]->concentration_value;
      }

      else
      {
        //echo "NO VALUES ARE: ".$bancal_no2_values[$i]->concentration_value."<br/>";
        $nitrogen_dioxide_ave = $bancal_no2_values[$i]->concentration_value;

        $ave = $nitrogen_dioxide_ave;
        $aqi_value = round(calculateAQI($no2_guideline_values, $ave, 2, $aqi_values));
        array_push($bancal_no2_aqi_values, $aqi_value);
      }
    }
  }

  for($i = 0; $i < count($bancal_o3_values); $i++) // 8 hr - ppm
  {
    //$hour_value = $vonn_controller;
    $hour_value = date("H");
    $data_date_tomorrow = substr($bancal_o3_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_o3_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_o3_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //$ozone_8_ave += $bancal_o3_values[$i]->concentration_value;
        //$ozone_8_ctr++;
      }

      else
      {
        if($data_hour_value > 0)
        {
          if((($i + 1) % 8) == 1)
          {
            $ozone_8_ave = 0;
            $ozone_8_ctr = 0;
          }

          //echo "O3 - 8 VALUES ARE: ".$bancal_o3_values[$i]->timestamp."<br/>";
          $ozone_8_ave += $bancal_o3_values[$i]->concentration_value;
          $ozone_8_ctr++;

          $ave = $ozone_8_ave / $ozone_8_ctr;
          $aqi_value = round(calculateAQI($ozone_guideline_values_8, $ave, 3, $aqi_values));
          array_push($bancal_o3_aqi_values, $aqi_value);
        }
      }
    }
  }

  for($i = 0; $i < count($bancal_o3_values); $i++) // 1 hr - ppm
  {
    $hour_value = date("H");
    //$hour_value = $vonn_controller;
    $data_date_tomorrow = substr($bancal_o3_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_o3_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_o3_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //$ozone_1_ave = $bancal_o3_values[$i]->concentration_value;
      }

      else
      {
        //echo "O3 - 1 VALUES ARE: ".$bancal_o3_values[$i]->concentration_value."<br/>";
        $ozone_1_ave = $bancal_o3_values[$i]->concentration_value;

        $ave = $ozone_1_ave;
        $aqi_value = round(calculateAQI($ozone_guideline_values_1, $ave, 3, $aqi_values));
        array_push($bancal_o3_1_aqi_values, $aqi_value);
      }
    }
  }

  for($i = 0; $i < count($bancal_pm10_values); $i++) // 24hr - ppm
  {
    $hour_value = date("H");
    //$hour_value = $vonn_controller;
    $data_date_tomorrow = substr($bancal_pm10_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_pm10_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_pm10_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //echo "pm VALUES ARE: ".$bancal_pm10_values[$i]->concentration_value."<br/>";
        //$pm_10_ave += $bancal_pm10_values[$i]->concentration_value;
        //$pm_10_ctr++;
      }

      else
      {
        //echo "PM 10 VALUES ARE: ".$bancal_pm10_values[$i]->concentration_value."<br/>";
        $pm_10_ave += $bancal_pm10_values[$i]->concentration_value;
        $pm_10_ctr++;

        $ave = $pm_10_ave / $pm_10_ctr;
        $aqi_value = round(calculateAQI($pm_10_guideline_values, $ave, 0, $aqi_values));
        array_push($bancal_pm10_aqi_values, $aqi_value);
      }
    }
  }

  for($i = 0; $i < count($bancal_tsp_values); $i++) // 24hr - ppm
  {
    $hour_value = date("H");
    //$hour_value = $vonn_controller;
    $data_date_tomorrow = substr($bancal_tsp_values[$i]->timestamp, 0, -9);
    $data_hour_value = substr($bancal_tsp_values[$i]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value)
    {
      if(count($bancal_tsp_values) == 24 && $data_date_tomorrow == $data_tomorrow)
      {
        //echo "tsp VALUES ARE: ".$bancal_pm10_values[$i]->concentration_value."<br/>";
        //$tsp_ave += $bancal_pm10_values[$i]->concentration_value;
        //$tsp_ctr++;
      }

      else
      {
        //echo "TSP VALUES ARE: ".$bancal_tsp_values[$i]->concentration_value."<br/>";
        $tsp_ave += $bancal_tsp_values[$i]->concentration_value;
        $tsp_ctr++;

        $ave = $tsp_ave / $tsp_ctr;
        $aqi_value = round(calculateAQI($tsp_guideline_values, $ave, 0, $aqi_values));
        array_push($bancal_tsp_aqi_values, $aqi_value);
      }
    }
  }

  if($carbon_monoxide_ctr > 0){
    $carbon_monoxide_ave /= $carbon_monoxide_ctr;
  }

  if($sulfur_dioxide_ctr > 0)
  {
    $sulfur_dioxide_ave /= $sulfur_dioxide_ctr;
  }

  if($nitrogen_dioxide_ctr > 0)
  {
    $nitrogen_dioxide_ave /= $nitrogen_dioxide_ctr;
  }

  if($ozone_1_ctr > 0)
  {
    $ozone_1_ave /= $ozone_1_ctr;
  }

  if($ozone_8_ctr > 0)
  {
    $ozone_8_ave /= $ozone_8_ctr;
  }

  if($pm_10_ctr > 0)
  {
    $pm_10_ave /= $pm_10_ctr;
  }

  if($tsp_ctr > 0)
  {
    $tsp_ave /= $tsp_ctr;
  }

  //echo "AVE IS: ".$carbon_monoxide_ave."<br/>";
  //echo "AVE IS: ".$carbon_monoxide_ave."<br/>";
  //echo "AVERAGE IS: ".$carbon_monoxide_ave."<br/>";

  /*
  $bancal_co_values = array();
  $bancal_so2_values = array();
  $bancal_no2_values = array();
  $bancal_o3_values = array();
  $bancal_pb_values = array();
  $bancal_pm10_values = array();
  $bancal_tsp_values = array();
  */


  $carbon_monoxide_aqi = 0;
  $sulfur_dioxide_aqi = 0;
  $nitrogen_dioxide_aqi = 0;
  $ozone_8_aqi = 0;
  $ozone_1_aqi = 0;
  $lead_aqi = 0; // None
  $pm_10_aqi = 0;
  $tsp_aqi = 0;

  //echo "CO AVE IS: ".floorDec($carbon_monoxide_ave, $precision = 1)."<br/>";
  $carbon_monoxide_aqi = round(calculateAQI($co_guideline_values, $carbon_monoxide_ave, 1, $aqi_values));
  //echo "CO AQI: ".$carbon_monoxide_aqi."<br/>";

  //echo "<br/>";

  //echo "SO2 AVE IS: ".floorDec($sulfur_dioxide_ave, $precision = 3)."<br/>";
  $sulfur_dioxide_aqi = round(calculateAQI($sufur_guideline_values, $sulfur_dioxide_ave, 3, $aqi_values));
  //echo "SO2 AQI: ".$sulfur_dioxide_aqi."<br/>";

  //echo "<br/>";

  //echo "NO2 AVE IS: ".floorDec($nitrogen_dioxide_ave, $precision = 2)."<br/>";
  $nitrogen_dioxide_aqi = round(calculateAQI($no2_guideline_values, $nitrogen_dioxide_ave, 2, $aqi_values));
  //echo "NO2 AQI: ".$nitrogen_dioxide_aqi."<br/>";

  //echo "<br/>";

  //echo "O3 - 8 AVE IS: ".floorDec($ozone_8_ave, $precision = 3)."<br/>";
  $ozone_8_aqi = round(calculateAQI($ozone_guideline_values_8, $ozone_8_ave, 3, $aqi_values));
  //echo "O3-8 AQI: ".$ozone_8_aqi."<br/>";

  //echo "<br/>";

  //echo "03 1 AVE IS: ".floorDec($ozone_1_ave, $precision = 3)."<br/>";
  $ozone_1_aqi = round(calculateAQI($ozone_guideline_values_1, $ozone_1_ave, 3, $aqi_values));
  //echo "O3-1 AQI: ".$ozone_1_aqi."<br/>";

  //echo "<br/>";

  //echo "PM 10 AVE IS: ".floorDec($pm_10_ave, $precision = 0)."<br/>";
  $pm_10_aqi = round(calculateAQI($pm_10_guideline_values, $pm_10_ave, 2, $aqi_values));
  //echo "PM 10 AQI: ".$pm_10_aqi."<br/>";

  //echo "<br/>";

  //echo "TSP AVE IS: ".floorDec($tsp_ave, $precision = 0)."<br/>";
  $tsp_aqi = round(calculateAQI($tsp_guideline_values, $tsp_ave, 2, $aqi_values));
  //echo "TSP AQI: ".$tsp_aqi."<br/>";

  $bancal_aqi_values = array();

  array_push($bancal_aqi_values, $carbon_monoxide_aqi);
  array_push($bancal_aqi_values, $sulfur_dioxide_aqi);
  array_push($bancal_aqi_values, $nitrogen_dioxide_aqi);
  array_push($bancal_aqi_values, $ozone_8_aqi);
  /*
  if($ozone_8_aqi >= $ozone_1_aqi)
  {
    array_push($bancal_aqi_values, $ozone_8_aqi);
  }

  else
  {
    array_push($bancal_aqi_values, $ozone_1_aqi);
  }*/

  array_push($bancal_aqi_values, $ozone_1_aqi);
  array_push($bancal_aqi_values, $pm_10_aqi);
  array_push($bancal_aqi_values, $tsp_aqi);

  $bancal_prevalentIndex = array_keys($bancal_aqi_values, max($bancal_aqi_values));
  //echo $max[0];

  /*
  $bancal_co_aqi_values = array();
  $bancal_so2_aqi_values = array();
  $bancal_no2_aqi_values = array();
  $bancal_o3_aqi_values = array();
  $bancal_o3_1_aqi_values = array();
  $bancal_pm10_aqi_values = array();
  $bancal_tsp_aqi_values = array();
  */

  //$bancal_min_max_values = [[min($bancal_co_aqi_values),max($bancal_co_aqi_values)],[min($bancal_so2_aqi_values), max($bancal_so2_aqi_values)],[min($bancal_no2_aqi_values), max($bancal_no2_aqi_values)],[min($bancal_o3_aqi_values), max($bancal_o3_aqi_values)],[min($bancal_o3_1_aqi_values), max($bancal_o3_1_aqi_values)],[min($bancal_pm10_aqi_values), max($bancal_pm10_aqi_values)], [min($bancal_tsp_aqi_values), max($bancal_tsp_aqi_values)]];

  $bancal_min_max_values = array();

  if(count($bancal_co_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_co_aqi_values),max($bancal_co_aqi_values)]);
  }if(count($bancal_so2_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_so2_aqi_values), max($bancal_so2_aqi_values)]);
  }if(count($bancal_no2_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_no2_aqi_values), max($bancal_no2_aqi_values)]);
  }if(count($bancal_o3_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_o3_aqi_values), max($bancal_o3_aqi_values)]);
  }if(count($bancal_o3_1_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_o3_1_aqi_values), max($bancal_o3_1_aqi_values)]);
  }if(count($bancal_pm10_aqi_values) > 0){
    array_push($bancal_min_max_values, [min($bancal_pm10_aqi_values), max($bancal_pm10_aqi_values)]);
  }if(count($bancal_tsp_aqi_values) > 0){
    array_push($bancal_tsp_aqi_values, [min($bancal_tsp_aqi_values), max($bancal_tsp_aqi_values)]);
  }

  /*
  $bancal_co_aqi_values = array();

  for($x = 0 ; $x < count($bancal_co_values); i++)
  {

  }
  */

  $area_chosen_name = "hii";

  if(isset($_GET["area"]))
  {
      $area_chosen_name = $_GET["area"];
  }

  function calculateAQI($gv, $ave, $prec, $aqi_val)
  {
    $aqi = 0;

    for($x = 0; $x < count($gv); $x++)
    {
      $roundedValue = floorDec($ave, $precision = $prec);

      if($roundedValue >= $gv[$x][0] && $roundedValue <= $gv[$x][1])
      {
        //$aqi = round((($aqi_val[$x][1] - $aqi_val[$x][0])/($gv[$x][1] - $gv[$x][0])) * ($roundedValue - $gv[$x][0]) + $aqi_val[$x][0]);
        $aqi = (($aqi_val[$x][1] - $aqi_val[$x][0])/($gv[$x][1] - $gv[$x][0])) * ($roundedValue - $gv[$x][0]) + $aqi_val[$x][0];
        break;
      }
    }

    return $aqi;
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

  var pollutant_labels = ["Carbon Monoxide", "Sulfur Dioxide", "Nitrogen Dioxide", "Ozone 8 Hr", "Ozone 1 Hr", "Particulate Matter 10", "Totally Suspended Particles"];
  var pollutant_symbols = ["CO", "SO2", "NO2", "O3 (8)", "O3 (1)","PM 10", "TSP"];

  var goodAir = "#2196F3";
  var fairAir = "#FFEB3B";
  var unhealthyAir = "#FF9800";
  var veryUnhealthyAir = "#f44336";
  var acutelyUnhealthyAir = "#9C27B0";
  var emergencyAir = "#b71c1c";
  var otherAir = "#212121";

  var bancalAllDayValues_array = <?= json_encode($bancalAllDayValues_array) ?>;

  var date_gathered = <?= json_encode($date_gathered) ?>;

  var bancal_aqi_values = <?= json_encode($bancal_aqi_values) ?>;
  var bancal_prevalentIndex = <?= $bancal_prevalentIndex[0] ?>;

  var bancal_prevalent_value = JSON.stringify(bancal_aqi_values[bancal_prevalentIndex]).replace(/"/g, '');

  var bancal_co_aqi_values = <?= json_encode($bancal_co_aqi_values) ?>;
  var bancal_so2_aqi_values = <?= json_encode($bancal_so2_aqi_values) ?>;
  var bancal_no2_aqi_values = <?= json_encode($bancal_no2_aqi_values) ?>;
  var bancal_o3_aqi_values = <?= json_encode($bancal_o3_aqi_values) ?>;
  var bancal_o3_1_aqi_values = <?= json_encode($bancal_o3_1_aqi_values) ?>;
  var bancal_pm10_aqi_values = <?= json_encode($bancal_pm10_aqi_values) ?>;
  var bancal_tsp_aqi_values = <?= json_encode($bancal_tsp_aqi_values) ?>;

  var bancal_min_max_values = <?= json_encode($bancal_min_max_values) ?>;

  var area_chosen = "<?= $area_chosen_name ?>";

  //alert(area_chosen);

  //alert(JSON.stringify(bancal_aqi_values));
  //alert(JSON.stringify(bancal_prevalentIndex));
</script>

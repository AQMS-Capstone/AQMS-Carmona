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

  // --------- GET VALUES FROM DB --------- //

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d");
  $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
  $date_tomorrow = $date_tomorrow." 00:00:00";

  //$bancal_date_gathered = date("Y-m-d H")." 00:00";

  $bancal_date_gathered = "";

  $bancalAllDayValues_array = array();
  $slexAllDayValues_array = array();

  $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE TIMESTAMP LIKE '%$date_now%' OR TIMESTAMP = '$date_tomorrow' ORDER BY TIMESTAMP";
  //echo $sql;
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

  // --------- SEPARATE THE VALUES INTO SPECIFIED ARRAYS --------- //

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

  // --------- DECLARE AVERAGE VARIABLES, CTR, AND GUIDELINES --------- //

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

  $bancal_aqi_values = array();

  $hour_value = 0 ; // < --------- CURRENT HOUR --------- >

  // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    //$prev_hour_value = 0;

    for($k = 0; $k < count($bancal_co_values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($bancal_co_values[$k]->timestamp, 11, -6);

      if($i == 23 && $data_hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
      {
        $check_24 = true;
        $index_24 = $k;
        break;
      }

      else if(($i + 1) == $data_hour_value) // < --------- IF ITS A NORMAL HOUR --------- >
      {
        $check = true;
        $index = $k;
        break;
      }
    }

      if($check_24 && $hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
      {
        $data_date_tomorrow = substr($bancal_co_values[$index_24]->timestamp, 0, -9);
        $data_hour_value = substr($bancal_co_values[$index_24]->timestamp, 11, -6);

        $carbon_monoxide_ave += $bancal_co_values[$index_24]->concentration_value;
        $carbon_monoxide_ctr++;

        $ave = $carbon_monoxide_ave / $carbon_monoxide_ctr;
        $aqi_value = round(calculateAQI($co_guideline_values, $ave, 1, $aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value)
        {
          //array_push($bancal_aqi_values,$aqi_value);
          $bancal_date_gathered = $bancal_co_values[$index_24]->timestamp;
        }

        array_push($bancal_co_aqi_values, $aqi_value);
      }

      else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
      {
        $data_date_tomorrow = substr($bancal_co_values[$index]->timestamp, 0, -9);
        $data_hour_value = substr($bancal_co_values[$index]->timestamp, 11, -6);

        if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
        {
          if((($i + 1) % 8) == 1) // < --------- 8HR AVERAGING WILL ENTAIL RESETTING OF AVERAGE VALUES TO 0 --------- >
          {
            $carbon_monoxide_ctr = 0;
            $carbon_monoxide_ave = 0;
          }

          $carbon_monoxide_ave += $bancal_co_values[$index]->concentration_value;
          $carbon_monoxide_ctr++;

          if($carbon_monoxide_ctr > 0) // < --------- TO AVOID DIVISION BY 0 --------- >
          {
            $ave = $carbon_monoxide_ave / $carbon_monoxide_ctr;
          }else {
            $ave = $carbon_monoxide_ave;
          }

          $aqi_value = round(calculateAQI($co_guideline_values, $ave, 1, $aqi_values));

          if($aqi_value > 400)
          {
            $aqi_value = -1;
          }

          if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
          {
            //array_push($bancal_aqi_values,$aqi_value);
            $bancal_date_gathered = $bancal_co_values[$index]->timestamp;
          }

          array_push($bancal_co_aqi_values, $aqi_value);
        }

        else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
        {
          array_push($bancal_co_aqi_values, -1);
        }
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($bancal_co_aqi_values, -1);
      }
  }

  // --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //
  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    for($k = 0; $k < count($bancal_so2_values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($bancal_so2_values[$k]->timestamp, 11, -6);

      if($i == 23 && $data_hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
      {
        $check_24 = true;
        $index_24 = $k;
        break;
      }

      else if(($i + 1) == $data_hour_value) // < --------- IF ITS A NORMAL HOUR --------- >
      {
        $check = true;
        $index = $k;
        break;
      }
    }

    if($check_24 && $hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
    {
      $data_date_tomorrow = substr($bancal_so2_values[$index_24]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_so2_values[$index_24]->timestamp, 11, -6);

      $sulfur_dioxide_ave += $bancal_so2_values[$index_24]->concentration_value;
      $sulfur_dioxide_ctr++;

      $ave = $sulfur_dioxide_ave / $sulfur_dioxide_ctr;
      $aqi_value = round(calculateAQI($sufur_guideline_values, $ave, 3, $aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = -1;
      }

      if($data_hour_value == $hour_value)
      {
        //array_push($bancal_aqi_values,$aqi_value);
        $bancal_date_gathered = $bancal_so2_values[$index_24]->timestamp;
      }

      array_push($bancal_so2_aqi_values, $aqi_value);
    }

    else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
    {
      $data_date_tomorrow = substr($bancal_so2_values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_so2_values[$index]->timestamp, 11, -6);

      if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
      {
        $sulfur_dioxide_ave += $bancal_so2_values[$index]->concentration_value;
        $sulfur_dioxide_ctr++;

        $ave = $sulfur_dioxide_ave / $sulfur_dioxide_ctr;
        $aqi_value = round(calculateAQI($sufur_guideline_values, $ave, 3, $aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
        {
          $bancal_date_gathered = $bancal_so2_values[$index]->timestamp;
        }

        array_push($bancal_so2_aqi_values, $aqi_value);
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($bancal_so2_aqi_values, -1);
      }
    }

    else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
    {
      array_push($bancal_so2_aqi_values, -1);
    }
  }

  // --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    for($k = 0; $k < count($bancal_no2_values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($bancal_no2_values[$k]->timestamp, 11, -6);

      if($i == 23 && $data_hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
      {
        $check_24 = true;
        $index_24 = $k;
        break;
      }

      else if(($i + 1) == $data_hour_value) // < --------- IF ITS A NORMAL HOUR --------- >
      {
        $check = true;
        $index = $k;
        break;
      }
    }

    if($check_24 && $hour_value == 0) // < --------- IF THE HOUR IS 24TH HOUR --------- >
    {
      $data_date_tomorrow = substr($bancal_no2_values[$index_24]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_no2_values[$index_24]->timestamp, 11, -6);

      $nitrogen_dioxide_ave = $bancal_no2_values[$index_24]->concentration_value;
      $aqi_value = round(calculateAQI($no2_guideline_values, $nitrogen_dioxide_ave, 2, $aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = -1;
      }

      if($data_hour_value == $hour_value)
      {
        //array_push($bancal_aqi_values,$aqi_value);
        $bancal_date_gathered = $bancal_no2_values[$index_24]->timestamp;
      }

      array_push($bancal_no2_aqi_values, $aqi_value);
    }

    else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
    {
      $data_date_tomorrow = substr($bancal_no2_values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_no2_values[$index]->timestamp, 11, -6);

      if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
      {
        $nitrogen_dioxide_ave = $bancal_no2_values[$index]->concentration_value;
        $aqi_value = round(calculateAQI($no2_guideline_values, $nitrogen_dioxide_ave, 2, $aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
        {
          $bancal_date_gathered = $bancal_no2_values[$index]->timestamp;
        }

        array_push($bancal_no2_aqi_values, $aqi_value);
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($bancal_no2_aqi_values, -1);
      }
    }

    else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
    {
      array_push($bancal_no2_aqi_values, -1);
    }
  }

  // --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

  $bancal_co_max = max($bancal_co_aqi_values);
  $bancal_so2_max = max($bancal_so2_aqi_values);
  $bancal_no2_max = max($bancal_no2_aqi_values);

  // --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

  $bancal_min_max_values = array();

  if(count($bancal_co_aqi_values) > 0) // < --------- AVOIDS NO DATA --------- >
  {
    $checker = false;

    for($x = 0 ; $x < count($bancal_co_aqi_values); $x++)
    {
      if($bancal_co_aqi_values[$x] > 0) // < --------- CHECK IF THE VALUE IS GREATER THAN 0, TO AVOID ERROR IN USING MIN METHOD --------- >
      {
        $checker = true;
        break;
      }
    }

    if($checker)
    {
      array_push($bancal_min_max_values, [min(array_filter($bancal_co_aqi_values, function($v) { return $v >= 0; })),max($bancal_co_aqi_values)]);
    }

    else
    {
      array_push($bancal_min_max_values, [min($bancal_co_aqi_values),max($bancal_co_aqi_values)]);
    }
  }

  else  // < --------- FILL IN VALUES WITH 0 --------- >
  {
    array_push($bancal_min_max_values, [0,0]);
  }

  if(count($bancal_so2_aqi_values) > 0) // < --------- AVOIDS NO DATA --------- >
  {
    $checker = false;

    for($x = 0 ; $x < count($bancal_so2_aqi_values); $x++)
    {
      if($bancal_so2_aqi_values[$x] > 0) // < --------- CHECK IF THE VALUE IS GREATER THAN 0, TO AVOID ERROR IN USING MIN METHOD --------- >
      {
        $checker = true;
        break;
      }
    }

    if($checker)
    {
      array_push($bancal_min_max_values, [min(array_filter($bancal_so2_aqi_values, function($v) { return $v >= 0; })),max($bancal_so2_aqi_values)]);
    }

    else
    {
      array_push($bancal_min_max_values, [min($bancal_so2_aqi_values),max($bancal_so2_aqi_values)]);
    }
  }

  else  // < --------- FILL IN VALUES WITH 0 --------- >
  {
    array_push($bancal_min_max_values, [0,0]);
  }

  if(count($bancal_no2_aqi_values) > 0) // < --------- AVOIDS NO DATA --------- >
  {
    $checker = false;

    for($x = 0 ; $x < count($bancal_no2_aqi_values); $x++)
    {
      if($bancal_no2_aqi_values[$x] > 0) // < --------- CHECK IF THE VALUE IS GREATER THAN 0, TO AVOID ERROR IN USING MIN METHOD --------- >
      {
        $checker = true;
        break;
      }
    }

    if($checker)
    {
      array_push($bancal_min_max_values, [min(array_filter($bancal_no2_aqi_values, function($v) { return $v >= 0; })),max($bancal_no2_aqi_values)]);
    }

    else
    {
      array_push($bancal_min_max_values, [min($bancal_no2_aqi_values),max($bancal_no2_aqi_values)]);
    }
  }

  else  // < --------- FILL IN VALUES WITH 0 --------- >
  {
    array_push($bancal_min_max_values, [0,0]);
  }

  // --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

  //echo $hour_value;

  if($bancal_co_max >= 0)
  {
    if($hour_value == 0)
    {
      array_push($bancal_aqi_values, $bancal_co_aqi_values[23]);
    }

    else
    {
      array_push($bancal_aqi_values, $bancal_co_aqi_values[$hour_value-1]);
    }
  }

  else
  {
    //array_push($bancal_aqi_values, $bancal_co_aqi_values[-1]);
  }

  if($bancal_so2_max >= 0)
  {
    if($hour_value == 0)
    {
      array_push($bancal_aqi_values, $bancal_so2_aqi_values[23]);
    }

    else
    {
      array_push($bancal_aqi_values, $bancal_so2_aqi_values[$hour_value-1]);
    }
  }

  else
  {
    //array_push($bancal_aqi_values, $bancal_so2_aqi_values[-1]);
  }

  if($bancal_no2_max >= 0)
  {
    if($hour_value == 0)
    {
      array_push($bancal_aqi_values, $bancal_no2_aqi_values[23]);
    }

    else
    {
      array_push($bancal_aqi_values, $bancal_no2_aqi_values[$hour_value-1]);
    }
  }

  else
  {
    //array_push($bancal_aqi_values, "-1");
  }

  // --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

  if(count($bancal_aqi_values) > 0 )
  {
    $bancal_prevalentIndex = array_keys($bancal_aqi_values, max($bancal_aqi_values));
  }

  else {
    $bancal_prevalentIndex = "0";
  }

  // --------- GET USER CHOSEN AREA --------- //

  $area_chosen_name = "";

  if(isset($_GET["area"]))
  {
      $area_chosen_name = $_GET["area"];
  }

  // --------- V O N N M E T H O D S --------- //

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

      else if($x == count($gv) - 1)
      {
        $aqi = -1;
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
  var bancal_aqi_values = <?= json_encode($bancal_aqi_values) ?>;
  var bancal_prevalentIndex = <?= $bancal_prevalentIndex[0] ?>;
  var bancal_prevalent_value = JSON.stringify(bancal_aqi_values[bancal_prevalentIndex]).replace(/"/g, '');
  var bancal_min_max_values = <?= json_encode($bancal_min_max_values) ?>;

  var bancal_date_gathered = <?= json_encode($bancal_date_gathered) ?>;

  var bancal_co_aqi_values = <?= json_encode($bancal_co_aqi_values) ?>;
  var bancal_so2_aqi_values = <?= json_encode($bancal_so2_aqi_values) ?>;
  var bancal_no2_aqi_values = <?= json_encode($bancal_no2_aqi_values) ?>;
  var bancal_o3_aqi_values = <?= json_encode($bancal_o3_aqi_values) ?>;
  var bancal_o3_1_aqi_values = <?= json_encode($bancal_o3_1_aqi_values) ?>;
  var bancal_pm10_aqi_values = <?= json_encode($bancal_pm10_aqi_values) ?>;
  var bancal_tsp_aqi_values = <?= json_encode($bancal_tsp_aqi_values) ?>;

  var bancal_co_max = <?= json_encode($bancal_co_max) ?>;
  var bancal_so2_max = <?= json_encode($bancal_so2_max) ?>;

  var area_chosen = "<?= $area_chosen_name ?>";;
</script>

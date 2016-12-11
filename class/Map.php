<?php

class Master{

  var $area_name = "";
  var $e_id = "";
  var $concentration_value = "";
  var $timestamp = "";
  var $e_name = "";
  var $e_symbol = "";

  function Master(){}
}

class Area{

  var $name = "";
  var $date_gathered = "";
  var $AllDayValues_array = array();
  var $co_values = array();
  var $so2_values = array();
  var $no2_values = array();
  var $o3_values = array();
  var $pb_values = array();
  var $pm10_values = array();
  var $tsp_values = array();
  var $co_actual_values = array();
  var $so2_actual_values = array();
  var $no2_actual_values = array();
  var $o3_actual_values = array();
  var $o3_1_actual_values = array();
  var $pm10_actual_values = array();
  var $tsp_actual_values = array();
  var $co_aqi_values = array();
  var $so2_aqi_values = array();
  var $no2_aqi_values = array();
  var $o3_aqi_values = array();
  var $o3_1_aqi_values = array();
  var $pm10_aqi_values = array();
  var $tsp_aqi_values = array();
  var $aqi_values = array();
  var $min_max_values = array();
  var $prevalentIndex = "";
  var $co_max = 0;
  var $so2_max = 0;
  var $no2_max = 0;
  var $o3_max = 0;
  var $pm10_max = 0;
  var $tsp_max = 0;

  function Area(){}
}

// --------- FUNCTIONS --------- //

function DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, $area, $date_now_string)
{
  require 'public/include/db_connect.php';

  $array_holder = array();

  if($hour_value == 0)
  {
    $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE (TIMESTAMP LIKE '%$date_yesterday%' OR TIMESTAMP = '$date_now_string') AND AREA_NAME = '$area' ORDER BY TIMESTAMP";
  }

  else
  {
    $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE (TIMESTAMP LIKE '%$date_now%' OR TIMESTAMP = '$date_tomorrow') AND AREA_NAME = '$area' ORDER BY TIMESTAMP";
  }

  $result =  mysqli_query($con,$sql);

  while($row=mysqli_fetch_assoc($result))
  {
    $dataClass = new Master();

    $dataClass->area_name = $row['area_name'];
    $dataClass->e_id = $row['e_id'];
    $dataClass->concentration_value = $row['concentration_value'];
    $dataClass->timestamp = $row['timestamp'];
    $dataClass->e_name = $row['e_name'];
    $dataClass->e_symbol = $row['e_symbol'];

    array_push($array_holder, $dataClass);
  }

  return $array_holder;
}
function EightHrAveraging($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  $ctr = 0;
  $ave = 0;

  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    if((($i + 1) % 8) == 1) // < --------- 8HR AVERAGING WILL ENTAIL RESETTING OF AVERAGE VALUES TO 0 --------- >
    {
      //echo "yas: ".$i. " ";
      $ctr = 0;
      $ave = 0;
    }

    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    //$prev_hour_value = 0;

    for($k = 0; $k < count($values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($values[$k]->timestamp, 11, -6);

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
      $data_date_tomorrow = substr($values[$index_24]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index_24]->timestamp, 11, -6);

      $ave += $values[$index_24]->concentration_value;
      $ctr++;

      $ave = $ave / $ctr;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = -1;
      }

      if($data_hour_value == $hour_value)
      {
        //array_push($bancal_aqi_values,$aqi_value);
        $date_gathered = $values[$index_24]->timestamp;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    }

    else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
    {
      $data_date_tomorrow = substr($values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index]->timestamp, 11, -6);

      if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
      {
        $ave += $values[$index]->concentration_value;
        $ctr++;

        if($ctr > 0) // < --------- TO AVOID DIVISION BY 0 --------- >
        {
          $ave = $ave / $ctr;
        }else {
          $ave = $ave;
        }

        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
        {
          //array_push($bancal_aqi_values,$aqi_value);
          $date_gathered = $values[$index]->timestamp;
        }

        //echo $aqi_value." ";

        array_push($aqi_values, $aqi_value);
        array_push($actual_values, $ave);
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($aqi_values, -1);
        array_push($actual_values, -1);
      }
    }

    else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
    {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }
  }

  array_push($container, $aqi_values);
  array_push($container, $actual_values);
  array_push($container, $date_gathered);

  return $container;
}
function TwentyFourHrAveraging($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  $ctr = 0;
  $ave = 0;

  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    for($k = 0; $k < count($values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($values[$k]->timestamp, 11, -6);

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
      $data_date_tomorrow = substr($values[$index_24]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index_24]->timestamp, 11, -6);

      $ave += $values[$index_24]->concentration_value;
      $ctr++;

      $ave = $ave / $ctr;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = -1;
      }

      if($data_hour_value == $hour_value)
      {
        //array_push($bancal_aqi_values,$aqi_value);
        $date_gathered = $values[$index_24]->timestamp;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    }

    else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
    {
      $data_date_tomorrow = substr($values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index]->timestamp, 11, -6);

      if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
      {
        $ave += $values[$index]->concentration_value;
        $ctr++;

        $ave = $ave / $ctr;
        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
        {
          $date_gathered = $values[$index]->timestamp;
        }

        array_push($aqi_values, $aqi_value);
        array_push($actual_values, $ave);
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($aqi_values, -1);
        array_push($actual_values, -1);
      }
    }

    else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
    {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }
  }

  array_push($container, $aqi_values);
  array_push($container, $actual_values);
  array_push($container, $date_gathered);

  return $container;
}
function OneHrAveraging($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  $ave = 0;

  for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
  {
    $index_24 = -1;
    $check_24 = false;

    $check = false;
    $index = 0;

    for($k = 0; $k < count($values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
    {
      $data_hour_value = substr($values[$k]->timestamp, 11, -6);

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
      $data_date_tomorrow = substr($values[$index_24]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index_24]->timestamp, 11, -6);

      $ave = $values[$index_24]->concentration_value;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = -1;
      }

      if($data_hour_value == $hour_value)
      {
        //array_push($bancal_aqi_values,$aqi_value);
        $date_gathered = $values[$index_24]->timestamp;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    }

    else if($check) // < --------- IF THE HOUR IS A NORMAL HOUR --------- >
    {
      $data_date_tomorrow = substr($values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($values[$index]->timestamp, 11, -6);

      if($data_hour_value <= $hour_value || $hour_value == 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
      {
        $ave = $values[$index]->concentration_value;
        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

        if($aqi_value > 400)
        {
          $aqi_value = -1;
        }

        if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
        {
          $date_gathered = $values[$index]->timestamp;
        }

        array_push($aqi_values, $aqi_value);
        array_push($actual_values, $ave);
      }

      else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
      {
        array_push($aqi_values, -1);
        array_push($actual_values, -1);
      }
    }

    else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
    {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }
  }

  array_push($container, $aqi_values);
  array_push($container, $actual_values);
  array_push($container, $date_gathered);

  return $container;
}
function calculateAQI($gv, $ave, $prec, $aqi_val)
{
  $aqi = 0;

  $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
  $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
  $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
  $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
  $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3

  for($x = 0; $x < count($gv); $x++)
  {
    if($gv == $tsp_guideline_values)
    {
      //echo "HEHE";

      if($ave >= 900)
      {
        $roundedValue = floorDec($ave, $precision = $prec);

        if($roundedValue >= $gv[$x][0])
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

      else
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

    }

    else
    {
      if($gv == $ozone_guideline_values_8)
      {
        //echo "HAHA";

        if($ave > 0.374)
        {
          //echo "HIHI";
          $gv = $ozone_guideline_values_1;
        }
      }

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
  }

  return $aqi;
}
function calculateConcentrationValue($gv, $aqi_value, $prec, $aqi_val)
{
  $concentration_value = 0;
  $roundedValue = round($aqi_value);
  $index = 0;

  for($x = 0; $x < count($aqi_val); $x++) {
    if($roundedValue >= $aqi_val[$x][0] && $roundedValue <= $aqi_val[$x][1]) {
      $index = $x;
      break;
    }

    else
    {
      $index - -1;
    }
  }

  if(index == -1)
  {
    return index;
  }

  else {
    $concentration_value = ($roundedValue - $aqi_val[$index][0]) * (($gv[$index][1] - $gv[$index][0]) / ($aqi_val[$index][1] - $aqi_val[$index][0])) + $gv[$index][0];

    return floorDec($concentration_value, $precision = $prec);
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
function MinMax($aqi_values)
{
  $data_container = array();

  if(count($aqi_values) > 0) // < --------- AVOIDS NO DATA --------- >
  {
    $checker = false;

    for($x = 0 ; $x < count($aqi_values); $x++)
    {
      if($aqi_values[$x] > 0) // < --------- CHECK IF THE VALUE IS GREATER THAN 0, TO AVOID ERROR IN USING MIN METHOD --------- >
      {
        $checker = true;
        break;
      }
    }

    if($checker)
    {
      $data_container = [min(array_filter($aqi_values, function($v) { return $v >= 0; })),max($aqi_values)];
      //array_push($data_container, [min(array_filter($aqi_values, function($v) { return $v >= 0; })),max($aqi_values)]);
    }

    else
    {
      $data_container = [min($aqi_values),max($aqi_values)];
      //array_push($data_container, [min($aqi_values),max($aqi_values)]);
    }
  }

  else  // < --------- FILL IN VALUES WITH 0 --------- >
  {
    $data_container = [0,0];
    //array_push($data_container, [0,0]);
  }

  return $data_container;
}
function AQIValues($max_value, $hour_value, $pollutant_aqi_values)
{
  $data_container = 0;

  if($max_value >= 0)
  {
    if($hour_value == 0)
    {
      $data_container = $pollutant_aqi_values[23];
      //array_push($area_aqi_values, $pollutant_aqi_values[23]);
    }

    else
    {
      $data_container = $pollutant_aqi_values[$hour_value-1];
      //array_push($area_aqi_values, $pollutant_aqi_values[$hour_value-1]);
    }
  }

  else
  {
    $data_container = -1;
    //array_push($area_aqi_values, -1);
  }

  return $data_container;
}
function Generate($name)
{
  $area_generate = new Area();
  $area_generate->name = $name;
  // --------- SERVER TIME --------- //

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d");
  $date_now_string = $date_now." 00:00:00";

  $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
  $date_tomorrow = $date_tomorrow." 00:00:00";

  $date_yesterday = date("Y-m-d", strtotime('yesterday'));
  $date_yesterday_string = $date_yesterday." 00:00:00";

  $hour_value = date("H"); // < --------- CURRENT HOUR --------- >

  // --------- GUIDELINE VALUES --------- //

  $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
  $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
  $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
  $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
  $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
  $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

  // --------- GET VALUES FROM DB --------- //

  $area_generate->AllDayValues_array = DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, $name, $date_now_string);

  // --------- SEPARATE THE VALUES INTO SPECIFIED ARRAYS --------- //

  for($i = 0; $i < count($area_generate->AllDayValues_array); $i++)
  {
    switch($area_generate->AllDayValues_array[$i]->e_id)
    {
      case 1: // CO
        array_push($area_generate->co_values, $area_generate->AllDayValues_array[$i]);
        break;

      case 2: // SO2
        array_push($area_generate->so2_values, $area_generate->AllDayValues_array[$i]);
        break;

      case 3: // NO2
        array_push($area_generate->no2_values, $area_generate->AllDayValues_array[$i]);
        break;

      case 4: // O3
        array_push($area_generate->o3_values, $area_generate->AllDayValues_array[$i]);
        break;

      case 5: // PM 10
        array_push($area_generate->pm10_values, $area_generate->AllDayValues_array[$i]);
        break;

      case 6: // TSP
        array_push($area_generate->tsp_values, $area_generate->AllDayValues_array[$i]);
        break;
    }
  }

  // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
  $data_container = EightHrAveraging($area_generate->co_values, $hour_value, $co_guideline_values, $aqi_values, 1);

  $area_generate->co_aqi_values = $data_container[0];
  $area_generate->co_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //
  $data_container = TwentyFourHrAveraging($area_generate->so2_values, $hour_value, $sufur_guideline_values, $aqi_values, 3);

  $area_generate->so2_aqi_values = $data_container[0];
  $area_generate->so2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  $data_container = OneHrAveraging($area_generate->no2_values, $hour_value, $no2_guideline_values, $aqi_values, 2);

  $area_generate->no2_aqi_values = $data_container[0];
  $area_generate->no2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM O3 --------- //

  $data_container = EightHrAveraging($area_generate->o3_values, $hour_value, $ozone_guideline_values_8, $aqi_values, 3);

  $area_generate->o3_aqi_values = $data_container[0];
  $area_generate->o3_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM PM 10 --------- //

  $data_container = TwentyFourHrAveraging($area_generate->pm10_values, $hour_value, $pm_10_guideline_values, $aqi_values, 0);

  $area_generate->pm10_aqi_values = $data_container[0];
  $area_generate->pm10_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM TSP --------- // REMEMBER TO COMMENT AQI > 400 IN TSP!!

  $data_container = TwentyFourHrAveraging($area_generate->tsp_values, $hour_value, $tsp_guideline_values, $aqi_values, 0);

  $area_generate->tsp_aqi_values = $data_container[0];
  $area_generate->tsp_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

  $area_generate->co_max = max($area_generate->co_aqi_values);
  $area_generate->so2_max = max($area_generate->so2_aqi_values);
  $area_generate->no2_max = max($area_generate->no2_aqi_values);
  $area_generate->o3_max = max($area_generate->o3_aqi_values);
  $area_generate->pm10_max = max($area_generate->pm10_aqi_values);
  $area_generate->tsp_max = max($area_generate->tsp_aqi_values);

// --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

  //$min_max_values = array();

  array_push($area_generate->min_max_values, MinMax($area_generate->co_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->so2_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->no2_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->o3_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->pm10_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->tsp_aqi_values));

// --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

  //$aqi_values = array();

  array_push($area_generate->aqi_values, AQIValues($area_generate->co_max, $hour_value, $area_generate->co_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->so2_max, $hour_value, $area_generate->so2_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->no2_max, $hour_value, $area_generate->no2_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->o3_max, $hour_value, $area_generate->o3_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->pm10_max, $hour_value, $area_generate->pm10_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->tsp_max, $hour_value, $area_generate->tsp_aqi_values));

// --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

  if(count($area_generate->aqi_values) > 0 )
  {
    $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));
  }

  else {
    $area_generate->prevalentIndex = "0";
  }

  return $area_generate;
}

// --------- MAIN METHOD --------- //

$bancal = Generate("bancal");
$slex = Generate("slex");

// --------- GET USER CHOSEN AREA --------- //
$area_chosen_name = "Bancal";

if(isset($_GET["area"]))
{
  $area_chosen_name = $_GET["area"];
}
?>

<script type="text/javascript">
  var pollutant_labels = ["Carbon Monoxide", "Sulfur Dioxide", "Nitrogen Dioxide", "Ozone", "Particulate Matter 10", "Totally Suspended Particles"];
  var pollutant_symbols = ["CO", "SO2", "NO2", "O3","PM 10", "TSP"];

  var goodAir = "#4CAF50";
  var fairAir = "#FFEB3B";
  var unhealthyAir = "#FF9800";
  var veryUnhealthyAir = "#f44336";
  var acutelyUnhealthyAir = "#9C27B0";
  var emergencyAir = "#b71c1c";
  var otherAir = "#212121";

  function Area(name, displayName, data){
    return {
      name: name,
      date_gathered: data.date_gathered,
      AllDayValues_array: data.AllDayValues_array,
      co_values: data.co_values,
      so2_values: data.so2_values,
      no2_values: data.no2_values,
      o3_values: data.o3_values,
      pb_values: data.pb_values,
      pm10_values: data.pm10_values,
      tsp_values: data.tsp_values,
      co_actual_values: data.co_actual_values,
      so2_actual_values: data.so2_actual_values,
      no2_actual_values: data.no2_actual_values,
      o3_actual_values: data.o3_actual_values,
      o3_1_actual_values: data.o3_1_actual_values,
      pm10_actual_values: data.pm10_actual_values,
      tsp_actual_values: data.tsp_actual_values,
      co_aqi_values: data.co_aqi_values,
      so2_aqi_values: data.so2_aqi_values,
      no2_aqi_values: data.no2_aqi_values,
      o3_aqi_values: data.o3_aqi_values,
      o3_1_aqi_values: data.o3_1_aqi_values,
      pm10_aqi_values: data.pm10_aqi_values,
      tsp_aqi_values: data.tsp_aqi_values,
      aqi_values: data.aqi_values,
      min_max_values: data.min_max_values,
      prevalentIndex: data.prevalentIndex[0],
      co_max: data.co_max,
      so2_max: data.so2_max,
      no2_max: data.no2_max,
      o3_max: data.o3_max,
      pm10_max: data.pm10_max,
      tsp_max: data.tsp_max,

      AQIStatus: "",
      AirQuality: "",
      AQI: "",
      prevalentPollutant: "",
      d_date_gathered: "",
      prevalent_value: data.aqi_values[data.prevalentIndex[0]],
      displayName: displayName
    };
  }

  var bancal_area = Area("bancal", "Bancal Carmona, Cavite", <?= json_encode($bancal)?>);
  var slex_area = Area("slex", "SLEX Carmona Exit, Cavite", <?= json_encode($slex)?>);

  var area_chosen = "<?= $area_chosen_name ?>";
</script>


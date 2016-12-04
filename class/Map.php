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

  // --------- FUNCTIONS --------- //

  function DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, $area)
{
  require 'public/include/db_connect.php';

  $array_holder = array();

  if($hour_value == 0)
  {
    $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE (TIMESTAMP LIKE '%$date_yesterday%' OR TIMESTAMP = '$date_now') AND AREA_NAME = '$area' ORDER BY TIMESTAMP";
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

  // --------- DECLARATIONS --------- //

  $bancal_date_gathered = "";
  $bancalAllDayValues_array = array();
  $bancal_co_values = array();
  $bancal_so2_values = array();
  $bancal_no2_values = array();
  $bancal_o3_values = array();
  $bancal_pb_values = array();
  $bancal_pm10_values = array();
  $bancal_tsp_values = array();
  $bancal_co_actual_values = array();
  $bancal_so2_actual_values = array();
  $bancal_no2_actual_values = array();
  $bancal_o3_actual_values = array();
  $bancal_o3_1_actual_values = array();
  $bancal_pm10_actual_values = array();
  $bancal_tsp_actual_values = array();
  $bancal_co_aqi_values = array();
  $bancal_so2_aqi_values = array();
  $bancal_no2_aqi_values = array();
  $bancal_o3_aqi_values = array();
  $bancal_o3_1_aqi_values = array();
  $bancal_pm10_aqi_values = array();
  $bancal_tsp_aqi_values = array();

  $slex_date_gathered = "";
  $slexAllDayValues_array = array();
  $slex_co_values = array();
  $slex_so2_values = array();
  $slex_no2_values = array();
  $slex_o3_values = array();
  $slex_pb_values = array();
  $slex_pm10_values = array();
  $slex_tsp_values = array();
  $slex_co_actual_values = array();
  $slex_so2_actual_values = array();
  $slex_no2_actual_values = array();
  $slex_o3_actual_values = array();
  $slex_o3_1_actual_values = array();
  $slex_pm10_actual_values = array();
  $slex_tsp_actual_values = array();
  $slex_co_aqi_values = array();
  $slex_so2_aqi_values = array();
  $slex_no2_aqi_values = array();
  $slex_o3_aqi_values = array();
  $slex_o3_1_aqi_values = array();
  $slex_pm10_aqi_values = array();
  $slex_tsp_aqi_values = array();

  $data_container = array();

  // --------- GET VALUES FROM DB --------- //

  $bancalAllDayValues_array = DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, "bancal");
  $slexAllDayValues_array = DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, "slex");

  // --------- SEPARATE THE VALUES INTO SPECIFIED ARRAYS --------- //

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

          case 5: // PM 10
            array_push($bancal_pm10_values, $bancalAllDayValues_array[$i]);
          break;

          case 6: // TSP
            array_push($bancal_tsp_values, $bancalAllDayValues_array[$i]);
          break;
      }
  }
  for($i = 0; $i < count($slexAllDayValues_array); $i++)
  {
      switch($slexAllDayValues_array[$i]->e_id)
      {
          case 1: // CO
            array_push($slex_co_values, $slexAllDayValues_array[$i]);
          break;

          case 2: // SO2
            array_push($slex_so2_values, $slexAllDayValues_array[$i]);
          break;

          case 3: // NO2
            array_push($slex_no2_values, $slexAllDayValues_array[$i]);
          break;

          case 4: // O3
            array_push($slex_o3_values, $slexAllDayValues_array[$i]);
          break;

          case 5: // PM 10
            array_push($slex_pm10_values, $slexAllDayValues_array[$i]);
          break;

          case 6: // TSP
            array_push($slex_tsp_values, $slexAllDayValues_array[$i]);
          break;
      }
  }

  // --------- DECLARE AVERAGE VARIABLES, CTR, AND GUIDELINES --------- //

  $data_tomorrow = date("Y-m-d", strtotime('tomorrow'));

  //// --------------------------------------------- BANCAL --------------------------------------------- ////

  // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
  $data_container = EightHrAveraging($bancal_co_values, $hour_value, $co_guideline_values, $aqi_values, 1);

  $bancal_co_aqi_values = $data_container[0];
  $bancal_co_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //
  $data_container = TwentyFourHrAveraging($bancal_so2_values, $hour_value, $sufur_guideline_values, $aqi_values, 3);

  $bancal_so2_aqi_values = $data_container[0];
  $bancal_so2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  $data_container = OneHrAveraging($bancal_no2_values, $hour_value, $no2_guideline_values, $aqi_values, 2);

  $bancal_no2_aqi_values = $data_container[0];
  $bancal_no2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM O3 --------- //

  $data_container = EightHrAveraging($bancal_o3_values, $hour_value, $ozone_guideline_values_8, $aqi_values, 3);

  $bancal_o3_aqi_values = $data_container[0];
  $bancal_o3_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM PM 10 --------- //

  $data_container = TwentyFourHrAveraging($bancal_pm10_values, $hour_value, $pm_10_guideline_values, $aqi_values, 0);

  $bancal_pm10_aqi_values = $data_container[0];
  $bancal_pm10_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM TSP --------- // REMEMBER TO COMMENT AQI > 400 IN TSP!!

  $data_container = TwentyFourHrAveraging($bancal_tsp_values, $hour_value, $tsp_guideline_values, $aqi_values, 0);

  $bancal_tsp_aqi_values = $data_container[0];
  $bancal_tsp_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $bancal_date_gathered = $data_container[2];
  }

  // --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

  $bancal_co_max = max($bancal_co_aqi_values);
  $bancal_so2_max = max($bancal_so2_aqi_values);
  $bancal_no2_max = max($bancal_no2_aqi_values);
  $bancal_o3_max = max($bancal_o3_aqi_values);
  $bancal_pm10_max = max($bancal_pm10_aqi_values);
  $bancal_tsp_max = max($bancal_tsp_aqi_values);

  // --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

  $bancal_min_max_values = array();

  array_push($bancal_min_max_values, MinMax($bancal_co_aqi_values));
  array_push($bancal_min_max_values, MinMax($bancal_so2_aqi_values));
  array_push($bancal_min_max_values, MinMax($bancal_no2_aqi_values));
  array_push($bancal_min_max_values, MinMax($bancal_o3_aqi_values));
  array_push($bancal_min_max_values, MinMax($bancal_pm10_aqi_values));
  array_push($bancal_min_max_values, MinMax($bancal_tsp_aqi_values));

  // --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

  $bancal_aqi_values = array();

  array_push($bancal_aqi_values, AQIValues($bancal_co_max, $hour_value, $bancal_co_aqi_values));
  array_push($bancal_aqi_values, AQIValues($bancal_so2_max, $hour_value, $bancal_so2_aqi_values));
  array_push($bancal_aqi_values, AQIValues($bancal_no2_max, $hour_value, $bancal_no2_aqi_values));
  array_push($bancal_aqi_values, AQIValues($bancal_o3_max, $hour_value, $bancal_o3_aqi_values));
  array_push($bancal_aqi_values, AQIValues($bancal_pm10_max, $hour_value, $bancal_pm10_aqi_values));
  array_push($bancal_aqi_values, AQIValues($bancal_tsp_max, $hour_value, $bancal_tsp_aqi_values));

  // --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

  if(count($bancal_aqi_values) > 0 )
  {
    $bancal_prevalentIndex = array_keys($bancal_aqi_values, max($bancal_aqi_values));
  }

  else {
    $bancal_prevalentIndex = "0";
  }

  //// --------------------------------------------- SLEX --------------------------------------------- ////

  // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
  $data_container = EightHrAveraging($slex_co_values, $hour_value, $co_guideline_values, $aqi_values, 1);

  $slex_co_aqi_values = $data_container[0];
  $slex_co_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //
  $data_container = TwentyFourHrAveraging($slex_so2_values, $hour_value, $sufur_guideline_values, $aqi_values, 3);

  $slex_so2_aqi_values = $data_container[0];
  $slex_so2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  $data_container = OneHrAveraging($slex_no2_values, $hour_value, $no2_guideline_values, $aqi_values, 2);

  $slex_no2_aqi_values = $data_container[0];
  $slex_no2_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM O3 --------- //

  $data_container = EightHrAveraging($slex_o3_values, $hour_value, $ozone_guideline_values_8, $aqi_values, 3);

  $slex_o3_aqi_values = $data_container[0];
  $slex_o3_actual_values = $data_container[1];

  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM PM 10 --------- //

  $data_container = TwentyFourHrAveraging($slex_pm10_values, $hour_value, $pm_10_guideline_values, $aqi_values, 0);

  $slex_pm10_aqi_values = $data_container[0];
  $slex_pm10_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- EXCRETE VALUES FROM TSP --------- // REMEMBER TO COMMENT AQI > 400 IN TSP!!

  $data_container = TwentyFourHrAveraging($slex_tsp_values, $hour_value, $tsp_guideline_values, $aqi_values, 0);

  $slex_tsp_aqi_values = $data_container[0];
  $slex_tsp_actual_values = $data_container[1];
  if($data_container[2] != "") {
    $slex_date_gathered = $data_container[2];
  }

  // --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

  $slex_co_max = max($slex_co_aqi_values);
  $slex_so2_max = max($slex_so2_aqi_values);
  $slex_no2_max = max($slex_no2_aqi_values);
  $slex_o3_max = max($slex_o3_aqi_values);
  $slex_pm10_max = max($slex_pm10_aqi_values);
  $slex_tsp_max = max($slex_tsp_aqi_values);

  // --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

  $slex_min_max_values = array();

  array_push($slex_min_max_values, MinMax($slex_co_aqi_values));
  array_push($slex_min_max_values, MinMax($slex_so2_aqi_values));
  array_push($slex_min_max_values, MinMax($slex_no2_aqi_values));
  array_push($slex_min_max_values, MinMax($slex_o3_aqi_values));
  array_push($slex_min_max_values, MinMax($slex_pm10_aqi_values));
  array_push($slex_min_max_values, MinMax($slex_tsp_aqi_values));

  // --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

  $slex_aqi_values = array();

  array_push($slex_aqi_values, AQIValues($slex_co_max, $hour_value, $slex_co_aqi_values));
  array_push($slex_aqi_values, AQIValues($slex_so2_max, $hour_value, $slex_so2_aqi_values));
  array_push($slex_aqi_values, AQIValues($slex_no2_max, $hour_value, $slex_no2_aqi_values));
  array_push($slex_aqi_values, AQIValues($slex_o3_max, $hour_value, $slex_o3_aqi_values));
  array_push($slex_aqi_values, AQIValues($slex_pm10_max, $hour_value, $slex_pm10_aqi_values));
  array_push($slex_aqi_values, AQIValues($slex_tsp_max, $hour_value, $slex_tsp_aqi_values));

  // --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

  if(count($slex_aqi_values) > 0 )
  {
    $slex_prevalentIndex = array_keys($slex_aqi_values, max($slex_aqi_values));
  }

  else {
    $slex_prevalentIndex = "0";
  }

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

  var bancalAllDayValues_array = <?= json_encode($bancalAllDayValues_array) ?>;
  var bancal_aqi_values = <?= json_encode($bancal_aqi_values) ?>;

  var bancal_prevalentIndex = <?= $bancal_prevalentIndex[0] ?>;
  var bancal_prevalent_value = JSON.stringify(bancal_aqi_values[bancal_prevalentIndex]).replace(/"/g, '');
  var bancal_prevalent_actual_value = JSON.stringify(bancal_aqi_values[bancal_prevalentIndex]).replace(/"/g, '');
  var bancal_min_max_values = <?= json_encode($bancal_min_max_values) ?>;

  var bancal_date_gathered = <?= json_encode($bancal_date_gathered) ?>;

  var bancal_co_aqi_values = <?= json_encode($bancal_co_aqi_values) ?>;
  var bancal_so2_aqi_values = <?= json_encode($bancal_so2_aqi_values) ?>;
  var bancal_no2_aqi_values = <?= json_encode($bancal_no2_aqi_values) ?>;
  var bancal_o3_aqi_values = <?= json_encode($bancal_o3_aqi_values) ?>;
  var bancal_o3_1_aqi_values = <?= json_encode($bancal_o3_1_aqi_values) ?>;
  var bancal_pm10_aqi_values = <?= json_encode($bancal_pm10_aqi_values) ?>;
  var bancal_tsp_aqi_values = <?= json_encode($bancal_tsp_aqi_values) ?>;

  var bancal_co_actual_values = <?= json_encode($bancal_co_actual_values) ?>;
  var bancal_so2_actual_values = <?= json_encode($bancal_so2_actual_values) ?>;
  var bancal_no2_actual_values = <?= json_encode($bancal_no2_actual_values) ?>;
  var bancal_o3_actual_values = <?= json_encode($bancal_o3_actual_values) ?>;
  var bancal_o3_1_actual_values = <?= json_encode($bancal_o3_1_actual_values) ?>;
  var bancal_pm10_actual_values = <?= json_encode($bancal_pm10_actual_values) ?>;
  var bancal_tsp_actual_values = <?= json_encode($bancal_tsp_actual_values) ?>;

  var bancal_co_max = <?= json_encode($bancal_co_max) ?>;
  var bancal_so2_max = <?= json_encode($bancal_so2_max) ?>;
  var bancal_no2_max = <?= json_encode($bancal_no2_max) ?>;
  var bancal_o3_max = <?= json_encode($bancal_o3_max) ?>;
  var bancal_pm10_max = <?= json_encode($bancal_pm10_max) ?>;
  var bancal_tsp_max = <?= json_encode($bancal_tsp_max) ?>;

  var slexAllDayValues_array = <?= json_encode($slexAllDayValues_array) ?>;
  var slex_aqi_values = <?= json_encode($slex_aqi_values) ?>;

  var slex_prevalentIndex = <?= $slex_prevalentIndex[0] ?>;
  var slex_prevalent_value = JSON.stringify(slex_aqi_values[slex_prevalentIndex]).replace(/"/g, '');
  var slex_min_max_values = <?= json_encode($slex_min_max_values) ?>;

  var slex_date_gathered = <?= json_encode($slex_date_gathered) ?>;

  var slex_co_aqi_values = <?= json_encode($slex_co_aqi_values) ?>;
  var slex_so2_aqi_values = <?= json_encode($slex_so2_aqi_values) ?>;
  var slex_no2_aqi_values = <?= json_encode($slex_no2_aqi_values) ?>;
  var slex_o3_aqi_values = <?= json_encode($slex_o3_aqi_values) ?>;
  var slex_o3_1_aqi_values = <?= json_encode($slex_o3_1_aqi_values) ?>;
  var slex_pm10_aqi_values = <?= json_encode($slex_pm10_aqi_values) ?>;
  var slex_tsp_aqi_values = <?= json_encode($slex_tsp_aqi_values) ?>;

  var slex_co_actual_values = <?= json_encode($slex_co_actual_values) ?>;
  var slex_so2_actual_values = <?= json_encode($slex_so2_actual_values) ?>;
  var slex_no2_actual_values = <?= json_encode($slex_no2_actual_values) ?>;
  var slex_o3_actual_values = <?= json_encode($slex_o3_actual_values) ?>;
  var slex_o3_1_actual_values = <?= json_encode($slex_o3_1_actual_values) ?>;
  var slex_pm10_actual_values = <?= json_encode($slex_pm10_actual_values) ?>;
  var slex_tsp_actual_values = <?= json_encode($slex_tsp_actual_values) ?>;

  var slex_co_max = <?= json_encode($slex_co_max) ?>;
  var slex_so2_max = <?= json_encode($slex_so2_max) ?>;
  var slex_no2_max = <?= json_encode($slex_no2_max) ?>;
  var slex_o3_max = <?= json_encode($slex_o3_max) ?>;
  var slex_pm10_max = <?= json_encode($slex_pm10_max) ?>;
  var slex_tsp_max = <?= json_encode($slex_tsp_max) ?>;

  var area_chosen = "<?= $area_chosen_name ?>";
</script>

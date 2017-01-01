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
  var $displayPointX = 0;
  var $displayPointName = "";
  var $rolling_time = array();

  function Area(){}
}

// --------- FUNCTIONS --------- //

class AreaFunction{
  var $co_holder = array();
  var $so2_holder = array();
  var $no2_holder = array();
}

function DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, $area, $date_now_string)
{
  require 'include/db_connect.php';

  $array_holder = array();
  $data_holder = array();

  $element_holder_bancal = new AreaFunction();
  $element_holder_slex = new AreaFunction();

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d H") . ":00:00";
  $date_beginning = date("Y-m-d H", time() - (86400 * 2) + (3600 * 1)) . ":01:00";

  $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE TIMESTAMP <= '$date_now'  AND TIMESTAMP >= '$date_beginning' AND AREA_NAME = '$area' ORDER BY TIMESTAMP";

  /*
  if($hour_value == 0)
  {
    $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE (TIMESTAMP LIKE '%$date_yesterday%' OR TIMESTAMP = '$date_now_string') AND AREA_NAME = '$area' ORDER BY TIMESTAMP";
  }

  else
  {
    $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE (TIMESTAMP LIKE '%$date_now%' OR TIMESTAMP = '$date_tomorrow') AND AREA_NAME = '$area' ORDER BY TIMESTAMP";
  }*/

  $result = mysqli_query($con, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $dataClass = new Master();

    $dataClass->area_name = $row['area_name'];
    $dataClass->e_id = $row['e_id'];
    $dataClass->concentration_value = $row['concentration_value'];
    $dataClass->timestamp = $row['timestamp'];
    $dataClass->e_name = $row['e_name'];
    $dataClass->e_symbol = $row['e_symbol'];

    if($dataClass->area_name == "bancal") {
      if ($dataClass->e_symbol == "CO") {
        array_push($element_holder_bancal->co_holder, $dataClass);
      } else if ($dataClass->e_symbol == "SO2") {
        array_push($element_holder_bancal->so2_holder, $dataClass);
      } else if ($dataClass->e_symbol == "NO2") {
        array_push($element_holder_bancal->no2_holder, $dataClass);
      }
    }else{
      if ($dataClass->e_symbol == "CO") {
        array_push($element_holder_slex->co_holder, $dataClass);
      } else if ($dataClass->e_symbol == "SO2") {
        array_push($element_holder_slex->so2_holder, $dataClass);
      } else if ($dataClass->e_symbol == "NO2") {
        array_push($element_holder_slex->no2_holder, $dataClass);
      }
    }

    //array_push($array_holder, $dataClass);
  }

//  if(count($element_holder_bancal->co_holder) > 0){
//    $data_holder = CalculateAveraging($element_holder_bancal->co_holder);
//    for($i = 0 ; $i < count($data_holder); $i++){
//      array_push($array_holder, $data_holder[$i]);
//    }
//  }
//  if(count($element_holder_bancal->so2_holder) > 0){
//    $data_holder = CalculateAveraging($element_holder_bancal->so2_holder);
//    for($i = 0 ; $i < count($data_holder); $i++){
//      array_push($array_holder, $data_holder[$i]);
//    }
//  }
  if(count($element_holder_bancal->no2_holder) > 0){
    $data_holder = CalculateAveraging($element_holder_bancal->no2_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }

//  if(count($element_holder_slex->co_holder) > 0){
//    $data_holder =  CalculateAveraging($element_holder_slex->co_holder);
//    for($i = 0 ; $i < count($data_holder); $i++){
//      array_push($array_holder, $data_holder[$i]);
//    }
//  }
//  if(count($element_holder_slex->so2_holder) > 0){
//    $data_holder =  CalculateAveraging($element_holder_slex->so2_holder);
//    for($i = 0 ; $i < count($data_holder); $i++){
//      array_push($array_holder, $data_holder[$i]);
//    }
//  }
//  if(count($element_holder_slex->no2_holder) > 0){
//    $data_holder = CalculateAveraging($element_holder_slex->no2_holder);
//    for($i = 0 ; $i < count($data_holder); $i++){
//      array_push($array_holder, $data_holder[$i]);
//    }
//  }

  return $array_holder;
}
function CalculateAveraging($element){
  $return_holder = array();

  if(count($element) > 0) {
    $date = date("Y-m-d H", strtotime($element[0]->timestamp)).":00:00";
    $ctr_timestamp_begin = date("Y-m-d H", strtotime($date)) . ":01:00";
    $ctr_timestamp_end = date("Y-m-d H", strtotime($date) + 3600) . ":00:00";
    $ave = 0;
    $ctr = 0;

    $dateString = "";

    echo "start begin ".$ctr_timestamp_begin;
    echo "<br/>";
    echo "begin end ".$ctr_timestamp_end;
    echo "<br/><br/>";

    for ($i = 0; $i < count($element); $i++) {
      $date = $element[$i]->timestamp;

      echo "CTRL ".$date;
      echo "<br/>";

      if(strtotime($date) <= strtotime($ctr_timestamp_end) && strtotime($date) >= strtotime($ctr_timestamp_begin)){
        //echo "inner</br>";
        $ave += $element[$i]->concentration_value;
        $ctr++;
        $dateString = date("Y-m-d H", strtotime($element[$i]->timestamp)).":00:00";
      }
      else{
        if($ctr > 0){
          $ave = $ave / $ctr;
          $dateString = $ctr_timestamp_end;
                    echo "1 DATESTRING ADD: ".$dateString;
                    echo "<br/>";
          array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));

          $ave = 0;
          $ctr = 0;

          $ave += $element[$i]->concentration_value;
          $ctr++;

          //$dateString = date("Y-m-d H", strtotime($element[$i]->timestamp)).":00:00";
          $ctr_timestamp_begin = date("Y-m-d H", strtotime($element[$i]->timestamp)) . ":01:00";
          $ctr_timestamp_end = date("Y-m-d H", strtotime($element[$i]->timestamp) + 3600) . ":00:00";

        }else{ // NO PRECEDING VALUE
          $ave = $element[$i]->concentration_value;
          $dateString = date("Y-m-d H", strtotime($element[$i]->timestamp)).":00:00";
                    echo "2 DATESTRING ADD: ".$dateString;
                    echo "<br/>";
          array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));

          $ave = 0;
          $ctr = 0;

          $ctr_timestamp_begin = date("Y-m-d H", strtotime($element[$i]->timestamp)) . ":01:00";
          $ctr_timestamp_end = date("Y-m-d H", strtotime($element[$i]->timestamp) + 3600) . ":00:00";
        }
      }

      if($i == count($element) - 1){
        $ave = $ave / $ctr;
        $dateString = date("Y-m-d H", strtotime($element[$i]->timestamp)).":00:00";
                echo "3 DATESTRING ADD: ".$dateString;
                echo "<br/>";
        array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));

        $ave = $element[$i]->concentration_value;
        $dateString = date("Y-m-d H", strtotime($element[$i]->timestamp) + 3600).":00:00";

        array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));
      }

    }

    //array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));

    echo "-----------------------";
    echo "<br/>";
  }

  return $return_holder;
}
function AssignDataElements($area_name, $e_id, $ave, $date, $name, $symbol){
  $dataClass = new Master();

  $dataClass->area_name = $area_name;
  $dataClass->e_id = $e_id;
  $dataClass->concentration_value = $ave;
  $dataClass->timestamp = $date;
  $dataClass->e_name = $name;
  $dataClass->e_symbol = $symbol;

  return $dataClass;
}
function EightHrAveraging2($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();
  $dates = GetRollingDates();

  $ctr = 0;
  $ave = 0;

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  // *- TO PREVENT HOURS W/O VALUES FROM DB TO HAVE AN AQI - OR IF DEEMED UNNECESSARY, MAY BE COMMENTED
  $db_dates = array();

  for ($k = 0; $k < count($values); $k++) {
    array_push($db_dates, $values[$k]->timestamp);
  }
  // *-

  for ($i = 0; $i < 24; $i++) {
    $ctrBegin = 23 - $i;
    $ctrEnd = $ctrBegin + 7;

    // *- TO PREVENT HOURS W/O VALUES FROM DB TO HAVE AN AQI - OR IF DEEMED UNNECESSARY, MAY BE COMMENTED
    $exists = false;

    if (in_array($dates[$ctrBegin], $db_dates)) {
      $exists = true;
    }
    // *-

    for ($j = $ctrBegin; $j <= $ctrEnd; $j++) { // NEEDED HOURS

      for ($k = 0; $k < count($values); $k++) { //FIND CONCENTRATION VALUE OF THOSE HOURS FROM DB
        if ($dates[$j] == $values[$k]->timestamp) {
          if ($dates[$j] == date("Y-m-d H").":00:00") {
            $date_gathered = $values[$k]->timestamp;
          }

          $ave += $values[$k]->concentration_value;
          $ctr++;

          break;
        }

      }
    }

    if ($ctr >= (8 * 0.75) && $exists) { //* - REMOVE EXISTS IF UNNECESSARY
      $ave = $ave / $ctr;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if ($aqi_value > 400) {
        $aqi_value = -1;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    } else {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }

    $ave = 0;
    $ctr = 0;
  }

  array_push($container, $aqi_values);
  array_push($container, $actual_values);
  array_push($container, $date_gathered);

  return $container;
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
function TwentyFourHrAveraging2($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();
  $dates = GetRollingDates();

  $ctr = 0;
  $ave = 0;

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  // *- TO PREVENT HOURS W/O VALUES FROM DB TO HAVE AN AQI - OR IF DEEMED UNNECESSARY, MAY BE COMMENTED
  $db_dates = array();

  for ($k = 0; $k < count($values); $k++) {
    array_push($db_dates, $values[$k]->timestamp);
  }
  // *-

  for ($i = 0; $i < 24; $i++) {
    $ctrBegin = 23 - $i;
    $ctrEnd = $ctrBegin + 23;

    // *- TO PREVENT HOURS W/O VALUES FROM DB TO HAVE AN AQI - OR IF DEEMED UNNECESSARY, MAY BE COMMENTED
    $exists = false;

    if (in_array($dates[$ctrBegin], $db_dates)) {
      $exists = true;
    }
    // *-

    for ($j = $ctrBegin; $j <= $ctrEnd; $j++) { // NEEDED HOURS

      for ($k = 0; $k < count($values); $k++) { //FIND CONCENTRATION VALUE OF THOSE HOURS FROM DB
        if ($dates[$j] == $values[$k]->timestamp) {
          if ($dates[$j] == date("Y-m-d H").":00:00") {
            $date_gathered = $values[$k]->timestamp;
          }

          $ave += $values[$k]->concentration_value;
          $ctr++;

          break;
        }

      }
    }

    if ($ctr >= (24 * 0.75) && $exists) { //* - REMOVE EXISTS IF UNNECESSARY
      $ave = $ave / $ctr;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if ($aqi_value > 400) {
        $aqi_value = -1;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    } else {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }

    $ave = 0;
    $ctr = 0;
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
function OneHrAveraging2($values, $hour_value, $guideline_values, $guideline_aqi_values, $prec)
{
  $container = array();
  $dates = GetRollingDates();

  $ctr = 0;
  $ave = 0;

  $aqi_values = array();
  $actual_values = array();
  $date_gathered = "";

  for ($i = 0; $i < 24; $i++) {
    $ctrBegin = 23 - $i;
    $ctrEnd = $ctrBegin;

    for ($j = $ctrBegin; $j <= $ctrEnd; $j++) { // NEEDED HOURS

      for ($k = 0; $k < count($values); $k++) { //FIND CONCENTRATION VALUE OF THOSE HOURS FROM DB
        if ($dates[$j] == $values[$k]->timestamp) {
          if ($dates[$j] == date("Y-m-d H").":00:00") {
            $date_gathered = $values[$k]->timestamp;
          }

          $ave += $values[$k]->concentration_value;
          $ctr++;

          break;
        }

      }
    }

    if ($ctr >= (1 * 0.75)) {
      $ave = $ave / $ctr;
      $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));

      if ($aqi_value > 400) {
        $aqi_value = -1;
      }

      array_push($aqi_values, $aqi_value);
      array_push($actual_values, $ave);
    } else {
      array_push($aqi_values, -1);
      array_push($actual_values, -1);
    }

    $ave = 0;
    $ctr = 0;
  }

  array_push($container, $aqi_values);
  array_push($container, $actual_values);
  array_push($container, $date_gathered);

  return $container;
}
function calculateAQI($gv, $ave, $prec, $aqi_val)
{
  $aqi = 0;

  require 'include/guidelines.php';

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

        if($ave > 0.374)
        {
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
    $data_container = $pollutant_aqi_values[23];
    /*
    if($hour_value == 0)
    {
      $data_container = $pollutant_aqi_values[23];
      //array_push($area_aqi_values, $pollutant_aqi_values[23]);
    }

    else
    {
      $data_container = $pollutant_aqi_values[$hour_value-1];
      //array_push($area_aqi_values, $pollutant_aqi_values[$hour_value-1]);
    }*/
  }

  else
  {
    $data_container = -1;
    //array_push($area_aqi_values, -1);
  }

  return $data_container;
}
function GetRollingTime($hour_value)
{
  $hours_literal = array();
  $hours_needed = array();
  $dayValues = [23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0];

  if ($hour_value < 8) {
    $ctr = 6 - $hour_value;

    for ($i = 0; $i <= $ctr; $i++) { // NEEDED
      array_unshift($hours_literal, $dayValues[$i]);
      array_unshift($hours_needed, $dayValues[$i]);
    }

    for ($i = 0; $i <= $hour_value; $i++) { // NEEDED
      array_push($hours_literal, $i);
      array_push($hours_needed, $i);
    }

    for ($i = 0; $i < 24; $i++) { // COMPLETE 24 HOURS
      if (in_array($dayValues[$i], $hours_literal) == false) {
        array_unshift($hours_literal, $dayValues[$i]);
      }
    }
  } else {
    $begin = $hour_value - 7;

    for ($i = $begin; $i <= $hour_value; $i++) { // THIS NEEDED
      array_push($hours_literal, $i);
      array_push($hours_needed, $i);
    }

    for ($i = $begin; $i >= 0; $i--) { // COMPLETE 24 HOURS
      if (in_array($i, $hours_literal) == false) { // COMPLETE 24 HOURS
        array_unshift($hours_literal, $i);
      }
    }

    for ($i = 0; $i < 24; $i++) {
      if (in_array($dayValues[$i], $hours_literal) == false) { // COMPLETE 24 HOURS
        array_unshift($hours_literal, $dayValues[$i]);
      }
    }
  }

  return $hours_literal;
}
function GetRollingDates()
{
  $dates = array();
  $ctr = 0;

  date_default_timezone_set('Asia/Manila');

  for($i = 0; $i < 47; $i++){
    $date_beginning = date("Y-m-d H",time() - $ctr).":00:00";
    $ctr += 3600;

    array_push($dates, $date_beginning);
  }
  return $dates;
}
function GetNeededTime_8($hour_value)
{
  $hours_needed = array();
  $dayValues = [23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0];

  if ($hour_value < 8) {
    $ctr = 6 - $hour_value;

    for ($i = 0; $i <= $ctr; $i++) { // NEEDED
      array_unshift($hours_needed, $dayValues[$i]);
    }

    for ($i = 0; $i <= $hour_value; $i++) { // NEEDED
      array_push($hours_needed, $i);
    }
  } else {
    $begin = $hour_value - 7;

    for ($i = $begin; $i <= $hour_value; $i++) { // THIS NEEDED
      array_push($hours_needed, $i);
    }
  }

  return $hours_needed;
}
function Generate($name)
{
  $area_generate = new Area();
  $area_generate->name = $name;
  // --------- SERVER TIME --------- //

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d");
  $date_now_string = $date_now . " 00:00:00";

  $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
  $date_tomorrow = $date_tomorrow . " 00:00:00";

  $date_yesterday = date("Y-m-d", strtotime('yesterday'));
  $date_yesterday_string = $date_yesterday . " 00:00:00";

  $hour_value = date("H"); // < --------- CURRENT HOUR --------- >

  // --------- SET ROLLING TIME --------- //

  $area_generate->rolling_time = GetRollingTime($hour_value);

  // --------- GUIDELINE VALUES --------- //

  require 'include/guidelines.php';

  // --------- GET VALUES FROM DB --------- //

  $area_generate->AllDayValues_array = DbConnect($hour_value, $date_yesterday, $date_now, $date_tomorrow, $name, $date_now_string);

  // --------- SEPARATE THE VALUES INTO SPECIFIED ARRAYS --------- //

  for ($i = 0; $i < count($area_generate->AllDayValues_array); $i++) {
    switch ($area_generate->AllDayValues_array[$i]->e_id) {
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
  $data_container = EightHrAveraging2($area_generate->co_values, $hour_value, $co_guideline_values, $guideline_aqi_values, $co_precision);

  $area_generate->co_aqi_values = $data_container[0];
  $area_generate->co_actual_values = $data_container[1];

  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //

  if($unit_used == "old") {
    $data_container = TwentyFourHrAveraging2($area_generate->so2_values, $hour_value, $sufur_guideline_values, $guideline_aqi_values, $sulfur_precision);
  }else{
    $data_container = OneHrAveraging2($area_generate->so2_values, $hour_value, $sufur_guideline_values, $guideline_aqi_values, $sulfur_precision);
  }
  $area_generate->so2_aqi_values = $data_container[0];
  $area_generate->so2_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  $data_container = OneHrAveraging2($area_generate->no2_values, $hour_value, $no2_guideline_values, $guideline_aqi_values, $no2_precision);

  $area_generate->no2_aqi_values = $data_container[0];
  $area_generate->no2_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM O3 --------- //

  $data_container = EightHrAveraging2($area_generate->o3_values, $hour_value, $ozone_guideline_values_8, $guideline_aqi_values, $o3_precision);

  $area_generate->o3_aqi_values = $data_container[0];
  $area_generate->o3_actual_values = $data_container[1];

  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM PM 10 --------- //

  $data_container = TwentyFourHrAveraging2($area_generate->pm10_values, $hour_value, $pm_10_guideline_values, $guideline_aqi_values, $pm10_precision);

  $area_generate->pm10_aqi_values = $data_container[0];
  $area_generate->pm10_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM TSP --------- // REMEMBER TO COMMENT AQI > 400 IN TSP!!

  $data_container = TwentyFourHrAveraging2($area_generate->tsp_values, $hour_value, $tsp_guideline_values, $guideline_aqi_values, $pm10_precision);

  $area_generate->tsp_aqi_values = $data_container[0];
  $area_generate->tsp_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

  // --------- DATE FORMATTER --------- //

  if ($area_generate->date_gathered != "") {
    //$area_generate->date_gathered = date("l, F d Y, h:i a", strtotime($area_generate->date_gathered));
    $area_generate->date_gathered = date("F d, Y @ h:i a", strtotime($area_generate->date_gathered));
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

  if (count($area_generate->aqi_values) > 0) {
    $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));
  } else {
    $area_generate->prevalentIndex = "0";
  }

  // --------- DISPLAY POINT X --------- //

  $pollutant_labels = ["Carbon Monoxide", "Sulfur Dioxide", "Nitrogen Dioxide", "Ozone", "Particulate Matter 10", "Totally Suspended Particles"];

  if ((count($area_generate->AllDayValues_array) > 0 || count($area_generate->aqi_values) > 0) && $area_generate->aqi_values[$area_generate->prevalentIndex[0]] > -1) {
    $area_generate->displayPointName = $pollutant_labels[$area_generate->prevalentIndex[0]] . " - " . $area_generate->aqi_values[$area_generate->prevalentIndex[0]];
    $area_generate->displayPointX = 0;

    list($left,, $right) = imageftbbox(11, 0, 'fonts/roboto/Roboto-Regular.ttf', $area_generate->displayPointName);
    $width = $right - $left;
    $area_generate->displayPointX = $width / 2;

  }else{
    $area_generate->displayPointName = "&nbsp-&nbsp";
    $area_generate->displayPointX = 11;

    //$area_generate->displayPointName = "offline";
    //$area_generate->displayPointX = 25;
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
      displayName: displayName,
      displayPointName: data.displayPointName,
      displayPointX: data.displayPointX,
      rolling_time: data.rolling_time
    };
  }

  var bancal_area = Area("bancal", "Bancal Carmona, Cavite", <?= json_encode($bancal)?>);
  var slex_area = Area("slex", "SLEX Carmona Exit, Cavite", <?= json_encode($slex)?>);

  var area_chosen = "<?= $area_chosen_name ?>";
</script>
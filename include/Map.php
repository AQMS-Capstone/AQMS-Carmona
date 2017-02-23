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
  var $co_actual_values = array();
  var $so2_actual_values = array();
  var $no2_actual_values = array();
  var $co_aqi_values = array();
  var $so2_aqi_values = array();
  var $no2_aqi_values = array();
  var $aqi_values = array();
  var $min_max_values = array();
  var $prevalentIndex = "";
  var $co_max = 0;
  var $so2_max = 0;
  var $no2_max = 0;
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

function DbConnect($area)
{
  require 'include/db_connect.php';

  $array_holder = array();

  $element_holder_bancal = new AreaFunction();
  $element_holder_slex = new AreaFunction();

  date_default_timezone_set('Asia/Manila');
  $date_now = date("Y-m-d H") . ":00:00";
  $date_beginning = date("Y-m-d H", time() - (86400 * 2) + (3600 * 1)) . ":01:00";

  $sql = $con->prepare("SELECT AREA_NAME, CO, SO2, NO2, TIMESTAMP FROM MASTER
          WHERE TIMESTAMP <= ?  AND TIMESTAMP >= ? AND AREA_NAME = ? 
          ORDER BY TIMESTAMP");
  $sql->bind_param("sss", $date_now, $date_beginning, $area);

  $sql->execute();
  $sql->store_result();
  //$num_of_rows = $sql->num_rows;
  $sql->bind_result($area_name, $CO, $SO2, $NO2, $timestamp);

  while ($sql->fetch()) {
    $dataClass_co = new Master();
    $dataClass_so2 = new Master();
    $dataClass_no2 = new Master();

    $dataClass_co->area_name = $area_name;
    $dataClass_co->e_id = "1";
    $dataClass_co->concentration_value = $CO;
    $dataClass_co->timestamp = $timestamp;
    $dataClass_co->e_name = "Carbon Monoxide";
    $dataClass_co->e_symbol = "CO";

    $dataClass_so2->area_name = $area_name;
    $dataClass_so2->e_id = "2";
    $dataClass_so2->concentration_value = $SO2;
    $dataClass_so2->timestamp = $timestamp;
    $dataClass_so2->e_name = "Sulfur Dioxide";
    $dataClass_so2->e_symbol = "SO2";

    $dataClass_no2->area_name = $area_name;
    $dataClass_no2->e_id = "3";
    $dataClass_no2->concentration_value = $NO2;
    $dataClass_no2->timestamp = $timestamp;
    $dataClass_no2->e_name = "Nitrogen Dioxide";
    $dataClass_no2->e_symbol = "NO2";

    if($area_name == "bancal") {
      array_push($element_holder_bancal->co_holder, $dataClass_co);
      array_push($element_holder_bancal->so2_holder, $dataClass_so2);
      array_push($element_holder_bancal->no2_holder, $dataClass_no2);
    }else{
      array_push($element_holder_slex->co_holder, $dataClass_co);
      array_push($element_holder_slex->so2_holder, $dataClass_so2);
      array_push($element_holder_slex->no2_holder, $dataClass_no2);
    }
  }

  $sql->free_result();
  $sql->close();
  $con->close();

  if(count($element_holder_bancal->co_holder) > 0){
    $data_holder = CalculateAveraging($element_holder_bancal->co_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }
  if(count($element_holder_bancal->so2_holder) > 0){
    $data_holder = CalculateAveraging($element_holder_bancal->so2_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }
  if(count($element_holder_bancal->no2_holder) > 0){
    $data_holder = CalculateAveraging($element_holder_bancal->no2_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }

  if(count($element_holder_slex->co_holder) > 0){
    $data_holder =  CalculateAveraging($element_holder_slex->co_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }
  if(count($element_holder_slex->so2_holder) > 0){
    $data_holder =  CalculateAveraging($element_holder_slex->so2_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }
  if(count($element_holder_slex->no2_holder) > 0){
    $data_holder = CalculateAveraging($element_holder_slex->no2_holder);
    for($i = 0 ; $i < count($data_holder); $i++){
      array_push($array_holder, $data_holder[$i]);
    }
  }

  return $array_holder;
}
function CalculateAveraging($element){

  date_default_timezone_set('Asia/Manila');

  $return_holder = array();

  if(count($element) > 0) {

    $date = date("Y-m-d H:i:s", strtotime($element[0]->timestamp));

    if(strtotime($date) < strtotime(date("Y-m-d H", strtotime($element[0]->timestamp)).":01:00")){
      $ctr_timestamp_begin = date("Y-m-d H", strtotime($date) - 3600) . ":01:00";
      $ctr_timestamp_end = date("Y-m-d H", strtotime($date)) . ":00:00";
    }else{

      $ctr_timestamp_begin = date("Y-m-d H", strtotime($date)) . ":01:00";
      $ctr_timestamp_end = date("Y-m-d H", strtotime($date) + 3600) . ":00:00";
    }

    $ave = 0;
    $ctr = 0;

    for ($i = 0; $i < count($element); $i++) {
      $date = $element[$i]->timestamp;

      if(strtotime($date) <= strtotime($ctr_timestamp_end) && strtotime($date) >= strtotime($ctr_timestamp_begin)){
        $ave += $element[$i]->concentration_value;
        $ctr++;
      }
      else{
        if($ctr > 0){
          $ave = $ave / $ctr;
          $dateString = $ctr_timestamp_end;
          array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));

          $ave = 0;
          $ctr = 0;

          $ave += $element[$i]->concentration_value;
          $ctr++;

          $date = date("Y-m-d H:i:s", strtotime($element[$i]->timestamp));

          if(strtotime($date) < strtotime(date("Y-m-d H", strtotime($date)).":01:00")){
            $ctr_timestamp_begin = date("Y-m-d H", strtotime($date) - 3600) . ":01:00";
            $ctr_timestamp_end = date("Y-m-d H", strtotime($date)) . ":00:00";
          }else {
            $ctr_timestamp_begin = date("Y-m-d H", strtotime($date)) . ":01:00";
            $ctr_timestamp_end = date("Y-m-d H", strtotime($date) + 3600) . ":00:00";
          }
        }
      }

      if($i == count($element) - 1){
        if(strtotime($date) <= strtotime($ctr_timestamp_end) && strtotime($date) >= strtotime($ctr_timestamp_begin)){
          $ave = $ave / $ctr;
          $dateString = $ctr_timestamp_end;
          array_push($return_holder, AssignDataElements($element[$i]->area_name, $element[$i]->e_id, $ave, $dateString, $element[$i]->e_name, $element[$i]->e_symbol));
        }
      }
    }
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
function EightHrAveraging($values, $guideline_values, $guideline_aqi_values, $prec)
{
  require 'include/guidelines.php';

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

      if($ave > $co_max){
        $aqi_value = -2;
      }else{
        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));
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
function TwentyFourHrAveraging($values, $guideline_values, $guideline_aqi_values, $prec)
{
  require 'include/guidelines.php';

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

      if($ave > $sulfur_max){
        $aqi_value = -2;
      }else{
        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));
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
function OneHrAveraging($values, $guideline_values, $guideline_aqi_values, $prec)
{
  require 'include/guidelines.php';

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

      if($ave > $no2_max){
        $aqi_value = -2;
      }else if($ave < $no2_min){
        $aqi_value = -3;
      }else{
        $aqi_value = round(calculateAQI($guideline_values, $ave, $prec, $guideline_aqi_values));
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
    $roundedValue = floorDec($ave, $precision = $prec);

    if($roundedValue >= $gv[$x][0] && $roundedValue <= $gv[$x][1])
    {
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
function calculateAQI_calcu($gv, $ave, $prec, $aqi_val)
{
  $aqi = 0;

  require 'include/guidelines.php';

  for($x = 0; $x < count($gv); $x++)
  {
    if($gv == $tsp_guideline_values)
    {
      if($ave >= 900)
      {
        $aqi = -4;
      }

      else
      {
        $roundedValue = floorDec($ave, $precision = $prec);

        if($roundedValue >= $gv[$x][0] && $roundedValue <= $gv[$x][1])
        {
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
        $aqi = (($aqi_val[$x][1] - $aqi_val[$x][0])/($gv[$x][1] - $gv[$x][0])) * ($roundedValue - $gv[$x][0]) + $aqi_val[$x][0];
        break;
      }

      else if($x == count($gv) - 1) {
          if ($gv == $no2_guideline_values) {
              if ($ave < $no2_min) {
                  $aqi = -3;
              }else if($ave > $no2_max){
                  $aqi = -2;
              }
          }else if ($gv == $ozone_guideline_values_8){
              if ($ave > 0.374){
                  $aqi = -4;
              }
          }else if ($gv == $ozone_guideline_values_1){
              if($ave < 0.125){
                  $aqi = -5;
              }else if($ave > $o3_max){
                  $aqi = -2;
              }
          } else{
              $aqi = -2;
          }
      }
    }
  }

  return $aqi;
}
function calculateConcentrationValue($gv, $aqi_value, $prec, $aqi_val)
{
  $roundedValue = round($aqi_value);
  $index = 0;

  for($x = 0; $x < count($aqi_val); $x++) {
    if($roundedValue >= $aqi_val[$x][0] && $roundedValue <= $aqi_val[$x][1]) {
      $index = $x;
      break;
    }

    else
    {
      $index = -6;
    }
  }

  if($index == -6)
  {
    return $index;
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
    }

    else
    {
      $data_container = [min($aqi_values),max($aqi_values)];
    }
  }

  else  // < --------- FILL IN VALUES WITH 0 --------- >
  {
    $data_container = [0,0];
  }

  return $data_container;
}
function AQIValues($pollutant_aqi_values)
{
  $data_container = $pollutant_aqi_values[23];

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
  $hour_value = date("H"); // < --------- CURRENT HOUR --------- >

  // --------- SET ROLLING TIME --------- //

  $area_generate->rolling_time = GetRollingTime($hour_value);

  // --------- GUIDELINE VALUES --------- //

  require 'include/guidelines.php';

  // --------- GET VALUES FROM DB --------- //

  $area_generate->AllDayValues_array = DbConnect($name);

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
    }
  }

  // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
  $data_container = EightHrAveraging($area_generate->co_values, $co_guideline_values, $guideline_aqi_values, $co_precision);

  $area_generate->co_aqi_values = $data_container[0];
  $area_generate->co_actual_values = $data_container[1];

  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //

  $data_container = TwentyFourHrAveraging($area_generate->so2_values, $sufur_guideline_values, $guideline_aqi_values, $sulfur_precision);

  $area_generate->so2_aqi_values = $data_container[0];
  $area_generate->so2_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

// --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

  $data_container = OneHrAveraging($area_generate->no2_values, $no2_guideline_values, $guideline_aqi_values, $no2_precision);

  $area_generate->no2_aqi_values = $data_container[0];
  $area_generate->no2_actual_values = $data_container[1];
  if ($data_container[2] != "") {
    $area_generate->date_gathered = $data_container[2];
  }

  // --------- DATE FORMATTER --------- //

  if ($area_generate->date_gathered != "") {
    $area_generate->date_gathered = date("F d, Y @ h:i a", strtotime($area_generate->date_gathered));
  }

// --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

  $area_generate->co_max = max($area_generate->co_aqi_values);
  $area_generate->so2_max = max($area_generate->so2_aqi_values);
  $area_generate->no2_max = max($area_generate->no2_aqi_values);

// --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

  array_push($area_generate->min_max_values, MinMax($area_generate->co_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->so2_aqi_values));
  array_push($area_generate->min_max_values, MinMax($area_generate->no2_aqi_values));

// --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

  array_push($area_generate->aqi_values, AQIValues($area_generate->co_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->so2_aqi_values));
  array_push($area_generate->aqi_values, AQIValues($area_generate->no2_aqi_values));

// --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

  if(min($area_generate->aqi_values) == -3){
    if(max($area_generate-> aqi_values) > -3 && max($area_generate-> aqi_values) != -1){
      $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));

      if(in_array(-2, $area_generate->aqi_values)){
        $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, -2);
      }
    }else{
      $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, -3);
    }
  }else{
    $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));

    if(in_array(-2, $area_generate->aqi_values)){
      $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, -2);
    }
  }
  
//  if (count($area_generate->aqi_values) > 0) {
//    $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));
//  }
//
//  if(in_array(-2, $area_generate->aqi_values) || in_array(-3, $area_generate->aqi_values)){
//    $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, min($area_generate->aqi_values));
//  }

  // --------- DISPLAY POINT X --------- //

  $pollutant_labels = ["Carbon Monoxide", "Sulfur Dioxide", "Nitrogen Dioxide", "Ozone", "Particulate Matter 10", "Totally Suspended Particles"];

  if ((count($area_generate->AllDayValues_array) > 0 || count($area_generate->aqi_values) > 0) && $area_generate->aqi_values[$area_generate->prevalentIndex[0]] > -1) {
    $area_generate->displayPointName = $pollutant_labels[$area_generate->prevalentIndex[0]] . ": " . $area_generate->aqi_values[$area_generate->prevalentIndex[0]];
    $area_generate->displayPointX = 0;

    list($left,, $right) = imageftbbox(11, 0, 'fonts/roboto/Roboto-Regular.ttf', $area_generate->displayPointName);
    $width = $right - $left;
    $area_generate->displayPointX = $width / 2;

  }else if ((count($area_generate->AllDayValues_array) > 0 || count($area_generate->aqi_values) > 0) && ($area_generate->aqi_values[$area_generate->prevalentIndex[0]] == -2 || $area_generate->aqi_values[$area_generate->prevalentIndex[0]] == -3)){
    if($area_generate->aqi_values[$area_generate->prevalentIndex[0]] == -2){
      $area_generate->displayPointName = $pollutant_labels[$area_generate->prevalentIndex[0]] . ": " . "400+";
    }else{
      $area_generate->displayPointName = $pollutant_labels[$area_generate->prevalentIndex[0]] . ": " . "201-";
    }

    $area_generate->displayPointX = 0;

    list($left,, $right) = imageftbbox(11, 0, 'fonts/roboto/Roboto-Regular.ttf', $area_generate->displayPointName);
    $width = $right - $left;
    $area_generate->displayPointX = $width / 2;
  }
  else{
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
      co_actual_values: data.co_actual_values,
      so2_actual_values: data.so2_actual_values,
      no2_actual_values: data.no2_actual_values,
      co_aqi_values: data.co_aqi_values,
      so2_aqi_values: data.so2_aqi_values,
      no2_aqi_values: data.no2_aqi_values,
      aqi_values: data.aqi_values,
      min_max_values: data.min_max_values,
      prevalentIndex: data.prevalentIndex[0],
      co_max: data.co_max,
      so2_max: data.so2_max,
      no2_max: data.no2_max,

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


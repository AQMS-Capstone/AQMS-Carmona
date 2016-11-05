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
  //$date_now = "2016-11-05";

  $bancalAllDayValues_array = array();
  $slexAllDayValues_array = array();

  $sql = "SELECT * FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE TIMESTAMP LIKE '%$date_now%' ORDER BY TIMESTAMP ASC";
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

  $carbon_monoxide_ave = 0;
  $carbon_monoxide_ctr = 0;

  $sulfur_dioxide_ave = 0;
  $sulfur_dioxide_ctr = 0;

  $nitrogen_dioxide_ave = 0;
  $nitrogen_dioxide_ctr = 0;

  $ozone_ave = 0;
  $ozone_ctr = 0;

  $lead_ave = 0; // None

  $pm_10_ave = 0;
  $pm_10_ctr = 0;

  $tsp_ave = 0;
  $tsp_ctr = 0;

  $bancalAveraged = array();
  $slexAveraged = array();

  for($i = 0; $i < count($bancalAllDayValues_array); $i++)
  {
    //$hour_value = date("H");
    //2016-05-11 08:00:00

    $data_hour_value = substr($bancalAllDayValues_array[$i]->timestamp, 11, -6);
    $hour_value = 10;

    if($data_hour_value <= $hour_value)
    {
      switch($bancalAllDayValues_array[$i]->e_id)
      {
          case 1: // CO

          //echo "WHAT IS: ".(($hour_value % 8))."<br/>";

          //if(($hour_value % 8) == 1 && ($data_hour_value % 8))

          $data_hour_value2 = substr($bancalAllDayValues_array[$i - 1]->timestamp, 11, -6);

          if(($data_hour_value2 % 8) == 1 && $data_hour_value2 == $hour_value)
          {
            $carbon_monoxide_ave = 0;
            $carbon_monoxide_ctr = 0;

            echo "HAPPENED";
            //echo "VALIDATION IS: ".(08 % 8)."<br/>";
            //echo "2 HOUR VALUE IS: ".$data_hour_value."<br/>";

            //echo "2 AVE IS: ".$bancalAllDayValues_array[$i]->concentration_value."<br/>";
          }

          $carbon_monoxide_ave += $bancalAllDayValues_array[$i]->concentration_value;
          $carbon_monoxide_ctr++;

          //echo "2 AVE IS: ".$bancalAllDayValues_array[$i]->concentration_value."<br/>";

          break;

          case 2: // SO2
            $sulfur_dioxide_ave += $bancalAllDayValues_array[$i]->concentration_value;
            $sulfur_dioxide_ctr++;
          break;

          case 3: // NO2
            $nitrogen_dioxide_ave += $bancalAllDayValues_array[$i]->concentration_value;
            $nitrogen_dioxide_ctr++;
          break;

          case 4: // O3
            $ozone_ave += $bancalAllDayValues_array[$i]->concentration_value;
            $ozone_ctr++;
          break;

          case 5: // Pb - None
          break;

          case 6: // PM 10
            $pm_10_ave += $bancalAllDayValues_array[$i]->concentration_value;
            $pm_10_ctr++;
          break;

          case 7: // TSP
            $tsp_ave += $bancalAllDayValues_array[$i]->concentration_value;
            $tsp_ctr++;
          break;
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

  if($ozone_ctr > 0)
  {
    $ozone_ave /= $ozone_ctr;
  }

  if($pm_10_ctr > 0)
  {
    $pm_10_ave /= $pm_10_ctr;
  }

  if($tsp_ctr > 0)
  {
    $tsp_ave /= $tsp_ctr;
  }

  echo "CTR IS: ".$carbon_monoxide_ctr."<br/>";
  echo "AVERAGE IS: ".$carbon_monoxide_ave."<br/>";

  $bancalThisHourValues_array = array();
  $slexThisHourValues_array = array();

  $new_date = date("Y-m-d H");
  //$new_date = "2016-11-05 09";
  $new_date2 = $new_date.":00:00";

  for($i = 0; $i < count($bancalAllDayValues_array); $i++)
  {
    if(strpos($bancalAllDayValues_array[$i]->timestamp, $new_date2) !== false )
    {
      array_push($bancalThisHourValues_array, $bancalAllDayValues_array[$i]);
    }
  }

  for($i = 0; $i < count($slexAllDayValues_array); $i++)
  {
    if(strpos($slexAllDayValues_array[$i]->timestamp, $new_date2) !== false )
    {
      array_push($slexThisHourValues_array, $slexAllDayValues_array[$i]);
    }
  }

  $bancalPrevalent = array();
  $slexPrevalent = array();

  $carbon_monoxide_aqi = 0;
  $sulfur_dioxide_aqi = 0.000;
  $nitrogen_dioxide_aqi = 0;
  $ozone_aqi = 0;
  $lead_aqi = 0; // None
  $pm_10_aqi = 0;
  $tsp_aqi = 0;

  $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
  $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm
  $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm
  $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm
  $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm
  $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
  $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, - 899], [900, -1]]; // 24 hr - ug/m3
  $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

  for($i = 0; $i < count($bancalThisHourValues_array); $i++)
  {
    $hour_value = date("H");
    //$hour_value = 9;

    switch($bancalThisHourValues_array[$i]->e_id)
    {
        case 1: // CO
            for($x = 0; $x < count($co_guideline_values); $x++)
            {
              if($hour_value > 0 && ($hour_value % 9) == 0) // Refreshes based on guideline
              {
                $carbon_monoxide_ave = $bancalThisHourValues_array[$i]->concentration_value;
              }

              $roundedValue = floorDec($carbon_monoxide_ave, $precision = 1);

              if($roundedValue >= $co_guideline_values[$x][0] && $roundedValue <= $co_guideline_values[$x][1])
              {
                $carbon_monoxide_aqi = round((($aqi_values[$x][1] - $aqi_values[$x][0])/($co_guideline_values[$x][1] - $co_guideline_values[$x][0])) * ($roundedValue - $co_guideline_values[$x][0]) + $aqi_values[$x][0]);
                break;
              }
            }
        break;

        case 2: // SO2
          for($x = 0; $x < count($sufur_guideline_values); $x++)
          {
            $roundedValue = floorDec($sulfur_dioxide_ave, $precision = 3);

            if($roundedValue >= $sufur_guideline_values[$x][0] && $roundedValue <= $sufur_guideline_values[$x][1])
            {
              $sulfur_dioxide_aqi = round((($aqi_values[$x][1] - $aqi_values[$x][0])/($sufur_guideline_values[$x][1] - $sufur_guideline_values[$x][0])) * ($roundedValue - $sufur_guideline_values[$x][0]) + $aqi_values[$x][0]);
              break;
            }
          }
        break;

        case 3: // NO2
          for($x = 0; $x < count($no2_guideline_values); $x++)
          {
            if($hour_value > 0 && ($hour_value % 1) == 0) // Refreshes based on guideline
            {
              $nitrogen_dioxide_ave = $bancalThisHourValues_array[$i]->concentration_value;
            }

            $roundedValue = floorDec($nitrogen_dioxide_ave, $precision = 2);

            if($roundedValue >= $no2_guideline_values[$x][0] && $roundedValue <= $no2_guideline_values[$x][1])
            {
              $nitrogen_dioxide_aqi = round((($aqi_values[$x][1] - $aqi_values[$x][0])/($no2_guideline_values[$x][1] - $no2_guideline_values[$x][0])) * ($roundedValue - $no2_guideline_values[$x][0]) + $aqi_values[$x][0]);
              break;
            }
          }
        break;

        case 4: // O3

        //$ozone_guideline_values_8;
        //$ozone_aqi

        $ozone_aqi_8 = 0;
        $ozone_aqi_1 = 0;

        if($hour_value > 0 && ($hour_value % 9) == 0) // Refreshes based on guideline - 8 hr
        {
          for($x = 0; $x < count($ozone_guideline_values_8); $x++)
          {
            $roundedValue = floorDec($ozone_ave, $precision = 3);

            if($roundedValue >= $ozone_guideline_values_8[$x][0] && $roundedValue <= $ozone_guideline_values_8[$x][1])
            {
              $ozone_aqi_8 = round((($aqi_values[$x][1] - $aqi_values[$x][0])/($ozone_guideline_values_8[$x][1] - $ozone_guideline_values_8[$x][0])) * ($roundedValue - $ozone_guideline_values_8[$x][0]) + $aqi_values[$x][0]);
              break;
            }
          }
        }

        else // Refreshes based on guideline - 1 hr
        {
          $ozone_ave = $bancalThisHourValues_array[$i]->concentration_value;

          for($x = 0; $x < count($ozone_guideline_values_1); $x++)
          {
            $roundedValue = floorDec($ozone_ave, $precision = 3);

            if($roundedValue >= $ozone_guideline_values_1[$x][0] && $roundedValue <= $ozone_guideline_values_1[$x][1])
            {
              $ozone_aqi_8 = round((($aqi_values[$x][1] - $aqi_values[$x][0])/($ozone_guideline_values_1[$x][1] - $ozone_guideline_values_1[$x][0])) * ($roundedValue - $ozone_guideline_values_1[$x][0]) + $aqi_values[$x][0]);
              break;
            }
          }
        }

        break;

        case 5: // Pb - None
        break;

        case 6: // PM 10
        break;

        case 7: // TSP
        break;
    }
  }

  echo $carbon_monoxide_aqi."<br/>";
  echo $sulfur_dioxide_aqi."<br/>";
  echo $nitrogen_dioxide_aqi."<br/>";

  function floorDec($val, $precision = 2) {
    if ($precision < 0) { $precision = 0; }
    $numPointPosition = intval(strpos($val, '.'));
    if ($numPointPosition === 0) { //$val is an integer
        return $val;
    }
    return floatval(substr($val, 0, $numPointPosition + $precision + 1));
}
?>

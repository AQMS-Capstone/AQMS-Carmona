<?php

for($i = 0; $i < 24; $i++) // < --------- 24 HOURS OF VALUES --------- >
{
  $index_24 = -1;
  $check_24 = false;

  $check = false;
  $index = 0;

  $prev_hour_value = 0;

  for($k = 0; $k < count($bancal_co_values); $k++) // < --------- CHECK CARBON MONOXIDE VALUES IF IT HAS A VALUE FOR SPECIFIC HOUR ($i + 1) --------- >
  {
    $data_hour_value = substr($bancal_co_values[$k]->timestamp, 11, -6);

    if($i == 23 && $data_hour_value == 0)
    {
      $check_24 = true;
      $index_24 = $k;
      break;
    }

    else if(($i + 1) == $data_hour_value)
    {
      $check = true;
      $index = $k;
      break;
    }
  }

  if($check) // < --------- IF AN HOUR FROM DB MATCHES WITH HOUR ($i + 1) --------- >
  {
    $hour_value = 23;
    //$hour_value = date("H");

    if($check_24)
    {
      $data_date_tomorrow = substr($bancal_co_values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_co_values[$index]->timestamp, 11, -6);
    }

    else
    {
      $data_date_tomorrow = substr($bancal_co_values[$index]->timestamp, 0, -9);
      $data_hour_value = substr($bancal_co_values[$index]->timestamp, 11, -6);


    }
    //$data_date_tomorrow = substr($bancal_co_values[$index]->timestamp, 0, -9);
    //$data_hour_value = substr($bancal_co_values[$index]->timestamp, 11, -6);

    if($data_hour_value <= $hour_value && $data_hour_value > 0) // < --------- TO AVOID VALUES FROM DB WHICH ARE NOT IN RANGE OF THE CURRENT HOUR --------- >
    {
      //echo "HOUR IS: ".$data_hour_value." ";
      //echo "W ";
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

      if($data_hour_value == $hour_value) // < --------- IF THE HOUR ($i + 1) IS THE CURRENT VALUE, THEN ADD TO BANCAL AQI VALUES --------- >
      {
        array_push($bancal_aqi_values,$aqi_value);
        $bancal_date_gathered = $bancal_co_values[$index]->timestamp;
        $prev_hour_value = $hour_value;
      }

      array_push($bancal_co_aqi_values, $aqi_value);
    }
    else
    {
      //echo "LOL";
      array_push($bancal_co_aqi_values, 0);
    }

    /*
    if($i == 23 && $index_24 > -1 && $prev_hour_value == 23)
    {
      echo "WOAHHH";
      //echo "VALUES ARE: ".$bancal_co_values[$i]->concentration_value."<br/>";
      $carbon_monoxide_ave += $bancal_co_values[$index]->concentration_value;
      $carbon_monoxide_ctr++;

      $ave = $carbon_monoxide_ave / $carbon_monoxide_ctr;
      $aqi_value = round(calculateAQI($co_guideline_values, $ave, 1, $aqi_values));

      if($aqi_value > 400)
      {
        $aqi_value = 0;
      }

      if($data_hour_value == $hour_value)
      {
        array_push($bancal_aqi_values,$aqi_value);
        $bancal_date_gathered = $bancal_co_values[$index]->timestamp;
      }

      array_push($bancal_co_aqi_values, $aqi_value);
    }
    */
  }

  else // < --------- FILL THE ARRAY WITH 0 VALUES --------- >
  {

    /*
    if((($i + 1) % 8) == 1 && $i > 0) // < --------- 8HR AVERAGING WILL ENTAIL RESETTING OF AVERAGE VALUES TO 0 --------- >
    {
      echo " WHAT";
      $carbon_monoxide_ctr = 0;
      $carbon_monoxide_ave = 0;
    }
    */

    array_push($bancal_co_aqi_values, 0);
  }
}

?>

<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 27/12/2016
 * Time: 5:35 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Constants{
    var $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
    var $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
    var $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
    var $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
    var $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
    var $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
    var $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
    var $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

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
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

    public function Area(){}
}
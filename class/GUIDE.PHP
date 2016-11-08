<?php

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

?>

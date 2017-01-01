<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 01/01/2017
 * Time: 8:25 PM
 */

$unit_used = "new";

//OLD

//$co_precision = 1;
//$sulfur_precision = 3;
//$no2_precision = 2;
//$o3_precision = 3;
//$pm10_precision = 0;
//$tsp_precision = 0;
//
//$co_step = 0.1;
//$co_min = 0.0;
//$co_max = 40.4;
//$co_unit = "ppm";
//
//$sulfur_step = 0.001;
//$sulfur_min = 0.000;
//$sulfur_max = 0.804;
//$sulfur_unit = "ppm";
//
//$no2_step = 0.01;
//$no2_min = 0.65;
//$no2_max = 1.64;
//$no2_unit = "ppm";
//
//$o3_step = 0.001;
//$o3_min = 0.000;
//$o3_max = 0.504;
//$o3_unit = "ppm";
//
//$pm10_min = 0;
//$pm10_max = 504;
//$pm10_unit = "ug/m3";
//
//$tsp_min = 0;
//$tsp_unit = "ug/m3";
//
//$co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
//$sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
//$no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
//$ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1, -1]]; // 8 hr - ppm // pbb - CHANGE
//$ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125, 0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
//$pm_10_guideline_values = [[0, 54], [55, 154], [155, 254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
//$tsp_guideline_values = [[0, 80], [81, 230], [231, 349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
//$guideline_aqi_values = [[0, 50], [51, 100], [101, 150], [151, 200], [201, 300], [301, 400]];

//NEW

$co_precision = 1;
$sulfur_precision = 0;
$no2_precision = 0;
$o3_precision = 3;
$pm10_precision = 0;
$tsp_precision = 0;

$co_step = 0.1;
$co_min = 0.0;
$co_max = 40.4;
$co_unit = "ppm";

//$sulfur_step = 0.001;
$sulfur_min = 0;
$sulfur_max = 804;
$sulfur_unit = "ppb";

//$no2_step = 0.01;
$no2_min = 0;
$no2_max = 1649;
$no2_unit = "ppb";

$o3_step = 0.001;
$o3_min = 0.000;
$o3_max = 0.504;
$o3_unit = "ppm";

$pm10_min = 0;
$pm10_max = 504;
$pm10_unit = "ug/m3";

$tsp_min = 0;
$tsp_unit = "ug/m3";

$co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
$sufur_guideline_values = [[0, 35], [36, 75], [76, 185], [186, 304], [305, 604], [605, 804]]; // 1hr - ppb - CHANGE
$no2_guideline_values = [[0, 53], [54, 100], [101, 360], [361, 649], [650, 1249], [1250, 1649]]; // 1 hr - ppb - CHANGE
$ozone_guideline_values_8 = [[0.000, 0.059], [0.060, 0.075], [0.076, 0.095], [0.096, 0.115], [0.116, 0.374], [-1, -1]]; // 8 hr - ppm // ppb - CHANGE
$ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125, 0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // ppb
$pm_10_guideline_values = [[0, 54], [55, 154], [155, 254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
$tsp_guideline_values = [[0, 80], [81, 230], [231, 349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
$guideline_aqi_values = [[0, 50], [51, 100], [101, 150], [151, 200], [201, 300], [301, 400]];
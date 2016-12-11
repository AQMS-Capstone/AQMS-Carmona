<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */

include("class/Map.php");

$synthesis = "";
$health_effects = "";
$cautionary = "";
$concentration = 0;
$aqi = 0;
$element = "";

if (isset($_POST["concentration"]) && isset($_POST["element"])) {
    $concentration = $_POST["concentration"];
    $element = $_POST["element"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AQI Calculator - Air Quality Monitoring System</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="icon" href="res/favicon.ico" type="image/x-icon">


</head>

<body>


<?php include('public/_header.php'); ?>

<div id="content-holder">
    <div class="section">
        <h1 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons" style="font-size: 2em;">cloud</span></h1>
        <h2 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b id = "txtTitle"></b></h2>
    </div>
    <br id="calculator">
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <form method="post">
                        <div class="input-field col s7">
                            <select id="element" name="element" required>
                                <option value="" disabled <?php if ($element == null) {
                                    echo 'selected';
                                } ?> >Select a pollutant
                                </option>
                                <option value="CO" <?php if ($element == "CO") {
                                    echo 'selected';
                                } ?>>(CO) Carbon Monoxide
                                </option>
                                <option value="SO2" <?php if ($element == "SO2") {
                                    echo 'selected';
                                } ?>>(SO2) Sulfur Dioxide
                                </option>
                                <option value="NO2" <?php if ($element == "NO2") {
                                    echo 'selected';
                                } ?>>(NO2) Nitrogen Dioxide
                                </option>
                                <option value="O3_8" <?php if ($element == "O3_8") {
                                    echo 'selected';
                                } ?>>(O3) Ozone 8hrs
                                </option>
                                <option value="O3_1" <?php if ($element == "O3_1") {
                                    echo 'selected';
                                } ?>>(O3) Ozone 1hr
                                </option>
                                <option value="PM 10" <?php if ($element == "PM 10") {
                                    echo 'selected';
                                } ?>>(PM10) Particulate Matter
                                </option>
                                <option value="TSP" <?php if ($element == "TSP") {
                                    echo 'selected';
                                } ?>>(TSP) Total Suspended Particles
                                </option>
                            </select>
                            <label>Pollutant</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="concentration" type="number" name="concentration" class="validate"
                                   value="<?php if ($concentration != null) {
                                       echo $concentration;
                                   } ?>">
                            <label for="number" id="txtConversion"></label>
                        </div>
                        <div class="input-field col s1">
                            <label id="unit">unit</label>
                        </div>
                        <div class="input-field col s2">
                            <button class="btn waves-effect waves-light" type="submit" name="submit">CALCULATE</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="result" hidden>
                <div class="divider"></div>
                <br>
                <div class="row">
                    <div class="col s12">
                        <div class="card" id="AQIStat">
                            <div class="card-content center">
                                <h2 style="margin:0;"><b id="aqiNum">
                                    </b></h2>
                                <h5><b id="aqiText">
                                    </b></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4">
                        <div class="card" style="min-height: 328px;">
                            <div class="card-content">
                                <div class="card-title teal-text"><b>Sensitive Groups</b></div>
                                <p id="synthesis">
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card" style="min-height: 328px;">
                            <div class="card-content">
                                <div class="card-title teal-text"><b>Health Effects</b></div>
                                <p id="health-effects">
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card" style="min-height: 328px;">
                            <div class="card-content">
                                <div class="card-title teal-text"><b>Cautionary</b></div>
                                <p id="cautionary">
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>


<?php include('public/_footer.php'); ?>


<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>
<script src="js/aqi-calculator.js"></script>
<script type="text/javascript">

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    var calculator = getUrlParameter('calculator');

    $(document).ready(function () {

        if (calculator != null) {

            if (calculator == "ACV") {
                InitCVCalculator();

            }
            else if (calculator == "CVA") {
                InitAQICalculator();
            }

            else{
                InitAQICalculator();
            }
        }
        else {
            InitAQICalculator();
        }

        $("#legends").remove();
    })

</script>

<?php
function GetAQI()
{
    $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
    $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
    $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
    $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
    $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
    $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
    $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
    $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

    $aqi = 0;

    $concentration = $_POST["concentration"];
    $element = $_POST["element"];

    if ($element == "CO") {
        $aqi = round(calculateAQI($co_guideline_values, $concentration, 1, $aqi_values));
    }
    if ($element == "SO2") {
        $aqi = round(calculateAQI($sufur_guideline_values, $concentration, 3, $aqi_values));
    }
    if ($element == "NO2") {
        $aqi = round(calculateAQI($no2_guideline_values, $concentration, 2, $aqi_values));
    }
    if ($element == "O3_8") {
        $aqi = round(calculateAQI($ozone_guideline_values_8, $concentration, 3, $aqi_values));
    }
    if ($element == "O3_1") {
        $aqi = round(calculateAQI($ozone_guideline_values_1, $concentration, 3, $aqi_values));
    }
    if ($element == "PM 10") {
        $aqi = round(calculateAQI($pm_10_guideline_values, $concentration, 0, $aqi_values));
    }
    if ($element == "TSP") {
        $aqi = round(calculateAQI($tsp_guideline_values, $concentration, 0, $aqi_values));
    }

    echo "
          <script type='text/javascript'>
          
             var AQI = \"$aqi\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             $(\"#aqiNum\").text(AQI);
             
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             $(\"#result\").show();
             ScrollTo('calculator');
          </script>
    ";

    header("location: aqi-calculator.php");
}

function GetCV(){
    $co_guideline_values = [[0.0, 4.4], [4.5, 9.4], [9.5, 12.4], [12.5, 15.4], [15.5, 30.4], [30.5, 40.4]]; // 8hr - ppm
    $sufur_guideline_values = [[0.000, 0.034], [0.035, 0.144], [0.145, 0.224], [0.225, 0.304], [0.305, 0.604], [0.605, 0.804]]; // 24hr - ppm - CHANGE
    $no2_guideline_values = [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [0.65, 1.24], [1.25, 1.64]]; // 1 hr - ppm // pbb - CHANGE
    $ozone_guideline_values_8 = [[0.000, 0.064], [0.065, 0.084], [0.085, 0.104], [0.105, 0.124], [0.125, 0.374], [-1,-1]]; // 8 hr - ppm // pbb - CHANGE
    $ozone_guideline_values_1 = [[-1, -1], [-1, -1], [0.125,  0.164], [0.165, 0.204], [0.205, 0.404], [0.405, 0.504]]; // 1 hr - ppm // pbb
    $pm_10_guideline_values = [[0, 54], [55, 154], [155,  254], [255, 354], [355, 424], [425, 504]]; // 24 hr - ug/m3
    $tsp_guideline_values = [[0, 80], [81, 230], [231,  349], [350, 599], [600, 899], [900, -1]]; // 24 hr - ug/m3
    $aqi_values = [[0,50], [51,100], [101,150], [151,200], [201,300], [301,400]];

    $concentration = $_POST["concentration"];
    $element = $_POST["element"];

    $concentration_value = 0;

    if ($element == "CO") {
        $concentration_value = calculateConcentrationValue($co_guideline_values, $concentration, 1, $aqi_values);
    }
    if ($element == "SO2") {
        $concentration_value = calculateConcentrationValue($sufur_guideline_values, $concentration, 3, $aqi_values);
    }
    if ($element == "NO2") {
        $concentration_value = calculateConcentrationValue($no2_guideline_values, $concentration, 2, $aqi_values);
    }
    if ($element == "O3_8") {
        $concentration_value = calculateConcentrationValue($ozone_guideline_values_8, $concentration, 3, $aqi_values);
    }
    if ($element == "O3_1") {
        $concentration_value = calculateConcentrationValue($ozone_guideline_values_1, $concentration, 3, $aqi_values);
    }
    if ($element == "PM 10") {
        $concentration_value = calculateConcentrationValue($pm_10_guideline_values, $concentration, 0, $aqi_values);
    }
    if ($element == "TSP") {
        $concentration_value = calculateConcentrationValue($tsp_guideline_values, $concentration, 0, $aqi_values);
    }

    echo "
          <script type='text/javascript'>
          
             var AQI = \"$concentration\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             $('#aqiNum').text($concentration_value);
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             $(\"#result\").show();
             ScrollTo('calculator');
          </script>     
    ";

    header("location: aqi-calculator.php");
}

if (isset($_POST['submit'])) {

    if(isset($_GET["calculator"]))
    {
        $data = $_GET["calculator"];

        if($data == "CVA"){
            GetAQI();
        }else{
            GetCV();
        }
    }else{
        GetAQI();
    }
}
?>
</body>
</html>

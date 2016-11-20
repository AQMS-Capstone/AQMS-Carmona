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

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon"/>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon"/>


</head>

<body>


<?php include('public/_header.php'); ?>

<div id="content-holder">
    <div class="section">
        <h1 class="header center teal-text"><span class="material-icons" style="font-size: 2em;">cloud</span></h1>
        <h2 class="header center teal-text" id="calculator"><b>AQI Calculator</b></h2>
    </div>
    <br>
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
                                } ?>>(NO2) Nitrogen Oxide
                                </option>
                                <option value="O3_8" <?php if ($element == "O3_8") {
                                    echo 'selected';
                                } ?>>(O3) Ozone 8hrs
                                </option>
                                <option value="O3_1" <?php if ($element == "O3_1") {
                                    echo 'selected';
                                } ?>>(O3) Ozone 1hr
                                </option>
                                <option value="PM10" <?php if ($element == "PM10") {
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
                            <label for="number">Concentration</label>
                        </div>
                        <div class="input-field col s1">
                            <label id="unit">µg/m3</label>
                        </div>
                        <div class="input-field col s2">
                            <button class="btn waves-effect waves-light" type="submit" name="submit">CALCULATE</button>
                        </div>
                    </form>
                </div>
            </div>
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
                            <div class="card-title teal-text"><b>Synthesis</b></div>
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


<?php include('public/_footer.php'); ?>


<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/init.js"></script>
<script src="js/aqi-calculator.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#legends").remove();
    })
</script>

<?php
function GetAQI()
{
    global $co_guideline_values;
    global $sufur_guideline_values;
    global $no2_guideline_values;
    global $ozone_guideline_values_8;
    global $ozone_guideline_values_1;
    global $pm_10_guideline_values;
    global $tsp_guideline_values;


    global $aqi_values;

    global $aqi;
    global $element;

    $concentration = $_POST["concentration"];
    $element = $_POST["element"];

    if ($element == "CO") {
        $aqi = round(calculateAQI($co_guideline_values, $concentration, 1, $aqi_values));
    }
    if ($element == "SO2") {
        $aqi = round(calculateAQI($sufur_guideline_values, $concentration, 1, $aqi_values));
    }
    if ($element == "NO2") {
        $aqi = round(calculateAQI($no2_guideline_values, $concentration, 1, $aqi_values));
    }
    if ($element == "O3_8") {
        $aqi = round(calculateAQI($ozone_guideline_values_8, $concentration, 1, $aqi_values));
    }
    if ($element == "O3_1") {
        $aqi = round(calculateAQI($ozone_guideline_values_1, $concentration, 1, $aqi_values));
    }

    if ($element == "PM10") {
        $aqi = round(calculateAQI($pm_10_guideline_values, $concentration, 1, $aqi_values));
    }
    if ($element == "TSP") {
        $aqi = round(calculateAQI($tsp_guideline_values, $concentration, 1, $aqi_values));
    }

    echo "
          
          
          <script type='text/javascript'>
             var AQI = \"$aqi\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             $(\"#aqiNum\").text(AQI);
             
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             ScrollTo('calculator');
          </script>
          
          
    ";

    header("location: aqi-calculator.php");
}

if (isset($_POST['submit'])) {
    GetAQI();
}
?>
</body>
</html>

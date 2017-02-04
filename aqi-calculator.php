<?php
/**
 * Created by PhpStorm.
 * User: Skullpluggery
 * Date: 8/13/2016
 * Time: 7:00 PM
 */
define("PAGE_TITLE", "Calculator - Air Quality Monitoring System");
include("include/Map.php");
include('include/guidelines.php');

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

<?php include('include/header.php'); ?>

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
                        <div class="input-field col s12 l7">
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
                        <div class="input-field col s10 l2">
                            <input id="concentration" type="number" name="concentration" class="validate"
                                   value="<?php if ($concentration != null) {
                                       echo $concentration;
                                   } ?>">
                            <label for="number" id="txtConversion"></label>
                        </div>
                        <div class="input-field col s2 l1">
                            <label id="unit">unit</label>
                        </div>
                        <div class="input-field col s12 l2">
                            <button class="btn waves-effect waves-light" style="width: 100%;" type="submit" name="submit">CALCULATE</button>
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
                <div class="row row-no-after">
                    <div class="col s12 m12">
                        <div class="card" style="height: 215px;">
                            <div class="card-content">
                                <ul class="tabs">
                                    <li class="tab col s3"><a href="#cautionary">Cautionary Statement</a></li>
                                </ul>
                                <br>
                                <div id="cautionary" class="col s12"> </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col s12'>
                    <ul class='collapsible' data-collapsible='accordion'>
                        <li>
                            <div class='collapsible-header active'>
                                <div class='row-no-after'>
                                    <div class='col s5'>
                                        <i class='material-icons'>settings_input_svideo</i>
                                        <b id = ''>References</b>
                                    </div>
                                </div>

                            </div>
                            <div class='collapsible-body'>
                                <p class="center grey-text">DAO 2000-81 Breakpoint Table</p>
                                <img class="materialboxed" width="90%" src="res/images/guidelines/reference-table.png" alt="CAA Breakpoint Table">
                                <p><b>1*</b> When 8-hour O3 concentrations exceed 0.374 ppm, AQI values of 301 or higher must be calculated with 1-hour O3 concentrations.<br><br>
                                <b>2*</b> Areas are generally required to report the AQI based on 8-hour ozone values. However, there are a smaller number of areas where an AQI based on 1-hour ozone values would be more precautionary. In these cases, in addition to calculating the 8-hour ozone index value, the 1-hour index value may be calculated and the maximum of the two values is reported.<br><br>
                                <b>3*</b>  NO2 has no 1-hour term NAAQG.</p>
                                <p class="center grey-text">AQI Formula (from Guidelines for Reporting of Daily Air Quality Index - AQI - May 2016)</p>
                                <img class="materialboxed" width="50%" src="res/images/guidelines/formula.png" alt="CAA Breakpoint Table">
                                <br>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<br>
<br>


<?php include('include/footer.php'); ?>


<script src="js/aqi-calculator.js"></script>
<script type="text/javascript">
    var unit_used = "<?php echo $unit_used; ?>";

    var co_step = <?php echo $co_step; ?>;
    var co_min = <?php echo $co_min; ?>;
    var co_max = <?php echo $co_max; ?>;
    var co_unit = "<?php echo $co_unit; ?>";

    var sulfur_step = 1;
    if(unit_used == "old") {
        sulfur_step = <?php echo $sulfur_step; ?>;
    }

    var sulfur_min = <?php echo $sulfur_min; ?>;
    var sulfur_max = <?php echo $sulfur_max; ?>;
    var sulfur_unit = "<?php echo $sulfur_unit; ?>";

    var no2_step = 1;
    if(unit_used == "old") {
        no2_step = <?php echo $no2_step; ?>;
    }
    var no2_min = <?php echo $no2_min; ?>;
    var no2_max = <?php echo $no2_max; ?>;
    var no2_unit = "<?php echo $no2_unit; ?>";

    var o3_step = <?php echo $o3_step; ?>;
    var o3_min = <?php echo $o3_min; ?>;
    var o3_max = <?php echo $o3_max; ?>;
    var o3_unit = "<?php echo $o3_unit; ?>";

    var pm10_min = <?php echo $pm10_min; ?>;
    var pm10_max = <?php echo $pm10_max; ?>;
    var pm10_unit = "<?php echo $pm10_unit; ?>";

    var tsp_min = <?php echo $tsp_min; ?>;
    var tsp_unit = "<?php echo $tsp_unit; ?>";

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

if (isset($_POST['submit'])) {
    require_once("include/dbFunctions.php");

    $aqicvCalcu = new AQICalculator();
    if(isset($_GET["calculator"]))
    {
        $data = $_GET["calculator"];

        if($data == "CVA"){
            $aqicvCalcu->GetAQI();
        }else{
            $aqicvCalcu->GetCV();
        }
    }else{
        $aqicvCalcu->GetAQI();
    }
}
?>
</body>
</html>

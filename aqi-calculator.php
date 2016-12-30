<?php
include("include/Map.php");

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

<?php
define('WEB_TITLE', 'Calculator - Air Quality Monitoring System');
include("include/header.php");
?>
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
                <div class="row">
                    <div class="col s12 l4">
                        <div class="card" style="min-height: 328px;">
                            <div class="card-content">
                                <div class="card-title teal-text"><b>Sensitive Groups</b></div>
                                <p id="synthesis">
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col s12 l4">
                        <div class="card" style="min-height: 328px;">
                            <div class="card-content">
                                <div class="card-title teal-text"><b>Health Effects</b></div>
                                <p id="health-effects">
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col s12 l4">
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


<?php include('include/footer.php'); ?>

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

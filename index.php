<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    header('Location: mobile-home.php');
?>
<?php
define("PAGE_TITLE", "Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>

<div id="content-holder">
    <?php
    $data = "";
    if (isset($_GET["area"])) {
        $data = $_GET["area"];
    }
    ?>
    <div id="home">
        <div id="googleMap"></div>
        <div class="container">

            <div id="zoneStatus" class="card float-card">
                <div class="card-content black-text" style="height: 433px;">
                    <div class="row">
                        <div class="col s12 m4">
                            <div class="center-align">
                                <p><span class="material-icons" style="font-size: 5em;" id="AQIStat">cloud</span></p>
                                <p style="font-weight: bold; font-size: 1.5em;">AQI: <span id="aqiNum"></span></p>
                            </div>
                        </div>
                        <div>
                            <div class="col s12 m7">
                                <div class="row-no-after left-align-on-med-and-up center-align">
                                    <div class="col s12">
                                        <p style="font-weight: bold; font-size: 1.5em;" id="aqiText">AQI Status</p>
                                        <span style="font-size: x-large"><b class="teal-text"
                                                                            id="zoneName">Zone Name</b></span>
                                    </div>
                                    <div id="AQIStat_txt" class="col s12">
                                        <b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">Prevalent Air Pollutant</span>
                                    </div>
                                    <div class="col s12">
                                        <b>Recorded on: </b> <span id="timeUpdated">DateToday TimeToday</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row-no-after">
                        <div class="col s12 m12">
                            <div style="min-height: 120px">
                                <!--Synthesis-->
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#synthesis">Sensitive Groups</a></li>
                                    <li class="tab col s3"><a href="#health-effects">Health Effects</a></li>
                                    <li class="tab col s3"><a href="#cautionary">Cautionary</a></li>
                                </ul>
                                <div class="divider"></div>
                                <br>

                                <div id="synthesis" class="col s12"> </div>
                                <div id="health-effects" class="col s12"> </div>
                                <div id="cautionary" class="col s12"> </div>

                                <br>
                            </div>
                        </div>

                    </div>
                    <div class="bottom-fixed">
                        <div style=" padding-left: 20px;padding-right: 20px;">
                            <?php

                            function getAreaStatus($area_data)
                            {
//                                if (count($area_data->AllDayValues_array) != 0) {
//
//                                    $ind = $area_data->prevalentIndex[0];
//                                    $maxValue = 0;
//
//                                    switch ($ind) {
//                                        case 0:
//                                            $maxValue = $area_data->co_max;
//                                            break;
//
//                                        case 1:
//                                            $maxValue = $area_data->so2_max;
//                                            break;
//
//                                        case 2:
//                                            $maxValue = $area_data->no2_max;
//                                            break;
//
//                                        case 3:
//                                            $maxValue = $area_data->o3_max;
//                                            break;
//
//                                        case 4:
//                                            $maxValue = $area_data->pm10_max;
//                                            break;
//
//                                        case 5:
//                                            $maxValue = $area_data->tsp_max;
//                                            break;
//                                    }
//
//                                    if ($maxValue > -1) {
//                                        $chartName = "chart_div_" . ($ind + 1);
//                                        echo "<div class='chart'><canvas id='$chartName'></canvas></div>";
//                                    }
//                                }
                                $untilValue = $area_data->aqi_values;

                                if (count($area_data->AllDayValues_array) != 0) {
                                    for ($x = 0; $x < count($untilValue); $x++) {
                                        $maxValue = 0;

                                        switch ($x) {
                                            case 0:
                                                $maxValue = $area_data->co_max;
                                                break;

                                            case 1:
                                                $maxValue = $area_data->so2_max;
                                                break;

                                            case 2:
                                                $maxValue = $area_data->no2_max;
                                                break;

                                            case 3:
                                                $maxValue = $area_data->o3_max;
                                                break;

                                            case 4:
                                                $maxValue = $area_data->pm10_max;
                                                break;

                                            case 5:
                                                $maxValue = $area_data->tsp_max;
                                                break;
                                        }

                                        if ($maxValue > -1) {
                                            $elementName = "e_symbol_" . ($x + 1);
                                            $conentrationName = "concentration_value_" . ($x + 1);
                                            $chartName = "chart_div_" . ($x + 1);
                                            $elementNameMin = "aqi_min_" . ($x + 1);
                                            $elementNameMax = "aqi_max_" . ($x + 1);

//                                                echo "<tr>";
//                                                echo "<td class='elementName' id='$elementName'>NaN</td>";
//                                                echo "<td class='elementCurrent' id='$conentrationName'>NaN</td>";
                                            echo "<div class='chart'><canvas id='$chartName'></canvas></div>";
//                                                echo "<td class='elementMin' id='$elementNameMin'>NaN</td>";
//                                                echo "<td class='elementMax' id='$elementNameMax'>NaN</td>";
//                                                echo "</tr>";
                                        }
                                    }
                                }
                            }

                            if (isset($_GET["area"])) {
                                $data = $_GET["area"];
                                $untilValue = array();

                                if ($data == "SLEX") {
                                    getAreaStatus($slex);
                                } else if ($data == "Bancal") {
                                    getAreaStatus($bancal);
                                }
                            }
                            ?>
                        </div>


                        <a class="waves-effect teal-text btn-flat center-align" href="daily.php?area=<?php echo "$data" ?>"
                           style="margin-top: 1em; width: 100%;">See More</a>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNqg21fMXOnBCPajFuCDgy5zt6MkOPYv4"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/graph.js"></script>
<script src="js/materialize.js"></script>
<script src="js/caqms-api.js"></script>
<script src="js/aqi-calculator.js"></script>
<script src="js/init.js"></script>
</body>
</html>

<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
    header('Location: index.php');

}
?>

<?php
define("PAGE_TITLE", "Daily - Air Quality Monitoring System");
include("include/Map.php");
include('include/header.php');
?>

<div id="content-holder">
<div class="container">
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-image">
                    <img  id="zoneImg" class="img-circle" src="res/images/area/slex_carmona-exit.jpg"">
                    <span class="card-title teal-text" style="font-weight: bold" id="zoneName">Zone Name</span>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col s3 center">
                            <p><span class="material-icons" style="font-size: 4em;" id="AQIStat">cloud</span></p>
                            <p style="font-weight: bold; font-size: 1em;">AQI: <span id="aqiNum"></span ></p>
                        </div>
                        <div class="col s9">
                            <p style="font-size: 1.5em"><b id="aqiText">NaN</b></p>
                        </div>
                    </div>
                    <p><b>Prevalent Air Pollutant: </b> <span id="prevalentPollutant">NaN</span></p>
                    <p><b>Recorded on: </b><span id="timeUpdated">NaN</span></p>

                </div>
                <div class="card-action center">
                    <a id ="prevArea-daily" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_left</i></a>
                    <a id ="nextArea-daily" class="waves-effect orange-text"><i class="material-icons">keyboard_arrow_right</i></a>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="row row-no-after">-->
<!--        <div class="col s12">-->
<!--            <div class="card">-->
<!--                <div class="card-content">-->
<!--                    <h5 class="teal-text" style="margin-top: 0;"><b>Current Distribution</b></h5>-->
<!--                    <div class="divider"></div>-->
<!--                    <br>-->
<!--                    <div class="row">-->
<!--                        <div class="col s12">-->
<!--                            <canvas id="doughnutChart"></canvas>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="row row-no-after">-->
<!--        <div class="col s12">-->
<!--            <div class="card" style="min-height: 400px;">-->
<!--                <div class="card-content">-->
<!--                    <h5 class="teal-text" style="margin-top: 0;"><b>Rolling 24 hrs Distribution</b></h5>-->
<!--                    <div class="divider"></div>-->
<!--                    <br>-->
<!--                    <div style="width: 100%; height: 300px;">-->
<!--                        <canvas id="barChart"></canvas>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
    <div class="row row-no-after">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5 class="teal-text" style="margin-top: 0;"><b>Cautionary</b></h5>
                    <div class="divider"></div>
                    <br>
                    <div id="cautionary"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    function getAreaStatus2($area_data)
    {
        $untilValue = $area_data->aqi_values;

        $ind = $area_data->prevalentIndex[0];

        $elementName = "e_symbol_" . ($ind + 1);
        $conentrationName = "concentration_value_" . ($ind + 1);
        $chartName = "chart_div_" . ($ind + 1);
        $elementNameMin = "aqi_min_" . ($ind + 1);
        $elementNameMax = "aqi_max_" . ($ind + 1);

        $value = $area_data->aqi_values[$ind];

        echo "<div class='row'>
                        <div class='col s12'>
                            <ul class='collapsible' data-collapsible='accordion'>
                                <li data-click-accordion = '' data-prevValue = '$value' data-prevIndex = '$ind'>
                                    <div class='collapsible-header active'>
                                        <div class='row-no-after'>
                                            <div class='col s5'>
                                                <i class='material-icons'>settings_input_svideo</i>
                                                <b id = '$elementName'>Prevalent Element Name Here</b>
                                            </div>
                                            <div class='col s7 right-align'>
                                                <div style='font-weight: bold'>
                                                    <span class='teal-text' id = '$conentrationName'>Current: 00</span> | <span
                                                            class='blue-text' id = '$elementNameMin'>Min: 00</span> | <span class='red-text' id = '$elementNameMax'>Max: 00</span>
                                                </div>
                    
                                            </div>
                                        </div>
                    
                                    </div>
                                    <div class='collapsible-body'>
                                        <div class='chart'><canvas id='$chartName'></canvas></div>
                                    </div>
                                </li>";

        //if (count($area_data->AllDayValues_array) != 0) {
        for ($x = 0; $x < count($untilValue); $x++) {
            $found = false;

            if ($x != $ind) {
                switch ($x) {
                    case 0:
                        $found = true;
                        break;

                    case 1:
                        $found = true;
                        break;

                    case 2:
                        $found = true;
                        break;

//                                case 3:
//                                    $maxValue = $area_data->o3_max;
//                                    break;
//
//                                case 4:
//                                    $maxValue = $area_data->pm10_max;
//                                    break;
//
//                                case 5:
//                                    $maxValue = $area_data->tsp_max;
//                                    break;
                }

                if ($found) {
                    $elementName = "e_symbol_" . ($x + 1);
                    $conentrationName = "concentration_value_" . ($x + 1);
                    $chartName = "chart_div_" . ($x + 1);
                    $elementNameMin = "aqi_min_" . ($x + 1);
                    $elementNameMax = "aqi_max_" . ($x + 1);

                    $value = $area_data->aqi_values[$x];

                    echo "<li data-click-accordion = '' data-prevValue = '$value' data-prevIndex = '$x'>
                                    <div class='collapsible-header'>
                                        <div class='row-no-after'>
                                            <div class='col s5'>
                                                <i class='material-icons'>settings_input_svideo</i>
                                                <b id = '$elementName'></b>
                                            </div>
                                            <div class='col s7 right-align'>
                                                <div style='font-weight: bold'>
                                                    <span class='teal-text' id = '$conentrationName'>Current: 00</span> | <span
                                                            class='blue-text' id = '$elementNameMin'>Min: 00</span> | <span class='red-text' id = '$elementNameMax'>Max: 00</span>
                                                </div>
                    
                                            </div>
                                        </div>
                    
                                    </div>
                                    <div class='collapsible-body'>
                                    
                                        <div class='chart'><canvas id='$chartName'></canvas></div>
                                    </div>
                                </li>
                                </li>";
                }
            }
        }
        //}

        echo "
                            </ul>
                        </div>
                    </div>
                    ";
    }

    if(isset($_GET["area"]))
    {
        $data = $_GET["area"];
        $untilValue = array();

        if($data == "SLEX") {
            getAreaStatus2($slex);
        }

        else if($data == "Bancal") {
            getAreaStatus2($bancal);
        }
    }else{
        getAreaStatus2($bancal);
    }
    ?>
</div>

<?php include('include/footer.php'); ?>
<!--Additional Scripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/mobile.js"></script>
<script src="js/graph.js"></script>
<script src="js/daily-graph.js"></script>
<script src="js/aqi-calculator.js"></script>
</body>
</html>

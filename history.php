<?php
require_once 'include/dbFunctions.php';
$error = false;
$areaName = array('Select an area', 'SLEX', 'Bancal', 'All');
$row = 0;

if(isset($_POST['btnGenerate']))
{

    $gpdf = new GPDF();
    $area = filter_input(INPUT_POST, 'drpArea');
    $dateTimeFrom = filter_input(INPUT_POST, 'txtDateTimeFrom');
    $dateTimeTo = filter_input(INPUT_POST, 'txtDateTimeTo');
    $order = filter_input(INPUT_POST, 'drpOrder');


if($area == 3) {
    $row = $gpdf->CheckPollutants("", $dateTimeFrom, $dateTimeTo);
}
else{
    $row = $gpdf->CheckPollutants($areaName[$area], $dateTimeFrom, $dateTimeTo);
}
if($row == 0){
    //$error = true;
    echo "<script>alert('No available data')</script>";
}else{
    header("Location: generatepdf.php");
}

}
?>

<?php
define("PAGE_TITLE", "History - Air Quality Monitoring System");
include('include/header.php');
?>



<div id="content-holder">
    <br>
    <h1 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons" style="font-size: 2em;">library_books</span></h1>
    <h2 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b>History Report</b></h2>
    <p class="header center grey-text" style="margin-top: 0; padding-top: 0;">By filling out and submitting this form, the page would generate a PDF file.</p>

   <div class="section no-pad-bot">
        <div class="container">
            <div class="divider"></div>
            <br>
            <div class="row">
                <div class="col s12">
                    <div>
                        <form method = "post" target="_blank" action="generatepdf.php">
                        <!--<form method = "post" action="generatepdf.php">-->
                            <div id = "woah" class="input-field col s12">
                                <!--<select name = "drpArea" id = "drpArea" required onchange="getData(this.value)">-->
                                <select name = "drpArea" id = "drpArea" required>
                                    <option value="" disabled selected>Select an area</option>
                                    <option value="1">SLEX Carmona</option>
                                    <option value="2">Bancal</option>

                                    <option value="3">All</option>
                                </select>
                                <label>Area</label>
                            </div>
                            <!--<div  class="input-field col s12">
                                <select name = "drpPollutant" id = "drpPollutant" required>
                                    <option value="" disabled selected>Select a pollutant</option>
                                </select>
                                <label>Pollutant</label>
                            </div>-->

                            <div  class="input-field col s12">
                                <select name = "drpOrder" required>
                                    <option value="1" selected>Timestamp</option>

                                </select>
                                <label>Order By</label>
                            </div>

                            <div class="input-field s12">
                                <div class="input-field col s12">
                                    <p class="flatpickr input-date">
                                        <label for="time">From</label>
                                        <input id="txtDateTimeFrom" name="txtDateTimeFrom" class="date col s12"
                                               placeholder="YYYY-MM-DD"
                                               data-input>
                                    </p>

                                </div>
                            </div>
                            <div class="input-field s12">
                                <div class="input-field col s12">
                                    <p class="flatpickr input-date">
                                        <label for="time">To</label>
                                        <input id="txtDateTimeTo" name="txtDateTimeTo" class="date col s12"
                                               placeholder="YYYY-MM-DD"
                                               data-input>
                                    </p>

                                </div>
                            </div>

                            <div class="input-field center col s12">
                                <button class="btn btn-large waves-effect waves-light"  type="submit" name="btnGenerate" style="width: 100%;">
                                    Generate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>


<?php  include('include/footer.php'); ?>
<!--ADDITIONAL SCRIPTS-->
<script src="js/flatpickr.min.js"></script>
<script type="text/javascript">
    var area_name = ["slex", "bancal", "all"];

    $( document ).ready(function(){
        $("#legends").remove();

        $('select').material_select();

        $(document).on('change','#drpArea',function(){
            var val = $(this).val();

            $.ajax({
                url: 'getPollutants.php',
                data: {area:area_name[val-1]},
                type: 'GET',
                dataType: 'html',
                success: function(result){
                    var $selectDropdown = $("#drpPollutant").empty().html(' ');
                    $('#drpPollutant').html(result);
                    $selectDropdown.trigger('contentChanged');
                }
            });
        });

        var val = $("#drpArea").val();

        $.ajax({
            url: 'getPollutants.php',
            data: {area:area_name[val-1]},
            type: 'GET',
            dataType: 'html',
            success: function(result){
                var $selectDropdown = $("#drpPollutant").empty().html(' ');
                $('#drpPollutant').html(result);
                $selectDropdown.trigger('contentChanged');
            }
        });

            $('select').on('contentChanged', function() {
            // re-initialize (update)
            $(this).material_select();
        });

    })


</script>
</body>
</html>

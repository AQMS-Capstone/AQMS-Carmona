<?php
define("PAGE_TITLE", "Maintenance - Air Quality Monitoring System");
include('include/Map.php');
?>
<?php include('include/admin-header.php'); ?>
<main>
    <div class="row row-no-after" id="statusDiv">
        <div class='col s12 m6'>
            <div class='card z-depth-0'>
                <div id='aqiColor1' class='col s12' style='margin-bottom: 15px;'>
                    <p style='font-size: 1em;' class='white-text'><b id='aqiText1'></p>
                </div>
                <div class='card-content'>
                    <div class='row'>
                        <p class='card-title teal-text' style='font-weight: bold' id='zoneName'>BANCAL</p>
                        <div class='divider'></div>
                        <br>
                        <div class='col s12' style='padding: 0;'>
                            <p><span id='message1'></span ></p>
                            <br><br>
                            <div class="input-field center">
                                <button class="btn btn-large waves-effect waves-light" type="button" value="1" onclick ='ChangeStat(this.value)' style="width: 100%;">
                                    <span id='btn1'>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class='col s12 m6'>
            <div class='card z-depth-0'>
                <div id='aqiColor2' class='col s12' style='margin-bottom: 15px;'>
                    <p style='font-size: 1em;' class='white-text'><b id='aqiText2'></p>
                </div>
                <div class='card-content'>
                    <div class='row'>
                        <p class='card-title teal-text' style='font-weight: bold' id='zoneName'>SLEX</p>
                        <div class='divider'></div>

                        <br>
                        <div class='col s12' style='padding: 0;'>
                            <p><span id='message2'></span ></p>
                            <br><br>
                            <div class="input-field center">
                                <button class="btn btn-large waves-effect waves-light" type="button" value="2" onclick ='ChangeStat(this.value)' style="width: 100%;">
                                    <span id='btn2'>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include('include/footer.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script src="js/maintenance.js"></script>
<script>
    $( "#maintenance-tab" ).addClass( "active" );
</script>
</body>
</html>
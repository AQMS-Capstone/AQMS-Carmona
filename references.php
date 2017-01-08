<?php
define("PAGE_TITLE", "About - Air Quality Monitoring System");
include('include/header.php');
?>

<div id="content-holder">
    <br>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">References</h3>
            <h5 class="teal-text text-lighten-2">The information provided in this website are guided by the following guideline/s</h5>

            <div class="divider"></div>
            <br>
            <br>
            <div class="row">

                <div class="col s12 left-align-on-med-and-up">
                    <li class="gray-text text-lighten-3 caption">Technical Assistance Document for the Reporting of Daily Air Quality - May 2016 | <a href="https://www3.epa.gov/airnow/aqi-technical-assistance-document-may2016.pdf" target = "_blank" class = "orange-text">Download PDF</a></li>
                    <li class="gray-text text-lighten-3 caption">Implementing Rules and Regulations for RA 8749 - DAO 200-81 | <a href="http://air.emb.gov.ph/wp-content/uploads/2016/04/DAO-2000-81.pdf" target = "_blank" class = "orange-text">Download PDF</a></li>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  include('include/footer.php'); ?>
<script type="text/javascript">
    $( document ).ready(function(){
        $("#legends").remove();
    })
</script>
</body>
</html>
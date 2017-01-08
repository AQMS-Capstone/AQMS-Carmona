<?php
define("PAGE_TITLE", "About - Air Quality Monitoring System");
include('include/header.php');
?>

<div id="content-holder">
    <br>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">About</h3>
            <h5 class="teal-text text-lighten-2">Learn about Carmona, the AQMS and our Project Team.</h5>
        </div>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="res/images/parallax/carmona_1.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">Municipality of Carmona</h3>
            <div class="divider"></div><br>
            <p class="gray-text text-lighten-3 caption">
                Carmona is located on the south-eastern part of the province of Cavite, approximately 36 kilometres south of Manila and 24 kilometres from Trece Martires City, Cavite’s provincial capital.
                It is bounded on the north, east and south by the City of Biñan, Laguna, Municipality of General Mariano Alvarez (GMA) on the north-west and Silang on the south-west.
                The geographic coordinates of Carmona are about 14.32° latitude and 121.06° longitude.
            </p>
        </div>
    </div>
    <div class="parallax-container">
        <div class="center" style="margin-top: 7%; margin-left: 7%;">
            <img class="img-parallax" src="res/images/parallax/aqms-cloud.png">
        </div>


        <div class="parallax"><img src="res/images/parallax/aqms.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">The Air Quality Monitoring System</h3>
            <div class="divider"></div><br>
            <p class="gray-text text-lighten-3 caption">
                AQMS promotes Air Pollution awareness and provides a unified Air Quality information for the Municipality of Carmona.
                The system will gather concentration values of the following pollutants (CO, SO2, and NO2) in real-time from the two "key-areas" in Carmona namely: Bancal Junction/Intersection, and SLEX Entrance / Exit. The system will then provide the necessary information such as the prevalent pollutant, its AQI value and synthesis, and the rolling 24-hour AQI Graph
                in order to help the citizen of Carmona be aware of the air quality they're breathing.
            </p>
        </div>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="res/images/parallax/carmona_2.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container center">
            <h3 class="header teal-text">Meet the Team</h3>
            <p class="gray-text text-lighten-3 caption">We are a team of students from Malayan Colleges Laguna.</p>
            <div class="divider"></div>
            <br>
            <br>
            <div class="row">
                <div class="col s12 l3">
                    <div>
                        <a href="https://www.facebook.com/VCMesina" target="_blank"><img class="img-circle img-small" src="res/images/team/vonn.jpg" alt="Vonn"></a>
                    </div>
                </div>
                <div class="col s12 l9 left-align-on-med-and-up">
                    <h4>Vonn Mesina</h4>
                    <p>Vonn is currently an I.T. student, specializing in web and mobile development.
                        He is currently working at Gleent Inc. as their OJT-iOS Developer</p>
                </div>
            </div>

            <div class="row">
                <div class="col s12 l3">
                    <div>
                        <a href="https://www.facebook.com/rairulyle" target="_blank"><img class="img-circle img-small" src="res/images/team/lyle.jpg" alt="Lyle"></a>
                    </div>
                </div>
                <div class="col s12 l9 left-align-on-med-and-up">

                    <h4>Lyle Dela Cuesta</h4>
                    <p>Lyle is currently an I.T. student, specializing in web and mobile development.
                        He is currently working at NXP, Philips Inc. as their OJT-Front End and Back End Developer</p>
                </div>
            </div>

            <div class="row">
                <div class="col s12 l3">
                    <div>
                        <a href="https://www.facebook.com/krismariano30" target="_blank"><img class="img-circle img-small" src="res/images/team/kris.jpg" alt="Kris"></a>
                    </div>
                </div>
                <div class="col s12 l9 left-align-on-med-and-up">
                    <h4>Kris Mariano</h4>
                    <p>Kris is currently an I.T. student, specializing in web and mobile development.
                        He is currently working at NXP, Philips Inc. as their OJT-Front End and Back End Developer.</p>
                </div>
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

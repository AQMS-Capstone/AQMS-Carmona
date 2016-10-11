
<!--Zone Status Card-->
<div id="zoneStatus" class="card">
    <div>
        <div class="col-md-6">
            <div class="AQIStat" id="AQIStat">
                <span id="aqiNum" style="font-size: 90px;"></span>
            </div>
        </div>
        <div class="col-md-6">
            <p style="font-weight: bold; font-size: x-large; word-break: break-all;" id="zoneName"></p>
            <p style="font-weight: bold; font-size: large; word-break: break-all;" id="aqiText"></p>
            <p><span>Prevalent Air Pollutant: </span><span id="prevalentPollutant">N02</span></p>
            <p id="timeUpdated"></p>
        </div>
        <div class="col-md-12">
            <p style="font-weight: bold" id="zoneRisk"></p>
        </div>
    </div>

    <div class="">
        <ul class="nav navbar-nav">
            <li ><a href="#tabs-1" id = "tab-1-clicked" style="color:black; padding-left: 162px; padding-right: 162px">AQI Plot</a></li>
            <li ><a href="#tabs-2" id="tab-2-clicked" style="color:black; padding-left: 150px; padding-right: 150px">Concentration Plot</a></li>
        </ul>


    </div>
    <div id="tabs-1">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>Current</th>
                    <th></th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CO</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>NO2</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>O3</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                </tbody>
            </table>
        </div>

        <p style="padding: 20px; padding-top: 20px">Synthesis: Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>


    </div>
    <div id="tabs-2">

        <div class="col-md-12" style="margin-bottom: 10px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>Current</th>
                    <th></th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CO</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>NO2</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                <tr>
                    <td>O3</td>
                    <td>999</td>
                    <td><img src="res/sampleData.png"></td>
                    <td>0</td>
                    <td>999</td>
                </tr>
                </tbody>
            </table>
        </div>


        <p style="padding: 20px; padding-top: 20px">Synthesis: Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
    </div>

</div>

<div class="map-container">
    <div id="googleMap" class="mapAPI"></div>
</div>

<nav class="footer-fixed">
    <div class="container">
        <ul>
            <li style="vertical-align:middle; color:white">© 2016 AQMS</li>
        </ul>
    </div>
</nav>
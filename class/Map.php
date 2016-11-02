<?php
class Map{
  /*
  var $m_id = "";
  var $p_id = "";
  var $p_name = "";
  var $p_value = "";
  var $p_status = "";
  var $p_time = "";
  */

  var $m_id = "";
  var $a_id = "";
  var $e_id = "";
  var $concentration_value = "";
  var $timestamp = "";

  function Map(){}
}

require_once 'public/include/db_connect.php';

$bancalMap = new Map();
$slexMap = new Map();

$sql = "SELECT * FROM MASTER";
$result =  mysqli_query($con,$sql);

while($row=mysqli_fetch_assoc($result))
{
  if($row['a_id'] == "2")
  {
    $bancalMap->m_id = $row['m_id'];
    $bancalMap->a_id = $row['a_id'];
    $bancalMap->e_id = $row['e_id'];
    $bancalMap->concentration_value = $row['concentration_value'];
    $bancalMap->timestamp = $row['e_id'];
  }

  else if($row['a_id'] == "1")
  {
    $slexMap->m_id = $row['m_id'];
    $slexMap->a_id = $row['a_id'];
    $slexMap->e_id = $row['e_id'];
    $slexMap->concentration_value = $row['concentration_value'];
    $slexMap->timestamp = $row['e_id'];
  }
}

$sql = "SELECT * FROM PSCSGP";
$result =  mysqli_query($con,$sql);

$guidelineValues=array();

while($row=mysqli_fetch_assoc($result))
{
  $guidelineValues[] = $row;
}

//Default Values
if($bancalMap->e_id == "")
{
  $bancalMap->m_id = "0";
  $bancalMap->a_id = "0";
  $bancalMap->e_id = "0";
  $bancalMap->concentration_value = "0";
  $bancalMap->timestamp = "0";
}

if($slexMap->e_id == "")
{
  $slexMap->m_id = "0";
  $slexMap->a_id = "0";
  $slexMap->e_id = "0";
  $slexMap->concentration_value = "0";
  $slexMap->timestamp = "0";
}

//$airData = json_encode($rows);

//$bancalMap = new Map(0, 90);
//$slexMap = new Map(1,50);
?>


<!--  Scripts-->
<script type="text/javascript">

  //Air Quality Color Indicator
  var goodAir = "#2196F3";
  var moderateAir = "#FFEB3B";
  var unhealthy1Air = "#FF9800";
  var unhealthy2Air = "#f44336";
  var veryUnhealthyAir = "#9C27B0";
  var hazardoussAir = "#b71c1c";

  var guidelineValues = <?= json_encode($guidelineValues) ?>
  //alert(JSON.stringify(guidelineValues[10].description));

  function Map (determiner) {

    if(determiner == "2"){
      this.m_id = <?= $bancalMap->m_id ?>;
      this.a_id = <?= $bancalMap->a_id ?>;
      this.e_id = <?= $bancalMap->e_id ?>;
      this.contentration_value = <?= $bancalMap->concentration_value ?>;
      this.timestamp = <?= $bancalMap->timestamp ?>;
    }

    else if(determiner == "1") {
      this.m_id =  <?= $slexMap->m_id ?>;
      this.a_id = <?= $slexMap->a_id ?>;
      this.e_id = <?= $slexMap->e_id ?>;
      this.contentration_value = <?= $slexMap->concentration_value ?>;
      this.timestamp = <?= $slexMap->timestamp ?>;
    }

    //alert(JSON.stringify(guidelineValues[10].description));

    for(var i = 0; i < guidelineValues.length; i++)
    {
      var e_id = JSON.stringify(guidelineValues[i].e_id);
      var aqi_code = JSON.stringify(guidelineValues[i].aqi_code);
      var description =JSON.stringify(guidelineValues[i].description);
      var value_min = JSON.stringify(guidelineValues[i].value_min);
      var value_max = JSON.stringify(guidelineValues[i].value_max);
      var averaging_time = JSON.stringify(guidelineValues[i].averaging_time);
      var time_unit = JSON.stringify(guidelineValues[i].time_unit);

      if(this.pid == e_id)
      {

      }
    }


    /*
    for(var key in guidelineValuesString) {
      if (guidelineValuesString.hasOwnProperty(key)) {
          //alert("Hello");
          alert(guidelineValuesString[key]);
      }
    }*/

    /*
    for(i = 0 ; i < guidelineValues.length ; i++)
    {

    }*/

    //window.alert(guidelineValues);

    /*
    switch(this.p_id)
    {
      case 0: // TSP
        this.p_name = "TSP";
        if(this.p_value >= 0 && this.p_value <= 80){
          this.p_airqualiy = goodAir;
          this.p_aqi_status = "Good";
        }else if(this.p_value >= 81 && this.p_value <= 230){
          this.p_airqualiy = moderateAir;
          this.p_aqi_status = "Fair";
        }else if(this.p_value >= 231 && this.p_value <= 349){
          this.p_airqualiy = unhealthy1Air;
          this.p_aqi_status = "Unhealthy for Sensitive Groups";
        }else if(this.p_value >= 350 && this.p_value <= 599){
          this.p_airqualiy = unhealthy2Air;
          this.p_aqi_status = "Very Unhealthy";
        }else if(this.p_value >= 600 && this.p_value <= 899){
          this.p_aqi_status = "Acutely Unhealthy";
          this.p_airqualiy = veryUnhealthyAir;
        }else if(this.p_value >= 900){
          this.p_airqualiy = hazardoussAir;
          this.p_aqi_status = "Emergency";
        }else {
          this.p_aqi_status = "Out of the NAAQGV.";
        }
        break;

      case 1: // PM 10
        this.p_name = "PM 10";
        if(this.p_value >= 0 && this.p_value <= 54){
          this.p_airqualiy = goodAir;
          this.p_aqi_status = "Good";
        }else if(this.p_value >= 55 && this.p_value <= 154){
          this.p_airqualiy = moderateAir;
          this.p_aqi_status = "Fair";
        }else if(this.p_value >= 155 && this.p_value <= 254){
          this.p_airqualiy = unhealthy1Air;
          this.p_aqi_status = "Unhealthy for Sensitive Groups";
        }else if(this.p_value >= 255 && this.p_value <= 354){
          this.p_airqualiy = unhealthy2Air;
          this.p_aqi_status = "Very Unhealthy";
        }else if(this.p_value >= 355 && this.p_value <= 424){
          this.p_airqualiy = veryUnhealthyAir;
          this.p_aqi_status = "Acutely Unhealthy";
        }else if(this.p_value >= 425 && this.p_value <= 504){
          this.p_airqualiy = hazardoussAir;
          this.p_aqi_status = "Emergency";
        }else {
          this.p_aqi_status = "Out of the NAAQGV.";
        }
        break;

      case 2: // SO2
        this.p_name = "SO2";
        if(this.p_value >= 0.000 && this.p_value <= 0.034){
          this.p_airqualiy = goodAir;
          this.p_aqi_status = "Good";
        }else if(this.p_value >= 0.035 && this.p_value <= 0.144){
          this.p_airqualiy = moderateAir;
          this.p_aqi_status = "Fair";
        }else if(this.p_value >= 0.145 && this.p_value <= 0.224){
          this.p_airqualiy = unhealthy1Air;
          this.p_aqi_status = "Unhealthy for Sensitive Groups";
        }else if(this.p_value >= 0.225 && this.p_value <= 0.304){
          this.p_airqualiy = unhealthy2Air;
          this.p_aqi_status = "Very Unhealthy";
        }else if(this.p_value >= 0.305 && this.p_value <= 0.604){
          this.p_airqualiy = veryUnhealthyAir;
          this.p_aqi_status = "Acutely Unhealthy";
        }else if(this.p_value >= 0.605 && this.p_value <= 0.804){
          this.p_aqi_status = "Emergency";
          this.p_airqualiy = hazardoussAir;
        }else {
          this.p_aqi_status = "Out of the NAAQGV.";
        }
        break;

      case 3: // O3
        this.p_name = "O3 1hr";
        if(this.p_value > 0.375){ // O3 1hr
          if(this.p_value >= 0.000 && this.p_value <= 0.124){
            this.p_aqi_status = "No defined NAAQGV.";
          }else if(this.p_value >= 0.125 && this.p_value <= 0.164){
            this.p_airqualiy = unhealthy1Air;
            this.p_aqi_status = "Unhealthy for Sensitive Groups";
          }else if(this.p_value >= 0.165 && this.p_value <= 0.204){
            this.p_airqualiy = unhealthy2Air;
            this.p_aqi_status = "Very Unhealthy";
          }else if(this.p_value >= 0.205 && this.p_value <= 0.404){
            this.p_airqualiy = veryUnhealthyAir;
            this.p_aqi_status = "Acutely Unhealthy";
          }else if(this.p_value >= 0.405 && this.p_value <= 0.504){
            this.p_airqualiy = hazardoussAir;
            this.p_aqi_status = "Emergency";
          }else {
            this.p_aqi_status = "Out of the NAAQGV.";
          }
        }

        else { // O3 8 hr
          this.p_name = "03 8 hr";
          if(this.p_value >= 0.000 && this.p_value <= 0.064){
            this.p_airqualiy = goodAir;
            this.p_aqi_status = "Good";
          }else if(this.p_value >= 0.065 && this.p_value <= 0.084){
            this.p_airqualiy = moderateAir;
            this.p_aqi_status = "Fair";
          }else if(this.p_value >= 0.085 && this.p_value <= 0.104){
            this.p_airqualiy = unhealthy1Air;
            this.p_aqi_status = "Unhealthy for Sensitive Groups";
          }else if(this.p_value >= 0.105 && this.p_value <= 0.124){
            this.p_airqualiy = unhealthy2Air;
            this.p_aqi_status = "Very Unhealthy";
          }else if(this.p_value >= 0.125 && this.p_value <= 0.374){
            this.p_airqualiy = veryUnhealthyAir;
            this.p_aqi_status = "Acutely Unhealthy";
          }
        }
        break;

      case 4: // CO
        this.p_name = "CO";
        if(this.p_value >= 0.0 && this.p_value <= 4.4){
          this.p_airqualiy = goodAir;
          this.p_aqi_status = "Good";
        }else if(this.p_value >= 4.5 && this.p_value <= 9.4){
          this.p_airqualiy = moderateAir;
          this.p_aqi_status = "Fair";
        }else if(this.p_value >= 9.5 && this.p_value <= 12.4){
          this.p_airqualiy = unhealthy1Air;
          this.p_aqi_status = "Unhealthy for Sensitive Groups";
        }else if(this.p_value >= 12.5 && this.p_value <= 15.4){
          this.p_airqualiy = unhealthy2Air;
          this.p_aqi_status = "Very Unhealthy";
        }else if(this.p_value >= 15.5 && this.p_value <= 30.4){
          this.p_airqualiy = veryUnhealthyAir;
          this.p_aqi_status = "Acutely Unhealthy";
        }else if(this.p_value >= 30.5 && this.p_value <= 40.4){
          this.p_airqualiy = hazardoussAir;
          this.p_aqi_status = "Emergency";
        }else {
          this.p_aqi_status = "Out of the NAAQGV.";
        }
        break;

      case 5: // NO2
        this.p_name = "NO2";
        if(this.p_value >= 0.00 && this.p_value <= 0.64){
          this.p_aqi_status = "No defined NAAQGV.";
        }else if(this.p_value >= 0.65 && this.p_value <= 1.24){
          this.p_aqi_status = "Acutely Unhealthy";
          this.p_airqualiy = hazardoussAir;
        }else if(this.p_value >= 1.25 && this.p_value <= 1.64){
          this.p_aqi_status = "Emergency";
          this.p_airqualiy = hazardoussAir;
        }else {
          this.p_aqi_status = "Out of the NAAQGV.";
        }
        break;
    }*/
  }

  var bancalMap = new Map("2");
  var slexMap =  new Map("1");

</script>

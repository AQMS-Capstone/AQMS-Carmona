<?php
require_once 'lib/fpdf.php';

class PDF extends FPDF
{

// Simple table
    function BasicTable($header, $data)
    {
        // Header
        $this->Cell(5);
        foreach ($header as $col) {
            $this->SetFont('helvetica', 'B', 10);

            $this->Cell(45, 7, $col, 1, 0, 'C');
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell(5);
            $this->SetFont('helvetica', '', 10);
            foreach ($row as $col)
                $this->Cell(45, 6, $col, 1, 0, 'C');
            $this->Ln();

        }

    }

// Page header
    function Header()
    {
        date_default_timezone_set("Asia/Manila");
        $g_time = date("l, m-d-Y G:i");
        // Logo
        $this->Image('res/header.png', 10, 3, 190);
        $this->Image('res/Logo1.png', 10, 3, 32);
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(50);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(30, 5, 'AQMS Carmona History Report', 0, 0);
        // Arial bold 15
        // Move to the right

        $this->Cell(48);
        // Title
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        //$this->Cell(10);
        $this->Cell(30, 30, 'Generated on:' . ' ' . $g_time, 0, 0);
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(150);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

class GPDF{

    function CheckPollutants($a_name, $p_name, $dFrom, $dTo){
        include('include/db_connect.php');
        if($a_name == "" && $p_name == ""){
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";
        }
        else if($a_name == ""){
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

        }
        else if($p_name == ""){
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

        }
        else{
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

        }

        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);
        mysqli_close($con);
        return $row;
    }

    function GetPollutants($a_name, $p_name, $dFrom, $dTo, $order){

        include('include/db_connect.php');

        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        if($a_name == "" && $p_name == ""){
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
        }
        else if($a_name == ""){
            $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE ELEMENTS.e_symbol = '$p_name' AND DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";

        }
        else if($p_name == ""){
            $query = "SELECT E_NAME, AREA_NAME ,E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
        }
        else{
            $query = "SELECT E_NAME, AREA_NAME ,E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
        }
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {

            if($row['AREA_NAME'] == "bancal"){
                array_push($bancalData, $row["E_NAME"] . ';' . $row["E_SYMBOL"] . ';' . $row["CONCENTRATION_VALUE"] . ';' . $row["timestamp"]);


                array_push($bancalData1, $row["E_NAME"]);
                array_push($bancalData1, $row["E_SYMBOL"]);
                array_push($bancalData1, $row["CONCENTRATION_VALUE"]);
                array_push($bancalData1, $row["timestamp"]);
            }
            else{
                array_push($slexData, $row["E_NAME"] . ';' . $row["E_SYMBOL"] . ';' . $row["CONCENTRATION_VALUE"] . ';' . $row["timestamp"]);


                array_push($slexData1, $row["E_NAME"]);
                array_push($slexData1, $row["E_SYMBOL"]);
                array_push($slexData1, $row["CONCENTRATION_VALUE"]);
                array_push($slexData1, $row["timestamp"]);
            }

        }

        mysqli_close($con);
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

}


?>

<?php

class AQICalculator{
    function GetAQI()
    {
        require 'include/guidelines.php';

        $aqi = 0;

        $concentration = $_POST["concentration"];
        $element = $_POST["element"];

        if ($element == "CO") {
            $aqi = round(calculateAQI($co_guideline_values, $concentration, 1, $guideline_aqi_values));
        }
        if ($element == "SO2") {
            $aqi = round(calculateAQI($sufur_guideline_values, $concentration, 3, $guideline_aqi_values));
        }
        if ($element == "NO2") {
            $aqi = round(calculateAQI($no2_guideline_values, $concentration, 2, $guideline_aqi_values));
        }
        if ($element == "O3_8") {
            $aqi = round(calculateAQI($ozone_guideline_values_8, $concentration, 3, $guideline_aqi_values));
        }
        if ($element == "O3_1") {
            $aqi = round(calculateAQI($ozone_guideline_values_1, $concentration, 3, $guideline_aqi_values));
        }
        if ($element == "PM 10") {
            $aqi = round(calculateAQI($pm_10_guideline_values, $concentration, 0, $guideline_aqi_values));
        }
        if ($element == "TSP") {
            $aqi = round(calculateAQI($tsp_guideline_values, $concentration, 0, $guideline_aqi_values));
        }

        echo "
          <script type='text/javascript'>
          
             var AQI = \"$aqi\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             $(\"#aqiNum\").text(AQI);
             
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             $(\"#result\").show();
             ScrollTo('calculator');
          </script>
    ";

    }

    function GetCV(){
        require 'include/guidelines.php';

        $concentration = $_POST["concentration"];
        $element = $_POST["element"];

        $concentration_value = 0;

        if ($element == "CO") {
            $concentration_value = calculateConcentrationValue($co_guideline_values, $concentration, 1, $guideline_aqi_values);
        }
        if ($element == "SO2") {
            $concentration_value = calculateConcentrationValue($sufur_guideline_values, $concentration, 3, $guideline_aqi_values);
        }
        if ($element == "NO2") {
            $concentration_value = calculateConcentrationValue($no2_guideline_values, $concentration, 2, $guideline_aqi_values);
        }
        if ($element == "O3_8") {
            $concentration_value = calculateConcentrationValue($ozone_guideline_values_8, $concentration, 3, $guideline_aqi_values);
        }
        if ($element == "O3_1") {
            $concentration_value = calculateConcentrationValue($ozone_guideline_values_1, $concentration, 3, $guideline_aqi_values);
        }
        if ($element == "PM 10") {
            $concentration_value = calculateConcentrationValue($pm_10_guideline_values, $concentration, 0, $guideline_aqi_values);
        }
        if ($element == "TSP") {
            $concentration_value = calculateConcentrationValue($tsp_guideline_values, $concentration, 0, $guideline_aqi_values);
        }

        echo "
          <script type='text/javascript'>
          
             var AQI = \"$concentration\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             $('#aqiNum').text($concentration_value);
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             $(\"#result\").show();
             ScrollTo('calculator');
          </script>     
    ";

    }
}

?>
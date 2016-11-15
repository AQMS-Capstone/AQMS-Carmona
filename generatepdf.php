<?php

require_once '/lib/fpdf.php';
require_once 'public/include/db_connect.php';


$areaIndex = 0;
$pollutantIndex = 0;
$date = "";
$prevalent_air_pollutant = "";
$aqi_status = "";
$datePicked = "";
$red = 0;
$blue = 0;
$green = 130;
$sampol = array();
$sampol1 = array();
$igachu = array();
$ugachme = array();
$query = "";
$time_updated = "";

$area = array('Select an area', 'SLEX', 'Bancal', 'SLEX Carmona Exit and Bancal Junction, Carmona, Cavite');
$pollutant = array('Select a pollutant', 'CO', 'SO2', 'NO2', 'O3', 'Pb', 'PM10', 'TSP', 'All');
//$area = $_GET[$areaArray];
if (isset($_POST['btnGenerate'])) {
    $areaIndex = $_POST['drpArea'];
    $pollutantIndex = $_POST['drpPollutant'];
    $date = $_POST["txtDateTimeFrom"];
    $loc = strtolower($area[$areaIndex]);
    if ($pollutantIndex == 7) {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
              WHERE area_name = '$loc' and DATE(timestamp) = '$date'
              ORDER BY CONCENTRATION_VALUE DESC";

    } else {
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
              WHERE area_name = '$loc' and MASTER.e_id = '$pollutantIndex' and DATE(timestamp) = '$date'
              ORDER BY concentration_value DESC";
        $result = mysqli_query($con, $query);
    }
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        array_push($sampol, $row["E_NAME"] . ';' . $row["E_SYMBOL"] . ';' . $row["CONCENTRATION_VALUE"] . ';' . $row["timestamp"]);


        array_push($sampol1, $row["E_NAME"]);
        array_push($sampol1, $row["E_SYMBOL"]);
        array_push($sampol1, $row["CONCENTRATION_VALUE"]);
        array_push($sampol1, $row["timestamp"]);
    }

    $time_updated = $sampol1[3];

    foreach ($sampol as $line) {
        # code...
        $ugachme[] = explode(';', trim($line));
    }


    mysqli_close($con);

}


$a_name = $area[$areaIndex];
$aqi_index = $sampol1[2];


if ($aqi_index < 26.0) {
    $aqi_status = "Good";
    $red = 10;
    $blue = 80;
    $green = 25;
    $h_synthesis = "";
}
if ($aqi_index > 25.0 || $aqi_index < 50.0) {
    $aqi_status = "Fair";
    $red = 200;
    $blue = 20;
    $green = 180;
    $h_synthesis = "";
}
if ($aqi_index > 49.0 || $aqi_index < 100.0) {
    $aqi_status = "Unhealthy for Sensitive Groups";
    $red = 200;
    $blue = 20;
    $green = 180;
    $h_synthesis = "People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.";
}
if ($aqi_index > 99.0 || $aqi_index < 251.0) {
    $aqi_status = "Very Unhealthy";
    $red = 250;
    $blue = 0;
    $green = 0;
    $h_synthesis = "People should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles and avoid sources of CO, such as heavy traffic. Smokers should refrain from smoking.";

}
if ($aqi_index > 250.0 || $aqi_index < 351.0) {
    $aqi_status = "Acutely Unhealthy";
    $red = 150;
    $blue = 150;
    $green = 0;
    $h_synthesis = "People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.";
}
if ($aqi_index > 350.0) {
    $aqi_status = "Emergency";
    $red = 120;
    $blue = 0;
    $green = 0;
    $h_synthesis = "Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed";
}
$prevalent_air_pollutant_symbol = $sampol1[1];
$prevalent_air_pollutant = $sampol1[0];


//------------------ GENERATING PDF -------------------------
class PDF extends FPDF
{

// Simple table
    function BasicTable($header, $sampol)
    {
        // Header
        $this->Cell(5);
        foreach ($header as $col) {
            $this->SetFont('helvetica', 'B', 10);

            $this->Cell(45, 7, $col, 1, 0, 'C');
        }
        $this->Ln();
        // Data
        foreach ($sampol as $row) {
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
        $this->Image('res/header.png', 10, 6, 190);
        $this->Image('res/Logo1.png', 10, 6, 32);
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(50);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(30, 10, 'AQMS Carmona History Report', 0, 0);
        // Arial bold 15
        // Move to the right

        $this->Cell(48);
        // Title
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        //$this->Cell(10);
        $this->Cell(30, 30, 'Generated on:' . ' ' . $g_time, 0, 0);
        // Line break
        $this->Ln(10);
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


// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle("AQMS Monitoring - Generated Report");

$pdf->Ln(6);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(70);
$pdf->Cell(0, 15, 'Area: ');
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(-105);
$pdf->Cell(0, 15, $a_name);
$pdf->Ln(8);

//AQI index

$pdf->SetFillColor($red, $green, $blue);
$pdf->SetTextColor(255, 255, 255);
$pdf->Rect(10, 30, 65, 44, 'F');

$pdf->Cell(6);

$pdf->SetFont('helvetica', 'B', 72);
$pdf->Cell(0, 25, $aqi_index);
$pdf->Cell(-120);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Status: ');
$pdf->Cell(-100);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(0, 10, $aqi_status);
$pdf->Ln(14);
$pdf->Cell(70);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, -6, 'Prevalent Pollutant: ');
$pdf->Cell(-71);
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(0, -6, $prevalent_air_pollutant . ' (' . $prevalent_air_pollutant_symbol . ')');
$pdf->Ln(15);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(70);
$pdf->Cell(0, -23, 'Last Updated: ');
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(-82);
$pdf->Cell(0, -23, $time_updated);
$pdf->Ln(18);
$pdf->Cell(20);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 32);
$pdf->Cell(0, -40, "ppm");
$pdf->Ln(-3);

//Details

//Table
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('helvetica', '', 14);
$pdf->BasicTable($header, $ugachme);
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 10, 'Synthesis:');
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, $h_synthesis);
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 10, 'Health Effects:');
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, $h_synthesis);
$pdf->Ln(8);


$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 30, 'Cautionary Statement:');
$pdf->Ln(20);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, $h_synthesis);


$pdf->Output();
header('Location: history.php');
?>

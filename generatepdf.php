<?php

require_once '/lib/fpdf.php';
require_once 'public/include/db_connect.php';


$areaIndex = 0;
$pollutantIndex = 0;
$prevalent_air_pollutant = "";
$sampol = array();
$sampol1 = array();
$igachu = array();
$ugachme = array();
$query = "";
$time_updated = "";

$area = array('Select an area', 'SLEX Carmona Exit, Carmona, Cavite', 'Bancal', 'SLEX Carmona Exit and Bancal Junction, Carmona, Cavite');
$pollutant = array('Select a pollutant', 'CO', 'All');
//$area = $_GET[$areaArray];
if(isset($_POST['btnGenerate'])){
  $areaIndex = $_POST['drpArea'];
  $pollutantIndex = $_POST['drpPollutant'];
  $loc = strtolower($area[$areaIndex]);
  if($pollutantIndex == 3){
    $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
              WHERE area_name = '$loc'
              ORDER BY CONCENTRATION_VALUE DESC";
  }else if($pollutantIndex == 1){
    $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
              FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
              WHERE area_name = '$loc' and MASTER.e_id = '$pollutantIndex'
              ORDER BY concentration_value DESC";
  }
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)){
    array_push($sampol, $row["E_NAME"].';'.$row["E_SYMBOL"].';'.$row["CONCENTRATION_VALUE"].';'. $row["timestamp"]);


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
if($aqi_index < 25){
  $h_synthesis = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. ";
}
else if($aqi_index > 25 || $aqi_index <50){
  $h_synthesis = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. ";
}
else{
  $h_synthesis = "People, should limit outdoor exertion.  People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible.  Unnecessary trips should be postponed. Motor vehicle use may be restricted.  Industrial activities may be curtailed.";

}
$prevalent_air_pollutant_symbol = $sampol1[1];
$prevalent_air_pollutant = $sampol1[0];
$aqi_status = "";
$year = "yyyy";
$month = "mm";
$day = "dd";
$red = 0;
$blue = 0;
$green = 130;


class PDF extends FPDF
{

// Simple table
function BasicTable($header, $sampol)
{
    // Header
    $this->Cell(5);
    foreach($header as $col){
      $this->SetFont('Times', 'B', 12);

        $this->Cell(45,7,$col,1,0,'C');
      }
    $this->Ln();
    // Data
    foreach($sampol as $row)
    {
      $this->Cell(5);
      $this->SetFont('Arial', '', 10);
        foreach($row as $col)
            $this->Cell(45,6,$col,1,0,'C');
        $this->Ln();

    }

}
// Page header
function Header()
{
    date_default_timezone_set("Asia/Manila");
    $g_time = date("l, m-d-Y G:i");
    // Logo
    $this->Image('res/header.png',10,6,190);
    $this->Image('res/Logo1.png',10,6,32);
    $this->SetFont('Arial', 'B', 18);
    $this->Cell(38);
    $this->SetTextColor(255,255,255);
    $this->Cell(30, 10, 'AQMS Carmona History Report',0,0);
    // Arial bold 15
    // Move to the right

    $this->Cell(48);
    // Title
    $this->SetFont('Arial', 'B', 8);
    $this->SetTextColor(255,255,255);
    $this->Cell(10);
    $this->Cell(30,20,'Generated on:'.' '.$g_time,0,0);
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(150);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

if($aqi_index<=25){
  $aqi_status = "Good";
  $red = 10;
  $blue = 80;
  $green = 25;
}
else if($aqi_index>=26 || $aqi_index<=51){
  $aqi_status = "Fair";
  $red = 200;
  $blue = 20;
  $green = 180;
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle("AQMS Monitoring - Generated Report");

$pdf->SetFont('Times','B',16);
$pdf->Cell(0,5, $a_name);
$pdf->Ln(20);

//AQI index

$pdf->SetFillColor($red,$green,$blue);
$pdf->SetTextColor(255,255,255);
$pdf->Rect( 10,  39,  65,  44 ,'F');

$pdf->Cell(20);

$pdf->SetFont('Times', 'B', 72);
$pdf->Cell(0,10, $aqi_index);
$pdf->Cell(-120);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times', 'B', 24);
$pdf->Cell(0,0, 'Status: '.$aqi_status);
$pdf->Ln();
$pdf->Cell(70);
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,20, 'Prevalent Pollutant: '.$prevalent_air_pollutant.' ('.$prevalent_air_pollutant_symbol.')');
$pdf->Ln(18);
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(70);
$pdf->Cell(0,5, 'Time Updated: '.$time_updated);
$pdf->Ln(18);
$pdf->Cell(20);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Times', '', 32);
$pdf->Cell(0,-30, "ppm");
$pdf->Ln(20);

//Details

//Table
$pdf->SetTextColor(0,0,0);
$header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->BasicTable($header,$ugachme);
$pdf->Ln(8);


$pdf->SetFont('Times','B',18);
$pdf->Cell(0,10, 'Synthesis');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$h_synthesis);


$pdf->Output();

  ?>

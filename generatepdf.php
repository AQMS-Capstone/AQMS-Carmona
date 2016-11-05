<?php

require '/lib/fpdf.php';



$a_name = "SLEX Carmona Exit, Carmona, Cavite";
$h_synthesis = "People, should limit outdoor exertion.  People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible.  Unnecessary trips should be postponed. Motor vehicle use may be restricted.  Industrial activities may be curtailed.";
$aqi_index = 30;
$prevalent_air_pollutant_symbol = "CO";
$prevalent_air_pollutant = "Carbon Monoxide";
$aqi_status = "";
$year = "yyyy";
$month = "mm";
$day = "dd";
$red = 0;
$blue = 0;
$green = 130;


class PDF extends FPDF
{

  function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header
    $this->Cell(5);
    foreach($header as $col){
      $this->SetFont('Times', 'B', 12);

        $this->Cell(45,7,$col,1,0,'C');
      }
    $this->Ln();
    // Data
    foreach($data as $row)
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
  $a_id = 0;
    // Logo
    $this->Image('res/header.png',10,6,190);
    $this->Image('res/Logo1.png',10,6,32);
    // Arial bold 15
    // Move to the right

    $this->Cell(165);
    // Title
    $this->SetFont('Arial', 'B', 10);
    $this->SetTextColor(255,255,255);
    $this->Cell(30,15,'Area ID:'.' '.$a_id,0,0);
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
  $red = 10;
  $blue = 25;
  $green = 80;
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

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
$pdf->Cell(22);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Times', '', 32);
$pdf->Cell(0,10, "ppm");
$pdf->Ln(20);

//Details

//Table
$pdf->SetTextColor(0,0,0);
$header = array('Element', 'Element Symbol', 'Concentration Value', 'Timestamp');
$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->BasicTable($header,$data);
$pdf->Ln(8);

$pdf->SetFont('Times','B',18);
$pdf->Cell(0,10, 'Health Effects');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$h_synthesis);
$pdf->Ln(5);


$pdf->SetFont('Times','B',18);
$pdf->Cell(0,10, 'Synthesis');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$h_synthesis);


$pdf->Output();

  ?>

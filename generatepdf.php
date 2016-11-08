<?php

require_once '/lib/fpdf.php';
require_once 'public/include/db_connect.php';


$areaIndex = 0;
$pollutantIndex = 0;
$column_ename = "";
$column_esym = "";
$column_cValue = 0.0;
$column_timestamp = "";
$number_of_rows = 0;
$area = array('Select an area', 'SLEX Carmona Exit, Carmona, Cavite', 'Bancal Junction, Carmona, Cavite', 'SLEX Carmona Exit and Bancal Junction, Carmona, Cavite');
$pollutant = array('Select a pollutant', 'CO', 'All');
//$area = $_GET[$areaArray];
if(isset($_POST['btnGenerate'])){
  $areaIndex = $_POST['drpArea'];
  $pollutantIndex = $_POST['drpPollutant'];

  $query = "SELECT e_name, e_symbol, concentration_value, timestamp
                FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                WHERE area_name = '$area[$areaIndex]' and MASTER.e_id = '$pollutantIndex' ORDER BY timestamp";

  $result =  mysqli_query($con,$query);

while($row = mysqli_fetch_assoc($result))
  {
    $e_name = $row["e_name"];
    $e_sym = substr($row["e_symbol"],0,20);
    $cValue = $row["concentration_value"];
    $timestamp = $row["timestamp"];


    $column_ename = $column_ename.$e_name."\n";
    $column_esym = $column_esym.$e_sym."\n";
    $column_cValue = $column_cValue.$cValue."\n";
    $column_timestamp = $column_timestamp.$timestamp."\n";

  }

  $sql = "SELECT count(1) FROM master";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);

  $number_of_rows = $row[0];
  mysqli_close($con);
}



$a_name = $area[$areaIndex];
$h_synthesis = "People, should limit outdoor exertion.  People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible.  Unnecessary trips should be postponed. Motor vehicle use may be restricted.  Industrial activities may be curtailed.";
$aqi_index = 30;
$prevalent_air_pollutant_symbol = "Element Symbol";
$prevalent_air_pollutant = "Element";
$aqi_status = "";
$year = "yyyy";
$month = "mm";
$day = "dd";
$red = 0;
$blue = 0;
$green = 130;

/*
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
    date_default_timezone_set("Asia/Manila");
    $g_time = date("l, m-d-Y G:i");
    // Logo
    $this->Image('res/header.png',10,6,190);
    $this->Image('res/Logo1.png',10,6,32);
    // Arial bold 15
    // Move to the right

    $this->Cell(118);
    // Title
    $this->SetFont('Arial', 'B', 10);
    $this->SetTextColor(255,255,255);
    $this->Cell(30,15,'Generated on:'.' '.$g_time,0,0);
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
}*/

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
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle("AQMS Monitoring - Generated Report");

$pdf->SetFont('Times','B',16);
$pdf->Cell(0,5, $a_name);
$pdf->Ln(20);

//Fields Name position
$Y_Fields_Name_position = 20;
//Table position, under Fields Name
$Y_Table_Position = 26;

//First create each Field Name
//Gray color filling each Field Name box
$pdf->SetFillColor(232,232,232);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',12);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(45);
$pdf->Cell(50,6,'ELEMENT',1,0,'C',1);
$pdf->SetX(95);
$pdf->Cell(20,6,'SYMBOL',1,0,'C',1);
$pdf->SetX(115);
$pdf->Cell(30,6,'CVALUE',1,0,'C',1);
$pdf->SetX(145);
$pdf->Cell(30,6,'TIMESTAMP',1,0,'C',1);
$pdf->Ln();

$pdf->SetFont('Arial','',12);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(50,6,$column_ename,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(95);
$pdf->MultiCell(20,6,$column_esym,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(115);
$pdf->MultiCell(30,6,$column_cValue,1,'R');
$pdf->SetY($Y_Table_Position);
$pdf->SetX(145);
$pdf->MultiCell(30,6,$column_timestamp,1,'R');

$i = 0;
$pdf->SetY($Y_Table_Position);
while ($i < $number_of_rows)
{
    $pdf->SetX(45);
    $pdf->MultiCell(120,6,'',1);
    $i = $i +1;
}

echo $number_of_rows;

//AQI index
/*
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
$header = array('Pollutant', 'Symbol', 'Averaged Values', 'Timestamp');
$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->BasicTable($header,$data);
$pdf->Ln(8);


$pdf->SetFont('Times','B',18);
$pdf->Cell(0,10, 'Synthesis');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$h_synthesis);*/


$pdf->Output();

  ?>

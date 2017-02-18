<?php


require_once 'include/db_connect.php';
require_once 'include/dbFunctions.php';

$areaIndex = 0;
$orderIndex = 0;
$dateTo = "";
$dateFrom = "";
$area = "";
$order = "";
$filterPollutant = 0;

$bancalData = array();
$slexData = array();
$bancalData1 = array();
$slexData1 = array();
$bancalDataSet = array();
$slexDataSet = array();

try {
    $areaIndex = $_POST['drpArea'];
    $dateFrom = $_POST['txtDateTimeFrom'];
    $dateTo = $_POST['txtDateTimeTo'];
    $filterPollutant = $_POST['drpPollutant'];
    $filename = "";

    switch($areaIndex){
        case 1:{
           $area = "slex";
            break;
        }
        case 2:{
            $area = "bancal";
            break;
        }
        case 3:{
            $area = "All";
            break;
        }
    }


    $gpdf = new GPDF();
    $filename = $dateFrom.'_to_'.$dateTo.'_AQI_History_Report'.'.pdf';

    list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants($area, $dateFrom, $dateTo, $filterPollutant);
    if(empty($bancalData) && empty($slexData))
    {
        echo "<script>
                alert('There are no data available to generate a report');
               </script>";
        echo "<script>window.close();</script>";
    }

    if(!empty($slexData) && empty($bancalData)){
        foreach ($slexData as $line) {
            # code...
            $slexDataSet[] = explode(';', trim($line));
        }
    }
    else if(empty($slexData) && !empty($bancalData)){
        foreach ($bancalData as $line) {
            # code...
            $bancalDataSet[] = explode(';', trim($line));
        }
    }
    else{
        foreach ($slexData as $line) {
            # code...
            $slexDataSet[] = explode(';', trim($line));
        }

        foreach ($bancalData as $line) {
            # code...
            $bancalDataSet[] = explode(';', trim($line));
        }
    }

    if(count($slexData1) != 0 && count($bancalData1) != 0) {
        if (strtotime($slexData1[0] > strtotime($bancalData1[0]))) {
            $time_updated = $slexData1[0];
        } else {
            $time_updated = $bancalData1[0];
        }

        $a_name = "SLEX and Bancal, Carmona, Cavite";

    }else if(count($slexData1) != 0 && count($bancalData1) == 0){
        $a_name = "SLEX, Carmona, Cavite";
        $time_updated = $slexData1[0];

    }else if(count($slexData1) == 0 && count($bancalData1) != 0){
        $a_name = "Bancal, Carmona, Cavite";
        $time_updated = $bancalData1[0];
    }

//------------------ GENERATING PDF -------------------------
    switch($filterPollutant){
        case 1:{
            CreateTableCO($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
            break;
        }
        case 2:{
            CreateTableSO2($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
            break;
        }
        case 3:{
            CreateTableNO2($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
            break;
        }
        case 4:{
            CreateTableAllPollutants($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
            break;
        }
    }


}
catch(Exception $e){
    die();
}

finally{
    //session_destroy();
    mysqli_close($con);
}

function CreateTableCO($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle("AQMS Monitoring - Generated Report");
    $pdf->Ln(-5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, 15, 'Area: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-178);
    $pdf->Cell(0, 15, $a_name);
    $pdf->Ln(8);

    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, -23, 'Last Updated: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-163);
    $pdf->Cell(0, -23, $time_updated);
    $pdf->Ln(1);

//Table

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableSO2($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle("AQMS Monitoring - Generated Report");
    $pdf->Ln(-5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, 15, 'Area: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-178);
    $pdf->Cell(0, 15, $a_name);
    $pdf->Ln(8);

    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, -23, 'Last Updated: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-163);
    $pdf->Cell(0, -23, $time_updated);
    $pdf->Ln(1);

//Table

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreatetableNO2($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle("AQMS Monitoring - Generated Report");
    $pdf->Ln(-5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, 15, 'Area: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-178);
    $pdf->Cell(0, 15, $a_name);
    $pdf->Ln(8);

    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, -23, 'Last Updated: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-163);
    $pdf->Cell(0, -23, $time_updated);
    $pdf->Ln(1);

//Table

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableAllPollutants($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle("AQMS Monitoring - Generated Report");
    $pdf->Ln(-5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, 15, 'Area: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-178);
    $pdf->Cell(0, 15, $a_name);
    $pdf->Ln(8);

    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, -23, 'Last Updated: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-163);
    $pdf->Cell(0, -23, $time_updated);
    $pdf->Ln(1);

//Table

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}
?>

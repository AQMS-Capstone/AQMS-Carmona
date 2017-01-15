<?php


require_once 'include/db_connect.php';
require_once 'include/dbFunctions.php';

$areaIndex = 0;
$pollutant = "";
$dateFrom = "";
$dateTo = "";
$prevalent_air_pollutant = "";
$prevalent_air_pollutant_symbol = "";
$aqi_status = "";
$aqi_index = 0;
$synthesis = "";
$health_Effects = "";
$c_Statement = "";
$time_updated = "";
$a_name = "";
$bancalData = array();
$slexData = array();
$bancalData1 = array();
$slexData1 = array();
$bancalDataSet = array();
$slexDataSet = array();

$filename = "";
$orderIndex = 0;
$order = "" ;

try {

    $area = array('Select an area', 'SLEX', 'Bancal', 'All');
    $pollutant = array('Select a pollutant', 'CO', 'SO2', 'NO2', 'O3', 'Pb', 'PM 10', 'TSP', 'All');
    //if (isset($_POST['btnGenerate'])) {
    /*
    $areaIndex = $_POST['drpArea'];
    $pollutantIndex = $_POST['drpPollutant'];
    $dateFrom = $_POST["txtDateTimeFrom"];
    $dateTo = $_POST["txtDateTimeTo"];
    */
    //session_start();

    $areaIndex = $_POST["drpArea"];;
    $pollutant = $_POST["drpPollutant"];
    $dateFrom = $_POST["txtDateTimeFrom"];
    $dateTo = $_POST["txtDateTimeTo"];
    $orderIndex = $_POST["drpOrder"];


    //echo $areaIndex;


    if($orderIndex <= 1){
        $order = 'timestamp';
    }else if($orderIndex == 2){
        $order = 'MASTER.e_id, timestamp';
    }else{
        $order = 'MASTER.concentration_value, timestamp';
    }
    $loc = strtolower($area[$areaIndex]);
    $gpdf = new GPDF();

    $filename = $dateFrom.'_to_'.$dateTo.'_AQI_History_Report'.'.pdf';
    if($areaIndex == 3) {
        if ($pollutant == 'All') {
            list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants("", "", $dateFrom, $dateTo, $order);

        } else {
            list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants("", $pollutant, $dateFrom, $dateTo, $order);
        }

    }
    else{
        if ($pollutant == 'All') {
            list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants($loc, "", $dateFrom, $dateTo, $order);
        } else {
            list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants($loc, $pollutant, $dateFrom, $dateTo, $order);
        }

        $a_name = $area[$areaIndex].' Carmona, Cavite';
    }

    if(empty($bancalData) && empty($slexData))
    {
        echo "<script>
                alert('There are no data available to generate a report');
                window.location.href='history.php';
               </script>";
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
        if (strtotime($slexData1[3] > strtotime($bancalData1[3]))) {
            $time_updated = $slexData1[3];
        } else {
            $time_updated = $bancalData1[3];
        }

        $a_name = "SLEX and Bancal, Carmona, Cavite";
        if ($slexData1[2] > $bancalData1[2]) {
            $prevalent_air_pollutant_symbol = $slexData1[1];
            $prevalent_air_pollutant = $slexData1[0];
            $aqi_index = $slexData1[2];
        } else {
            $prevalent_air_pollutant_symbol = $bancalData1[1];
            $prevalent_air_pollutant = $bancalData1[0];
            $aqi_index = $bancalData1[2];
        }
    }else if(count($slexData1) != 0 && count($bancalData1) == 0){
        $a_name = "SLEX, Carmona, Cavite";
        $time_updated = $slexData1[3];
        $prevalent_air_pollutant_symbol = $slexData1[1];
        $prevalent_air_pollutant = $slexData1[0];
        $aqi_index = $slexData1[2];

    }else if(count($slexData1) == 0 && count($bancalData1) != 0){
        $a_name = "Bancal, Carmona, Cavite";
        $time_updated = $bancalData1[3];
        $prevalent_air_pollutant_symbol = $bancalData1[1];
        $prevalent_air_pollutant = $bancalData1[0];
        $aqi_index = $bancalData1[2];
    }

    if ($aqi_index < 26.0) {
        $aqi_status = "Good";
        $c_Statement = "People with asthma are the group most at risk.";
        $health_Effects = "";
        $synthesis = "";
    }
    else if ($aqi_index > 25.0 && $aqi_index < 50.0) {
        $aqi_status = "Fair";
        $c_Statement = "Unusually sensitive people should consider limiting prolonged outdoor exertion";
        $health_Effects = "";
        $synthesis = "";
    }
    elseif ($aqi_index > 49.0 && $aqi_index < 100.0) {
        $aqi_status = "Unhealthy for Sensitive Groups";
        $c_Statement = "People should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.";
        $health_Effects = "";
        $synthesis = "";
    }
    elseif ($aqi_index > 99.0 && $aqi_index < 251.0) {
        $aqi_status = "Very Unhealthy";
        $c_Statement = "People should stay indoors and rest as much as possible. Unnecessary trips should be postponed. People should voluntarily restrict the use of vehicles and avoid sources of CO, such as heavy traffic. Smokers should refrain from smoking.";
        $health_Effects = "";
        $synthesis = "";

    }
    else if ($aqi_index > 250.0 && $aqi_index < 351.0) {
        $aqi_status = "Acutely Unhealthy";
        $c_Statement = "People, should limit outdoor exertion. People with heart or respiratory disease, such as asthma, should stay indoors and rest as much as possible. Unnecessary trips should be postponed. Motor vehicle use may be restricted. Industrial activities may be curtailed.";
        $health_Effects = "";
        $synthesis = "";
    }
    else  {
        $aqi_status = "Emergency";
        $c_Statement = "Everyone should remain indoors, (keeping windows and doors closed unless heat stress is possible). Motor vehicle use should be prohibited except for emergency situations. Industrial activities, except that which is vital for public safety and health, should be curtailed";
        $health_Effects = "";
        $synthesis = "";
    }



//------------------ GENERATING PDF -------------------------



// Instanciation of inherited class
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

//
    /*$pdf->Cell(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Status: ');
    $pdf->Cell(-175);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, $aqi_status);
    $pdf->Ln(14);
    $pdf->Cell(1);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, -6, 'Prevalent Pollutant: ');
    $pdf->Cell(-155);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, -6, $prevalent_air_pollutant . ' (' . $prevalent_air_pollutant_symbol . ')');*/
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(0, -23, 'Last Updated: ');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(-163);
    $pdf->Cell(0, -23, $time_updated);
    $pdf->Ln(1);

//Details

//Table

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }
    /*
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Synthesis:');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, $synthesis);
    $pdf->Ln(1);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Health Effects:');
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, $health_Effects);
    $pdf->Ln(1);


    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Cautionary Statement:');
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, $c_Statement);
    */

    $pdf->Output('I', $filename);

}
catch(Exception $e){
    die();
}

finally{
    //session_destroy();
    mysqli_close($con);
}
?>

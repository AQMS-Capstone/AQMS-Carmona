<?php

require_once 'lib/fpdf.php';
require_once 'public/include/db_connect.php';


$areaIndex = 0;
$pollutantIndex = 0;
$dateFrom = "";
$dateTo = "";
$prevalent_air_pollutant = "";
$prevalent_air_pollutant_symbol = "";
$aqi_status = "";
$aqi_index = 0;
$sampol = array();
$sampol1 = array();
$igachu = array();
$ugachme = array();
$query = "";
$synthesis = "";
$health_Effects = "";
$c_Statement = "";
$time_updated = "";
$a_name = "";
$query1 = "";
$bancalData = array();
$slexData = array();
$bancalData1 = array();
$slexData1 = array();
$bancalDataSet = array();
$slexDataSet = array();

$filename = "";
$orderIndex = 0;
$order = "";

try {

    $area = array('Select an area', 'SLEX', 'Bancal', 'All');
    $pollutant = array('Select a pollutant', 'CO', 'SO2', 'NO2', 'O3', 'Pb', 'PM10', 'TSP', 'All');
    //if (isset($_POST['btnGenerate'])) {
        /*
        $areaIndex = $_POST['drpArea'];
        $pollutantIndex = $_POST['drpPollutant'];
        $dateFrom = $_POST["txtDateTimeFrom"];
        $dateTo = $_POST["txtDateTimeTo"];
        */
        session_start();

        $areaIndex = $_SESSION["drpArea"];;
        $pollutantIndex = $_SESSION["drpPollutant"];
        $dateFrom = $_SESSION["txtDateTimeFrom"];
        $dateTo = $_SESSION["txtDateTimeTo"];
        $orderIndex = $_SESSION["drpOrder"];
        if($orderIndex <= 1){
            $order = 'timestamp';
        }else{
            $order = 'master.e_id';
        }
        $loc = strtolower($area[$areaIndex]);

        $filename = $dateFrom.'_to_'.$dateTo.'_AQI_History_Report'.'.pdf';
        if($areaIndex == 3) {
            if ($pollutantIndex == 7) {
                $query1 = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dateFrom') and DATE('$dateTo')
                          ORDER BY $order DESC";

                $result = mysqli_query($con, $query1);
                while ($row = mysqli_fetch_array($result)) {

                    if($row["AREA_NAME"] == "bancal"){
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


            } else {
                $query1 = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE MASTER.e_id ='$pollutantIndex' AND DATE(timestamp) BETWEEN DATE('$dateFrom') and DATE('$dateTo')
                          ORDER BY $order DESC";

                $result = mysqli_query($con, $query1);
                while ($row = mysqli_fetch_array($result)) {

                    if($row["AREA_NAME"] == "bancal"){
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


        }
        else{
            if ($pollutantIndex == 7) {
                $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$loc' and DATE(timestamp) BETWEEN DATE('$dateFrom') and DATE('$dateTo')
                          ORDER BY $order DESC";

            } else {
                $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$loc' and MASTER.e_id = '$pollutantIndex' and DATE(timestamp) BETWEEN DATE('$dateFrom') and DATE('$dateTo')
                          ORDER BY $order DESC";
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

            $a_name = $area[$areaIndex].' Carmona, Cavite';
            $aqi_index = $sampol1[2];
            $prevalent_air_pollutant_symbol = $sampol1[1];
            $prevalent_air_pollutant = $sampol1[0];
        }


    //}

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
//$data = $pdf->LoadData('countries.txt');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $slexDataSet);
        $pdf->Ln(2);
    }
    else {
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Pollutant', 'Symbol', 'Concentration Values', 'Timestamp');
//$data = $pdf->LoadData('countries.txt');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable($header, $ugachme);
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
    /*session_start();*/

    /*
    echo '<script language="javascript">';
    echo 'alert("Error")';
    echo '</script>';

    header("Location: history.php");
       */
    die();

}

finally{
    session_destroy();
    mysqli_close($con);
}
?>

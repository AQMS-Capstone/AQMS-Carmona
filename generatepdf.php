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

    //VONN ADDED THIS
    $reportType = $_POST['drpType'];

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

    if($reportType == "1"){
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
    else if($reportType == "2"){
        if($filterPollutant == "4"){
            list($coData_bancal, $so2Data_bancal, $no2Data_bancal, $coData_slex, $so2Data_slex, $no2Data_slex, $timestamp) = $gpdf->GetPollutants_AQI_ALL($area, $dateFrom, $dateTo, $filterPollutant);

            $coDataSet_bancal[] = array();
            $so2DataSet_bancal[] = array();
            $no2DataSet_bancal[] = array();

            $coDataSet_slex[] = array();
            $so2DataSet_slex[] = array();
            $no2DataSet_slex[] = array();

            if(empty($coData_bancal) && empty($coData_bancal) && empty($no2Data_bancal) && empty($coData_slex) && empty($coData_slex) && empty($no2Data_slex)){
                echo "<script>
                alert('There are no data available to generate a report');
               </script>";
                echo "<script>window.close();</script>";
            }

            if(!empty($coData_bancal)){
                foreach ($coData_bancal as $line) {
                    $coDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($so2Data_bancal)){
                foreach ($so2Data_bancal as $line) {
                    $so2DataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($no2Data_bancal)){
                foreach ($no2Data_bancal as $line) {
                    $no2DataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($coData_slex)){
                foreach ($coData_slex as $line) {
                    $coDataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($so2Data_slex)){
                foreach ($so2Data_slex as $line) {
                    $so2DataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($no2Data_slex)){
                foreach ($no2Data_slex as $line) {
                    $no2DataSet_slex[] = explode(';', trim($line));
                }
            }

            $a_name = "SLEX and Bancal, Carmona, Cavite";
            $time_updated = $timestamp;

            //------------------ GENERATING PDF -------------------------

            CreateTableAllPollutants_AQI($a_name, $time_updated, $coDataSet_bancal, $so2DataSet_bancal, $no2DataSet_bancal, $coDataSet_slex, $so2DataSet_slex, $no2DataSet_slex, $filename);
        }
        else{
            list($bancalData, $slexData, $bancalData1, $slexData1) = $gpdf->GetPollutants_AQI($area, $dateFrom, $dateTo, $filterPollutant);

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
                    CreateTableCO_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
                    break;
                }
                case 2:{
                    CreateTableSO2_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
                    break;
                }
                case 3:{
                    CreateTableNO2_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
                    break;
                }
                case 4:{
                    //CreateTableAllPollutants($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
                    break;
                }
            }
        }
    }
    else{
        if($filterPollutant == "4"){
            list($coData_bancal, $so2Data_bancal, $no2Data_bancal, $coData_slex, $so2Data_slex, $no2Data_slex, $timestamp, $summary_bancal, $summary_slex, $highest_bancal, $highest_slex) = $gpdf->GetPollutants_ambient_ALL($area, $dateFrom, $dateTo, $filterPollutant);

            $coDataSet_bancal = array();
            $so2DataSet_bancal = array();
            $no2DataSet_bancal = array();
            $summaryDataSet_bancal = array();
            $highestDataSet_bancal = array();

            $coDataSet_slex = array();
            $so2DataSet_slex = array();
            $no2DataSet_slex = array();
            $summaryDataSet_slex = array();
            $highestDataSet_slex = array();
            
            if(empty($coData_bancal) && empty($coData_bancal) && empty($no2Data_bancal) && empty($coData_slex) && empty($coData_slex) && empty($no2Data_slex)){
                echo "<script>
                alert('There are no data available to generate a report');
               </script>";
                echo "<script>window.close();</script>";
            }

            if(!empty($coData_bancal)){
                foreach ($coData_bancal as $line) {
                    $coDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($so2Data_bancal)){
                foreach ($so2Data_bancal as $line) {
                    $so2DataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($no2Data_bancal)){
                foreach ($no2Data_bancal as $line) {
                    $no2DataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($coData_slex)){
                foreach ($coData_slex as $line) {
                    $coDataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($so2Data_slex)){
                foreach ($so2Data_slex as $line) {
                    $so2DataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($no2Data_slex)){
                foreach ($no2Data_slex as $line) {
                    $no2DataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($summary_bancal)){
                foreach ($summary_bancal as $line) {
                    $summaryDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($summary_slex)){
                foreach ($summary_slex as $line) {
                    $summaryDataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($highest_bancal)){
                foreach ($highest_bancal as $line) {
                    $highestDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($highest_slex)){
                foreach ($highest_slex as $line) {
                    $highestDataSet_slex[] = explode(';', trim($line));
                }
            }

            $a_name = "";
            switch($areaIndex){
                case 1:{
                    $a_name = "SLEX Carmona";
                    break;
                }
                case 2:{
                    $a_name = "Bancal Junction";
                    break;
                }
                case 3:{
                    $a_name = "SLEX Carmona and Bancal Junction";
                    break;
                }
            }
            
            $time_updated = $timestamp;

            //------------------ GENERATING PDF -------------------------

            CreateTableAllPollutants_ambient($a_name, $time_updated, $coDataSet_bancal, $so2DataSet_bancal, $no2DataSet_bancal, $coDataSet_slex, $so2DataSet_slex, $no2DataSet_slex, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex);
        }
        else{
            list($bancalData, $slexData, $bancalData1, $slexData1, $summary_bancal, $summary_slex, $highest_bancal, $highest_slex) = $gpdf->GetPollutants_ambient($area, $dateFrom, $dateTo, $filterPollutant);

            $summaryDataSet_slex = array();
            $highestDataSet_slex = array();

            $summaryDataSet_bancal = array();
            $highestDataSet_bancal = array();

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

            if(!empty($summary_bancal)){
                foreach ($summary_bancal as $line) {
                    $summaryDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($summary_slex)){
                foreach ($summary_slex as $line) {
                    $summaryDataSet_slex[] = explode(';', trim($line));
                }
            }

            if(!empty($highest_bancal)){
                foreach ($highest_bancal as $line) {
                    $highestDataSet_bancal[] = explode(';', trim($line));
                }
            }

            if(!empty($highest_slex)){
                foreach ($highest_slex as $line) {
                    $highestDataSet_slex[] = explode(';', trim($line));
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
                    CreateTableCO_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex);
                    break;
                }
                case 2:{
                    CreateTableSO2_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex);
                    break;
                }
                case 3:{
                    CreateTableNO2_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex);
                    break;
                }
                case 4:{
                    //CreateTableAllPollutants($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename);
                    break;
                }
            }
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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

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

function CreateTableNO2($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

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

// AQI HERE

function CreateTableCO_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableSO2_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableNO2_AQI($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename){
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
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableAllPollutants_AQI($a_name, $time_updated, $coDataSet_bancal, $so2DataSet_bancal, $no2DataSet_bancal, $coDataSet_slex, $so2DataSet_slex, $no2DataSet_slex, $filename){
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

    if(!empty($coDataSet_bancal) || !empty($so2DataSet_bancal) || !empty($no2DataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, -5, 'Bancal Junction');
        $pdf->Ln(1);
    }

    if(!empty($coDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $coDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($so2DataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $so2DataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($no2DataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $no2DataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($coDataSet_slex) || !empty($so2DataSet_slex) || !empty($no2DataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);
    }

    if(!empty($coDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Hourly ppm)', 'CO (Avg 8hr ppm)', 'CO (AQI)', 'CO (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $coDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($so2DataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (AQI)', 'SO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $so2DataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($no2DataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 1hr ppm)', 'NO2 (AQI)', 'NO2 (Category)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $no2DataSet_slex);
        $pdf->Ln(2);
    }


//    if(!empty($bancalData) && !empty($slexData)){
//
//        $pdf->SetFont('helvetica', 'B', 10);
//        $pdf->Cell(0, 10, 'Bancal Junction');
//        $pdf->Ln(8);
//
//        $pdf->SetTextColor(0, 0, 0);
//        $pdf->SetFont('helvetica', 'B', 10);
//        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
//        $pdf->SetFont('helvetica', '', 10);
//        $pdf->BasicTable($header, $bancalDataSet);
//        $pdf->Ln(2);
//
//
//        $pdf->SetFont('helvetica', 'B', 10);
//        $pdf->Cell(0, 10, 'SLEX Carmona');
//        $pdf->Ln(8);
//
//        $pdf->SetTextColor(0, 0, 0);
//        $pdf->SetFont('helvetica', 'B', 10);
//        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
//        $pdf->SetFont('helvetica', '', 10);
//        $pdf->BasicTable($header, $slexDataSet);
//        $pdf->Ln(2);
//    }else if(!empty($bancalData) && empty($slexData)){
//        $pdf->SetTextColor(0, 0, 0);
//        $pdf->SetFont('helvetica', 'B', 10);
//        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
//        $pdf->SetFont('helvetica', '', 10);
//        $pdf->BasicTable($header, $bancalDataSet);
//        $pdf->Ln(2);
//    }
//    else if(empty($bancalData) && !empty($slexData)){
//        $pdf->SetTextColor(0, 0, 0);
//        $pdf->SetFont('helvetica', 'B', 10);
//        $header = array('Timestamp', 'CO (ppm)', 'SO2 (ppm)', 'NO2 (ppm)');
//        $pdf->SetFont('helvetica', '', 10);
//        $pdf->BasicTable($header, $slexDataSet);
//        $pdf->Ln(2);
//    }

    $pdf->Output('I', $filename);
}

function CreateTableCO_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex){
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

    if(!empty($summaryDataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, -5, 'Bancal Summary');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($summaryDataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'SLEX Carmona Summary');
        $pdf->Ln(6);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableSO2_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex){
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

    if(!empty($summaryDataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, -5, 'Bancal Summary');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'SO2 (24 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($summaryDataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'SLEX Carmona Summary');
        $pdf->Ln(6);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'SO2 (24 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableNO2_ambient($a_name, $time_updated, $bancalData, $slexData, $bancalDataSet, $slexDataSet, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex){
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

    if(!empty($summaryDataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, -5, 'Bancal Summary');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($summaryDataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'SLEX Carmona Summary');
        $pdf->Ln(6);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $summaryDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($bancalData) && !empty($slexData)){

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $bancalDataSet);
        $pdf->Ln(2);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $slexDataSet);
        $pdf->Ln(2);
    }else if(!empty($bancalData) && empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $bancalDataSet);
        $pdf->Ln(2);
    }
    else if(empty($bancalData) && !empty($slexData)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $slexDataSet);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}

function CreateTableAllPollutants_ambient($a_name, $time_updated, $coDataSet_bancal, $so2DataSet_bancal, $no2DataSet_bancal, $coDataSet_slex, $so2DataSet_slex, $no2DataSet_slex, $filename, $summaryDataSet_bancal, $summaryDataSet_slex, $highestDataSet_bancal, $highestDataSet_slex){
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

    if(!empty($summaryDataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, -5, 'Bancal Summary');
        $pdf->Ln(1);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)', 'SO2 (24 hr)', 'NO2 (24 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $summaryDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($summaryDataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'SLEX Carmona Summary');
        $pdf->Ln(6);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Frequency', 'CO (1 hr)', 'CO (8 hr)', 'SO2 (24 hr)', 'NO2 (24 hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $summaryDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($highestDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Highest per element', 'Timestamp', 'Value', 'Evaluation');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $highestDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($coDataSet_bancal) || !empty($so2DataSet_bancal) || !empty($no2DataSet_bancal)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Bancal Junction');
        $pdf->Ln(8);
    }

    if(!empty($coDataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $coDataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($so2DataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $so2DataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($no2DataSet_bancal)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $no2DataSet_bancal);
        $pdf->Ln(2);
    }

    if(!empty($coDataSet_slex) || !empty($so2DataSet_slex) || !empty($no2DataSet_slex)){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'SLEX Carmona');
        $pdf->Ln(8);
    }

    if(!empty($coDataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'CO (Avg 1hr ppm)', 'CO (Evaluation 1hr)', 'CO (Avg 8hr ppm)', 'CO (Evaluation 8hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_AQI($header, $coDataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($so2DataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'SO2 (Hourly ppm)', 'SO2 (Avg 24hr ppm)', 'SO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $so2DataSet_slex);
        $pdf->Ln(2);
    }

    if(!empty($no2DataSet_slex)){
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $header = array('Timestamp', 'NO2 (Hourly ppm)', 'NO2 (Avg 24hr ppm)', 'NO2 (Evaluation 24hr)');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->BasicTable_ambient($header, $no2DataSet_slex);
        $pdf->Ln(2);
    }

    $pdf->Output('I', $filename);
}
?>

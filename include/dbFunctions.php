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

    function BasicTable_AQI($header, $data)
    {
        // Header
        $this->Cell(5);
        foreach ($header as $col) {
            $this->SetFont('helvetica', 'B', 10);

            $this->Cell(36, 7, $col, 1, 0, 'C');
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell(5);
            $this->SetFont('helvetica', '', 10);
            foreach ($row as $col)
                $this->Cell(36, 6, $col, 1, 0, 'C');
            $this->Ln();

        }

    }

    function BasicTable_ambient($header, $data)
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

class Master_AQI{

    var $area_name = "";
    var $timestamp = "";
    var $co = "";
    var $so2 = "";
    var $no2 = "";

    function Master_AQI(){}
}

class Master_AQI_2{

    var $area_name = "";
    var $timestamp = "";
    var $concentration_value = "";

    function Master_AQI_2(){}
}

class AreaFunction_AQI{
    var $co_holder = array();
    var $so2_holder = array();
    var $no2_holder = array();
}

class GPDF{

    function GetPollutants($a_name, $dFrom, $dTo, $filterPollutant){

        include('include/db_connect.php');

        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        if($a_name == "All"){
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants($query);
                    break;
                }
            }

        }
        else{
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);

                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants($query);
                    break;
                }
            }
        }


        $query->close();
        $con->close();
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

    function GetPollutants_AQI($a_name, $dFrom, $dTo, $filterPollutant){

        include('include/db_connect.php');

        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        if($a_name == "All"){
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant_AQI($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant_AQI($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant_AQI($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants_AQI($query);
                    break;
                }
            }

        }
        else{
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant_AQI($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant_AQI($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant_AQI($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);

                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants_AQI($query);
                    break;
                }
            }
        }


        $query->close();
        $con->close();
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

    function GetPollutants_ambient($a_name, $dFrom, $dTo, $filterPollutant){

        include('include/db_connect.php');

        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        if($a_name == "All"){
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant_ambient($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant_ambient($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant_ambient($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("ss", $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants_ambient($query);
                    break;
                }
            }

        }
        else{
            switch($filterPollutant){
                case 1:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, CO FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreCOPollutant_ambient($query);
                    break;
                }
                case 2:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, SO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreSO2Pollutant_ambient($query);
                    break;
                }
                case 3:{
                    $query = $con->prepare("SELECT AREA_NAME, TIMESTAMP, NO2 FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);
                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreNO2Pollutant_ambient($query);
                    break;
                }
                case 4:{
                    $query = $con->prepare("SELECT * FROM MASTER
                          WHERE AREA_NAME = ? AND DATE(timestamp) BETWEEN DATE(?) and DATE(?)
                          ORDER BY TIMESTAMP DESC");
                    $query->bind_param("sss", $a_name, $dFrom, $dTo);

                    list($bancalData, $slexData, $bancalData1, $slexData1) = $this->StoreAllPollutants_ambient($query);
                    break;
                }
            }
        }


        $query->close();
        $con->close();
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

    function StoreCOPollutant($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $CO);
        $result = $query;
        while ($result->fetch()) {

            if($area_name == "bancal"){
                array_push($bancalData, $timestamp . ';' . $CO);

                array_push($bancalData1, $timestamp);
                array_push($bancalData1, $CO);

            }
            else{
                array_push($slexData, $timestamp . ';' . $CO);

                array_push($slexData1,$timestamp);
                array_push($slexData1, $CO);

            }
        }

        $result->free_result();
        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreSO2Pollutant($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name,$timestamp, $SO2);
        $result = $query;
        while ($result->fetch()) {

            if($area_name == "bancal"){
                array_push($bancalData, $timestamp .  ';' . $SO2);

                array_push($bancalData1, $timestamp);
                array_push($bancalData1, $SO2);

            }
            else{
                array_push($slexData, $timestamp .  ';' . $SO2);

                array_push($slexData1,$timestamp);
                array_push($slexData1, $SO2);

            }

        }

        $result->free_result();
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

    function StoreNO2Pollutant($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $NO2);
        $result = $query;
        while ($result->fetch()) {

            if($area_name == "bancal"){
                array_push($bancalData, $timestamp . ';' .  $NO2);

                array_push($bancalData1, $timestamp);
                array_push($bancalData1, $NO2);

            }
            else{
                array_push($slexData, $timestamp . ';' .  $NO2);

                array_push($slexData1,$timestamp);
                array_push($slexData1, $NO2);

            }

        }

        $result->free_result();
        return [$bancalData, $slexData, $bancalData1, $slexData1];

    }

    function StoreAllPollutants($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $CO, $SO2, $NO2, $timestamp);
        $result = $query;
        while ($result->fetch()) {

            if($area_name == "bancal"){
                array_push($bancalData, $timestamp . ';' . $CO . ';' . $SO2 . ';' .  $NO2);

                array_push($bancalData1, $timestamp);
                array_push($bancalData1, $CO);
                array_push($bancalData1, $SO2);
                array_push($bancalData1, $NO2);

            }
            else{
                array_push($slexData, $timestamp . ';' . $CO . ';' . $SO2 . ';' .  $NO2);

                array_push($slexData1,$timestamp);
                array_push($slexData1, $CO);
                array_push($slexData1, $SO2);
                array_push($slexData1, $NO2);

            }

        }

        $result->free_result();
        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    // AQI HERE

    //$this->floorDec_AQI($array_holder[$i]->concentration_value, $precision = 1)
    //$array_holder[$i]->concentration_value

    function StoreCOPollutant_AQI($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $CO);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass_co = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass_co->area_name = "bancal";
                $dataClass_co->timestamp = $timestamp;
                $dataClass_co->concentration_value = $CO;

                array_push($element_holder_bancal->co_holder, $dataClass_co);
            }
            else{
                $dataClass_co->area_name = "slex";
                $dataClass_co->timestamp = $timestamp;
                $dataClass_co->concentration_value = $CO;

                array_push($element_holder_slex->co_holder, $dataClass_co);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->co_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->co_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->co_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->co_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(8, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 8);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $co_max){
                $aqi = "400+";
            }else{
                $aqi = $this->calculateAQI_AQI($co_guideline_values, $cv, $co_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = 1);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = 1) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(8, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 8);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $co_max){
                $aqi = "400+";
            }else{
                $aqi = $this->calculateAQI_AQI($co_guideline_values, $cv, $co_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = 1);
            }

            array_push($slexData, $array_holder_slex[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_slex[$i]->concentration_value, $precision = 1) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);
        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreSO2Pollutant_AQI($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $SO2);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass->area_name = "bancal";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $SO2;

                array_push($element_holder_bancal->so2_holder, $dataClass);
            }
            else{
                $dataClass->area_name = "slex";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $SO2;

                array_push($element_holder_slex->so2_holder, $dataClass);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->so2_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->so2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->so2_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->so2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 24);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $sulfur_max){
                $aqi = "400+";
            }else{
                $aqi = $this->calculateAQI_AQI($sufur_guideline_values, $cv, $sulfur_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $sulfur_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = $sulfur_precision) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 24);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $sulfur_max){
                $aqi = "400+";
            }else{
                $aqi = $this->calculateAQI_AQI($sufur_guideline_values, $cv, $sulfur_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $sulfur_precision);
            }

            array_push($slexData, $array_holder_slex[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_slex[$i]->concentration_value, $precision = $sulfur_precision) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);
        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreNO2Pollutant_AQI($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $NO2);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass->area_name = "bancal";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $NO2;

                array_push($element_holder_bancal->no2_holder, $dataClass);
            }
            else{
                $dataClass->area_name = "slex";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $NO2;

                array_push($element_holder_slex->no2_holder, $dataClass);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->no2_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->no2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->no2_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->no2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(1, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 1);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $no2_max){
                $aqi = "400+";
            }else if($cv < 0.65){
                $aqi = "201-";
            }else{
                $aqi = $this->calculateAQI_AQI($no2_guideline_values, $cv, $no2_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $no2_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = $no2_precision) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(1, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 1);

            if($cv == -1){
                $aqi = "-";
            }else if($cv > $no2_max){
                $aqi = "400+";
            }else if($cv < 0.65){
                $aqi = "201-";
            }else{
                $aqi = $this->calculateAQI_AQI($no2_guideline_values, $cv, $no2_precision, $guideline_aqi_values);
            }

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $no2_precision);
            }

            array_push($slexData, $array_holder_slex[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_slex[$i]->concentration_value, $precision = $no2_precision) . ';' . $cv . ';' . $aqi . ';' . $this->determineAQICategory($aqi));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);
        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreAllPollutants_AQI($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $CO, $SO2, $NO2, $timestamp);
        $result = $query;
        while ($result->fetch()) {

            if($area_name == "bancal"){
                array_push($bancalData, $timestamp . ';' . $CO . ';' . $SO2 . ';' .  $NO2);

                array_push($bancalData1, $timestamp);
                array_push($bancalData1, $CO);
                array_push($bancalData1, $SO2);
                array_push($bancalData1, $NO2);

            }
            else{
                array_push($slexData, $timestamp . ';' . $CO . ';' . $SO2 . ';' .  $NO2);

                array_push($slexData1,$timestamp);
                array_push($slexData1, $CO);
                array_push($slexData1, $SO2);
                array_push($slexData1, $NO2);

            }

        }

        $result->free_result();
        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function CalculateAveraging_AQI($element){
        date_default_timezone_set('Asia/Manila');

        $return_holder = array();

        if(count($element) > 0) {

            $date = date("Y-m-d H:i:s", strtotime($element[0]->timestamp));

            if(strtotime($date) < strtotime(date("Y-m-d H", strtotime($element[0]->timestamp)).":01:00")){
                $ctr_timestamp_begin = date("Y-m-d H", strtotime($date) - 3600) . ":01:00";
                $ctr_timestamp_end = date("Y-m-d H", strtotime($date)) . ":00:00";
            }else{

                $ctr_timestamp_begin = date("Y-m-d H", strtotime($date)) . ":01:00";
                $ctr_timestamp_end = date("Y-m-d H", strtotime($date) + 3600) . ":00:00";
            }

            $ave = 0;
            $ctr = 0;

            for ($i = 0; $i < count($element); $i++) {
                $date = $element[$i]->timestamp;

                if(strtotime($date) <= strtotime($ctr_timestamp_end) && strtotime($date) >= strtotime($ctr_timestamp_begin)){
                    $ave += $element[$i]->concentration_value;
                    $ctr++;
                }
                else{
                    if($ctr > 0){
                        $ave = $ave / $ctr;
                        $dateString = $ctr_timestamp_end;
                        array_push($return_holder, $this->AssignDataElements_AQI($element[$i]->area_name, $ave, $dateString));

                        $ave = 0;
                        $ctr = 0;

                        $ave += $element[$i]->concentration_value;
                        $ctr++;

                        $date = date("Y-m-d H:i:s", strtotime($element[$i]->timestamp));

                        if(strtotime($date) < strtotime(date("Y-m-d H", strtotime($date)).":01:00")){
                            $ctr_timestamp_begin = date("Y-m-d H", strtotime($date) - 3600) . ":01:00";
                            $ctr_timestamp_end = date("Y-m-d H", strtotime($date)) . ":00:00";
                        }else {
                            $ctr_timestamp_begin = date("Y-m-d H", strtotime($date)) . ":01:00";
                            $ctr_timestamp_end = date("Y-m-d H", strtotime($date) + 3600) . ":00:00";
                        }
                    }
                }

                if($i == count($element) - 1){
                    if(strtotime($date) <= strtotime($ctr_timestamp_end) && strtotime($date) >= strtotime($ctr_timestamp_begin)){
                        $ave = $ave / $ctr;
                        $dateString = $ctr_timestamp_end;
                        array_push($return_holder, $this->AssignDataElements_AQI($element[$i]->area_name, $ave, $dateString));
                    }
                }
            }
        }

        return $return_holder;
    }

    function Averaging_AQI($data, $dates, $hour)
    {
        $ave = 0;
        $ctr = 0;

        for($i = 0; $i < count($data); $i++){
            if(in_array($data[$i]->timestamp, $dates)){
                $ave += $data[$i]->concentration_value;
                $ctr ++;
            }
        }

        if($ctr >= (0.75 * $hour)){
            return $ave / $ctr;
        }else{
            return -1;
        }
    }

    function GetRollingDates_AQI($limiter, $date)
    {
        $dates = array();
        $ctr = 0;

        date_default_timezone_set('Asia/Manila');

        for($i = 0; $i < $limiter; $i++){
            $date_beginning = date("Y-m-d H",strtotime($date) - $ctr).":00:00";
            $ctr += 3600;

            array_push($dates, $date_beginning);
        }
        return $dates;
    }

    function AssignDataElements_AQI($area_name, $ave, $date){
        $dataClass = new Master_AQI_2();

        $dataClass->area_name = $area_name;
        $dataClass->concentration_value = $ave;
        $dataClass->timestamp = $date;

        return $dataClass;
    }

    function floorDec_AQI($val, $precision = 2) {
        if ($precision < 0) { $precision = 0; }
        $numPointPosition = intval(strpos($val, '.'));
        if ($numPointPosition === 0) { //$val is an integer
            return $val;
        }
        return floatval(substr($val, 0, $numPointPosition + $precision + 1));
    }

    function determineAQICategory($aqi){
        if($aqi == "-"){
            return "-";
        }else if($aqi == "400+"){
            return "Emergency";
        }else if($aqi == "201-"){
            return "Good";
        }else if($aqi >= 0 && $aqi <= 50){
            return "Good";
        }else if($aqi >= 51 && $aqi <= 100)
        {
            return "Fair";
        }else if($aqi >= 101 && $aqi <= 150)
        {
            return "Unhealthy for Sensitive Groups";
        }else if($aqi >= 151 && $aqi <= 200)
        {
            return "Very Unhealthy";
        }else if($aqi >= 201 && $aqi <= 300)
        {
            return "Acutely Unhealthy";
        }else if($aqi >= 301)
        {
            return "Emergency";
        }else{
            return "-";
        }
    }

    function calculateAQI_AQI($gv, $ave, $prec, $aqi_val)
    {
        $aqi = "-";

        require 'include/guidelines.php';

        for($x = 0; $x < count($gv); $x++)
        {
            $roundedValue = $this->floorDec_AQI($ave, $precision = $prec);

            if($roundedValue >= $gv[$x][0] && $roundedValue <= $gv[$x][1])
            {
                $aqi = (($aqi_val[$x][1] - $aqi_val[$x][0])/($gv[$x][1] - $gv[$x][0])) * ($roundedValue - $gv[$x][0]) + $aqi_val[$x][0];
                $aqi = round($aqi);
                break;
            }

            else if($x == count($gv) - 1)
            {
                $aqi = "-";
            }
        }

        return $aqi;
    }

    // NAAQGV

    function StoreCOPollutant_ambient($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $CO);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass_co = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass_co->area_name = "bancal";
                $dataClass_co->timestamp = $timestamp;
                $dataClass_co->concentration_value = $CO;

                array_push($element_holder_bancal->co_holder, $dataClass_co);
            }
            else{
                $dataClass_co->area_name = "slex";
                $dataClass_co->timestamp = $timestamp;
                $dataClass_co->concentration_value = $CO;

                array_push($element_holder_slex->co_holder, $dataClass_co);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->co_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->co_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->co_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->co_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(1, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 1);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $co_precision);
            }

            $dates_2 = $this->GetRollingDates_AQI(8, $array_holder_bancal[$i]->timestamp);
            $cv_2 = $this->Averaging_AQI($array_holder_bancal, $dates_2, 8);

            if($cv_2 == -1){
                $cv_2 = "-";
            }else{
                $cv_2 = $this->floorDec_AQI($cv_2, $precision = $co_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 0) . ';' . $cv_2 . ';' . $this->determineEvaluation_ambient($cv_2, 1));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(1, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 1);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $co_precision);
            }

            $dates_2 = $this->GetRollingDates_AQI(8, $array_holder_slex[$i]->timestamp);
            $cv_2 = $this->Averaging_AQI($array_holder_slex, $dates_2, 8);

            if($cv_2 == -1){
                $cv_2 = "-";
            }else{
                $cv_2 = $this->floorDec_AQI($cv_2, $precision = $co_precision);
            }

            array_push($slexData, $array_holder_slex[$i]->timestamp . ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 0) . ';' . $cv_2 . ';' . $this->determineEvaluation_ambient($cv_2, 1));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);

        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreSO2Pollutant_ambient($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $SO2);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass->area_name = "bancal";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $SO2;

                array_push($element_holder_bancal->so2_holder, $dataClass);
            }
            else{
                $dataClass->area_name = "slex";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $SO2;

                array_push($element_holder_slex->so2_holder, $dataClass);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->so2_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->so2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->so2_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->so2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 24);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $sulfur_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = $sulfur_precision). ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 2));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 24);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $sulfur_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = $sulfur_precision). ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 2));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);
        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function StoreNO2Pollutant_ambient($query){
        $bancalData = array();
        $slexData = array();
        $bancalData1 = array();
        $slexData1 = array();

        $query->execute();
        $query->store_result();
        $query->bind_result($area_name, $timestamp, $NO2);
        $result = $query;

        $element_holder_bancal = new AreaFunction_AQI();
        $element_holder_slex = new AreaFunction_AQI();

        while ($result->fetch()) {
            $dataClass = new Master_AQI_2();

            if($area_name == "bancal"){
                $dataClass->area_name = "bancal";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $NO2;

                array_push($element_holder_bancal->no2_holder, $dataClass);
            }
            else{
                $dataClass->area_name = "slex";
                $dataClass->timestamp = $timestamp;
                $dataClass->concentration_value = $NO2;

                array_push($element_holder_slex->no2_holder, $dataClass);
            }
        }

        $result->free_result();

        $array_holder_bancal = array();
        $array_holder_slex = array();

        if(count($element_holder_bancal->no2_holder) > 0){
            $data_holder = $this->CalculateAveraging_AQI($element_holder_bancal->no2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_bancal, $data_holder[$i]);
            }
        }

        if(count($element_holder_slex->no2_holder) > 0){
            $data_holder =  $this->CalculateAveraging_AQI($element_holder_slex->no2_holder);
            for($i = 0 ; $i < count($data_holder); $i++){
                array_push($array_holder_slex, $data_holder[$i]);
            }
        }

        require 'include/guidelines.php';

        for($i = 0 ; $i < count($array_holder_bancal); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_bancal[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_bancal, $dates, 24);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $no2_precision);
            }

            array_push($bancalData, $array_holder_bancal[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_bancal[$i]->concentration_value, $precision = $no2_precision) . ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 3));

            array_push($bancalData1, $array_holder_bancal[$i]->timestamp);
            array_push($bancalData1, $array_holder_bancal[$i]->concentration_value);
        }

        for($i = 0 ; $i < count($array_holder_slex); $i++){
            $dates = $this->GetRollingDates_AQI(24, $array_holder_slex[$i]->timestamp);
            $cv = $this->Averaging_AQI($array_holder_slex, $dates, 24);

            if($cv == -1){
                $cv = "-";
            }else{
                $cv = $this->floorDec_AQI($cv, $precision = $no2_precision);
            }

            array_push($slexData, $array_holder_slex[$i]->timestamp . ';' . $this->floorDec_AQI($array_holder_slex[$i]->concentration_value, $precision = $no2_precision) . ';' . $cv . ';' . $this->determineEvaluation_ambient($cv, 3));

            array_push($slexData1, $array_holder_slex[$i]->timestamp);
            array_push($slexData1, $array_holder_slex[$i]->concentration_value);
        }

        return [$bancalData, $slexData, $bancalData1, $slexData1];
    }

    function determineEvaluation_ambient($cv, $pollutant){
        if($pollutant == 0){
            if($cv == "-"){
                return "-";
            }else if($cv <= 30){
                return "OK";
            }else{
                return "EXCEEDED";
            }
        }else if($pollutant == 1){
            if($cv == "-"){
                return "-";
            }else if($cv <= 9){
                return "OK";
            }else{
                return "EXCEEDED";
            }
        }else if($pollutant == 2){
            if($cv == "-"){
                return "-";
            }else if($cv <= 0.07){
                return "OK";
            }else{
                return "EXCEEDED";
            }
        }else if($pollutant == 3){
            if($cv == "-"){
                return "-";
            }else if($cv <= 0.08){
                return "OK";
            }else{
                return "EXCEEDED";
            }
        }
    }
}

?>

<?php

class AQICalculator{
    function GetAQI()
    {
        require 'include/guidelines.php';

        $concentration = $_POST["concentration"];
        $element = $_POST["element"];

        $concentration = abs($concentration);

        $aqi = 0;

        if ($element == "CO") {
            $aqi = round(calculateAQI_calcu($co_guideline_values, $concentration, $co_precision, $guideline_aqi_values));
        }
        if ($element == "SO2") {
            $aqi = round(calculateAQI_calcu($sufur_guideline_values, $concentration, $sulfur_precision, $guideline_aqi_values));
        }
        if ($element == "NO2") {
            $aqi = round(calculateAQI_calcu($no2_guideline_values, $concentration, $no2_precision, $guideline_aqi_values));
        }
        if ($element == "O3_8") {
            $aqi = round(calculateAQI_calcu($ozone_guideline_values_8, $concentration, $o3_precision, $guideline_aqi_values));
        }
        if ($element == "O3_1") {
            $aqi = round(calculateAQI_calcu($ozone_guideline_values_1, $concentration, $o3_precision, $guideline_aqi_values));
        }
        if ($element == "PM 10") {
            $aqi = round(calculateAQI_calcu($pm_10_guideline_values, $concentration, $pm10_precision, $guideline_aqi_values));
        }
        if ($element == "TSP") {
            $aqi = calculateAQI_calcu($tsp_guideline_values, $concentration, $tsp_precision, $guideline_aqi_values);

            if($aqi != -4){
                $aqi = round($aqi);
            }
        }

        $aqi_2 = $aqi;

        if($aqi == -4){
            $aqi_2 = "300+";
        }else if($aqi == -2){
            $aqi_2 = "400+";
        }else if($aqi == -3){
            $aqi_2 = "201-";
        }else if($aqi == -5){
            $aqi_2 = "101-";
        }

        echo "
          <script type='text/javascript'>
            
             var AQI = \"$aqi\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             AQI = \"$aqi_2\";
             
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

        $concentration = abs($concentration);

        $concentration_value = 0;

        if ($element == "CO") {
            $concentration_value = calculateConcentrationValue($co_guideline_values, $concentration, $co_precision, $guideline_aqi_values);
        }
        if ($element == "SO2") {
            $concentration_value = calculateConcentrationValue($sufur_guideline_values, $concentration, $sulfur_precision, $guideline_aqi_values);
        }
        if ($element == "NO2") {
            $concentration_value = calculateConcentrationValue($no2_guideline_values, $concentration, $no2_precision, $guideline_aqi_values);
        }
        if ($element == "O3_8") {
            $concentration_value = calculateConcentrationValue($ozone_guideline_values_8, $concentration, $o3_precision, $guideline_aqi_values);
        }
        if ($element == "O3_1") {
            $concentration_value = calculateConcentrationValue($ozone_guideline_values_1, $concentration, $o3_precision, $guideline_aqi_values);
        }
        if ($element == "PM 10") {
            $concentration_value = calculateConcentrationValue($pm_10_guideline_values, $concentration, $pm10_precision, $guideline_aqi_values);
        }
        if ($element == "TSP") {
            $concentration_value = calculateConcentrationValue($tsp_guideline_values, $concentration, $tsp_precision, $guideline_aqi_values);
        }

        if($concentration_value == -6 || $concentration_value == -1){
            $concentration = -6;
            $concentration_value = "N/A";
        }

        echo "
          <script type='text/javascript'>
          
             var AQI = \"$concentration\";
             var pollutant = \"$element\";
           
             GetAQIDetails(AQI,pollutant);
             
             AQI = \"$concentration_value\";
             
             $('#aqiNum').text(AQI);
             $(\"#AQIStat\").css(\"background-color\", AQIAirQuality);
             $(\"#aqiText\").text(AQIStatus);
             $(\"#result\").show();
             ScrollTo('calculator');
          </script>     
    ";

    }
}

?>


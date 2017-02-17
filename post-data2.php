<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 18/02/2017
 * Time: 12:55 AM
 */

if(isset($_REQUEST["md5Key"]) && $_REQUEST["md5Key"]=="df4c66a1decf3e92827507e56562c821")
{
    date_default_timezone_set('Asia/Manila');

    $date = date("Y-m-d H:i:s");
    $time = $date;
    $date_now = date("Y-m-d H:i:s");
    $date_now_string = $date_now;

    $pollutants = new Pollutants();
    $pollutants->area = $_REQUEST["area"];
    $pollutants->date = $date_now_string;
    $pollutants->co = $_REQUEST["value"][0];
    $pollutants->so2 = $_REQUEST["value"][1];
    $pollutants->no2 = $_REQUEST["value"][2];

    InsertData($pollutants);

    echo "SUCCESS!";
}
else{
    echo "Invalid key!";
}

class Pollutants{
    var $area = "";
    var $co = "";
    var $so2 = "";
    var $no2 = "";
    var $date = "";

    function Pollutants() {}
}

function InsertData($data_parameter){
    include('include/db_connect.php');

    $sql = $con->prepare("SELECT STATUS FROM DEVICE WHERE AREA_NAME = ?");
    $sql->bind_param("s", $data_parameter->area);

    $sql->execute();
    $sql->store_result();
    $sql->bind_result($status);

    $sql->fetch();

    if($status == "1"){
        $query = $con->prepare("INSERT INTO MASTER (area_name, timestamp, CO, SO2, NO2) VALUES (?,?,?,?,?)");
        $query->bind_param("sssss", $data_parameter->area, $data_parameter->date, $data_parameter->co, $data_parameter->so2, $data_parameter->no2);

        if(!$query->execute()){
            die('Error: ' . mysqli_error($con));
        }

        $query->close();
    }

    $sql->free_result();
    $sql->close();
    $con->close();
}
?>


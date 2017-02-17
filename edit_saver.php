<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 27/11/2016
 * Time: 7:47 PM
 */
include('include/db_connect.php');

if(isset($_POST['timestamp']) && !empty($_POST['timestamp'])) {
    $timestamp = $_POST['timestamp'];
    $concentration_value_co = $_POST['concentration_value_co'];
    $concentration_value_so2 = $_POST['concentration_value_so2'];
    $concentration_value_no2 = $_POST['concentration_value_no2'];
    $area = $_POST['area'];

    $sql = $con->prepare("UPDATE MASTER SET CO = ?, SO2 = ?, NO2 = ? WHERE timestamp = ? and area_name = ?");
    $sql->bind_param("sssss", $concentration_value_co, $concentration_value_so2, $concentration_value_no2, $timestamp, $area);

    if (!$sql->execute())
    {
        die('Error: ' . mysqli_error($con));
        //$error_message = mysqli_error($con);
    }

    else
    {
        echo "Success";
    }

    $sql->close();
    $con->close();
}

else
{
    echo "Update failed. Please try again.";
}
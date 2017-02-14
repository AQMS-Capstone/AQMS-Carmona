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
    $concentration_value = $_POST['concentration_value'];
    $area = $_POST['area'];
    $e_id = $_POST['e_id'];

    $sql = $con->prepare("UPDATE MASTER SET concentration_value=? WHERE timestamp = ? and area_name = ? and e_id = ?");
    $sql->bind_param("ssss", $concentration_value, $timestamp, $area, $e_id);

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

/*
$timestamp = $_POST['timestamp'];
$concentration_value = $_POST['concentration_value'];

$sql = "UPDATE MASTER SET concentration_value='$concentration_value' WHERE timestamp = '$timestamp'";

if (!mysqli_query($con,$query))
{
    die('Error: ' . mysqli_error($con));
}

else
{
    echo "alert('Success');";
}
*/
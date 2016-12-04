<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 27/11/2016
 * Time: 7:47 PM
 */
include('public/include/db_connect.php');

if(isset($_POST['timestamp']) && !empty($_POST['timestamp'])) {
    $timestamp = $_POST['timestamp'];
    $concentration_value = $_POST['concentration_value'];
    $area = $_POST['area'];
    $e_id = $_POST['e_id'];

    $sql = "UPDATE MASTER SET concentration_value='$concentration_value' WHERE timestamp = '$timestamp' and area_name = '$area' and e_id = '$e_id'";

    if (!mysqli_query($con,$sql))
    {
        die('Error: ' . mysqli_error($con));
        $error_message = mysqli_error($con);

        echo "mysqli_error($con)";
    }

    else
    {
        echo "Success";
    }
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
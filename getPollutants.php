<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 11/27/2016
 * Time: 10:04 PM
 */

include('include/db_connect.php');


$area = $_GET['area'];
echo "<option value=\"\" disabled selected>Select a pollutant</option>";
if($area == "all")
{
    $query = "SELECT * FROM MASTER";
    $result = mysqli_query($con, $query);

    if(!mysqli_num_rows($result) == 0){
        echo  "<option value='CO'>CO</option>";
        echo  "<option value='SO2'>SO2</option>";
        echo  "<option value='NO2'>NO2</option>";
        echo  "<option value='All'>All</option>";
    }
}

else
{
    $query = $con->prepare("SELECT * FROM MASTER WHERE AREA_NAME = ?");
    $query->bind_param("s", $area);
    $query->execute();
    $query->store_result();
    $num_of_rows = $query->num_rows;

    if(!$num_of_rows == 0){
        echo  "<option value='CO'>CO</option>";
        echo  "<option value='SO2'>SO2</option>";
        echo  "<option value='NO2'>NO2</option>";
        echo  "<option value='All'>All</option>";
    }

    $query->free_result();
    $con->close();
}

mysqli_close($con);

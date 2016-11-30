<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 11/27/2016
 * Time: 10:04 PM
 */

include('public/include/db_connect.php');


$area = $_GET['area'];
echo "<option value=\"\" disabled selected>Select a pollutant</option>";
if($area == "all")
{
    $query = "SELECT DISTINCT ELEMENTS.e_symbol as e_symbol FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id ORDER BY ELEMENTS.e_id";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

        echo  "<option value='".$row['e_symbol']."'>{$row['e_symbol']}</option>";
    }

    if (mysqli_num_rows($result) > 0) {
        echo  "<option value='All'>All</option>";
    }
}

else
{
    $query = "SELECT DISTINCT ELEMENTS.e_symbol as e_symbol FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id WHERE area_name = '$area' ORDER BY ELEMENTS.e_id";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

        echo  "<option value='".$row['e_symbol']."'>{$row['e_symbol']}</option>";
    }

    if (mysqli_num_rows($result) > 0) {
        echo  "<option value='All'>All</option>";
    }
}

mysqli_close($con);

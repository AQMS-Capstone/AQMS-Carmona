<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 11/27/2016
 * Time: 10:04 PM
 */

include('public/include/db_connect.php');

echo "<option value='EHH'>HELLO</option>";

/*
if(isset($_GET['area']) && !empty($_GET['area'])) {
    $area = $_GET['area'];
    $query = "SELECT DISTINCT elements.e_symbol as e_symbol FROM MASTER INNER JOIN elements ON master.e_id = elements.e_id WHERE area_name = '$area' ORDER BY elements.e_id";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

        echo  "<option value='".$row['e_symbol']."'>{$row['e_symbol']}</option>";
    }

    mysqli_close($con);
}

else
{
    echo  "<option value='EHH'>HELLO</option>";
}
*/

<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 18/02/2017
 * Time: 3:03 AM
 */

if(isset($_REQUEST['phpValue']) && isset($_REQUEST['phpValue2'])) {
    include('include/db_connect.php');

    $status = "";
    $area = "";

    if ($_REQUEST['phpValue'] == "1") {
        if($_REQUEST['phpValue2'] == "0"){
            $status = "0";
            $area = "bancal";

            $sql = $con->prepare("UPDATE DEVICE SET STATUS = ? WHERE area_name = ?");
            $sql->bind_param("ss",$status, $area);

            if (!$sql->execute())
            {
                die('Error: ' . mysqli_error($con));
                //$error_message = mysqli_error($con);
            }

            else
            {
                echo "Success";
            }
        }else if($_REQUEST['phpValue2'] == "1"){
            $status = "1";
            $area = "bancal";

            $sql = $con->prepare("UPDATE DEVICE SET STATUS = ? WHERE area_name = ?");
            $sql->bind_param("ss",$status, $area);

            if (!$sql->execute())
            {
                die('Error: ' . mysqli_error($con));
                //$error_message = mysqli_error($con);
            }

            else
            {
                echo "Success";
            }
        }
    } else if ($_REQUEST['phpValue'] == "2"){
        if($_REQUEST['phpValue2'] == "0"){
            $status = "0";
            $area = "slex";

            $sql = $con->prepare("UPDATE DEVICE SET STATUS = ? WHERE area_name = ?");
            $sql->bind_param("ss",$status, $area);

            if (!$sql->execute())
            {
                die('Error: ' . mysqli_error($con));
                //$error_message = mysqli_error($con);
            }

            else
            {
                echo "Success";
            }
        }else if($_REQUEST['phpValue2'] == "1"){
            $status = "1";
            $area = "slex";

            $sql = $con->prepare("UPDATE DEVICE SET STATUS = ? WHERE area_name = ?");
            $sql->bind_param("ss",$status, $area);

            if (!$sql->execute())
            {
                die('Error: ' . mysqli_error($con));
                //$error_message = mysqli_error($con);
            }

            else
            {
                echo "Success";
            }
        }
    }
}else{
    echo "ERROR";
}
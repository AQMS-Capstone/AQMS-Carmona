<?php
//VONN NOTE

//THINGS TO HASH:

// USERNAME AND PASSWORD!!

// GET CREATED_BY FIELD FROM SESSION!!!!!!!!!!!!

/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 19/02/2017
 * Time: 2:54 PM
 */

include('include/db_connect.php');

if(isset($_POST['UID']) && !empty($_POST['UID']) && isset($_POST['USERNAME']) && !empty($_POST['USERNAME']) && isset($_POST['PRIVILEGE']) && !empty($_POST['PRIVILEGE'])) {
    $privilege = $_POST['PRIVILEGE'];

    if($privilege == "1" || $privilege == "2" || $privilege == "3"){
        $uid = $_POST['UID'];
        $username = $_POST['USERNAME'];
        $password = $_POST['PASSWORD'];

        if($privilege == "1"){
            $privilege = "0";
        }else if($privilege == "2"){
            $privilege = "1";
        }else{
            $privilege = "2";
        }

        if($password != ""){
            $sql = $con->prepare("UPDATE ACCOUNT SET PASSWORD = ?, PRIVILEGE = ? WHERE USERNAME = ? and UID = ?");
            $sql->bind_param("ssss", password_hash($password,PASSWORD_DEFAULT), $privilege, $username, $uid);
        }else{
            $sql = $con->prepare("UPDATE ACCOUNT SET PRIVILEGE = ? WHERE USERNAME = ? and UID = ?");
            $sql->bind_param("sss", $privilege, $username, $uid);
        }

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
    }else{
        echo "Update failed. Please try again.";
    }
}

else
{
    echo "Update failed. Please try again.";
}
<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 18/02/2017
 * Time: 1:46 AM
 */

include('include/db_connect.php');

$area1 = "bancal";
$area2 = "slex";

$sql = $con->prepare("SELECT STATUS FROM DEVICE WHERE AREA_NAME = ?");
$sql->bind_param("s", $area1);

$sql->execute();
$sql->store_result();
$sql->bind_result($status1);

$sql->fetch();

$sql = $con->prepare("SELECT STATUS FROM DEVICE WHERE AREA_NAME = ?");
$sql->bind_param("s",$area2);

$sql->execute();
$sql->store_result();
$sql->bind_result($status2);

$sql->fetch();

$sql->free_result();
$sql->close();
$con->close();

echo json_encode(array("status1"=>$status1, "status2"=>$status2));
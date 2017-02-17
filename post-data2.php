<?php
if($_REQUEST["md5Key"]=="df4c66a1decf3e92827507e56562c821")
{
	for($i=0; $i < 3;$i++)
	{
		include('include/db_connect.php');
		
		date_default_timezone_set('Asia/Manila');

		$date = date("Y-m-d H:i:s");
		$time = $date;
		$date_now = date("Y-m-d H:i:s");
		$date_now_string = $date_now;
		
		$area = $_REQUEST["area"];
		$element = $_REQUEST["e_id"][$i];
		$value = $_REQUEST["value"][$i];
		
	   $query = $con->prepare("INSERT INTO MASTER (area_name, e_id, concentration_value, timestamp) VALUES (?,?,?,?)");
				$query->bind_param("ssss", $area, $element, $value, $date_now_string);

				if(!$query->execute()){
					die('Error: ' . mysqli_error($con));
				}
				
	$query->close();
    $con->close();
	
	}
	echo "SUCCESS!";
}
else{
	echo "Invalid Key!";
	header('Location: index.php');
}
?>


<!DOCTYPE html>
<?php

include_once('include/db_connect.php');

$userStats= "";
$CO = "";
$SO2 = "";
$NO2 = "";
$query = "";
$timestamp = "";
$date = "";
$time = "";
$insertTimestamp = "";

  if(isset($_POST['get'])){
  $query = "select timestamp from MASTER
            where e_id = '1' and a_id = '1'
            order by timestamp desc
            limit 1" ;

  $result = mysqli_query($con, $query);
  $strArray = mysqli_fetch_array($result);
  $timestamp = strtotime($strArray[0]);
  $datetime = explode(" ",$timestamp);
  $date = date('d-m-Y', $datetime[0]);
  $time = date('H:i:s', strtotime($datetime[1])+3600);
  $insertTimestamp = $date. " ". $time;

  echo $insertTimestamp;

}



  if (isset($_POST['send'])) {
    $CO = $_POST['co_element'];
    $SO2 = $_POST['so2_element'];
    $NO2 = $_POST['no2_element'];

    if ($CO != "") {
      $query = "INSERT INTO MASTER(a_id, e_id, concentration_value, timestamp) VALUES ('1', '1', '$CO', '$insertTimestamp')";
      if (!mysqli_query($con,$query))
        {
          die('Error: ' . mysqli_error($con));
        }

        else
        {
          $statusMessage = "New record added successfully.";
        }
    }
    if ($SO2 != "") {
      $query = "INSERT INTO MASTER(a_id, e_id, concentration_value, timestamp) VALUES ('1', '2', '$SO2', NOW())";
      if (!mysqli_query($con,$query))
        {
          die('Error: ' . mysqli_error($con));
        }

        else
        {
          $statusMessage = "New record added successfully.";
        }
    }
    if ($NO2 != "") {
      $query = "INSERT INTO MASTER(a_id, e_id, concentration_value, timestamp) VALUES ('1', '3', '$NO2', NOW())";
      if (!mysqli_query($con,$query))
        {
          die('Error: ' . mysqli_error($con));
        }

        else
        {
          $statusMessage = "New record added successfully.";
        }
    }
    else{
      echo "No input";
    }

}

    mysqli_close($con);


?>


<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <script type="text/javascript">

  </script>
  <body>

    <form class="" method="post">

      <?php echo $userStats ?>
      <label for="txt1">CO: </label><input id = "txt1" name = "co_element" type="text" value=""><br>
      <label for="txt1">SO2: </label><input type="text" name = "so2_element" value=""><br>
      <label for="txt1">NO2: </label><input type="text" name = "no2_element" value=""><br>

      <input type="submit" name="send" value="Send It!">
      <input type="submit" name="get" value="Get Timestamp!">
    </form>


  </body>
</html>

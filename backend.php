<?php

require_once 'public/include/db_connect.php';

if(isset($_POST['btnSubmit'])){
  $area = $_POST['area'];
  $E_ID = -1;
  $CValue = $_POST['cValue'];
  $time_now = "";

  if($area == "" || $E_ID == 0 || $CValue == ""){
    echo "Something's missing";
  }
  else{
    $E_ID = $_POST['element'];
    $query = "SELECT timestamp  FROM MASTER WHERE E_ID = '$E_ID' and area_name='bancal' ORDER BY timestamp desc limit 1";
    $result = mysqli_query($con,$query);

    while($row = mysqli_fetch_array($result))
    {
        if(mysql_num_rows($result)==0){
            echo date("Y-m-d H:i:s", strtotime("00:00:00")+3600);
            break;
        }
        else{
          $time_now = date("Y-m-d H:i:s", strtotime($row['timestamp'])+3600);
          break;
        }


    }
    echo $time_now;

    //echo date("Y-m-d H:00:00");

/*
    $query = "INSERT INTO MASTER (m_id, area_name, e_id, concentration_value, timestamp) VALUES (NULL, '$area', '$E_ID', '$CValue', '$time_now')";

    if (!mysqli_query($con,$query))
    {
      die('Error: ' . mysqli_error($con));
    }

    else
    {
      $statusMessage = "New record added successfully.";
    }
*/
    mysqli_close($con);
    echo $time_now;
  }

}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Quality Monitoring</title>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="icon" href="res/favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <form action="" method="post">
      <input type="text" name="area" value="" placeholder="Area"><br><br>
      <select name = "element">
          <option value="" disabled selected>Select an Element</option>
          <option value="1">CO</option>
          <option value="2">SO2</option>
          <option value="3">NO2</option>
          <option value="3">O3</option>
          <option value="3">Pb</option>
          <option value="3">PM 10</option>
          <option value="3">TSP</option>
      </select><br><br>
      <input type="text" name="cValue" value="" placeholder="Concentration Value"><br><br>

      <input type="submit" name="btnSubmit" value="Insert SQL">
    </form>

    
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/init.js"></script>
  </body>
</html>

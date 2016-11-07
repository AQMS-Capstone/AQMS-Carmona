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
      //$date_now = date("Y-m-d");
        if(mysql_num_rows($result)==0){
            //$time_now = date("Y-m-d H:i:s", strtotime($row['timestamp'])+3600);
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
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="" method="post">
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
  </body>
</html>

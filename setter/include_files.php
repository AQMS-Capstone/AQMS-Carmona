<?php
  $choice = json_decode($_REQUEST['phpValue']);

  if($choice == "Data")
  {
    include("../public/history.php");
  }

  else if($choice == "Home")
  {
    include("../class/Map.php");
    include("../public/map.php");
  }
?>

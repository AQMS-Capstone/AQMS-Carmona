<?php
class Map{
  var $m_id;
  var $p_id;
  var $p_name;
  var $p_value;
  var $p_status;
  var $p_time;

  function Map($pollutant, $value)
  {
    $this->p_id = $pollutant;
    $this->p_value = $value;
  }
}
?>

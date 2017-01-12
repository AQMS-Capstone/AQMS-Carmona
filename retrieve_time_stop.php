
<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 1/12/2017
 * Time: 3:03 PM
 */

Init();

function Init(){

    date_default_timezone_set('Asia/Manila');
    $date_now = date("Y-m-d H:i");
    $date_supposed = date("Y-m-d H") . ":01";
    $triggered = false;
    if(strtotime($date_now) >= strtotime($date_supposed)){
        $triggered = true;
    }
    else{
        $triggered = false;
    }

    echo json_encode(array("isStopTriggered"=>$triggered));
}
<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 1/12/2017
 * Time: 1:13 PM
 */

Init();

function Init(){

    date_default_timezone_set('Asia/Manila');
    $time = date("H:i:s");
    $date_now = date("Y-m-d H:i");
    $date_supposed = date("Y-m-d H") . ":00";
    $triggered = false;
    if($date_now == $date_supposed){
        $triggered = true;
    }
    else{
        $triggered = false;
    }

    echo json_encode(array("isSoundTriggered"=>$triggered, "serverTime"=>$time));
}
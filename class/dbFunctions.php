<?php



function CheckPollutants($a_name, $p_name, $dFrom, $dTo){
    include('public/include/db_connect.php');
    if($a_name == "" && $p_name == ""){
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";
    }
    else if($a_name == ""){
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

    }
    else if($p_name == ""){
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

    }
    else{
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY TIMESTAMP DESC";

    }

    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);
    mysqli_close($con);
    return $row;
}

function GetPollutants($a_name, $p_name, $dFrom, $dTo, $order){

    include('public/include/db_connect.php');

    $bancalData = array();
    $slexData = array();
    $bancalData1 = array();
    $slexData1 = array();

    if($a_name == "" && $p_name == ""){
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
    }
    else if($a_name == ""){
        $query = "SELECT E_NAME, E_SYMBOL, CONCENTRATION_VALUE, timestamp, AREA_NAME
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE ELEMENTS.e_symbol = '$p_name' AND DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";

    }
    else if($p_name == ""){
        $query = "SELECT E_NAME, AREA_NAME ,E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
    }
    else{
        $query = "SELECT E_NAME, AREA_NAME ,E_SYMBOL, CONCENTRATION_VALUE, timestamp
                          FROM MASTER INNER JOIN ELEMENTS ON MASTER.e_id = ELEMENTS.e_id
                          WHERE area_name = '$a_name' and ELEMENTS.e_symbol = '$p_name' and DATE(timestamp) BETWEEN DATE('$dFrom') and DATE('$dTo')
                          ORDER BY $order DESC";
    }
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {

        if($row['AREA_NAME'] == "bancal"){
            array_push($bancalData, $row["E_NAME"] . ';' . $row["E_SYMBOL"] . ';' . $row["CONCENTRATION_VALUE"] . ';' . $row["timestamp"]);


            array_push($bancalData1, $row["E_NAME"]);
            array_push($bancalData1, $row["E_SYMBOL"]);
            array_push($bancalData1, $row["CONCENTRATION_VALUE"]);
            array_push($bancalData1, $row["timestamp"]);
        }
        else{
            array_push($slexData, $row["E_NAME"] . ';' . $row["E_SYMBOL"] . ';' . $row["CONCENTRATION_VALUE"] . ';' . $row["timestamp"]);


            array_push($slexData1, $row["E_NAME"]);
            array_push($slexData1, $row["E_SYMBOL"]);
            array_push($slexData1, $row["CONCENTRATION_VALUE"]);
            array_push($slexData1, $row["timestamp"]);
        }

    }


        return [$bancalData, $slexData, $bancalData1, $slexData1];

}

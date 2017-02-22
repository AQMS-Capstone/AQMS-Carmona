<?php
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) || !empty($_POST['password']) || !empty($_POST['privilege'])) {

// Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        $privilege = $_POST['privilege'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
        include('include/db_connect.php');
// To protect MySQL injection for Security purpose
        $username = trim($username);
        $password = trim($password);

// SQL query to fetch information of registerd users and finds user match.

        $query = $con->prepare("SELECT USERNAME FROM ACCOUNT 
                                    WHERE USERNAME= ?");
        $query->bind_param("s", $username);
        $query->execute();
        $query->store_result();
        $num_of_rows = $query->num_rows;

        if ($num_of_rows == 0) {

            date_default_timezone_set('Asia/Manila');
            $date_now = date("Y-m-d H:i:s");
            $date_now_string = $date_now;
            $hashed_password = password_hash($password,PASSWORD_DEFAULT);
            $query = $con->prepare("INSERT INTO ACCOUNT (USERNAME, PASSWORD, PRIVILEGE, DATE_CREATED, CREATED_BY) VALUES (?,?,?,?,?)");
            $query->bind_param("sssss", $username, $hashed_password, $privilege,$date_now_string ,$_SESSION["USERNAME"]);


            if (!$query->execute()) {
                die($error = mysqli_error($con));

            }
        } else {
            $error = "Account already exist!";
        }

        $query->free_result();
        $query->close();
        $con->close();
    }
}
?>
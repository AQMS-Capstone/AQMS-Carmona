<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";

    }
    else
    {
// Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
        include('include/db_connect.php');
// To protect MySQL injection for Security purpose
        $username = trim($username);
        $password = trim($password);

// SQL query to fetch information of registerd users and finds user match.
        $query = $con->prepare("SELECT USERNAME, PASSWORD, PRIVILEGE FROM ACCOUNT 
                            WHERE USERNAME= ?");

        $query->bind_param("s", $username);
        $query->execute();
        $query->store_result();

        //$result = $query->get_result();
        //$num_of_rows = $result->num_rows;

        $query->bind_result($ret_username, $ret_password, $ret_privilege);

        $num_of_rows = $query->num_rows;

        if ($num_of_rows == 1) {
            while($query->fetch()) {
                if(password_verify($password,$ret_password))
                {
                    $_SESSION["USERNAME"]=$ret_username; // Initializing Session
                    $_SESSION["PRIVILEGE"]=$ret_privilege; // Initializing Session

                    if($_SESSION["PRIVILEGE"]!="2")
                    {
                        header("location: feed.php"); // Redirecting To Other Page
                    }
                    else{
                        unset($_SESSION["USERNAME"]);
                        unset($_SESSION["PRIVILEGE"]);
                        $error = "User is blocked!";
                    }
                }
                else{
                    $error = "Wrong Password!";
                }

            }


        } else {
            $error = "Username or Password is invalid";

        }
        $query->free_result();
        $query->close();
        $con->close();
    }
}
?>
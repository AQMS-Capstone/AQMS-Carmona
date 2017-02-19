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
        $query = $con->prepare("SELECT * FROM ACCOUNT 
                            WHERE USERNAME= ? AND PASSWORD = ?");

        $query->bind_param("ss", $username, $password);
        $query->execute();
        $query->store_result();
        $num_of_rows = $query->num_rows;

        if ($num_of_rows == 1) {
            $_SESSION["USERNAME"]=$username; // Initializing Session
            header("location: feed.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        $query->free_result();
        $query->close();
        $con->close();
    }
}
?>
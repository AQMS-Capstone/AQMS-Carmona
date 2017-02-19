<?php
session_start();
unset($_SESSION["USERNAME"]);
unset($_SESSION["PRIVILEGE"]);

header('Location: user-login.php');
?>
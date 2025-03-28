<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: login.php");
    exit();
}
echo "Welcome to your Dashboard!";
?>

<a href="logout.php">Logout</a>

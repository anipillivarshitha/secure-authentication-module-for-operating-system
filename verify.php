<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['otp'] == $otp && time() < strtotime($user['otp_expiry'])) {
        $_SESSION['authenticated'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid OTP or expired!";
    }
}
?>

<form method="POST">
    <input type="text" name="otp" required placeholder="Enter OTP">
    <button type="submit">Verify</button>
</form>

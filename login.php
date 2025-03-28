<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = rand(100000, 999999);
        $_SESSION['otp_expiry'] = time() + 300; // 5 min expiry

        // Store OTP in the database
        $stmt = $conn->prepare("UPDATE users SET otp=?, otp_expiry=DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE email=?");
        $stmt->bind_param("ss", $_SESSION['otp'], $email);
        $stmt->execute();

        // Send OTP via email
        require "send_otp.php";

        header("Location: verify.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}
?>

<form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit">Login</button>
</form>

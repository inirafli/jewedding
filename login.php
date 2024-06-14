<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tb_users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : '/jewedding/home.php';
            unset($_SESSION['redirect_to']);
            if ($user['role'] == 'admin') {
                header('Location: /jewedding/admin/dashboard.php');
            } else {
                header("Location: $redirect_to");
            }
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
}
?>

<form method="POST" action="login.php">
    <h2>Login</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
    <p>Belum punya akun? <a href="register.php">Register di sini</a></p>
</form>

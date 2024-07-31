<?php
include('includes/db.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql_check = "SELECT * FROM tb_users WHERE username='$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "Username sudah digunakan. Silakan pilih username lain.";
        echo "<script>showRetryAlert('error', 'Gagal Registrasi Akun', '$error', 'Coba Lagi');</script>";
    } else {
        $sql = "INSERT INTO tb_users (name, email, username, password, role, created_at, updated_at)
                VALUES ('$name', '$email', '$username', '$password', 'customer', NOW(), NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "<script>showAlert('success', 'Registrasi Akun Berhasil', 'Silahkan Masuk dengan Akun baru-mu!', 'login.php', 'Login');</script>";
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>showRetryAlert('error', 'Gagal Registrasi Akun', '$error_message', 'Coba Lagi');</script>";
        }
    }
}
?>

<div class="flex justify-center items-center px-8 pt-[60px] min-h-screen bg-accent">
    <form method="POST" action="register.php" class="bg-white py-8 px-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-10 text-center text-primary">Daftar</h2>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" id="name" name="name" class="mt-2 mb-4 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-2 mb-4 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" class="mt-2 mb-4 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
        <div class="relative mb-10">
            <input type="password" id="password" name="password" class="mt-2 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600">
                <i id="password-eye" class="mdi mdi-eye-outline"></i>
            </button>
        </div>
        <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Daftar</button>
        <p class="mt-6 text-center">Sudah punya akun? <a href="login.php" class="text-primary hover:underline">Masuk di sini</a></p>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var passwordEye = document.getElementById('password-eye');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordEye.classList.remove('mdi-eye-outline');
            passwordEye.classList.add('mdi-eye-off-outline');
        } else {
            passwordInput.type = 'password';
            passwordEye.classList.remove('mdi-eye-off-outline');
            passwordEye.classList.add('mdi-eye-outline');
        }
    }
</script>

<?php include('includes/footer.php'); ?>
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
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}

include('includes/header.php');
?>

<div class="flex justify-center items-center min-h-screen bg-accent">
    <form method="POST" action="login.php" class="bg-white p-8 rounded shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-primary">Masuk</h2>
        <?php if (isset($error_message)) : ?>
            <p class="text-red-500"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" class="mt-1 mb-4 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
        <div class="relative mb-8">
            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600">
                <i id="password-eye" class="mdi mdi-eye-outline"></i>
            </button>
        </div>
        <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Masuk</button>
        <p class="mt-4 text-center">Belum punya akun? <a href="register.php" class="text-primary hover:underline">Daftar di sini</a></p>
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
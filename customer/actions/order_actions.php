<?php
include('../../includes/middleware.php');
include('../../includes/header.php');
include('../../includes/db.php');

if (isset($_GET['id'])) {
    $catalogue_id = $_GET['id'];

    $sql = "SELECT * FROM tb_catalogues WHERE catalogue_id='$catalogue_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $catalogue = $result->fetch_assoc();
    } else {
        echo "Catalogue not found.";
        exit();
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'];
    $wedding_date = $_POST['wedding_date'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $sql_user = "SELECT name, email FROM tb_users WHERE user_id='$user_id'";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();
    $name = $user['name'];
    $email = $user['email'];

    $sql = "INSERT INTO tb_orders (catalogue_id, phone_number, wedding_date, status, notes, user_id) 
            VALUES ('$catalogue_id', '$phone_number', '$wedding_date', 'requested', '$notes', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                showAlert('success', 'Pesanan Berhasil', 'Pesanan telah berhasil ditempatkan.', '../../customer/check_status.php', 'Cek Status');
              </script>";
        exit();
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>showAlert('error', 'Gagal Membuat Pesanan', 'Terjadi kesalahan: $error_message', null, 'Coba Lagi');</script>";
    }
}

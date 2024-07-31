<?php
include('../../includes/middleware.php');
include('../../includes/header.php');
include('../../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];
    $user_id = $_SESSION['user_id'];

    $target_dir = "../../assets/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>showRetryAlert('error', 'Gagal', 'File bukan gambar.', 'Coba Lagi');</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) {
        echo "<script>showRetryAlert('error', 'Gagal', 'Ukuran Gambar terlalu besar. Maksimal 5 MB.', 'Coba Lagi');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "webp") {
        echo "<script>showRetryAlert('error', 'Gagal', 'Hanya Gambar bertipe JPG, JPEG, WEBP, & PNG yang diizinkan.', 'Coba Lagi');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);

            // Insert data into database
            $sql = "INSERT INTO tb_catalogues (image, package_name, description, price, category, availability, user_id, created_at, updated_at) 
                    VALUES ('$image', '$package_name', '$description', '$price', '$category', '$availability', '$user_id', NOW(), NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                showAlert('success', 'Katalog Ditambahkan', 'Data Katalog baru berhasil ditambahkan.', '/jewedding/admin/dashboard.php', 'Cek Katalog');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

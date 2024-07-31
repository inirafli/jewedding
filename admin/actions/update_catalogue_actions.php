<?php
include('../../includes/header.php');
include('../../includes/db.php');

if (isset($_POST['catalogue_id'])) {
    $catalogue_id = $_POST['catalogue_id'];
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];
    $old_image = $_POST['old_image'];

    // Handle file upload if a new image is provided
    $uploadOk = 1;
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../../assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>showRetryAlert('error', 'Gagal', 'File bukan gambar.', 'Coba Lagi');</script>";
            $uploadOk = 0;
        }
        if ($_FILES["image"]["size"] > 5000000) {
            echo "<script>showRetryAlert('error', 'Gagal', 'Ukuran Gambar terlalu besar. Maksimal 5 MB.', 'Coba Lagi');</script>";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "webp") {
            echo "<script>showRetryAlert('error', 'Gagal', 'Hanya Gambar bertipe JPG, JPEG, WEBP, & PNG yang diizinkan.', 'Coba Lagi');</script>";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]);

                // Delete the old image file
                if (file_exists($target_dir . $old_image)) {
                    unlink($target_dir . $old_image);
                }

                $sql = "UPDATE tb_catalogues SET image='$image', package_name='$package_name', description='$description', price='$price', category='$category', availability='$availability', updated_at=NOW() WHERE catalogue_id='$catalogue_id'";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }
    } else {
        $sql = "UPDATE tb_catalogues SET package_name='$package_name', description='$description', price='$price', category='$category', availability='$availability', updated_at=NOW() WHERE catalogue_id='$catalogue_id'";
    }

    if ($uploadOk == 1 && $conn->query($sql) === TRUE) {
         echo "<script>
                showAlert('success', 'Katalog Diperbarui', 'Data Katalog berhasil diperbarui.', '/jewedding/admin/dashboard.php', 'Cek Katalog');
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

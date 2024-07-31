<?php
include('../../includes/middleware.php');
include('../../includes/header.php');
include('../../includes/db.php');

if (isset($_GET['id'])) {
    $catalogue_id = $_GET['id'];

    $sql = "SELECT image FROM tb_catalogues WHERE catalogue_id='$catalogue_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $catalogue = $result->fetch_assoc();
        $image = $catalogue['image'];

        // Delete the image file from the directory
        $target_dir = "../../assets/images/";
        if (file_exists($target_dir . $image)) {
            unlink($target_dir . $image);
        }

        // Delete the catalogue from the database
        $sql = "DELETE FROM tb_catalogues WHERE catalogue_id='$catalogue_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                showAlert('success', 'Berhasil', 'Pesanan telah berhasil dihapus dari Database.', '/jewedding/admin/dashboard.php', 'Cek Katalog');
              </script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Catalogue not found.";
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

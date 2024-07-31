<?php
include('../../includes/middleware.php');
include('../../includes/header.php');
include('../../includes/db.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $sql = "DELETE FROM tb_orders WHERE order_id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                showAlert('success', 'Berhasil', 'Pesanan telah berhasil dihapus dari Database.', '/jewedding/admin/manage_orders.php', 'Cek Status');
              </script>";
    } else {
        echo "Error deleting order: " . $conn->error;
    }
} else {
    echo "No order ID provided.";
}

<?php
include('../../includes/middleware.php');
include('../../includes/db.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $sql = "DELETE FROM tb_orders WHERE order_id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../../admin/manage_orders.php');
        exit();
    } else {
        echo "Error deleting order: " . $conn->error;
    }
} else {
    echo "No order ID provided.";
}

<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE tb_orders SET status='$status', updated_at=NOW() WHERE order_id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

$sql = "SELECT o.*, u.name as customer_name, c.package_name, c.price, c.image, o.wedding_date, o.notes, o.status 
        FROM tb_orders o 
        JOIN tb_users u ON o.user_id = u.user_id 
        JOIN tb_catalogues c ON o.catalogue_id = c.catalogue_id";
$result = $conn->query($sql);

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold text-center mb-12">Kelola Pesanan Masuk</h2>

    <div>
        <h3 class="text-lg font-semibold mb-4">Pesanan Masuk</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'requested') {
                        echo renderOrderCard($row);
                    }
                }
            } else {
                echo "<p class='text-center text-gray-600'>No orders found.</p>";
            }
            ?>
        </div>

        <h3 class="text-lg font-semibold mt-12 mb-4">Pesanan Disetujui</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'approved') {
                        echo renderOrderCard($row);
                    }
                }
            }
            ?>
        </div>

        <h3 class="text-lg font-semibold mt-12 mb-4">Pesanan Ditolak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'rejected') {
                        echo renderOrderCard($row);
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">

<?php
function renderOrderCard($row)
{
    $status_class = '';
    switch ($row['status']) {
        case 'rejected':
            $status_class = 'bg-red-500 text-white';
            break;
        case 'approved':
            $status_class = 'bg-green-500 text-white';
            break;
        case 'requested':
            $status_class = 'bg-gray-500 text-white';
            break;
    }

    $notes = $row['notes'] ? $row['notes'] : '-';

    $card = "<div class='order-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col'>";
    $card .= "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-full h-48 object-cover'>";
    $card .= "<div class='p-4 flex flex-col flex-grow'>";
    $card .= "<h4 class='text-xl font-bold mb-2 line-clamp-2'>" . $row['package_name'] . "</h4>";
    $card .= "<p class='text-gray-800 text-lg font-semibold mb-2'>" . formatRupiah($row['price']) . "</p>";
    $card .= "<div class='flex items-center text-gray-600 mb-2'><i class='mdi mdi-account-outline mr-2 text-xl'></i>" . $row['customer_name'] . "</div>";
    $card .= "<div class='flex items-center text-gray-600 mb-2'><i class='mdi mdi-phone-outline mr-2 text-xl'></i>" . $row['phone_number'] . "</div>";
    $card .= "<div class='flex items-center text-gray-600 mb-2'><i class='mdi mdi-calendar-outline mr-2 text-xl'></i>" . $row['wedding_date'] . "</div>";
    $card .= "<div class='text-gray-600 mb-2'><i class='mdi mdi-note-outline mr-2 text-xl'></i><span>Notes: <span class='block h-12 overflow-y-auto'>" . $notes . "</span></span></div>";
    $card .= "<div class='mt-4 flex flex-wrap justify-end space-x-2'>";
    $card .= "<form method='POST' action='manage_orders.php' class='flex space-x-2 space-y-2 justify-end flex-wrap'>";
    $card .= "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
    if ($row['status'] == 'requested') {
        $card .= "<button type='submit' name='status' value='approved' class='border border-primary text-primary px-3 py-2 rounded transition hover:bg-primary hover:text-white flex items-center'><i class='mdi mdi-check-outline mr-2'></i>Setujui</button>";
        $card .= "<button type='submit' name='status' value='rejected' class='border border-red-500 text-red-500 px-3 py-2 rounded transition hover:bg-red-500 hover:text-white flex items-center'><i class='mdi mdi-close-outline mr-2'></i>Tolak</button>";
    } elseif ($row['status'] == 'approved') {
        $card .= "<button type='submit' name='status' value='rejected' class='border border-red-500 text-red-500 px-3 py-2 rounded transition hover:bg-red-500 hover:text-white flex items-center'><i class='mdi mdi-close-outline mr-2'></i>Tolak</button>";
    } elseif ($row['status'] == 'rejected') {
        $card .= "<button type='submit' name='status' value='approved' class='border border-primary text-primary px-3 py-2 rounded transition hover:bg-primary hover:text-white flex items-center'><i class='mdi mdi-check-outline mr-2'></i>Setujui</button>";
    }
    $card .= "<a href='actions/delete_order.php?order_id=" . $row['order_id'] . "' class='border border-gray-500 text-gray-500 px-3 py-2 rounded transition hover:bg-gray-500 hover:text-white flex items-center'><i class='mdi mdi-delete-outline mr-2'></i>Hapus</a>";
    $card .= "</form>";
    $card .= "</div>";
    $card .= "</div>";
    $card .= "</div>";

    return $card;
}
?>
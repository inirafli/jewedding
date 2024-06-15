<?php
include('../includes/middleware.php');
checkRole('customer');
include('../includes/header.php');
include('../includes/db.php');

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$sql = "SELECT o.*, c.package_name, c.price, c.image, o.phone_number 
        FROM tb_orders o 
        JOIN tb_catalogues c ON o.catalogue_id = c.catalogue_id 
        WHERE o.user_id = '$user_id'";
$result = $conn->query($sql);

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold text-center mb-12">Status Pemesanan</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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

                echo "<div class='order-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col lg:flex-row'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-full h-48 lg:w-48 lg:h-auto object-cover'>";
                echo "<div class='p-4 flex flex-col flex-grow relative'>";
                echo "<h4 class='text-xl font-bold mb-1 line-clamp-1'>" . $row['package_name'] . "</h4>";
                echo "<p class='text-gray-800 text-lg font-semibold mb-2'>" . formatRupiah($row['price']) . "</p>";
                echo "<div class='flex items-center text-gray-600 mb-1'><i class='mdi mdi-calendar-outline mr-2 text-xl'></i>" . $row['wedding_date'] . "</div>";
                echo "<div class='flex items-center text-gray-600 mb-12'><i class='mdi mdi-phone-outline mr-2 text-xl'></i>" . $row['phone_number'] . "</div>";
                echo "<div class='absolute right-4 bottom-4 px-3 py-1 rounded " . $status_class . "'>" . ucfirst($row['status']) . "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-gray-600'>No orders found.</p>";
        }
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
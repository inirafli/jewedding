<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

$sql = 'SELECT * FROM tb_catalogues';
$result = $conn->query($sql);

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto max-w-screen-xl px-6 py-12 lg:px-16 flex-grow mt-16">
    <div class="flex flex-wrap items-center justify-between mb-4">
        <h3 class="text-xl font-bold mb-4">Daftar Katalog</h3>
        <a href="add_catalogue.php" class="bg-primary text-white px-5 py-2 rounded-md hover:bg-secondary transition mb-4">Tambah Katalog</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admin_sql = "SELECT name FROM tb_users WHERE user_id = " . $row['user_id'];
                $admin_result = $conn->query($admin_sql);
                $admin_name = $admin_result->num_rows > 0 ? $admin_result->fetch_assoc()['name'] : 'Unknown';

                $category_class = '';
                switch ($row['category']) {
                    case 'Basic':
                        $category_class = 'bg-gray-100 text-gray-800';
                        break;
                    case 'Silver':
                        $category_class = 'bg-gray-300 text-gray-900';
                        break;
                    case 'Gold':
                        $category_class = 'bg-yellow-300 text-yellow-900';
                        break;
                    case 'Platinum':
                        $category_class = 'bg-gray-500 text-gray-100';
                        break;
                }

                echo "<div class='catalogue-card bg-white rounded-lg shadow-lg'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-full h-48 object-cover rounded-t-md'>";
                echo "<div class='p-4 flex flex-col justify-between'>";
                echo "<div class='bg-accent text-secondary px-2 py-1 rounded mb-3 text-center'>" . ($row['availability'] == 'Y' ? 'Tersedia' : 'Tidak Tersedia') . "</div>";
                echo "<div>";
                echo "<h4 class='text-xl font-bold mb-2 truncate'>" . $row['package_name'] . "</h4>";
                echo "<div class='flex justify-start space-x-4 items-center mb-2'>";
                echo "<p class='px-4 py-1 rounded " . $category_class . "'>" . $row['category'] . "</p>";
                echo "<p class='font-bold text-lg'>" . formatRupiah($row['price']) . "</p>";
                echo "</div>";
                echo "<div class='text-gray-600 flex items-center'><i class='mdi mdi-update mr-3 text-xl'></i>" . (!is_null($row['updated_at']) ? $row['updated_at'] : $row['created_at']) . "</div>";
                echo "<div class='text-gray-600 flex items-center'><i class='mdi mdi-account-outline mr-3 text-xl'></i>" . $admin_name . "</div>";
                echo "</div>";
                echo "<div class='flex justify-end space-x-2 mt-4'>";
                echo "<a href='update_catalogue.php?id=" . $row['catalogue_id'] . "' class='border border-primary text-primary px-4 py-2 rounded transition hover:bg-primary hover:text-white flex items-center'><i class='mdi mdi-pencil-outline mr-2 text-lg'></i> Ubah</a>";
                echo "<a href='javascript:void(0);' onclick='confirmDelete(\"" . $row['catalogue_id'] . "\")' class='border border-primary text-primary px-4 py-2 rounded transition hover:bg-primary hover:text-white flex items-center'><i class='mdi mdi-delete-outline mr-2 text-lg'></i> Hapus</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-gray-600'>No catalogues found.</p>";
        }
        ?>
    </div>
</div>

<script>
function confirmDelete(catalogueId) {
    showConfirmationAlert(
        'Hapus Katalog',
        'Apakah kamu yakin ingin menghapus Katalog ini? Data yang telah dihapus tidak dapat dikembalikan.',
        'Ya, Hapus',
        'Tidak',
        function() {
            window.location.href = 'actions/delete_catalogue.php?id=' + catalogueId;
        }
    );
}

function confirmLogout() {
    showConfirmationAlert(
        'Hapus Pesanan',
        'Apakah kamu yakin ingin menghapus Pesanan ini? Data yang telah dihapus tidak dapat dikembalikan.',
        'Iya',
        'Tidak',
        function() {
            window.location.href = 'actions/delete_order.php?order_id=' + orderId;
        }
    );
}
</script>

<?php include('../includes/footer.php'); ?>
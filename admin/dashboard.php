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

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold mb-12 text-center">Admin Dashboard</h2>

    <div class="flex flex-wrap items-center justify-between mb-4">
        <h3 class="text-xl font-bold mb-4">Daftar Katalog</h3>
        <a href="add_catalogue.php" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition mb-4">Tambah Katalog</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='catalogue-card bg-white rounded-lg shadow-lg flex'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-48 object-cover rounded-l-md'>";
                echo "<div class='p-4 flex flex-col justify-between flex-grow'>";
                echo "<div>";
                echo "<h4 class='text-xl font-bold mb-2'>" . $row['package_name'] . "</h4>";
                echo "<p class='text-gray-700 mb-2'>" . $row['description'] . "</p>";
                echo "<p class='text-gray-800 font-semibold mb-2'>Harga: " . formatRupiah($row['price']) . "</p>";
                echo "<p class='text-gray-700 mb-2'>Kategori: " . $row['category'] . "</p>";
                echo "<p class='text-gray-700 mb-2'>Ketersediaan: " . ($row['availability'] == 'Y' ? 'Yes' : 'No') . "</p>";
                echo "</div>";
                echo "<div class='flex space-x-2'>";
                echo "<a href='update_catalogue.php?id=" . $row['catalogue_id'] . "' class='border border-primary text-primary px-3 py-2 rounded transition hover:bg-primary hover:text-onAccent hover:border-onAccent'><i class='mdi mdi-pencil'></i> Ubah</a>";
                echo "<a href='delete_catalogue.php?id=" . $row['catalogue_id'] . "' onclick='return confirm(\"Are you sure you want to delete this catalogue?\");' class='border border-primary text-primary px-3 py-2 rounded transition hover:bg-primary hover:text-onAccent hover:border-onAccent'><i class='mdi mdi-delete'></i> Hapus</a>";
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

<?php include('../includes/footer.php'); ?>
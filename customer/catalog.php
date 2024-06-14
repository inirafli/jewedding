<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

$sql = "SELECT * FROM tb_catalogues WHERE availability = 'Y'";
$result = $conn->query($sql);

// Function to format price in Indonesian Rupiah
function formatRupiah($price) {
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto py-4">
    <div class="flex justify-center mb-12">
        <div class="bg-primary text-onAccent py-2 px-4 rounded">
            <h2 class="text-xl font-bold text-center">Pilihan Paket</h2>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='bg-white rounded-lg shadow-lg overflow-hidden flex flex-col'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-full h-48 object-cover'>";
                echo "<div class='p-4 flex-grow flex flex-col'>";
                echo "<h4 class='text-xl font-bold mb-2'>" . $row['package_name'] . "</h4>";
                echo "<p class='text-gray-600 mb-2 flex-grow'>" . $row['description'] . "</p>";
                echo "<p class='text-gray-800 font-semibold'>Harga: " . formatRupiah($row['price']) . "</p>";
                echo "<p class='text-gray-600 mb-4'>Kategori: " . $row['category'] . "</p>";
                echo "<div class='mt-auto'>";
                echo "<a href='order.php?id=" . $row['catalogue_id'] . "' class='inline-block bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition'>Pilih Paket</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-gray-600'>No catalogues available.</p>";
        }
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

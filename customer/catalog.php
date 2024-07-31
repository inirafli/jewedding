<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

$sql = "SELECT * FROM tb_catalogues WHERE availability = 'Y'";
$result = $conn->query($sql);

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto max-w-screen-xl px-6 py-12 lg:px-16 flex-grow mt-16">
    <div class="flex justify-center mb-12">
        <div class="bg-onAccent text-primary py-2 px-4 rounded">
            <h2 class="text-xl font-bold text-center">Pilihan Paket</h2>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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

                echo "<div class='bg-white rounded-lg shadow-lg overflow-hidden flex flex-col'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "' class='w-full h-48 object-cover'>";
                echo "<div class='p-4 flex flex-col flex-grow'>";
                echo "<p class='px-2 py-1 rounded text-center text-bold mb-4 " . $category_class . "'>" . $row['category'] . "</p>";
                echo "<h4 class='text-xl font-bold mb-2 line-clamp-1'>" . $row['package_name'] . "</h4>";
                echo "<div class='flex-grow mb-2 overflow-hidden overflow-y-auto max-h-32'>";
                echo "<p class='text-gray-600'>" . $row['description'] . "</p>";
                echo "</div>";
                echo "<p class='text-gray-800 font-semibold text-xl mb-4'>" . formatRupiah($row['price']) . "</p>";
                echo "<div class='mt-auto mb-2'>";
                echo "<a href='order.php?id=" . $row['catalogue_id'] . "' class='inline-block bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition'>Pilih Paket</a>";
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
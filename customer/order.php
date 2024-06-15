<?php
include('../includes/middleware.php');
checkRole('customer');
include('../includes/header.php');
include('../includes/db.php');

if (isset($_GET['id'])) {
    $catalogue_id = $_GET['id'];

    $sql = "SELECT * FROM tb_catalogues WHERE catalogue_id='$catalogue_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $catalogue = $result->fetch_assoc();

        // Fetch admin email who posted the catalogue
        $admin_sql = "SELECT email FROM tb_users WHERE user_id=" . $catalogue['user_id'];
        $admin_result = $conn->query($admin_sql);
        if ($admin_result->num_rows > 0) {
            $admin_email = $admin_result->fetch_assoc()['email'];
        } else {
            $admin_email = 'Not available';
        }
    } else {
        echo "Catalogue not found.";
        exit();
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}
?>

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold mb-12 text-center">Formulir Pemesanan</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="order-form bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="actions/order_actions.php?id=<?php echo $catalogue['catalogue_id']; ?>" class="space-y-4">
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon Pemesan</label>
                    <input type="text" id="phone_number" name="phone_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label for="wedding_date" class="block text-sm font-medium text-gray-700">Tanggal Pernikahan</label>
                    <input type="date" id="wedding_date" name="wedding_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label for="summernote" class="block text-sm font-medium text-gray-700">Notes Pesanan</label>
                    <textarea id="summernote" name="notes" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Buat Pesanan</button>
                </div>
            </form>
        </div>
        <div class="order-details bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-md font-bold mb-4">Paket yang Dipilih</h3>
            <img src="../assets/images/<?php echo $catalogue['image']; ?>" alt="<?php echo $catalogue['package_name']; ?>" class="w-full h-48 object-cover rounded-md mb-4">
            <?php
            $category_class = '';
            switch ($catalogue['category']) {
                case 'Basic':
                    $category_class = 'bg-gray-100 text-gray-800 text-bold';
                    break;
                case 'Silver':
                    $category_class = 'bg-gray-300 text-gray-900 text-bold';
                    break;
                case 'Gold':
                    $category_class = 'bg-yellow-300 text-yellow-900 text-bold';
                    break;
                case 'Platinum':
                    $category_class = 'bg-gray-500 text-gray-100 text-bold';
                    break;
            }
            ?>
            <p class="px-2 py-1 rounded text-center text-bold mb-6 <?php echo $category_class; ?>"><?php echo $catalogue['category']; ?></p>
            <p class="text-gray-800 font-semibold text-2xl mb-2"><?php echo formatRupiah($catalogue['price']); ?></p>
            <h4 class="text-xl font-medium mb-3 line-clamp-1"><?php echo $catalogue['package_name']; ?></h4>
            <div class="inline-flex items-center bg-green-500 rounded-lg px-3 py-1">
                <i class="mdi mdi-check-circle-outline text-white text-md mr-2"></i>
                <span class="text-white text-md text-semibold">Tersedia</span>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">

<?php include('../includes/footer.php'); ?>
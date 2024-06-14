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
    } else {
        echo "Catalogue not found.";
        exit();
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'];
    $wedding_date = $_POST['wedding_date'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $sql_user = "SELECT name, email FROM tb_users WHERE user_id='$user_id'";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();
    $name = $user['name'];
    $email = $user['email'];

    $sql = "INSERT INTO tb_orders (catalogue_id, phone_number, wedding_date, status, notes, user_id, created_at, updated_at) 
            VALUES ('$catalogue_id', '$phone_number', '$wedding_date', 'requested', '$notes', '$user_id', NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully.";
        header('Location: check_status.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
            <form method="POST" action="order.php?id=<?php echo $catalogue['catalogue_id']; ?>" class="space-y-4">
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
            <h4 class="text-xl font-bold mb-2"><?php echo $catalogue['package_name']; ?></h4>
            <p class="text-gray-700 mb-4"><?php echo $catalogue['description']; ?></p>
            <p class="text-gray-800 font-semibold mb-2">Harga: <?php echo formatRupiah($catalogue['price']); ?></p>
            <p class="text-gray-700">Kategori: <?php echo $catalogue['category']; ?></p>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
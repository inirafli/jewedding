<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

function formatRupiah($price)
{
    return "Rp. " . number_format($price, 0, ',', '.');
}

// Inisialisasi variabel untuk filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// SQL query dasar
$sql = "SELECT o.*, c.package_name, c.price, u.name AS customer_name 
        FROM tb_orders o 
        JOIN tb_catalogues c ON o.catalogue_id = c.catalogue_id 
        JOIN tb_users u ON o.user_id = u.user_id";

// Menambahkan kondisi filter ke SQL query
if ($filter == 'latest') {
    $sql .= " ORDER BY o.created_at DESC";
} elseif ($filter == 'highest_price') {
    $sql .= " ORDER BY c.price DESC";
} elseif ($filter == 'approved') {
    $sql .= " WHERE o.status = 'approved'";
}

$result = $conn->query($sql);

// Hitung total harga pesanan yang statusnya approved
$total_price = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'approved') {
            $total_price += $row['price'];
        }
    }
    // Reset pointer untuk loop kedua
    $result->data_seek(0);
}
?>

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold text-center mb-12">Laporan Pesanan</h2>

    <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
        <p class="text-lg font-semibold mb-2 md:mb-0">Total Penjualan: <?php echo formatRupiah($total_price); ?></p>
        <div class="flex items-center">
            <label for="filter" class="mr-2">Filter:</label>
            <select id="filter" onchange="applyFilter()" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="" <?php echo $filter == '' ? 'selected' : ''; ?>>Semua</option>
                <option value="latest" <?php echo $filter == 'latest' ? 'selected' : ''; ?>>Terbaru</option>
                <option value="highest_price" <?php echo $filter == 'highest_price' ? 'selected' : ''; ?>>Harga Tertinggi</option>
                <option value="approved" <?php echo $filter == 'approved' ? 'selected' : ''; ?>>Status Approved</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-primary text-onAccent">
                <tr>
                    <th class="py-2 px-4 border-b">No</th>
                    <th class="py-2 px-4 border-b">Nama Paket</th>
                    <th class="py-2 px-4 border-b">Harga</th>
                    <th class="py-2 px-4 border-b">Nama Pemesan</th>
                    <th class="py-2 px-4 border-b">Nomor Telepon</th>
                    <th class="py-2 px-4 border-b">Tanggal Pernikahan</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $row_class = $no % 2 == 0 ? 'bg-gray-100' : 'bg-white';
                        echo "<tr class='{$row_class}'>";
                        echo "<td class='py-2 px-4 border-b text-center'>{$no}</td>";
                        echo "<td class='py-2 px-4 border-b'>{$row['package_name']}</td>";
                        echo "<td class='py-2 px-4 border-b'>" . formatRupiah($row['price']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>{$row['customer_name']}</td>";
                        echo "<td class='py-2 px-4 border-b'>{$row['phone_number']}</td>";
                        echo "<td class='py-2 px-4 border-b'>{$row['wedding_date']}</td>";
                        echo "<td class='py-2 px-4 border-b text-center'>" . ucfirst($row['status']) . "</td>";
                        echo "<td class='py-2 px-4 border-b'>{$row['created_at']}</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='py-2 px-4 border-b text-center'>Tidak ada data pesanan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function applyFilter() {
        var filter = document.getElementById('filter').value;
        window.location.href = 'report.php?filter=' + filter;
    }
</script>

<?php include('../includes/footer.php'); ?>
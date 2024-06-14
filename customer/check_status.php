<?php
include('../includes/middleware.php');
checkRole('customer');
include('../includes/header.php');
include('../includes/db.php');

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$sql = "SELECT o.*, c.package_name, c.description, c.price, c.category, c.image 
        FROM tb_orders o 
        JOIN tb_catalogues c ON o.catalogue_id = c.catalogue_id 
        WHERE o.user_id = '$user_id'";
$result = $conn->query($sql);
?>

<h2>Order Status Page</h2>
<p>Selamat datang di halaman Status Pemesanan.</p>

<div class="order-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order-card'>";
            echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "'>";
            echo "<h4>" . $row['package_name'] . "</h4>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . "</p>";
            echo "<p>Category: " . $row['category'] . "</p>";
            echo "<p>Wedding Date: " . $row['wedding_date'] . "</p>";
            echo "<p>Status: " . ucfirst($row['status']) . "</p>";
            echo "<p>Notes: " . $row['notes'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "No orders found.";
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
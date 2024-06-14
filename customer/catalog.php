<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

$sql = "SELECT * FROM tb_catalogues WHERE availability = 'Y'";
$result = $conn->query($sql);
?>

<h2>Catalogue List</h2>
<div class="catalogue-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='catalogue-card'>";
            echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "'>";
            echo "<h4>" . $row['package_name'] . "</h4>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . "</p>";
            echo "<p>Category: " . $row['category'] . "</p>";
            echo "<a href='order.php?id=" . $row['catalogue_id'] . "' class='btn'>Pilih Paket</a>";
            echo "</div>";
        }
    } else {
        echo "No catalogues available.";
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
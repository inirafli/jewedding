<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

$sql = 'SELECT * FROM tb_catalogues';
$result = $conn->query($sql);
?>

<h2>Admin Dashboard</h2>
<p>Selamat datang di dashboard admin.</p>

<a href="add_catalogue.php">Add New Catalogue</a>

<h3>Catalogue List</h3>
<<div class="catalogue-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='catalogue-card'>";
            echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "'>";
            echo "<h4>" . $row['package_name'] . "</h4>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . "</p>";
            echo "<p>Category: " . $row['category'] . "</p>";
            echo "<p>Availability: " . ($row['availability'] == 'Y' ? 'Yes' : 'No') . "</p>";
            echo "<a href='update_catalogue.php?id=" . $row['catalogue_id'] . "'>Edit</a> | ";
            echo "<a href='delete_catalogue.php?id=" . $row['catalogue_id'] . "' onclick='return confirm(\"Are you sure you want to delete this catalogue?\");'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "No catalogues found.";
    }
    ?>
    </div>

    <?php include('../includes/footer.php'); ?>
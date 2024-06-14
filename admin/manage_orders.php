    <?php
    include('../includes/middleware.php');
    checkRole('admin');
    include('../includes/header.php');
    include('../includes/db.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        $sql = "UPDATE tb_orders SET status='$status', updated_at=NOW() WHERE order_id='$order_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Order status updated successfully.";
        } else {
            echo "Error updating status: " . $conn->error;
        }
    }

    $sql = "SELECT o.*, u.name, u.email, c.package_name, c.description, c.price, c.category, c.image 
            FROM tb_orders o 
            JOIN tb_users u ON o.user_id = u.user_id 
            JOIN tb_catalogues c ON o.catalogue_id = c.catalogue_id";
    $result = $conn->query($sql);
    ?>

    <h2>Manage Orders</h2>
    <p>Manage the status of customer orders.</p>

    <div class="order-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='order-card'>";
                echo "<img src='../assets/images/" . $row['image'] . "' alt='" . $row['package_name'] . "'>";
                echo "<h4>" . $row['package_name'] . "</h4>";
                echo "<p><strong>Customer Name:</strong> " . $row['name'] . "</p>";
                echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p><strong>Price:</strong> " . $row['price'] . "</p>";
                echo "<p><strong>Category:</strong> " . $row['category'] . "</p>";
                echo "<p><strong>Wedding Date:</strong> " . $row['wedding_date'] . "</p>";
                echo "<p><strong>Status:</strong> " . ucfirst($row['status']) . "</p>";
                echo "<p><strong>Notes:</strong> " . $row['notes'] . "</p>";

                echo "<form method='POST' action='manage_orders.php'>";
                echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                echo "<label for='status'>Change Status:</label>";
                echo "<select name='status'>";
                echo "<option value='requested'" . ($row['status'] == 'requested' ? ' selected' : '') . ">Requested</option>";
                echo "<option value='approved'" . ($row['status'] == 'approved' ? ' selected' : '') . ">Approved</option>";
                echo "<option value='rejected'" . ($row['status'] == 'rejected' ? ' selected' : '') . ">Rejected</option>";
                echo "</select>";
                echo "<button type='submit'>Update Status</button>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "No orders found.";
        }
        ?>
    </div>

    <?php include('../includes/footer.php'); ?>
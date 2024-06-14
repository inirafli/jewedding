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

    // Get user details
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
?>

<h2>Order Form</h2>
<div class="order-container">
    <div class="order-form">
        <form method="POST" action="order.php?id=<?php echo $catalogue['catalogue_id']; ?>">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br>

            <label for="wedding_date">Wedding Date:</label>
            <input type="date" id="wedding_date" name="wedding_date" required><br>

            <label for="notes">Notes:</label>
            <textarea id="summernote" name="notes"></textarea><br>

            <button type="submit">Place Order</button>
        </form>
    </div>
    <div class="order-details">
        <h3>Selected Package</h3>
        <img src="../assets/images/<?php echo $catalogue['image']; ?>" alt="<?php echo $catalogue['package_name']; ?>">
        <h4><?php echo $catalogue['package_name']; ?></h4>
        <p><?php echo $catalogue['description']; ?></p>
        <p>Price: <?php echo $catalogue['price']; ?></p>
        <p>Category: <?php echo $catalogue['category']; ?></p>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
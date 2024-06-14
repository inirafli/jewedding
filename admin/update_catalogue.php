<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

if (isset($_GET['id'])) {
    $catalogue_id = $_GET['id'];

    $sql = "SELECT * FROM tb_catalogues WHERE catalogue_id='$catalogue_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $catalogue = $result->fetch_assoc();
        $old_image = $catalogue['image'];
    } else {
        echo "Catalogue not found.";
        exit();
    }
} else {
    echo "No catalogue ID provided.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];

    // Handle file upload if a new image is provided
    $uploadOk = 1;
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]);

                // Delete the old image file
                if (file_exists($target_dir . $old_image)) {
                    unlink($target_dir . $old_image);
                }

                $sql = "UPDATE tb_catalogues SET image='$image', package_name='$package_name', description='$description', price='$price', category='$category', availability='$availability', updated_at=NOW() WHERE catalogue_id='$catalogue_id'";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }
    } else {
        $sql = "UPDATE tb_catalogues SET package_name='$package_name', description='$description', price='$price', category='$category', availability='$availability', updated_at=NOW() WHERE catalogue_id='$catalogue_id'";
    }

    if ($uploadOk == 1 && $conn->query($sql) === TRUE) {
        header('Location: /jewedding/admin/dashboard.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Edit Catalogue</h2>
<form method="POST" action="update_catalogue.php?id=<?php echo $catalogue['catalogue_id']; ?>" enctype="multipart/form-data">
    <label for="package_name">Package Name:</label>
    <input type="text" id="package_name" name="package_name" value="<?php echo $catalogue['package_name']; ?>" required><br>

    <label for="description">Description:</label>
    <textarea id="summernote" name="description" required><?php echo $catalogue['description']; ?></textarea><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?php echo $catalogue['price']; ?>" required><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo $catalogue['category']; ?>" required><br>

    <label for="availability">Availability:</label>
    <select id="availability" name="availability" required>
        <option value="Y" <?php if ($catalogue['availability'] == 'Y') echo 'selected'; ?>>Yes</option>
        <option value="N" <?php if ($catalogue['availability'] == 'N') echo 'selected'; ?>>No</option>
    </select><br>

    <label for="image">Upload New Image (optional):</label>
    <input type="file" id="image" name="image"><br>

    <button type="submit">Update Catalogue</button>
</form>

<?php include('../includes/footer.php'); ?>
<?php
include('../includes/middleware.php');
checkRole('admin');
include('../includes/header.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];
    $user_id = $_SESSION['user_id'];

    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);

            // Insert data into database
            $sql = "INSERT INTO tb_catalogues (image, package_name, description, price, category, availability, user_id, created_at, updated_at) 
                    VALUES ('$image', '$package_name', '$description', '$price', '$category', '$availability', '$user_id', NOW(), NOW())";

            if ($conn->query($sql) === TRUE) {
                header('Location: /jewedding/admin/dashboard.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<h2>Add New Catalogue</h2>
<form method="POST" action="add_catalogue.php" enctype="multipart/form-data">
    <label for="package_name">Package Name:</label>
    <input type="text" id="package_name" name="package_name" required><br>

    <label for="description">Description:</label>
    <textarea id="summernote" name="description" required></textarea><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required><br>

    <label for="availability">Availability:</label>
    <select id="availability" name="availability" required>
        <option value="Y">Yes</option>
        <option value="N">No</option>
    </select><br>

    <label for="image">Upload Image:</label>
    <input type="file" id="image" name="image" required><br>

    <button type="submit">Add Catalogue</button>
</form>

<?php include('../includes/footer.php'); ?>
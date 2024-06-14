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

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold mb-8 text-center">Ubah Katalog</h2>
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <form method="POST" action="update_catalogue.php?id=<?php echo $catalogue['catalogue_id']; ?>" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="package_name" class="block text-sm font-medium text-gray-700">Nama Paket</label>
                <input type="text" id="package_name" name="package_name" value="<?php echo $catalogue['package_name']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="summernote" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required><?php echo $catalogue['description']; ?></textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" id="price" name="price" value="<?php echo $catalogue['price']; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                    <option value="Basic" <?php if ($catalogue['category'] == 'Basic') echo 'selected'; ?>>Basic</option>
                    <option value="Silver" <?php if ($catalogue['category'] == 'Silver') echo 'selected'; ?>>Silver</option>
                    <option value="Gold" <?php if ($catalogue['category'] == 'Gold') echo 'selected'; ?>>Gold</option>
                    <option value="Platinum" <?php if ($catalogue['category'] == 'Platinum') echo 'selected'; ?>>Platinum</option>
                </select>
            </div>
            <div>
                <label for="availability" class="block text-sm font-medium text-gray-700">Ketersediaan</label>
                <select id="availability" name="availability" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                    <option value="Y" <?php if ($catalogue['availability'] == 'Y') echo 'selected'; ?>>Tersedia</option>
                    <option value="N" <?php if ($catalogue['availability'] == 'N') echo 'selected'; ?>>Tidak Tersedia</option>
                </select>
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar Baru (opsional):</label>
                <div class="flex items-center justify-center w-full">
                    <label for="image" id="image-label" class="flex flex-col items-center justify-center w-full h-64 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200 hidden">
                        <i class="mdi mdi-camera-outline text-3xl text-gray-500"></i>
                        <span class="mt-2 text-sm text-gray-500">Click to add an image</span>
                        <input type="file" id="image" name="image" class="hidden" onchange="showImagePreview(event)">
                    </label>
                    <div id="image-preview" class="w-full h-64 rounded-lg overflow-hidden cursor-pointer" onclick="document.getElementById('image').click()">
                        <img src="../assets/images/<?php echo $old_image; ?>" alt="Image Preview" class="w-full h-64 object-cover">
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Ubah Katalog</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showImagePreview(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            img.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');

            const label = document.getElementById('image-label');
            label.classList.add('hidden');
        }
    }
</script>

<?php include('../includes/footer.php'); ?>
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

<div class="container mx-auto py-8">
    <h2 class="text-xl font-bold mb-8 text-center">Tambah Katalog</h2>
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <form method="POST" action="add_catalogue.php" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="package_name" class="block text-sm font-medium text-gray-700">Nama Paket</label>
                <input type="text" id="package_name" name="package_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="summernote" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required></textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" id="price" name="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                    <option value="Basic">Basic</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </div>
            <div>
                <label for="availability" class="block text-sm font-medium text-gray-700">Ketersediaan</label>
                <select id="availability" name="availability" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" required>
                    <option value="Y">Tersedia</option>
                    <option value="N">Tidak< Tersedia</option>
                </select>
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Masukan Gambar</label>
                <div class="flex items-center justify-center w-full">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200">
                        <i class="mdi mdi-camera-outline text-3xl text-gray-500"></i>
                        <span class="mt-2 text-sm text-gray-500">Klik untuk menambahkan Gambar</span>
                        <input type="file" id="image" name="image" class="hidden" required onchange="showImagePreview(event)">
                    </label>
                </div>
                <div id="image-preview" class="mt-4 hidden">
                    <img src="#" alt="Image Preview" class="w-full h-32 object-cover rounded-md">
                </div>
            </div>
            <div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Tambah Katalog</button>
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
        }
    }
</script>

<?php include('../includes/footer.php'); ?>
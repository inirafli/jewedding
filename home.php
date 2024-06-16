<?php
session_start();
include('includes/header.php');
include('includes/db.php');

$sql = "SELECT * FROM tb_settings LIMIT 1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<div class="relative bg-cover bg-center h-[60vh] mb-8 w-full" style="background-image: url('/jewedding/assets/wedding_header.jpg');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
        <h1 class="text-4xl font-bold mb-2">Selamat Datang di <?php echo $settings['website_name']; ?></h1>
        <p class="text-xl mb-4">Kami mewujudkan impian pernikahan Anda</p>
        <a href="/jewedding/customer/catalog.php" class="bg-secondary text-white px-4 py-2 rounded hover:bg-white hover:text-secondary transition">Lihat Katalog</a>
    </div>
</div>

<div class="container mx-auto py-8 px-4 lg:px-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="mdi mdi-star-circle-outline text-primary text-5xl"></i>
            <h3 class="text-xl font-bold mt-4 mb-2">Layanan Profesional</h3>
            <p class="text-gray-700">Menyediakan layanan pernikahan profesional dengan perhatian penuh terhadap detail.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="mdi mdi-cake text-primary text-5xl mb-4"></i>
            <h3 class="text-xl font-bold mt-4 mb-2">Paket Lengkap</h3>
            <p class="text-gray-700">Berbagai paket pernikahan lengkap yang bisa disesuaikan dengan kebutuhan Anda.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <i class="mdi mdi-calendar-check text-primary text-5xl mb-4"></i>
            <h3 class="text-xl font-bold mt-4 mb-2">Kemudahan Pemesanan</h3>
            <p class="text-gray-700">Proses pemesanan yang mudah dan cepat melalui platform online kami.</p>
        </div>
    </div>
</div>

<div class="w-full bg-primary text-white py-8 px-6 rounded-lg lg:px-16">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Kontak Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <p class="mb-2"><i class="mdi mdi-phone text-xl mr-2"></i> <?php echo $settings['phone_number1']; ?></p>
                <p class="mb-2"><i class="mdi mdi-phone text-xl mr-2"></i> <?php echo $settings['phone_number2']; ?></p>
                <p class="mb-2"><i class="mdi mdi-email text-xl mr-2"></i> <?php echo $settings['email1']; ?></p>
                <p class="mb-2"><i class="mdi mdi-email text-xl mr-2"></i> <?php echo $settings['email2']; ?></p>
                <p class="mb-2"><i class="mdi mdi-map-marker text-xl mr-2"></i> <?php echo $settings['address']; ?></p>
                <p class="mb-2"><i class="mdi mdi-store-clock text-xl mr-2"></i> <?php echo $settings['time_business_hour']; ?></p>
                <div class="flex space-x-6 mt-6">
                    <a href="mailto:<?php echo $settings['email1']; ?>" class="icon-button">
                        <i class="mdi mdi-email text-xl"></i>
                    </a>
                    <a href="<?php echo $settings['facebook_url']; ?>" class="icon-button" target="_blank">
                        <i class="mdi mdi-facebook text-xl"></i>
                    </a>
                    <a href="<?php echo $settings['Instagram_url']; ?>" class="icon-button" target="_blank">
                        <i class="mdi mdi-instagram text-xl"></i>
                    </a>
                    <a href="<?php echo $settings['youtube_url']; ?>" class="icon-button" target="_blank">
                        <i class="mdi mdi-youtube text-xl"></i>
                    </a>
                </div>
            </div>
            <div class="overflow-hidden rounded-lg">
                <iframe src="<?php echo $settings['maps']; ?>" width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
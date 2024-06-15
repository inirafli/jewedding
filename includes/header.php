<?php
ob_start();
include($_SERVER['DOCUMENT_ROOT'] . '/jewedding/includes/db.php');

$sql = "SELECT * FROM tb_settings LIMIT 1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JeWedding<?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? ' - Admin' : ''; ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- MdiIcons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">


    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 120,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']]
                ]
            });
        });
    </script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Karla', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1f2937',
                        secondary: '#6b7280',
                        accent: '#f3f4f6',
                        onAccent: '#f8fafc',
                    },
                },
            },
        };
    </script>
</head>

<body class="bg-accent text-primary font-sans min-h-screen flex flex-col">
    <header class="bg-primary text-white font-bold fixed w-full top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center">
                <img src="<?php echo $settings['logo']; ?>" alt="Logo" class="absolute h-[64px] w-[64px]">
                <h1 class="ml-16 text-xl"><?php echo $settings['website_name']; ?><?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? ' - Admin' : ''; ?></h1>
            </div>
            <nav class="hidden md:flex space-x-4">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <a href="/jewedding/admin/dashboard.php" class="relative px-3 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Dashboard</a>
                    <a href="/jewedding/admin/manage_orders.php" class="relative px-3 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Kelola Status Pesanan</a>
                    <a href="/jewedding/admin/report.php" class="relative px-3 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Laporan</a>
                <?php else : ?>
                    <a href="/jewedding/home.php" class="relative px-4 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Beranda</a>
                    <a href="/jewedding/customer/catalog.php" class="relative px-4 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Katalog</a>
                    <a href="/jewedding/customer/check_status.php" class="relative px-4 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Cek Status Pesanan</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role'])) : ?>
                    <a href="/jewedding/logout.php" class="relative px-4 py-2 rounded-lg hover:bg-white hover:text-primary transition-all">Logout</a>
                <?php endif; ?>
            </nav>
            <button class="md:hidden text-white focus:outline-none" onclick="toggleMobileMenu()">
                <i class="mdi mdi-menu mdi-24px"></i>
            </button>
        </div>
        <nav id="mobile-menu" class="hidden md:hidden bg-primary text-white space-y-4 px-6 pb-4">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="/jewedding/admin/dashboard.php" class="block">Dashboard</a>
                <a href="/jewedding/admin/manage_orders.php" class="block">Kelola Status Pesanan</a>
                <a href="/jewedding/admin/report.php" class="block">Laporan</a>
            <?php else : ?>
                <a href="/jewedding/home.php" class="block">Beranda</a>
                <a href="/jewedding/customer/catalog.php" class="block">Katalog</a>
                <a href="/jewedding/customer/check_status.php" class="block">Cek Status Pesanan</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role'])) : ?>
                <a href="/jewedding/logout.php" class="block">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <script>
            function toggleMobileMenu() {
                var menu = document.getElementById('mobile-menu');
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                } else {
                    menu.classList.add('hidden');
                }
            }
        </script>
</body>


</html>
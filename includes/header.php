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
                height: 120, // Adjust the height as needed
                toolbar: [
                    // Customize the toolbar
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
    <header class="bg-primary text-white font-bold">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center">
                <img src="../assets/images/logo-placeholder.png" alt="Logo" class="h-10 w-10">
                <h1 class="ml-3 text-xl">JeWedding<?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? ' - Admin' : ''; ?></h1>
            </div>
            <nav class="hidden md:flex space-x-8">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <a href="/jewedding/admin/dashboard.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Dashboard</a>
                    <a href="/jewedding/admin/manage_orders.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Kelola Status Pesanan</a>
                    <a href="/jewedding/admin/report.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Laporan</a>
                <?php else : ?>
                    <a href="/jewedding/home.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Beranda</a>
                    <a href="/jewedding/customer/catalog.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Katalog</a>
                    <a href="/jewedding/customer/check_status.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Cek Status Pesanan</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role'])) : ?>
                    <a href="/jewedding/logout.php" class="relative hover:bg-white hover:text-primary px-3 py-2">Logout</a>
                <?php endif; ?>
            </nav>
            <button class="md:hidden text-white focus:outline-none" onclick="toggleMobileMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
        <nav id="mobile-menu" class="hidden md:hidden bg-primary text-white space-y-2 px-6 pb-4">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="/jewedding/admin/dashboard.php" class="block hover:underline">Dashboard</a>
                <a href="/jewedding/admin/manage_orders.php" class="block hover:underline">Kelola Status Pesanan</a>
                <a href="/jewedding/admin/report.php" class="block hover:underline">Laporan</a>
            <?php else : ?>
                <a href="/jewedding/home.php" class="block hover:underline">Beranda</a>
                <a href="/jewedding/customer/catalog.php" class="block hover:underline">Katalog</a>
                <a href="/jewedding/customer/check_status.php" class="block hover:underline">Cek Status Pesanan</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role'])) : ?>
                <a href="/jewedding/logout.php" class="block hover:underline">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container mx-auto p-6 flex-grow">
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JeWedding<?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? ' - Admin' : ''; ?></title>
    <link rel="stylesheet" href="../assets/styles/index.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#summernote").summernote({
                height: 250,
            });
            $(".dropdown-toggle").dropdown();
        });
    </script>
</head>

<body>
    <header>
        <h1>JeWePe Wedding Organizer<?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? ' - Admin' : ''; ?></h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <li><a href="/jewedding/admin/dashboard.php">Dashboard</a></li>
                    <li><a href="/jewedding/admin/manage_orders.php">Kelola Status Pesanan</a></li>
                    <li><a href="/jewedding/admin/report.php">Laporan</a></li>
                <?php else : ?>
                    <li><a href="/jewedding/home.php">Beranda</a></li>
                    <li><a href="/jewedding/customer/catalog.php">Katalog</a></li>
                    <li><a href="/jewedding/customer/check_status.php">Cek Status Pesanan</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role'])) : ?>
                    <li><a href="/jewedding/logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
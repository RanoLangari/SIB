<?php
require('../config.php');
if (!isset($_SESSION["user"])) {
    header("Location: ../NotFound.php");
    exit;
}

if (!isset($_POST["id_keranjang"])) {
    echo "<script>
    alert('Mohon Ceklis Produk Yang Ingin Dibeli');
    document.location.href = 'keranjang.php';
    </script>";
}

if (($_POST["metodePembayaran"]) === "Pilih Metode Pembayaran") {
    echo "<script>
    alert('Mohon Pilih Metode Pembayaran yang dimau');
    document.location.href = 'keranjang.php';
    </script>";
}



$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
$row = mysqli_fetch_assoc($result);
$metodePembayaran = $_POST["metodePembayaran"];
$tokenPesanan = $_POST["tokenPesanan"];

if (isset($_POST["checkout"])) {
    addPesanan($_POST);
}

if (isset($_POST['UploadBuktiPembayaran'])) {
    if (uploadBuktiPembayaran($_POST) > 0) {
        echo "<script>
        alert('Bukti Pembayaran Berhasil Diupload');
        document.location.href = 'Pesanan.php';
        </script>";
    } else {
    }
}

$total = $_POST["id_keranjang"];

foreach ($total as $data) {
    // query untuk mendapatkan nilai dari atribut jumlah order pada keranjang
    $query = mysqli_query($conn, "SELECT * FROM keranjang LEFT JOIN orderan ON keranjang.id_barang = orderan.id_produk  WHERE id_keranjang = $data");
    $rowData = mysqli_fetch_assoc($query);
    $jumlah_order = $rowData["jumlah_order"] * $rowData["harga"];
    $total_harga[] = $jumlah_order;
}

$totalBayar = array_sum($total_harga);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/keranjangstyle.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v2/toolkit.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="../index.php">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>User Menu</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="keranjang.php"><i class="fas fa-cart-plus"></i><span>Keranjang</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="Pesanan.php"><i class=""></i><span>Pesanan</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php"><i class="fas fa-home"></i><span>Halaman Utama</span></a></li>

                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>

            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?= $row["username"] ?></span><?php echo "<img class='border rounded-circle img-profile' src='assets/img/profile/" . $row['gambar'] . "''>"; ?></a>

                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href=""><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <?php if ($metodePembayaran === "cod") : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <p>Terimakasih telah berbelanja di toko kami, silahkan lakukan pembayaran dengan metode COD (Cash On Delivery) dengan membayar langsung kepada kurir kami saat barang sampai.</p>
                                    <p>Setelah melakukan pembayaran, silahkan upload bukti pembayaran di bawah, informasi mengenai pemesanan dapat dilihat di <a href="Pesanan.php">Halaman Pemesanan</a> yang terdapat di sidebar</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($metodePembayaran === "bank") : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <p>Terimakasih telah berbelanja di toko kami, Mohon Lakukan Pembayaran sebesar <strong>Rp.<?= number_format($totalBayar, 0, ',', '.') ?></strong> dengan metode transfer ke Nomor Rekening bank berikut :</p>
                                    <p>Bank BCA : 1234567890</p>
                                    <p>Bank Mandiri : 0987654321</p>
                                    <p>Bank BNI : 1234567890</p>
                                    <p>Bank BRI : 0987654321</p>
                                    <p>Setelah melakukan pembayaran, silahkan upload bukti pembayaran di bawah, informasi mengenai pemesanan dapat dilihat di <a href="Pesanan.php">Halaman Pemesanan</a> yang terdapat di sidebar</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Upload Bukti Pembayaran</p>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="tokenPesanan" value="<?= $tokenPesanan ?>" hidden>
                                            <input type="hidden" name="id_user" value="<?= $id ?>" hidden>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="mb-3"><label class="form-label" for="bukti_pembayaran"><strong>Bukti Pembayaran</strong></label><input class="form-control" type="file" id="buktiPembayaran" name="gambar"></div>
                                                </div>

                                            </div>
                                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="Submit" name="UploadBuktiPembayaran">Simpan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($metodePembayaran === "dana") : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <h3 class="text-center">Pembayaran</h3>
                                    <!-- text danger -->
                                    <p>Terimakasih telah berbelanja di toko kami, Mohon Lakukan Pembayaran sebesar <strong>Rp.<?= number_format($totalBayar, 0, ',', '.') ?></strong> dengan metode transfer ke Nomor Dana berikut :</p>
                                    <p>Dana : 1234567890</p>
                                    <p>Setelah melakukan pembayaran, silahkan upload bukti pembayaran di bawah, informasi mengenai pemesanan dapat dilihat di <a href="Pesanan.php">Halaman Pemesanan</a> yang terdapat di sidebar</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Upload Bukti Pembayaran</p>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_user" value="<?= $id ?>" hidden>
                                            <input type="hidden" name="tokenPesanan" value="<?= $tokenPesanan ?>" hidden>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="mb-3"><label class="form-label" for="bukti_pembayaran"><strong>Bukti Pembayaran</strong></label><input class="form-control" type="file" id="buktiPembayaran" name="gambar"></div>
                                                </div>

                                            </div>
                                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="Submit" name="UploadBuktiPembayaran">Simpan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>




                </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
            </div>

            <script src="assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="assets/js/bs-init.js"></script>
            <script src="assets/js/theme.js"></script>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
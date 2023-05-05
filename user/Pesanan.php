<?php
require('../config.php');
if (!isset($_SESSION["user"])) {
    header("Location: ../NotFound.php");
    exit;
}
$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
$row = mysqli_fetch_assoc($result);

$queryConcatTokenPesanan = mysqli_query($conn, "SELECT token_pesanan, GROUP_CONCAT(CONCAT('<li>',token_pesanan,'</li>') SEPARATOR '') AS token_pesanan FROM pesanan WHERE id_user = $id GROUP BY token_pesanan");
$concatTokenPesanan = mysqli_fetch_assoc($queryConcatTokenPesanan);


if (isset($_POST['ubahBuktiPembayaran'])) {
    if (ubahBuktiPembayaran($_POST) > 0) {
        echo "<script>
        alert('Bukti Pembayaran Berhasil Diupload');
        document.location.href = 'Pesanan.php';
        </script>";
    } else {
        echo "<script>
        alert('Bukti Pembayaran Gagal Diupload');
        document.location.href = 'Pesanan.php';
        </script>";
    }
}

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
                    <li class="nav-item"><a class="nav-link" href="keranjang.php"><i class="fas fa-cart-plus"></i><span>Keranjang</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="Pesanan.php"><i class=""></i><span>Pesanan</span></a></li>
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
                    <h3 class="text-dark mb-4">Pesanan</h3>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Produk Yang Diorder</th>
                                    <th>Total Harga Per Produk</th>
                                    <th>Total Harga</th>
                                    <th>Alamat</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                $id = $_SESSION['id'];
                                $queryConcatTokenPesanan = mysqli_query($conn, "SELECT pesanan.id_pesanan, orderan.harga, pesanan.jumlah_pesanan,pesanan.alamat,pesanan.metode_pembayaran,pesanan.bukti_pembayaran,pesanan.status_pembayaran,pesanan.status_pengiriman,pesanan.token_pesanan, GROUP_CONCAT(CONCAT('<li>',orderan.nama ,'<b> - </b>', pesanan.jumlah_pesanan,' pcs </li>') SEPARATOR '') AS id_produk, GROUP_CONCAT(CONCAT('<li>','Rp.',orderan.harga * pesanan.jumlah_pesanan,'</li>') SEPARATOR '') AS total_harga FROM pesanan INNER JOIN orderan ON pesanan.id_produk = orderan.id_produk WHERE pesanan.id_user = $id GROUP BY pesanan.token_pesanan ORDER BY pesanan.id_pesanan DESC");


                                while ($row = mysqli_fetch_array($queryConcatTokenPesanan)) {
                                ?>

                                    <tr>
                                        <td class="Produk yang diorder"><?php echo $row['id_produk']; ?></td>
                                        <td class="totalPerProduk"><?php echo $row['total_harga'] ?></td>
                                        <td>
                                            <?php
                                            $queryTotal = mysqli_query($conn, "SELECT SUM(harga * jumlah_pesanan) AS total_harga FROM pesanan INNER JOIN orderan ON pesanan.id_produk = orderan.id_produk WHERE pesanan.id_user = $id AND pesanan.token_pesanan = '$row[token_pesanan]'");
                                            $rowTotal = mysqli_fetch_array($queryTotal);
                                            echo "Rp." . $rowTotal['total_harga'];
                                            ?>
                                        </td>
                                        <td><?php echo $row['alamat']; ?></td>
                                        <td><?php echo $row['metode_pembayaran']; ?></td>
                                        <td><?php echo "<img style='width: 100px; height: 100px;' src='assets/img/profile/" . $row['bukti_pembayaran'] . "''>"; ?></td>
                                        <td><?php echo $row['status_pembayaran']; ?></td>
                                        <td><?php echo $row['status_pengiriman']; ?></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#edit<?= $row["id_pesanan"]; ?>" class="btn btn-primary">Ganti Bukti Pembayaran</button>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="edit<?= $row["id_pesanan"]; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">UBAH DATA</h4>
                                                    </div>
                                                    <!-- Body -->
                                                    <div class="modal-body">
                                                        <div class="card shadow mb-3">
                                                            <div class="card-header py-3">
                                                                <p class="text-primary m-0 fw-bold">Upload Bukti Pembayaran</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="hidden" name="tokenPesanan" value="<?= $row['token_pesanan'] ?>" hidden>
                                                                <div class="row">
                                                                    <div class="row">
                                                                        <div class="mb-3"><label class="form-label" for="bukti_pembayaran"><strong>Bukti Pembayaran</strong></label><input class="form-control" type="file" id="buktiPembayaran" name="gambar"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-warning" name="ubahBuktiPembayaran" style="border-radius: 0;">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Edit Data -->
                                <?php } ?>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright ©BetaGlowing Shop 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>


    <script>
        $(document).ready(function() {
            $('.totalHarga').each(function() {
                var total = 0,
                    harga = $(this).closest('tr').find('.harga').text(),
                    jumlah = $(this).closest('tr').find('.jumlah').text();
                total = harga * jumlah;
                $(this).text(total);
            });
        });
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
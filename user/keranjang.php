<?php
require('../config.php');
if (!isset($_SESSION["user"])) {
    header("Location: ../NotFound.php");
    exit;
}
$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
$row = mysqli_fetch_assoc($result);

$dataKeranjang = mysqli_query($conn, "SELECT * FROM keranjang 
INNER JOIN orderan ON keranjang.id_barang = orderan.id_produk
WHERE id_user = $id ORDER BY id_keranjang DESC");

$tokenPesanan = getToken(20);

if (isset($_POST["UbahDataOrder"])) {
    if (ubahDataOrder($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah');
                document.location.href = 'keranjang.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah');
                document.location.href = 'keranjang.php';
            </script>
        ";
    }
}

if (isset($_POST["hapusDataOrder"])) {
    if (hapusDataOrder($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'keranjang.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Dihapus');
                document.location.href = 'keranjang.php';
            </script>
        ";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Keranjang - User</title>
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
                    <li class="nav-item"><a class="nav-link" href="Pesanan.php"><i class="fas fa-clipboard-list"></i><span>Pesanan</span></a></li>
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?= $row["username"] ?></span><?php if (empty($row['gambar'])) : ?>
                                            <img class="border rounded-circle img-profile" src="../img/user.png"></a>
                                <?php else : ?>
                                    <?= "<img class='border rounded-circle img-profile' src='assets/img/profile/" . $row['gambar'] . "''>"; ?></a>
                                <?php endif; ?>

                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href=""><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                <?php while ($myKeranjang = mysqli_fetch_assoc($dataKeranjang)) : ?>
                                    <?php
                                    $totalHarga = $myKeranjang["jumlah_order"] * $myKeranjang["harga"]
                                    ?>
                                    <tr>
                                        <td><?= $myKeranjang["nama"] ?></td>
                                        <td>
                                            <?= $myKeranjang["jumlah_order"] ?> || <button data-toggle="modal" data-target="#edit<?= $myKeranjang["id_keranjang"]; ?>" class="btn btn-warning"><i class="fa fa-pen fa-xs"></i></button>
                                        </td>
                                        <td>Rp.<?= $myKeranjang["harga"] ?></td>
                                        <td>Rp.<?= $totalHarga  ?></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#hapus<?= $myKeranjang["id_keranjang"]; ?>" class="btn btn-danger"><i class="fa fa-trash fa-xs"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="edit<?= $myKeranjang["id_keranjang"]; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">UBAH DATA</h4>
                                                    </div>
                                                    <!-- Body -->
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_barang" value="<?= $myKeranjang["id_keranjang"]; ?>">
                                                        <div class="form-group">
                                                            <label for="nama">Nama</label>
                                                            <input type="text" id="nama" name="nama_barang" class="form-control" value="<?= $myKeranjang['nama'] ?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jumlah_order">Jumlah</label>
                                                            <input type="number" id="jumlah_order" name="jumlah_order" class="form-control" value="<?= $myKeranjang['jumlah_order'] ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-warning" name="UbahDataOrder" style="border-radius: 0;">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Edit Data -->
                                    <!-- Modal hapus Data -->
                                    <div class="modal fade" id="hapus<?= $myKeranjang["id_keranjang"]; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form method="post">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">HAPUS DATA
                                                            <?= $myKeranjang['nama'] ?> -
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Anda yakin ingin menghapus data ini?
                                                        <input type="hidden" name="id_barang" value="<?= $myKeranjang['id_keranjang']; ?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="hapusDataOrder" style="border-radius: 0;">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal hapus Data -->
                                <?php endwhile; ?>
                            </table>

                        </div>
                        <?php
                        $Keranjang = mysqli_query($conn, "SELECT * FROM keranjang 
                            INNER JOIN orderan ON keranjang.id_barang = orderan.id_produk
                            WHERE id_user = $id");
                        ?>
                        <div class="card-footer">
                            <a data-toggle="modal" data-target="<?php if (mysqli_num_rows($Keranjang) > 0) : ?>
                                #checkout
                            <?php else : ?>
                                #checkoutKosong
                            <?php endif; ?>" class="btn btn-success">Checkout</a>
                        </div>
                        <!-- Modal Checkout -->
                        <div class="modal fade" id="checkout">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="Pembayaran.php">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Checkout</h4>
                                        </div>
                                        <!-- Body -->
                                        <div class="modal-body">
                                            <p>Silahkan Centang Produk Yang Ingin di Checkout </p>
                                            <div class="card-body">

                                                <?php while ($checkOut = mysqli_fetch_assoc($Keranjang)) : ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="<?= $checkOut['id_keranjang'] ?>" id="defaultCheck1" name="id_keranjang[]">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            <?= $checkOut['nama'] ?> - <?= $checkOut['jumlah_order'] ?> Pcs - Rp.<?= $checkOut['jumlah_order'] * $checkOut['harga'] ?>
                                                        </label>
                                                    </div>
                                                <?php endwhile; ?>
                                            </div>
                                            <div>

                                                <input type="hidden" name="id_user" value="<?= $id ?>">
                                                <input type="hidden" name="tokenPesanan" value="<?= $tokenPesanan ?>">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" id="alamat" name="alamat" class="form-control-file" required>
                                                <label for="noHp">Nomor Hp Yang Bisa Dihubungi</label>
                                                <input type="text" id="noHp" name="noHp" class="form-control-file" required>
                                                <label for="namaPenerima">Nama Penerima</label>
                                                <input type="text" id="namaPenerima" name="namaPenerima" class="form-control-file" required>
                                                <label for="metodePembayaran">Metode Pembayaran</label>
                                                <select class="form-select" aria-label="Default select example" name="metodePembayaran">
                                                    <option value="" selected>Pilih Metode Pembayaran</option>
                                                    <option value="dana">Dana</option>
                                                    <option value="bank">Transfer Bank</option>
                                                    <option value="cod">COD</option>
                                                </select>
                                            </div>

                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                            <button type="submit" class="btn btn-warning" name="checkout" style="border-radius: 0;">Checkout</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Checkout -->

                        <!-- Modal checkoutKosong -->
                        <div class="modal fade" id="checkoutKosong">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">CheckOut Produk</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tidak Ada Produk di Keranjang</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal checkoutKosong -->

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

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
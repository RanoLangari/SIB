<?php
require('../config.php');
if (!isset($_SESSION["admin"])) {
    header("Location: ../NotFound.php");
    exit;
}
$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
$row = mysqli_fetch_assoc($result);


if (isset($_POST['ubahPengirimanPembayaran'])) {
    if (ubahPengirimanPembayaran($_POST) > 0) {
        echo "<script>
        alert('Data berhasil diubah');
        document.location.href = 'Pesanan.php';
        </script>";
    } else {
        echo "<script>
        alert('Data gagal diubah');
        document.location.href = 'Pesanan.php';
        </script>";
    }
}

if (isset($_POST['hapusDataPesanan'])) {
    if (hapusDataPesanan($_POST) > 0) {
        echo "<script>
        alert('Data berhasil dihapus');
        document.location.href = 'Pesanan.php';
        </script>";
    } else {
        echo "<script>
        alert('Data gagal dihapus');
        document.location.href = 'Pesanan.php';
        </script>";
    }
}

if (isset($_POST['clearAll'])) {
    if (clearAllNotification($_POST) > 0) {
        echo "
            <script>
                document.location.href = 'profile.php';
            </script>
        ";
    } else {
        echo "
            <script>
                document.location.href = 'profile.php';
            </script>
        ";

        mysqli_error($conn);
    }
}

$queryTotalNotification = mysqli_query($conn, "SELECT COUNT(*) as totalNotif FROM pesanan WHERE status_notifikasi = '1'");
$rowNotification = mysqli_fetch_assoc($queryTotalNotification);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Pesanan - Admin</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/keranjangstyle.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v2/toolkit.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .fullscreen {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            animation: animate 0.7s;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.8);
            cursor: zoom-out;
        }

        .fullscreen img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="../index.php">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Admin Menu</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="produk.php"><i class="fas fa-list"></i><span>Produk</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="Pesanan.php"><i class="fas fa-clipboard-list"></i><span>Pesanan</span></a></li>
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
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter"><?= $rowNotification['totalNotif'] ?></span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <?php
                                        $queryNotification = mysqli_query($conn, "SELECT * FROM pesanan WHERE status_notifikasi = '1'");

                                        ?>
                                        <h6 class="dropdown-header">Notifikasi</h6>
                                        <?php if (mysqli_num_rows($queryNotification) == 0) : ?>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <p class="text-center">Tidak ada notifikasi</p>
                                            </a>
                                        <?php else : ?>
                                            <?php while ($dataNotifikasi = mysqli_fetch_assoc($queryNotification)) : ?>
                                                <a class="dropdown-item d-flex align-items-center" href="./Pesanan.php">
                                                    <div><span class="small text-gray-500">data</span>
                                                        <p>Ada Pesanan Baru!</p>
                                                    </div>
                                                </a>
                                            <?php endwhile; ?>
                                            <form action="" method="post">
                                                <button type="submit" name="clearAll" class="dropdown-item text-center small text-gray-500">Hapus Notifikasi</button>
                                            </form>

                                        <?php endif; ?>

                                    </div>
                                </div>
                            </li>
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
                                    <th class="w-25">Produk Yang Diorder</th>
                                    <th class="w-25">Total Harga Per Produk</th>
                                    <th>Total Harga</th>
                                    <th>Nama Penerima</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Waktu Pesanan</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                $id = $_SESSION['id'];
                                $query = mysqli_query($conn, "SELECT pesanan.nama_penerima, pesanan.no_hp, pesanan.tgl_pesanan, pesanan.id_pesanan, orderan.harga, pesanan.jumlah_pesanan,pesanan.alamat,pesanan.metode_pembayaran,pesanan.bukti_pembayaran,pesanan.status_pembayaran,pesanan.status_pengiriman,pesanan.token_pesanan, GROUP_CONCAT(CONCAT('<li>',orderan.nama,'<b> - </b>', pesanan.jumlah_pesanan,' pcs </li>') SEPARATOR '') AS id_produk, GROUP_CONCAT(CONCAT('<li>','Rp.',orderan.harga * pesanan.jumlah_pesanan,'</li>') SEPARATOR '') AS total_harga FROM pesanan LEFT JOIN orderan ON pesanan.id_produk = orderan.id_produk  GROUP BY pesanan.token_pesanan ORDER BY pesanan.id_pesanan DESC");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['id_produk']; ?></td>
                                        <td><?php echo $row['total_harga']  ?></td>
                                        <td>
                                            <?php
                                            $queryTotal = mysqli_query($conn, "SELECT SUM(harga * jumlah_pesanan) AS total_harga FROM pesanan INNER JOIN orderan ON pesanan.id_produk = orderan.id_produk WHERE pesanan.token_pesanan = '$row[token_pesanan]'");
                                            $rowTotal = mysqli_fetch_array($queryTotal);
                                            echo "Rp." . $rowTotal['total_harga'];
                                            ?>
                                        </td>
                                        <td><?php echo $row['nama_penerima']; ?></td>
                                        <td><?php echo $row['no_hp']; ?></td>
                                        <td><?php echo $row['alamat']; ?></td>
                                        <td><?php echo $row['tgl_pesanan']; ?></td>
                                        <td><?php if ($row['bukti_pembayaran'] == NULL) {
                                                echo "Belum Ada Bukti Pembayaran";
                                            } else {
                                                echo "<a href='../user/assets/img/profile/" . $row['bukti_pembayaran'] . "' target='_blank'>Lihat Bukti Pembayaran</a>";
                                            } ?></td>
                                        <td><?php echo $row['metode_pembayaran']; ?></td>
                                        <td><?php echo $row['status_pembayaran']; ?></td>
                                        <td><?php echo $row['status_pengiriman']; ?></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#edit<?= $row["id_pesanan"]; ?>" class="btn btn-warning mb-3"><i class="fa fa-pen"></i></button>
                                            <button data-toggle="modal" data-target="#hapus<?= $row["id_pesanan"]; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="edit<?= $row["id_pesanan"]; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">UBAH DATA</h4>
                                                    </div>
                                                    <!-- Body -->
                                                    <div class="modal-body">
                                                        <input type="hidden" name="tokenPesanan" value="<?= $row["token_pesanan"]; ?>">
                                                        <select class="form-select" aria-label="Default select example" name="statusPembayaran" required>
                                                            <option value="" selected>Pilih Status Pembayaran</option>
                                                            <option value="Belum Dibayar">Belum Dibayar</option>
                                                            <option value="Sudah Dibayar">Sudah Dibayar</option>
                                                        </select>
                                                        <br>
                                                        <select class="form-select" aria-label="Default select example" name="statusPengiriman" required>
                                                            <option value="" selected>Pilih Status Pengiriman</option>
                                                            <option value="Belum Dikirim">Belum Dikirim</option>
                                                            <option value="Dalam Pengemasan">Dalam Pengemasan</option>
                                                            <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                                                            <option value="Sudah Dikirim">Sudah Dikirim</option>
                                                        </select>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-warning" name="ubahPengirimanPembayaran" style="border-radius: 0;">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Edit Data -->
                                    <!-- Modal hapus Data -->
                                    <div class="modal fade" id="hapus<?= $row["id_pesanan"]; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form method="post">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">HAPUS DATA

                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Anda yakin ingin menghapus data ini?
                                                        <ul>
                                                            <?= $row['id_produk'] ?>
                                                        </ul>
                                                        <input type="hidden" name="tokenPesanan" value="<?= $row['token_pesanan']; ?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="hapusDataPesanan" style="border-radius: 0;">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal hapus Data -->
                                <?php } ?>
                            </table>

                        </div>

                    </div>

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright ©BetaGlowing Shop 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>


    <script>
        const zoom = document.querySelectorAll('.zoom');

        zoom.forEach(function(img) {
            img.addEventListener('click', function() {
                // Buat elemen <div> baru untuk menampilkan gambar yang diperbesar
                const fullscreen = document.createElement('div');
                fullscreen.classList.add('fullscreen');

                // Buat elemen <img> baru dengan sumber gambar yang sama seperti gambar yang diperbesar
                const fullscreenImg = document.createElement('img');
                fullscreenImg.src = this.src;

                // Tambahkan elemen <img> ke elemen <div>
                fullscreen.appendChild(fullscreenImg);

                // Tambahkan elemen <div> ke body
                document.body.appendChild(fullscreen);

                // Hilangkan scrollbar pada body
                document.body.style.overflow = 'hidden';

                // Tambahkan event listener untuk menghapus elemen <div> ketika diklik atau esc key ditekan
                fullscreen.addEventListener('click', function() {
                    fullscreen.remove();
                    document.body.style.overflow = '';
                });

                document.addEventListener('keyup', function(e) {
                    if (e.key === 'Escape') {
                        fullscreen.remove();
                        document.body.style.overflow = '';
                    }
                });
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
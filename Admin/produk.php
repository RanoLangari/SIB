<?php
require("../config.php");

if (!isset($_SESSION["admin"])) {
    header("Location: ../NotFound.php");
    exit;
}

$id = $_SESSION["id"];
$row = query("SELECT * FROM user WHERE id = $id")[0];
$order = query("SELECT * FROM orderan ORDER BY id_produk DESC");

if (isset($_POST["TambahBrng"])) {
    if (TambahDataOrderan($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'produk.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'produk.php';
            </script>
        ";
    }
}

if (isset($_POST["UbahBrng"])) {
    if (UbahDataBarang($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah');
                document.location.href = 'produk.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah');
                document.location.href = 'produk.php';
            </script>
        ";
    }
}

if (isset($_POST["hapus"])) {
    if (HapusBarang($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'produk.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Dihapus');
                document.location.href = 'produk.php';
            </script>
        ";
    }
}


if (isset($_POST["AddExcel"])) {
    if (importData($_FILES['excel']) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan');
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
    <title>Produk - Admin</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Admin Menu</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="produk.php"><i class="fas fa-list"></i><span>Produk</span></a></li>
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?= $row["username"] ?></span><?php echo "<img class='border rounded-circle img-profile' src='assets/img/profile/" . $row['gambar'] . "''>"; ?></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href=""><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 20px;">
                        Tambah Data
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalExcel" style="margin-bottom: 20px; margin-left: 20px;">
                        Tambah Data Via EXCEL
                    </button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr style="text-align: center;">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>

                                <?php foreach ($order as $brng) : ?>
                                    <tr style="text-align: center;">
                                        <td><?= $i; ?></td>
                                        <td><?= $brng["nama"] ?></td>
                                        <td>
                                            <?php echo "<img src='assets/img/profile/" . $brng['gambar'] . "' width='100' height='100'>"; ?>
                                        </td>
                                        <td><?= $brng["jumlah"] ?></td>
                                        <td><?= $brng["harga"] ?></td>
                                        <td><?= $brng["kategori"] ?></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#edit<?= $brng["id_produk"]; ?>" class="btn btn-warning"><i class="fa fa-pen"></i></button> ||
                                            <button data-toggle="modal" data-target="#hapus<?= $brng["id_produk"]; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="edit<?= $brng["id_produk"]; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">UBAH DATA</h4>
                                                    </div>
                                                    <!-- Body -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $brng['nama'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gambar</label>
                                                            <input type="file" id="gambar" name="gambar" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah</label>
                                                            <input type="text" id="jumlah" name="jumlah" class="form-control" value="<?= $brng['jumlah'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="text" id="harga" name="harga" class="form-control" value="<?= $brng['harga'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="kategori" class="custom-select form-control">
                                                                <?php if ($brng['kategori'] == '') : ?>
                                                                    <option value="" selected>Pilih Kategori</option>
                                                                    <option value="serum">Serum</option>
                                                                    <option value="sunscreen">Sunscreen</option>
                                                                    <option value="pelembab">Pelembab</option>
                                                                    <option value="cleanser">Cleanser</option>
                                                                    <option value="toner">Toner</option>
                                                                <?php else : ?>
                                                                    <option value="<?= $brng['kategori'] ?>" selected><?= $brng['kategori'] ?></option>
                                                                    <option value="serum">Serum</option>
                                                                    <option value="sunscreen">Sunscreen</option>
                                                                    <option value="pelembab">Pelembab</option>
                                                                    <option value="cleanser">Cleanser</option>
                                                                    <option value="toner">Toner</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="id" value="<?= $brng["id_produk"]; ?>">
                                                        <input type="hidden" name="gambarlama" value="<?= $brng["gambar"] ?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-primary" name="UbahBrng" style="border-radius: 0;">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Edit Data -->
                                    <!-- Modal hapus Data -->
                                    <div class="modal fade" id="hapus<?= $brng["id_produk"]; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">

                                                    <!-- Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">HAPUS DATA
                                                            <?= $brng['nama'] ?> -
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Anda yakin ingin menghapus data ini?
                                                        <input type="hidden" name="id" value="<?= $brng['id_produk']; ?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 0;">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="hapus" style="border-radius: 0;">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal hapus Data -->
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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

    <!-- Modal tambah Data -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH DATA</h4>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input name="gambar" type="file" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah Barang" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input name="harga" type="number" class="form-control" placeholder="Harga Barang" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="custom-select form-control">
                                <option value="" selected>Pilih jenis</option>
                                <option value="serum">Serum</option>
                                <option value="sunscreen">Sunscreen</option>
                                <option value="pelembab">Pelembab</option>
                                <option value="cleanser">Cleanser</option>
                                <option value="toner">Toner</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="TambahBrng" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end tambah data modal -->

    <!-- Modal tambah Data via excel -->
    <div id="myModalExcel" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH DATA VIA EXCEL</h4>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File Excel</label>
                            <input type="file" name="excel" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="AddExcel" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end tambah data via excel modal -->

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
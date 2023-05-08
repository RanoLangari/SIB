<?php
require("../config.php");

if (!isset($_SESSION["admin"])) {
    header("Location: ../NotFound.php");
    exit;
}

$id = $_SESSION["id"];
$row = query("SELECT * FROM user WHERE id = $id")[0];

if (isset($_POST["Submit"])) {
    if (ubahdata($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah');
                document.location.href = 'profile.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah');
                document.location.href = 'profile.php';
            </script>
        ";
    }
}

if (isset($_POST['Simpan'])) {
    if (UbahPassword($_POST) > 0) {
        echo "
            <script>
                alert('Password Berhasil Diubah');
                document.location.href = 'profile.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Password Gagal Diubah');
                document.location.href = 'profile.php';
            </script>
        ";

        mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - Admin</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
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
                    <li class="nav-item"><a class="nav-link active" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="produk.php"><i class="fas fa-list"></i><span>Produk</span></a></li>
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
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Profile</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow">
                                    <?php echo "<img class='rounded-circle mb-3 mt-4' src='assets/img/profile/" . $row['gambar'] . "' width='160' height='160'>"; ?>
                                    <div class="mb-3"><label for="username"><?= $row['username'] ?></label></div>
                                </div>
                            </div>

                        </div>
                        <div class="col">
                            <div class="col">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Ubah Data Admin</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>" hidden>
                                                <input type="hidden" name="gambarlama" value="<?= $row['gambar'] ?>" hidden>

                                                <div class="row">
                                                    <div class="row">
                                                        <div class="mb-3"><label class="form-label" for="gambar"><strong>Gambar Profile</strong></label><input class="form-control" type="file" id="gambar" name="gambar"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Username</strong></label><input class="form-control" type="text" id="username" name="username" value="<?= $row['username'] ?>" required></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="email"><strong>Email Address</strong></label><input class="form-control" type="email" id="email" name="email" value="<?= $row['email'] ?>" required></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="Submit" name="Submit">Save Settings</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div clas="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Ganti Password</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="text" name="id" value="<?= $row['id'] ?>" hidden>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="oldPass"><strong>Masukan Password Lama</strong></label><input class="form-control" type="password" id="oldPass" name="oldPass" required></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="newPass"><strong>Masukan Password Baru</strong></label><input class="form-control" type="password" id="newPass" name="newPass" required></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="Submit" name="Simpan">Save Settings</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
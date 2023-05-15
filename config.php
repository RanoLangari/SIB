<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, "MIIDrzCCApegAwIBAgIQCDvgVpBCRrGhdWrJWZHHSjANBgkqhkiG9w0BAQUFADBh
MQswCQYDVQQGEwJVUzEVMBMGA1UEChMMRGlnaUNlcnQgSW5jMRkwFwYDVQQLExB3
d3cuZGlnaWNlcnQuY29tMSAwHgYDVQQDExdEaWdpQ2VydCBHbG9iYWwgUm9vdCBD
QTAeFw0wNjExMTAwMDAwMDBaFw0zMTExMTAwMDAwMDBaMGExCzAJBgNVBAYTAlVT
MRUwEwYDVQQKEwxEaWdpQ2VydCBJbmMxGTAXBgNVBAsTEHd3dy5kaWdpY2VydC5j
b20xIDAeBgNVBAMTF0RpZ2lDZXJ0IEdsb2JhbCBSb290IENBMIIBIjANBgkqhkiG
9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4jvhEXLeqKTTo1eqUKKPC3eQyaKl7hLOllsB
CSDMAZOnTjC3U/dDxGkAV53ijSLdhwZAAIEJzs4bg7/fzTtxRuLWZscFs3YnFo97
nh6Vfe63SKMI2tavegw5BmV/Sl0fvBf4q77uKNd0f3p4mVmFaG5cIzJLv07A6Fpt
43C/dxC//AH2hdmoRBBYMql1GNXRor5H4idq9Joz+EkIYIvUX7Q6hL+hqkpMfT7P
T19sdl6gSzeRntwi5m3OFBqOasv+zbMUZBfHWymeMr/y7vrTC0LUq7dBMtoM1O/4
gdW7jVg/tRvoSSiicNoxBN33shbyTApOB6jtSj1etX+jkMOvJwIDAQABo2MwYTAO
BgNVHQ8BAf8EBAMCAYYwDwYDVR0TAQH/BAUwAwEB/zAdBgNVHQ4EFgQUA95QNVbR
TLtm8KPiGxvDl7I90VUwHwYDVR0jBBgwFoAUA95QNVbRTLtm8KPiGxvDl7I90VUw
DQYJKoZIhvcNAQEFBQADggEBAMucN6pIExIK+t1EnE9SsPTfrgT1eXkIoyQY/Esr
hMAtudXH/vTBH1jLuG2cenTnmCmrEbXjcKChzUyImZOMkXDiqw8cvpOp/2PV5Adg
06O/nVsJ8dWO41P0jmP6P6fbtGbfYmbW0W5BjfIttep3Sp+dWOIrWcBAI+0tKIJF
PnlUkiaY4IBIqDfv8NZ5YBberOgOzW6sRBc4L0na4UU+Krk2U886UAb3LujEV0ls
YSEY1QSteDwsOoBrp+uvFRTp2InBuThs4pFsiv9kuXclVzDAGySj4dzp30d8tbQk
CAUw7C29C79Fv1C5qfPrmAESrciIxpg0X40KPMbp1ZWVbd4=", NULL, NULL, NULL);
$con = mysqli_real_connect($conn, "ranolangari.mysql.database.azure.com", "ranolangari", "23Juni2003", "betaglowing", 3306, MYSQLI_CLIENT_SSL);


// $conn = mysqli_connect("localhost", "root", "", "betaglowing");




function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
    }

    return $token;
}


function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;
    $email = $data["email"];
    $Username = strtolower(stripslashes($data["username"]));
    $Password = mysqli_real_escape_string($conn, $data["pass"]);
    $PasswordConf = mysqli_real_escape_string($conn, $data["pass2"]);


    if ($Password == $PasswordConf) {
        $Result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$Username'");
        if (mysqli_num_rows($Result) === 0) {
            // enkripsi Password
            $PasswordEnkripsi = Password_hash($Password, PASSWORD_DEFAULT);

            // tambahkan user baru ke database
            mysqli_query($conn, "INSERT INTO user VALUES(NULL, '$Username','$email','', '$PasswordEnkripsi','0')");

            return mysqli_affected_rows($conn);
        } else {
            echo "<script>
                    alert('Username Sudah Terdaftar');
                </script>";
        }
    } else {
        echo "<script>
                alert('Konfirmasi Password Tidak Sesuai');
            </script>";
    }
}



function Login($data)
{
    global $conn;
    $Username = $data["username"];
    $Password = $data["pass"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$Username'");

    // cek Username
    if (mysqli_num_rows($result) === 1) {

        // cek Password
        $row = mysqli_fetch_assoc($result);
        if (Password_verify($Password, $row["pass"])) {
            if ($row['role'] === '1') {
                $idUser = $row["id"];
                $_SESSION["admin"] = true;
                $_SESSION["id"] = $idUser;
                header("Location: ../index.php");
                exit;
            } else {
                $idUser = $row["id"];
                $_SESSION["user"] = true;
                $_SESSION["id"] = $idUser;
                header("Location: ../index.php");
                exit;
            }
        }
    }

    return 0;
}

function ubahdata($data)
{
    global $conn;
    $id = $data["id"];
    $Username = $data["username"];
    $email = $data["email"];
    $gambarlama = $data["gambarlama"];

    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE user SET
                username = '$Username',
                email = '$email',
                gambar = '$gambar'
                WHERE id = $id
                ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu');
            </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar');
            </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/img/profile/' . $namaFileBaru);

    return $namaFileBaru;
}

function UbahPassword($data)
{
    global $conn;
    $id = $data["id"];
    $oldPass = $data["oldPass"];
    $pass = $data["newPass"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
    $password = $row["pass"];
    if (password_verify($oldPass, $password)) {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $query = "UPDATE user 
                SET
                pass = '$password'
                WHERE id = $id
                ";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
    echo "<script>
                alert('Password lama tidak sesuai');
            </script>";
    return false;
}

function TambahDataOrderan($data)
{
    global $conn;
    $nama = $data["nama"];
    $jumlah = $data["jumlah"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO orderan VALUES
                (NULL,'$nama','$gambar','$jumlah','$harga','$kategori')
                ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function UbahDataBarang($data)
{
    global $conn;
    $id = $data["id"];
    $nama = $data["nama"];
    $jumlah = $data["jumlah"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];
    $gambarlama = $data["gambarlama"];

    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE orderan SET
                nama = '$nama',
                gambar = '$gambar',
                jumlah = '$jumlah',
                harga =  '$harga',
                kategori = '$kategori'
                
                WHERE id_produk = $id
                ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function HapusBarang($data)
{
    global $conn;
    $id = $data["id"];

    //create query to delete where id = $id
    $query = "DELETE FROM orderan WHERE id_produk = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function importData($data)
{
    global $conn;
    $fileName = $_FILES['excel']['tmp_name'];
    $spreadsheet = IOFactory::load($fileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    for ($i = 1; $i < count($sheetData); $i++) {
        $nama = $sheetData[$i]['0'];
        $jumlah = $sheetData[$i]['1'];
        $harga = $sheetData[$i]['2'];
        $kategori = $sheetData[$i]['3'];
        $query = "INSERT INTO orderan VALUES ('','$nama','','$jumlah','$harga','$kategori', '')";
        mysqli_query($conn, $query);
    }
    return mysqli_affected_rows($conn);
}

function addToCart($data)
{
    global $conn;
    $id_barang = $data["id_barang"];
    $id_user = $data["id_user"];

    $cekCart = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND id_barang = '$id_barang'");
    if (mysqli_num_rows($cekCart) > 0) {
        mysqli_query($conn, "UPDATE keranjang SET jumlah_order = jumlah_order + 1 WHERE id_user = '$id_user' AND id_barang = '$id_barang'");
    } else {
        mysqli_query($conn, "INSERT INTO keranjang VALUES (NULL, '$id_user', '$id_barang', '1')");
    }
    return mysqli_affected_rows($conn);
}


function ubahDataOrder($data)
{
    global $conn;
    $id_barang = $data["id_barang"];
    $jumlah_order = $data["jumlah_order"];

    mysqli_query($conn, "UPDATE keranjang SET jumlah_order = '$jumlah_order' WHERE id_keranjang = '$id_barang'");
    return mysqli_affected_rows($conn);
}

function hapusDataOrder($data)
{
    global $conn;
    $id_barang = $data["id_barang"];

    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id_barang'");
    return mysqli_affected_rows($conn);
}

function addPesanan($data)
{
    global $conn;
    $id_user = $data["id_user"];
    $namaPenerima = $data["namaPenerima"];
    $alamat = $data["alamat"];
    $noHp = $data["noHp"];
    $tgl_pesanan = date("Y-m-d H:i:s");
    $metodePembayaran = $data["metodePembayaran"];
    $tokenPesanan = $data["tokenPesanan"];


    foreach ($_POST["id_keranjang"] as $key => $value) {
        $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_keranjang = '$value'");
        $row = mysqli_fetch_assoc($result);

        mysqli_query($conn, "INSERT INTO pesanan VALUES (NULL,'$row[id_barang]','$id_user','$row[jumlah_order]', '$namaPenerima', '$alamat', '$noHp', '$tgl_pesanan', '$metodePembayaran','$tokenPesanan', '', 'Belum Dibayar', 'Menunggu Pembayaran', '1')");

        // mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$value'");
    }
    return mysqli_affected_rows($conn);
}

function uploadBuktiPembayaran($data)
{
    global $conn;
    $tokenPesanan = $data["tokenPesanan"];
    $buktiPembayaran = upload();
    if (!$buktiPembayaran) {
        return false;
    }

    $cekToken = mysqli_query($conn, "SELECT * FROM pesanan WHERE token_pesanan = '$tokenPesanan'");
    while ($row = mysqli_fetch_assoc($cekToken)) {
        mysqli_query($conn, "UPDATE pesanan SET bukti_pembayaran = '$buktiPembayaran', status_pembayaran = 'Menunggu Konfirmasi', status_pengiriman = 'Dalam Pengemasan' WHERE id_pesanan = '$row[id_pesanan]'");
    }
    return mysqli_affected_rows($conn);
}

function ubahPengirimanPembayaran($data)
{
    global $conn;
    $idPesanan = $data["tokenPesanan"];
    $statusPembayaran = $data["statusPembayaran"];
    $statusPengiriman = $data['statusPengiriman'];

    $cekTokenPesananAdmin = mysqli_query($conn, "SELECT * FROM pesanan WHERE token_pesanan = '$idPesanan'");
    foreach ($cekTokenPesananAdmin as $row) {
        mysqli_query($conn, "UPDATE pesanan SET status_pembayaran = '$statusPembayaran', status_pengiriman = '$statusPengiriman' WHERE id_pesanan = '$row[id_pesanan]'");
    }

    return mysqli_affected_rows($conn);
}

function hapusDataPesanan($data)
{
    global $conn;
    $idPesanan = $data["tokenPesanan"];

    $cekTokenPesananAdmin = mysqli_query($conn, "SELECT * FROM pesanan WHERE token_pesanan = '$idPesanan'");
    foreach ($cekTokenPesananAdmin as $row) {
        mysqli_query($conn, "DELETE FROM pesanan WHERE id_pesanan = '$row[id_pesanan]'");
    }

    return mysqli_affected_rows($conn);
}

function ubahBuktiPembayaran($data)
{
    global $conn;
    $tokenPesanan = $data["tokenPesanan"];
    $buktiPembayaran = upload();
    if (!$buktiPembayaran) {
        return false;
    }
    $cekTokenPesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE token_pesanan = '$tokenPesanan'");
    foreach ($cekTokenPesanan as $row) {
        mysqli_query($conn, "UPDATE pesanan SET bukti_pembayaran = '$buktiPembayaran', status_pembayaran = 'Menunggu Konfirmasi', status_pengiriman = 'Dalam Pengemasan' WHERE id_pesanan = '$row[id_pesanan]'");
    }
    return mysqli_affected_rows($conn);
}


function clearAllNotification($data)
{
    global $conn;

    mysqli_query($conn, "UPDATE pesanan SET status_notifikasi = '0' ");
    return mysqli_affected_rows($conn);
}

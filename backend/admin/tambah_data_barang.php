<!-- form_input_barang.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Barang</title>
</head>
<body>
    <h2>Input Data Barang</h2>
    <form action="proses_input_barang.php" method="post" enctype="multipart/form-data">
        <label for="kd_barang">Kode Barang:</label>
        <input type="text" id="kd_barang" name="kd_barang" required><br>

        <label for="kode_jenis">Kode Jenis:</label>
        <input type="text" id="kode_jenis" name="kode_jenis" required><br>

        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" required><br>

        <label for="stok">Stok:</label>
        <input type="number" id="stok" name="stok" required><br>

        <label for="harga_beli">Harga Beli:</label>
        <input type="number" id="harga_beli" name="harga_beli" required><br>

        <label for="harga_jual">Harga Jual:</label>
        <input type="number" id="harga_jual" name="harga_jual" required><br>

        <label for="gambar_produk">Gambar Produk:</label>
        <input type="file" id="gambar_produk" name="gambar_produk" required><br>

        <input type="submit" value="Submit">
    </form>
    <!-- proses_input_barang.php -->
<?php
include 'koneksi.php'; // File untuk koneksi ke database

$kd_barang = $_POST['kd_barang'];
$kode_jenis = $_POST['kode_jenis'];
$nama_barang = $_POST['nama_barang'];
$stok = $_POST['stok'];
$harga_beli = $_POST['harga_beli'];
$harga_jual = $_POST['harga_jual'];
$gambar_produk = $_FILES['gambar_produk']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($gambar_produk);

// Upload file gambar
if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $target_file)) {
    $sql = "INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual, gambar_produk)
            VALUES ('$kd_barang', '$kode_jenis', '$nama_barang', '$stok', '$harga_beli', '$harga_jual', '$gambar_produk')";

    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

mysqli_close($conn);
?>

</body>
</html>

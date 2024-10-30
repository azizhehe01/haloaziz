<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk</title>
</head>
<body>

<h2>Daftar Produk</h2>
<?php

// Fungsi untuk menampilkan produk
function tampilkanproduk($produkgua) {
    foreach ($produkgua as $produk) {
        echo "ID PRODUK: " . $produk["id"] . "<br>";
        echo "Nama Produk: " . $produk["nama"] . "<br>";
        echo "Harga: " . $produk["harga"] . "<br>";
        echo "-------------------------------------------" . "<br>";
    }
}

// Deklarasi array produk
$produkgua = array(
    array("id" => 101, "nama" => "kentang", "harga" => 1000),
    array("id" => 102, "nama" => "telur", "harga" => 5000),
    array("id" => 103, "nama" => "naga", "harga" => 9000),
);

// Menambahkan produk baru jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Validasi input (jika diperlukan)
    if (!empty($id) && !empty($nama) && is_numeric($harga)) {
        $produkgua[] = array(
            "id" => $id,
            "nama" => $nama,
            "harga" => $harga
        );
        echo "Produk berhasil ditambahkan!<br><br>";
    } else {
        echo "Input tidak valid!<br><br>";
    }
}

// Tampilkan produk sebelum dan setelah penambahan
echo "Sebelum input:<br>";
tampilkanproduk($produkgua);
?>

<h2>Tambah Produk Baru</h2>
<form method="post" action="">
    <label for="id">ID Produk:</label><br>
    <input type="text" name="id" required><br>
    <label for="nama">Nama Produk:</label><br>
    <input type="text" name="nama" required><br>
    <label for="harga">Harga:</label><br>
    <input type="number" name="harga" required><br><br>
    <input type="submit" value="Tambah Produk">
</form>

<?php
// Tampilkan produk setelah penambahan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Setelah Input:</h2>";
    tampilkanproduk($produkgua);
}
?>

</body>
</html>

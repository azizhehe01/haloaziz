<?php

function tampilkanproduk($produkgua) {
    foreach ($produkgua as $produk) {
        echo "ID PRODUK : ". $produk["id"]."\n";
        echo "nama produk : ". $produk["nama"]."\n";
        echo "harga : ". $produk["harga"]."\n";
        echo "-------------------------------------------"."\n";


    }
}

$produkgua = array(
    array("id" => 101, "nama" => "kentang", "harga" => 1000),
    array("id" => 102, "nama" => "telur", "harga" => 5000),
    array("id" => 103, "nama" => "naga", "harga" => 9000),

);

echo "sebelum di ganti --->"."\n";
    tampilkanproduk($produkgua);

function inputproduk(&$produkgua) {
    $id = readline("masukan id baru :");
    $nama = readline("masukan nama produk :");
    $harga = readline("masukan harga : ");

    $produkgua[] = array(
        "id" => $id,
        "nama" => $nama,
        "harga" => $harga
    );

    echo "produk berhasil di tambah"."\n";
    
}

$brp = readline("berpa data yang mau di masukin :");
for ($i= 0; $i < $brp; $i++) {

    echo "proses input"."\n";
    inputproduk($produkgua);
}

echo "setelah input"."\n";
tampilkanproduk($produkgua);

?>
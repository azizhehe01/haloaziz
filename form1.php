<?php
// session_start();
// session_destroy();

session_start();

if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = [
        ['id' => 1,
        'buku' => 'bumi',
        'pengarang' => 'A fuadi',
        'penerbit' => 'gramed'],

        ['id' => 2,
        'buku' => 'mars',
        'pengarang' => 'tereliye',
        'penerbit' => 'sidu'],
    ];
}

$data = &$_SESSION['data'];

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $buku = $_POST['buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];

    $newData = ['id' => count($data) + 1, 'buku' => $buku, 'pengarang'=> $pengarang, 'penerbit' => $penerbit];
    $data[] = $newData;

    header('Location: form1.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
    $id = $_GET['id'];
    $data = array_filter($data, function($row) use ($id) {
        return $row['id'] != $id;
    });

    $_SESSION['data'] = array_values($data);

    header('Location: form1.php');
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>id</th>
            <th>judul buku</th>
            <th>penulis</th>
            <th>penerbit</th>
            <th>Aksi</th>
        </tr>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['buku']?></td>
            <td><?php echo $row['pengarang']?></td>
            <td><?php echo $row['penerbit']?></td>
            <td>
                <a href="form1.php">edit</a> ,
                <a href="form1.php?action=delete&id=<?php echo $row['id']; ?>" onclick=" return confirm('yakin hapus');">hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    <h2>tambah data baru</h2>
    <form method="POST" action="form1.php">
        <input type="hidden" name="action" value="create">
        <label>buku :</label><br>
        <input type="text" name="buku" required><br>
        <label>pengarang :</label><br>
        <input type="text" name="pengarang" required><br>
        <label>penerbit</label><br>
        <input type="text" name="penerbit" required><br>
        <input type="submit" value="kirim">
    </form>
</body>
</html>

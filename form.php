
<?php
session_start();

// Inisialisasi data pengguna di session jika belum ada
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        ['id' => 1, 'name' => 'Aziz', 'email' => 'salman@example.com'],
        ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com']
    ];
}

$users = &$_SESSION['users']; // Reference ke session

// Tambah pengguna (Create)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Tambahkan data ke array
    $newUser = ['id' => count($users) + 1, 'name' => $name, 'email' => $email];
    $users[] = $newUser;

    // Redirect ke halaman utama
    header('Location: form.php');
    exit();
}

// Hapus pengguna (Delete)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $users = array_filter($users, function($user) use ($id) {
        return $user['id'] != $id;
    });

    // Update session setelah penghapusan
    $_SESSION['users'] = array_values($users); // Reindex array

    // Redirect ke halaman utama
    header('Location: form.php');
    exit();
}

// Edit pengguna (Update)
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cari pengguna berdasarkan id
    $userToEdit = array_filter($users, function($user) use ($id) {
        return $user['id'] == $id;
    });

    $userToEdit = array_shift($userToEdit); // Ambil pengguna pertama dari hasil filter

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update data pengguna
        foreach ($users as &$user) {
            if ($user['id'] == $id) {
                $user['name'] = $name;
                $user['email'] = $email;
                break;
            }
        }

        // Simpan kembali ke session
        $_SESSION['users'] = $users;

        // Redirect ke halaman utama
        header('Location: form.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Sederhana dengan Array</title>
</head>
<body>

<h2>Daftar Pengguna</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td>
            <a href="form.php?action=edit&id=<?php echo $user['id']; ?>">Edit</a>
            <a href="form.php?action=delete&id=<?php echo $user['id']; ?>" onclick="return confirm('Hapus pengguna ini?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($userToEdit)): ?>
<h2>Edit Pengguna</h2>
<form method="POST" action="form.php?action=edit&id=<?php echo $userToEdit['id']; ?>">
    <input type="hidden" name="action" value="update">
    <label>Nama: </label>
    <input type="text" name="name" value="<?php echo $userToEdit['name']; ?>" required><br>
    <label>Email: </label>
    <input type="email" name="email" value="<?php echo $userToEdit['email']; ?>" required><br>
    <input type="submit" value="Update Pengguna">
</form>
<?php else: ?>
<h2>Tambah Pengguna Baru</h2>
<form method="POST" action="form.php">
    <input type="hidden" name="action" value="create">
    <label>Nama: </label>
    <input type="text" name="name" required><br>
    <label>Email: </label>
    <input type="email" name="email" required><br>
    <input type="submit" value="Tambah Pengguna">
</form>
<?php endif; ?>

</body>
</html>
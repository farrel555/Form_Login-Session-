<?php
include 'config.php';
// Variabel untuk menyimpan pesan error atau sukses
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan input dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi: Cek apakah username dan password kosong
    if (empty($username) || empty($password)) {
        $message = "Username dan Password harus diisi!";
    } else {

        // Persiapkan query untuk menyimpan data ke database
        $stmt = $koneksi->prepare("INSERT INTO login (username, password) VALUES (?, ?)");

        // Check if prepare() was successful
        if ($stmt === false) {
            $message = "Error preparing statement: " . $koneksi->error;  // Shows the error from prepare()
        } else {
            // Bind parameters with correct types
            if (!$stmt->bind_param("ss", $username, $password)) {
                $message = "Error binding parameters: " . $stmt->error; // Shows error if binding fails
            } else {
                // Eksekusi query
                if ($stmt->execute()) {
                    $message = "Registrasi berhasil! Username: $username";
                } else {
                    $message = "Terjadi kesalahan saat eksekusi query: " . $stmt->error;  // Shows the execution error
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
</head>
<body>
    <h2>Form Registrasi</h2>

    <!-- Menampilkan pesan -->
    <?php if ($message != ""): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Form Registrasi -->
    <form action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Registrasi">
    </form>
</body>
</html>

<?php
include 'config.php';

// Start the session at the top of the file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find user by username
    $query = "SELECT * FROM login WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if username exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password (plain text comparison)
        if ($password == $user['password']) {
            // If login is successful, start session
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";

            // Set success message
            $_SESSION['login_success'] = "Login berhasil! Selamat datang, " . $username . ".";

            // Redirect to latihan2.php after successful login
            header("Location: latihan2.php");
            exit;
        } else {
            $_SESSION['login_error'] = "Password salah!";
        }
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan!";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Redirect back to the same login page to display the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


// Display login success message
if (isset($_SESSION['login_success'])) {
    echo "<p style='color: green; font-weight: bold;'>" . $_SESSION['login_success'] . "</p>";
    unset($_SESSION['login_success']);  // Unset the success message after displaying it
}

// Display login error message
if (isset($_SESSION['login_error'])) {
    echo "<p style='color: red; font-weight: bold;'>" . $_SESSION['login_error'] . "</p>";
    unset($_SESSION['login_error']);  // Unset the error message after displaying it
}
?>

<!-- Login Form -->
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
	<br/>
	<br/>
	<center><h2>PEMOGRAMAN WEB 2</h2></center>	
	<br/>
	<div class="login">
	<br/>
		<form action="" method="post" onSubmit="return validasi()">
			<div>
				<label>Username:</label>
				<input type="text" name="username" id="username" />
			</div>
			<div>
				<label>Password:</label>
				<input type="password" name="password" id="password" />
			</div>			
			<div>
				<input type="submit" value="Login" class="tombol">
			</div>
		</form>
	</div>
</body>
</html>
?>
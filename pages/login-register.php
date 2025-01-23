<?php

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 1) {
        echo '<script>window.location="login-user.php"</script>';
    } else {
        echo '<script>window.location="login-user.php"</script>';
    }
}

$error = '';
$validate = '';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $repass = mysqli_real_escape_string($conn, $_POST['repassword']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validasi input tidak kosong
    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($address)) && !empty(trim($password)) && !empty(trim($repass))) {
        // Validasi password dan konfirmasi password sama
        if ($password == $repass) {
            // Cek apakah username sudah ada di database
            $check_username = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");
            if (mysqli_num_rows($check_username) > 0) {
                $error = 'Username sudah terdaftar!';
            } else {
                // Insert data ke database
                $query = mysqli_query($conn, "INSERT INTO tb_user (username, name, email, address, password, role) VALUES ('$username', '$name', '$email', '$address', '$hashed_password', 0)");
                if ($query) {
                    echo '<script>alert("Registrasi berhasil! Silakan login."); window.location="login.php";</script>';
                } else {
                    $error = 'Registrasi gagal!';
                }
            }
        } else {
            $validate = 'Password tidak sama!';
        }
    } else {
        $error = 'Data tidak boleh kosong!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <section class="container-fluid mb-4">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
                <form method="POST" action="register.php" class="form-container">
                    <h4 class="text-center font-weight-bold">Sign-Up</h4>
                    <?php if($error != ''){ ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan Alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                        <?php if($validate != '') { ?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Konfirmasi Password" required>
                        <?php if($validate != '') { ?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php } ?>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
                    <div class="form-footer mt-2">
                        <p>Sudah punya akun? <a href="login.php">Login</a></p>
                    </div>
                </form>
            </section>
        </section>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
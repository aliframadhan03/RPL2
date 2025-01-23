<?php

// Cek apakah pengguna sudah login
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 1) {
        echo '<script>window.location="dashboard.php"</script>';
    } else {
        echo '<script>window.location="home.php"</script>';
    }
}

// Login logic
if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '".$user."' AND password = '".MD5($pass)."'");
    
    if (mysqli_num_rows($cek) > 0) {
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->user_id;
        $_SESSION['role'] = $d->role;
        
        echo '<script>alert("Berhasil login")</script>';
        if ($d->role == 1) {
            echo '<script>window.location="dashboard.php"</script>';
        } else {
            echo '<script>window.location="home.php"</script>';
        }
    } else {
        echo '<script>alert("Username atau Password Anda Salah!")</script>';
    }
}

// Reset Password logic
if (isset($_POST['reset_password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $check_user = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if (mysqli_num_rows($check_user) > 0) {
        $new_password = substr(md5(time()), 0, 8); // Generate password baru
        $hashed_password = md5($new_password);

        mysqli_query($conn, "UPDATE tb_user SET password = '$hashed_password' WHERE username = '$username'");
        echo '<script>alert("Password baru: '.$new_password.'"); window.location="login.php";</script>';
    } else {
        echo '<script>alert("Username tidak ditemukan!");</script>';
    }
}

// Register logic
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

    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($address)) && !empty(trim($password)) && !empty(trim($repass))) {
        if ($password == $repass) {
            $check_username = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");
            if (mysqli_num_rows($check_username) > 0) {
                $error = 'Username sudah terdaftar!';
            } else {
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
    <title>
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            echo 'Login untuk Admin';
        } else {
            echo 'Login untuk User';
        }
        ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="untree_co-section">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <form method="POST" action="" class="col-md-6 mb-5 mb-md-0">
                    <div class="p-3 p-lg-5 border bg-white rounded">
                        <h2 class="h3 mb-3 text-black">Login</h2>
                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="user" class="text-black">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="user" name="user" autocomplete="off" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="pass" class="text-black">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Masukkan kata sandi" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
                        </div>

                        <div class="form-group mt-3">
                            <p>Belum punya akun? <a href="#" onclick="document.getElementById('register-form').style.display='block';">Daftar di sini</a></p>
                        </div>

                        <div class="form-group mt-3">
                            <p><a href="#" onclick="document.getElementById('forgot-password-form').style.display='block';">Lupa password?</a></p>
                        </div>
                    </div>
                </form>

                <!-- Forgot Password Form -->
                <form method="POST" action="" id="forgot-password-form" class="col-md-6 mb-5 mb-md-0" style="display: none;">
                    <div class="p-3 p-lg-5 border bg-white rounded">
                        <h2 class="h3 mb-3 text-black">Reset Password</h2>
                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="username" class="text-black">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" name="reset_password" value="Reset Password" class="btn btn-primary btn-block">
                        </div>

                        <p class="mt-3"><a href="login.php">Kembali ke Login</a></p>
                    </div>
                </form>

                <!-- Register Form -->
                <form method="POST" action="" id="register-form" class="col-md-6 mb-5 mb-md-0" style="display: none;">
                    <div class="p-3 p-lg-5 border bg-white rounded">
                        <h2 class="h3 mb-3 text-black">Daftar</h2>
                        <?php if($error != ''){ ?>
                            <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                        <?php } ?>

                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="name" class="text-black">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="username" class="text-black">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="email" class="text-black">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="address" class="text-black">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan Alamat" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="password" class="text-black">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-12">
                                <label for="repassword" class="text-black">Ulangi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Ulangi Password" required>
                                <?php if($validate != ''){ ?>
                                    <small class="text-danger"><?= $validate; ?></small>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" name="register" value="Daftar" class="btn btn-primary btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

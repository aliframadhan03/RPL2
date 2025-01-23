<?php

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <form method="POST" action="" class="col-md-6 mb-5 mb-md-0">
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

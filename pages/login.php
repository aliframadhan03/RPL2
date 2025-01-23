<?php
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 1) {
        echo '<script>window.location="dashboard.php"</script>';
    }else{
        echo '<script>window.location="home.php"</script>';
    }
}

if(isset($_POST['submit'])){ 
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '".$user."' AND password = '".MD5($pass)."'");
    if(mysqli_num_rows($cek) > 0){
        
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->user_id;
        $_SESSION['role'] = $d->role;
        echo '<script>alert("Berhasil login")</script>';
        if ($d->role == 1) {
            echo '<script>window.location="dashboard.php"</script>';
        }else{
            echo '<script>window.location="home.php"</script>';
        }
        
        
    }else{
        echo '<script>alert("Username atau Password Anda Salah!")</script>';
    }
} 
?>
<div class="untree_co-section">
<div class="container">
<div class="row d-flex justify-content-center align-items-center">
<form method="POST" action="" class="col-md-6 mb-5 mb-md-0 ">
    
    <div class="p-3 p-lg-5 border bg-white rounded">
    <h2 class="h3 mb-3 text-black">Login</h2>
    <div class="form-group mb-3 row">
        <div class="col-md-12">
        <label for="user" class="text-black">Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="user" name="user" autocomplete="off" placeholder="Masukkan username">
        </div>
    </div>

    <div class="form-group mb-3 row">
        <div class="col-md-12">
        <label for="pass" class="text-black">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="pass" name="pass" placeholder="Masukkan kata sandi">
        </div>
    </div>

    <div class="form-group mt-3">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>

    <div class="form-group mt-3">
        <p><a href="login-forgotpass.php">Lupa password?</a></p>
    </div>

    <div class="form-group mt-3">
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
        </div>
    </div>
</form>
</div>
<!-- </form> -->
</div>
</div>
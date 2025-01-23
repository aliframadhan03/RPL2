<?php 
//MENGAMBIL DATA DARI DATABASE
     $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '".$_SESSION['id']."' ");
     $d = mysqli_fetch_object($query);   
    if(isset($_POST['submit'])){
        $nama   = ucwords($_POST['nama']);
        $user   = $_POST['user'];
        $hp     = $_POST['hp'];
        $email  = $_POST['email'];
        $alamat = ucwords($_POST['alamat']);

        $update = mysqli_query($conn, "UPDATE tb_user SET 
                            user_name = '".$nama."', 
                            username = '".$user."',
                            user_telp = '".$hp."',
                            user_email = '".$email."',
                            user_address = '".$alamat."' 
                            WHERE user_id = '".$d->user_id."' ");
        if ($update){
                echo '<script>alert("Ubah Data Berhasil")</script>';
                echo '<script>window.location="profil.php"</script>';
        }else{
            echo 'GAGAL '.mysqli_error($conn);
        }                 

    }
?>

<?php
    if(isset($_POST['ubah_password'])) {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if($pass2 != $pass1) {
        echo '<script>alert("Konfirmasi Password Tidak Sesuai")</script>';
    } else {
        $u_pass = mysqli_query($conn, "UPDATE tb_user SET
        password = '".MD5($pass1)."'
        WHERE user_id = '".$d->user_id."' ");

    if($u_pass) {
        echo '<script>alert("Ubah Password Berhasil")</script>';
        echo '<script>window.location="profile.php"</script>';
        } else {
        echo 'GAGAL!!! ' .mysqli_error($conn);
        }
    }
}
?>
<div class="untree_co-section">
<div class="container">
    <div class="row mb-5">
    <form method="POST" action="" class="col-md-12 mb-5 mb-md-0">
        
        <div class="p-3 p-lg-5 border bg-white">
        <h2 class="h3 mb-3 text-black">Profil user</h2>
        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="nama" class="text-black">Nama Lengkap<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" value="<?= $d->user_name; ?>" placeholder="Nama Lengkap">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="user" class="text-black">Usename <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="user" name="user" placeholder="Username" value="<?= $d->username; ?>">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="hp" class="text-black">Nomor HP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="hp" name="hp" placeholder="Nomor HP" value="<?= $d->user_telp; ?>">
            </div>
        </div>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 2) : ?>
        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="email" class="text-black">Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Alamat Email" value="<?= $d->user_email; ?>">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="alamat" class="text-black">Alamat <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Rumah" value="<?= $d->user_address; ?>">
            </div>
        </div>
        <?php endif;?>
        <div class="form-group mt-3">
                <input type="submit" name="submit" value="Simpan" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
    </div>
    <!-- </form> -->



    <div class="row">
    <form method="POST" action="" class="col-md-12 mb-5 mb-md-0">
        
        <div class="p-3 p-lg-5 border bg-white">
        <h2 class="h3 mb-3 text-black">Ubah Password</h2>
        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="pass1" class="text-black">Password baru<span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="pass1" name="pass1" autocomplete="off" placeholder="Password baru">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="pass2" class="text-black">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Konfirmasi password">
            </div>
        </div>

        <div class="form-group mt-3">
                <input type="submit" name="ubah_password" value="Simpan" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
    </div>
    <!-- </form> -->
</div>
</div>


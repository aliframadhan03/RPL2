<?php 
    if(isset($_POST['submit']) && !isset($_GET['id'])){
        $nama   = ucwords($_POST['nama']);
        $user   = $_POST['user'];
        $role = 2;
        $hp     = $_POST['hp'];
        $email  = $_POST['email'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $alamat = ucwords($_POST['alamat']);


        if($pass2 != $pass1) {
            echo '<script>alert("Konfirmasi Password Tidak Sesuai")</script>';
        }

        $syntax = "INSERT INTO `tb_user`
        (`user_id`, `user_name`, `username`, `password`, `role`, `user_telp`, `user_email`, `user_address`) 
        VALUES (NULL,'".$nama."','".$user."','".MD5($pass1)."','".$role."','".$hp."','".$email."','".$alamat."')";
        $insert = mysqli_query($conn, $syntax);
        if ($insert){
            echo '<script>alert("Tambah Data Berhasil")</script>';
            echo '<script>window.location="'.BASEURL.'data-user.php"</script>';
        }else{
            echo 'GAGAL '.mysqli_error($conn);
        }                 

    }

    if (isset($_GET['id'])) {
        $user = mysqli_query ($conn, "SELECT * FROM tb_user WHERE user_id = '".$_GET['id']."' "); 
 
        if(mysqli_num_rows($user) == 0){ 
            echo '<script>window.location = "data-user.php"</script>'; 
        } 
    
        $d = mysqli_fetch_object($user); 
        
        if(isset($_POST['submit'])) { 
            $nama   = ucwords($_POST['nama']);
            $user   = $_POST['user'];
            $hp     = $_POST['hp'];
            $email  = $_POST['email'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            $alamat = ucwords($_POST['alamat']);
            $plus = '';
            if (isset($pass1) && $pass1) {
                if($pass2 != $pass1) {
                    echo '<script>alert("Konfirmasi Password Tidak Sesuai")</script>';
                    echo '<script>window.location = "aksi-user.php?id='.$_GET['id'].'"</script>'; 
                }
                $plus .= "password = '".MD5($pass1)."',";
            }

            $update = mysqli_query($conn, "UPDATE tb_user SET 
                                user_name = '".$nama."', 
                                username = '".$user."',
                                user_telp = '".$hp."',
                                user_email = '".$email."',"
                                .$plus."
                                user_address = '".$alamat."' 
                                WHERE user_id = '".$d->user_id."' ");
            if($update) { 
                echo '<script>alert("Edit Data Berhasil")</script>'; 
                echo '<script>window.location = "data-user.php"</script>'; 
            } else { 
                echo 'GAGAL!!!' .mysqli_error($conn); 
            } 
        } 
    }
?>
<div class="untree_co-section">
<div class="container">
    <div class="row mb-5">
    <form method="POST" action="" class="col-md-12 mb-5 mb-md-0">
        
        <div class="p-3 p-lg-5 border bg-white">
        <h2 class="h3 mb-3 text-black"><?= (isset($_GET['id'])) ? 'Edit' : 'Tambah'; ?> User</h2>
        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="nama" class="text-black">Nama Lengkap<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required value="<?= (isset($_GET['id'])) ? $d->user_name : ''; ?>" placeholder="Nama Lengkap">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="user" class="text-black">Usename <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="user" name="user" placeholder="Username" value="<?= (isset($_GET['id'])) ? $d->username : ''; ?>" required>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="hp" class="text-black">Nomor HP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="hp" name="hp" placeholder="Nomor HP" value="<?= (isset($_GET['id'])) ? $d->user_telp : ''; ?>" required>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="email" class="text-black">Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Alamat Email" value="<?= (isset($_GET['id'])) ? $d->user_email : ''; ?>" required>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="pass1" class="text-black">Password baru<span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="pass1" name="pass1" autocomplete="off" <?= (isset($_GET['id'])) ? '' : 'required';?> placeholder="Password baru">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="pass2" class="text-black">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Konfirmasi password" <?= (isset($_GET['id'])) ? '' : 'required';?>>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="alamat" class="text-black">Alamat <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Rumah" value="<?= (isset($_GET['id'])) ? $d->user_address : ''; ?>" required>
            </div>
        </div>
        <div class="form-group mt-3">
                <input type="submit" name="submit" value="Simpan" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
    </div>
    <!-- </form> -->
</div>
</div>


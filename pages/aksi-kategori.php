<?php 
    if(isset($_POST['submit']) && !isset($_GET['id'])) { 
            
        $nama = ucwords($_POST['nama']); 

        $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES (null, '".$nama."')"); 
        if($insert) { 
            echo '<script>alert("Tambah Data Kategori Berhasil")</script>'; 
            echo '<script>window.location = "data-kategori.php"</script>'; 
        } else { 
            echo 'GAGAL!!!' .mysqli_error($conn); 
        } 
    } 


    if (isset($_GET['id'])) {
        $kategori = mysqli_query ($conn, "SELECT * FROM tb_category WHERE category_id = '".$_GET['id']."' "); 
 
        //Agar jika kategori id dihapus tidak error dan diarahkan kembali ke data kategori 
        if(mysqli_num_rows($kategori) == 0){ 
            echo '<script>window.location = "data-kategori.php"</script>'; 
        } 
    
        $k = mysqli_fetch_object($kategori); 
        
        if(isset($_POST['submit'])) { 
                         
            $nama = ucwords($_POST['nama']); 
                
            $update  = mysqli_query($conn, "UPDATE tb_category SET  
                                    category_name = '".$nama."' 
                                    WHERE category_id = '".$k->category_id."' "); 

            if($update) { 
                echo '<script>alert("Edit Data Berhasil")</script>'; 
                echo '<script>window.location = "data-kategori.php"</script>'; 
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
        <h2 class="h3 mb-3 text-black"><?= (isset($_GET['id'])) ? 'Edit' : 'Tambah'; ?> Kategori</h2>
        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="nama" class="text-black">Nama Kategori<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" value="<?= (isset($k->category_name)) ? $k->category_name : ''; ?>" placeholder="Nama Kategori" required>
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
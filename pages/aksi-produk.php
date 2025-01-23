<link rel="stylesheet" href="<?= BASEURL.'assets/ckeditor5/ckeditor5.css' ?>">
<?php 
if(isset($_POST['submit']) && !isset($_GET['id'])) { 
    // menampung inputan dari form 
    $kategori   = $_POST['kategori']; 
    $nama       = $_POST['nama']; 
    $harga      = $_POST['harga']; 
    $stock      = $_POST['stock']; 
    // $deskripsi  = $_POST['deskripsi']; 
    $deskripsi  = "sesuatu"; 
    $status     = $_POST['status']; 

    // menampung data file yang diupload 
    $filename = $_FILES['gambar']['name']; 
    $tmp_name = $_FILES['gambar']['tmp_name']; 

    $type1 = explode('.', $filename); 
    $type2 = strtolower(end($type1)); 

    $newname = 'produk'.time().'.'.$type2; 

    //menampung data format file yang diizinkan 
    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif'); 
    
    // validasi format file 
    if(!in_array($type2, $tipe_diizinkan)){ 
        //jika format file tidak sesuai 
        echo '<script>alert("Masukkan format file yang diizinkan: jpg, jpeg, png, gif")</script>'; 

    } else { 
        //jika format file sesuai 
        //proses upload file dan insert ke dalam database 
        move_uploaded_file($tmp_name, './produk/'.$newname); 

        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES ( 
            '', 
            '".$kategori."', 
            '".$nama."', 
            '".$harga."', 
            '".$deskripsi."', 
            '".$stock."',
            '".$newname."', 
            '".$status."', 
            null ) "); 
        if($insert){ 
            echo '<script>alert("Simpan Data Berhasil")</script>'; 
            echo '<script>window.location="data-produk.php"</script>'; 
        } else { 
            echo 'Simpan Data Gagal!!' .mysqli_error($conn); 
        } 
    } 
} 


if (isset($_GET['id'])) {
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' "); 
 
    //Agar jika kategori id dihapus tidak error dan diarahkan kembali ke data produk 
    if(mysqli_num_rows($produk) == 0){ 
        echo '<script>window.location = "data-produk.php"</script>'; 
    } 
 
    $p = mysqli_fetch_object($produk); 
    if(isset($_POST['submit'])) { 
            
        // data inputan dari form 
        $kategori   = $_POST['kategori']; 
        $nama       = $_POST['nama']; 
        $harga      = $_POST['harga']; 
        $stock  = $_POST['stock']; 
        $deskripsi  = $_POST['deskripsi']; 
        $status     = $_POST['status']; 
        $foto       = $_POST['foto']; 
    // data gambar baru 
        $filename = $_FILES['gambar']['name']; 
        $tmp_name = $_FILES['gambar']['tmp_name']; 

        //menampung data format file yang diizinkan 
        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif'); 

        // jika admin ganti gambar 
        if($filename != ''){ 
            $type1 = explode('.', $filename); 
            $type2 = $type1[1]; 

            $newname = 'produk'.time().'.'.$type2;     

            // validasi format file 
            
            if(!in_array($type2, $tipe_diizinkan)){ 

            //jika format file tidak sesuai 
                echo '<script>alert("Masukkan format file yang diizinkan: jpg, jpeg, png, gif")</script>'; 

            } else { 
                unlink('./produk/'.$foto); 
                move_uploaded_file($tmp_name, './produk/'.$newname); 
                $namagambar = $newname; 
            } 
        } else { 
            // jika admin tidak ganti gambar 
            $namagambar = $foto; 

        } 

        //query update data produk 
        $kueri = "UPDATE tb_product SET  
                                category_id = '".$kategori."', 
                                product_name = '".$nama."', 
                                product_price = '".$harga."', 
                                product_description = '".$deskripsi."',
                                product_stock = '".$stock."', 
                                product_image = '".$namagambar."', 
                                product_status = '".$status."' 
                                WHERE product_id = '".$p->product_id."'";
        $update = mysqli_query($conn, $kueri); 
        if($update){ 
            echo '<script>alert("Ubah data berhasil")</script>'; 
            echo '<script>window.location="data-produk.php"</script>'; 
        } else { 
            echo 'Ubah data gagal!!' .mysqli_error($conn); 
        } 
    } 
}

?> 

<div class="untree_co-section">
<div class="container">
    <div class="row mb-5">
    <form method="POST" action="" class="col-md-12 mb-5 mb-md-0" enctype="multipart/form-data">
        
        <div class="p-3 p-lg-5 border bg-white">
        <h2 class="h3 mb-3 text-black"><?= (isset($_GET['id'])) ? 'Edit' : 'Tambah'; ?> Produk</h2>
        <div class="form-group mb-3">
            <label for="kategori" class="text-black">Pilih Kategori <span class="text-danger">*</span></label>
            <select id="kategori" name="kategori" class="form-control">
                <option value="">Pilih Kategori</option>
                <?php 
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC"); 
                    while($r = mysqli_fetch_array($kategori)){ 
                ?> 
                <option value="<?php echo $r['category_id'] ?>" <?php if(isset($_GET['id'])){ echo ($r['category_id'] == $p->category_id)? 'selected':"";}; ?> ><?php echo $r['category_name'] ?></option> 
                <?php } ?> 
            </select>
        </div>

         <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="nama" class="text-black">Nama Produk<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" value="<?= (isset($_GET['id'])) ? $p->product_name : ''; ?>" placeholder="Nama Produk" required>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="harga" class="text-black">Harga Produk<span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="harga" name="harga" autocomplete="off" value="<?= (isset($_GET['id'])) ? $p->product_price : ''; ?>" placeholder="Harga Produk" required>
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="stock" class="text-black">Jumlah Stock<span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="stock" name="stock" autocomplete="off" value="<?= (isset($_GET['id'])) ? $p->product_stock : ''; ?>" placeholder="Jumlah Stock" required>
            </div>
        </div>
        
        <?php if(isset($_GET['id'])) : ?>
        <img src="produk/<?php echo $p->product_image ?>" width="150px"> 
        <input type="hidden" name="foto" value="<?php echo $p-> product_image ?>"> 
        <?php endif;?>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="gambar" class="text-black">Gambar Produk<span class="text-danger">*</span></label>
            <input type="file" class="form-control form-control-lg" id="gambar" name="gambar" autocomplete="off">
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-md-12">
            <label for="deskripsi" class="text-black">Deskripsi Produk<span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Deskripsi produk" id="deskripsi" name="deskripsi" autocomplete="off" required><?php echo (isset($_GET['id'])) ? $p->product_description : ''; ?></textarea>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="status" class="text-black">Pilih Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="form-control">
                <option value="">Pilih Status</option>
                <option value="1" <?php echo (isset($_GET['id']) && $p->product_status == 1)? 'selected':''; ?> >Aktif</option> 
                <option value="0" <?php echo (isset($_GET['id']) && $p->product_status == 0)? 'selected':''; ?> >Tidak 
            </select>
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

<script src="<?= BASEURL.'assets/ckeditor5/ckeditor5.js' ?>"></script>
<script>
    import { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph } from 'ckeditor5';
   ClassicEditor
    .create( document.querySelector( '#deskripsi' ), {
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        }
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: vd7qnogyyu6n-nohdljl880ze' );
        console.error( error );
    } );
</script>

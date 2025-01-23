<?php 
    if(isset($_GET['aksi']) && $_GET['aksi'] == 'kategori' && isset($_GET['id'])){ 
        $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '".$_GET['id']."' "); 
        echo '<script>alert("Kategori berhasil dihapus")</script>';
        echo '<script>window.location="'.BASEURL.'data-kategori.php"</script>';
    } 
 
    if(isset($_GET['aksi']) && $_GET['aksi'] == 'produk' && isset($_GET['id'])) { 
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        // Mengambil nama file gambar produk
        $query = mysqli_query($conn, "SELECT product_image FROM tb_product WHERE product_id = '$id'");
        if($query && mysqli_num_rows($query) > 0) {
            $product = mysqli_fetch_object($query); 
            $imagePath = './produk/'.$product->product_image;

            // Menghapus file gambar dari server
            if(file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Menghapus produk dari database
            $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id = '$id'"); 
            if($delete){
                echo '<script>alert("Produk berhasil dihapus!"); window.location = "'.BASEURL.'data-produk.php";</script>';
            } else {
                echo '<script>alert("Gagal menghapus produk! ' . mysqli_error($conn) . '"); window.location = "'.BASEURL.'data-produk.php";</script>';
            }
        } else {
            echo '<script>alert("Produk tidak ditemukan!"); window.location = "'.BASEURL.'data-produk.php";</script>';
        }
    } else {
        echo '<script>alert("ID Produk tidak valid!"); window.location = "'.BASEURL.'data-produk.php";</script>';
    }
 
?> 

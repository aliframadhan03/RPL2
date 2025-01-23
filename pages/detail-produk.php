<?php 
    error_reporting(0); 
    include 'db.php'; 
 
    $kontak = mysqli_query($conn, "SELECT user_telp, user_email, user_address FROM tb_user 
WHERE user_id = 1 "); 
    $a = mysqli_fetch_object($kontak); 
 
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' "); 
    $p = mysqli_fetch_object($produk); 
?> 
  
<!DOCTYPE html> 
<html> 
<head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Kitty Dance Equipment Store</title> 
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
</head>

<body> 

    <!-- Detail Produk --> 
    <div class="section"> 
        <div class="container"> 
            <h3>Detail Produk</h3> 
            <div class="box product-details" style="display: flex; align-items: flex-start; gap: 50px;"> 
                <div class="col-2 product-image" style="flex: 1;"> 
                    <img src="produk/<?php echo $p->product_image ?>" width="100%" class="img-produk"> 
                </div> 
                <div class="col-2 product-description" style="flex: 2;"> 
                    <h3><?php echo $p->product_name ?></h3> 
                    <h4>Rp. <?php echo number_format($p->product_price) ?></h4> 
                    <p>Deskripsi: <br>   
                        <?php echo $p->product_description ?> 
                    </p> 
                </div> 
            </div> 
        </div> 
    </div>

<!-- FOOTER --> 
    <div class="footer">
<div class="container"> 
            <small>Copyright &copy; 2024 - Kitty Dance Equipment Store.</small> 
        </div> 
    </div> 
 
</body>

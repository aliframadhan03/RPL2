<?php  
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 ORDER BY product_id DESC LIMIT 3");
    $result = array();
    while ($p =  mysqli_fetch_assoc($produk))
    {
        $result[] = $p;
    }
?> 

<!-- Start Hero Section -->
    <div class="hero">
        
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7">
                    <div class="intro-excerpt">
                        <h1>Provide Profesional <span style="color : #5c3f0c;">Dance Property</span></h1>
                        <p class="mb-4">Kami menyediakan peralatan tari dan pentas dengan kualitas terbaik! Kami akan terus berusaha mengembangkan fasilitas dan pelayanan kami untuk ada</p>
                        <p style="color : #FFFFFF;"><a href="<?= BASEURL.'keranjang.php'; ?>" class="btn btn-secondary me-2"><img src="<?= ASSETSURL.'img/cart.svg'; ?>">&nbsp;&nbsp;Keranjang Saya</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-img-wrap">
                        <img src="<?= ASSETSURL; ?>img/ornamen/hero.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="product-section">
    <div class="container">
        <div class="row">

            <!-- Start Column 1 -->
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title">Display produk terbaru kami.</h2>
                <p class="mb-4">Kami akan selalu berusaha menyediakan produk terbaik untuk kepuasan anda</p>
                <p><a href="<?= BASEURL.'produk.php'; ?>" class="btn">Lihat Semua</a></p>
            </div> 
            <!-- End Column 1 -->
            <?php if($result) : ?>
                <?php foreach($result AS $row) : ?>
                <!-- Start Column 2 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <div class="product-item" href="<?= BASEURL.'detail-produk.php?add='.$row['product_id'];?>">
                        <a href="<?= BASEURL.'detail-produk.php?id='.$row['product_id'];?>" style="text-decoration : none;">
                            <img style="height : 200px;width:auto;" src="<?= BASEURL; ?>produk/<?= $row['product_image']  ?>" class="img-fluid product-thumbnail">
                            <h3 class="product-title"><?= substr($row['product_name'], 0, 30); ?></h3>
                            <strong class="product-price">Rp. <?php echo number_format($row['product_price'],0,",", "."); ?></strong>
                             
                        </a></br>
                        <span>Stock : <?= $row['product_stock']; ?></span>
                        <a href="<?= BASEURL.'keranjang.php?add='.$row['product_id'];?>" class="icon-cross">
                            <img src="<?= ASSETSURL; ?>img/cross.svg" class="img-fluid">
                        </a>
                    </div>
                </div> 
                <!-- End Column 2 -->
                <?php endforeach;?>
            <?php endif;?>

        </div>
    </div>
</div>
<!-- End Product Section -->

<!-- End Blog Section -->	

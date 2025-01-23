<?php  
    $where = '';
    $search = '';
    if(isset($_GET['search']) && $_GET['search'] != ''){ 
        $where .= "AND product_name LIKE '%".$_GET['search']."%' "; 
        $search = $_GET['search'];
    } 

    if(isset($_GET['kat']) && $_GET['kat'] != ''){ 
        $where .= "AND category_id LIKE '%".$_GET['kat']."%' ";
    } 
 
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 
    $where ORDER BY product_id DESC"); 
    $result = array();
    while ($p =  mysqli_fetch_assoc($produk))
    {
        $result[] = $p;
    }

    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION['id']);
?> 
  
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row mb-5">
					<div class="col-lg-12 d-flex justify-content-center align-items-center">
						<div class="w-100 subscription-form d-flex justify-content-center align-items-center flex-column">
							<h3 class="d-flex align-items-center mb-3"><span>Cari produk yang anda sukai</span></h3>

							<form action="" method="GET" class="row g-3 w-100 d-flex justify-content-center align-items-center">
								<div class="col-md-6">
									<input type="text" name="search" class="form-control" value="<?= $search; ?>" placeholder="Cari produk">
								</div>
								<div class="col-auto">
									<button type="submit" class="btn btn-primary">
										<span class="fa fa-search"></span>
									</button>
								</div>
							</form>

						</div>
					</div>
				</div>

        <div class="row">

            <?php if($result) : ?>
                <?php foreach($result AS $row) : ?>
                <!-- Start Column 2 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <div class="product-item">
                        <a href="<?= BASEURL.'detail-produk.php?id='.$row['product_id'];?>" style="text-decoration : none;">
                                <img style="height : 200px;width:auto;" src="<?= BASEURL; ?>produk/<?= $row['product_image']  ?>" class="img-fluid product-thumbnail">
                                <h3 class="product-title"><?= substr($row['product_name'], 0, 30); ?></h3>
                                <strong class="product-price">Rp. <?php echo number_format($row['product_price'],0,",", "."); ?></strong>
                        </a></br>
                        <span>Stock : <?= $row['product_stock']; ?></span>
                            <button class="btn btn-primary add-to-cart" data-product-id="<?= $row['product_id']; ?>">
                             <img src="<?= ASSETSURL; ?>img/cross.svg" class="img-fluid">
                        </button>
                    </div>
                </div>                 

                <?php endforeach;?>
            <?php endif;?>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();  // Mencegah perilaku default tombol
                
                const productId = this.getAttribute('data-product-id');

                // Check if the user is logged in
                <?php if (!$isLoggedIn) : ?>
                    alert('Anda harus login untuk menambahkan produk ke keranjang.');
                    return; // Stop the function execution
                <?php endif; ?>

                // Gunakan satu flag untuk mencegah pop-up muncul lebih dari sekali
                if (confirm('Apakah Anda yakin ingin memasukkan produk ini ke keranjang?')) {
                    // Setelah konfirmasi, sembunyikan tombol untuk mencegah klik berulang
                    this.disabled = true;

                    // Kirim permintaan AJAX untuk menambahkan produk ke keranjang
                    fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `product_id=${productId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Tampilkan pesan sukses atau lakukan tindakan lain
                        alert('Produk berhasil ditambahkan ke keranjang!');
                        // Mengaktifkan kembali tombol jika diperlukan (opsional)
                        this.disabled = false;
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        // Mengaktifkan kembali tombol jika terjadi kesalahan
                        this.disabled = false;
                    });
                }
            });
        });
    });

</script>
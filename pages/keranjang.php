<?php

if (isset($_GET['add'])) {
    $product_id = $_GET['add'];
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$product_id."' "); 
    $p = mysqli_fetch_object($produk); 
    $jml = (isset($_SESSION['cart'][$product_id])) ? ($_SESSION['cart'][$product_id] + 1) : 1;
    if ($p->product_stock < $jml) {
        $_SESSION['cart'][$product_id] = $p->product_stock;
        echo '<script>alert("Stock produk Tidak mencukupi")</script>';
        echo '<script>window.history.back()</script>';
    }else{
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
        echo '<script>window.location="keranjang.php"</script>';
    }
    
    
}

// Menghapus produk dari keranjang
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$product_id."' "); 
        $p = mysqli_fetch_object($produk); 
        $jml = (isset($_SESSION['cart'][$product_id])) ? ($_SESSION['cart'][$product_id] - 1) : 1;
        if ($p->product_stock < $jml) {
            $_SESSION['cart'][$product_id] = $p->product_stock;
            echo '<script>alert("Stock produk Tidak mencukupi")</script>';
            echo '<script>window.history.back()</script>';
        }else{
            $_SESSION['cart'][$product_id]--;
            echo '<script>window.location="keranjang.php"</script>';
        }
    }
    echo '<script>window.location="keranjang.php"</script>';
}

// Menghapus semua produk dari keranjang
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    unset($_SESSION['cart'][$product_id]);
    echo '<script>window.location="keranjang.php"</script>';
}
?>
<div class="untree_co-section before-footer-section">
<div class="container">
    <div class="row mb-5">
    <form class="col-md-12" method="post">
        <div class="site-blocks-table">
        <table class="table">
            <thead>
            <tr>
                <th class="product-thumbnail">Gambar</th>
                <th class="product-name">Produk</th>
                <th class="product-price">Harga</th>
                <th class="product-quantity">Jumlah</th>
                <th class="product-total">Total</th>
                <th class="product-remove">Aksi</th>
            </tr>
            </thead>
            <tbody>
                <?php $total_bayar = 0; if (!empty($_SESSION['cart'])) : ?>
                    <?php foreach ($_SESSION['cart'] as $id => $jumlah) :  ?>
                    <?php
                        $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = $id");
                        $row = mysqli_fetch_array($produk);
                        $total_harga = $row['product_price'] * $jumlah;
                        $total_bayar += $total_harga;    
                    ?>
                    <tr>
                        <td class="product-thumbnail">
                        <img src="<?= BASEURL; ?>produk/<?= $row['product_image']  ?>" alt="Image" class="img-fluid">
                        </td>
                        <td class="product-name">
                        <h2 class="h5 text-black"><?= substr($row['product_name'], 0, 30); ?></h2>
                        </td>
                        <td>Rp. <?php echo number_format($row['product_price'],0,",", "."); ?></td>
                        <td>
                        <div class="input-group mb-3 d-flex justify-content-center align-items-center quantity-container" >
                            <div class="input-group-prepend">
                            <a class="btn btn-outline-black decrease" href="<?= BASEURL.'keranjang.php?remove='.$row['product_id']; ?>">&minus;</a>
                            </div>
                            <input type="text" style="max-width: 120px;" disabled="true" class="form-control text-center quantity-amount" value="<?php echo $jumlah; ?>" placeholder="">
                            <div class="input-group-append">
                            <a class="btn btn-outline-black increase" href="<?= BASEURL.'keranjang.php?add='.$row['product_id']; ?>">&plus;</a>
                            </div>
                        </div>
                        <span>Total Stock Tersedia : <?= $row['product_stock']; ?></span>

                        </td>
                        <td>Rp. <?php echo number_format($total_harga,0,",", "."); ?></td>
                        <td><a href="<?= BASEURL ?>keranjang.php?delete=<?= $row['product_id']; ?>" class="btn btn-danger btn-sm">Hapus</a></td>
                    </tr>
                    <?php endforeach;?>
            <?php else :?>
                <tr>
                    <td colspan="6"><center>Tidak ada data keranjang</center></td>
                </tr>
            <?php endif;?>

            </tbody>
        </table>
        </div>
    </form>
    </div>

    <div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 pl-5">
        <div class="row justify-content-end">
        <div class="col-md-7">
            <div class="row">
            <div class="col-md-12 text-center border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase">Total Keranjang</h3>
            </div>
            </div>
            <div class="row mb-5 d-flex justify-content-center align-items-center">
            <div class="col-md-6">
                <span class="text-black">Total</span>
            </div>
            <div class="col-md-6 text-center">
                <strong class="text-black">Rp. <?php echo number_format($total_bayar,0,",", "."); ?>,00</strong>
            </div>
            </div>

            <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='<?= BASEURL; ?>checkout.php'">Checkout</button>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</div>

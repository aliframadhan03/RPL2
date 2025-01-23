<?php

if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login sebagai user untuk melanjutkan pembayaran"); window.location="login.php";</script>';
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '".$_SESSION['id']."' ");
$d = mysqli_fetch_object($query);

// Proses pembayaran
if (isset($_POST['bayar'])) {
    $total_price = 0;
    foreach ($_SESSION['cart'] as $id => $jumlah) {
        $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = $id");
        $p = mysqli_fetch_array($produk);
        $total_price += $p['product_price'] * $jumlah;
    }
    
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $user_id = $_SESSION['id'];
    $payment_method = $_POST['payment_method'];

    // Simpan detail transaksi
    mysqli_query($conn, "INSERT INTO tb_transaction 
    (customer_name, user_id, customer_address, total_price, transaction_date, payment_status, shipping_status, tracking_number) 
    VALUES ('$customer_name', '$user_id', '$customer_address', '$total_price', NOW(), 'Sudah Bayar', 'Sedang Dikemas', NULL)");

    $transaction_id = mysqli_insert_id($conn);

    // Simpan detail produk transaksi
    foreach ($_SESSION['cart'] as $id => $jumlah) {
        $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = $id");
        $p = mysqli_fetch_array($produk);
        $total_harga = $p['product_price'] * $jumlah;
        $jml = $p['product_stock'] - $jumlah;

        mysqli_query($conn, "INSERT INTO tb_transaction_details 
        (transaction_id, product_id, quantity, price) 
        VALUES ('$transaction_id', '$id', '$jumlah', '$total_harga')");
        
        mysqli_query($conn, "UPDATE tb_product SET product_stock='".$jml."' WHERE product_id = ".$id);
    }

    // Bersihkan keranjang belanja
    unset($_SESSION['cart']);

    echo '<script>alert("Transaksi berhasil!."); window.location="bayar.php";</script>';
}

// Tampilkan detail transaksi pengguna
$transactions = mysqli_query($conn, "SELECT * FROM tb_transaction WHERE user_id = '".$_SESSION['id']."' ORDER BY transaction_date DESC");
?>
<div class="untree_co-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Riwayat Transaksi</h2>
                <div class="p-3 p-lg-5 border bg-white">
                    <?php while ($row = mysqli_fetch_assoc($transactions)) { ?>
                    <div class="border p-3 mb-3">
                        <p><strong>Nama:</strong> <?= $row['customer_name'] ?></p>
                        <p><strong>Alamat:</strong> <?= $row['customer_address'] ?></p>
                        <p><strong>Total Harga:</strong> Rp <?= number_format($row['total_price'], 0, ',', '.') ?></p>
                        <p><strong>Status Pembayaran:</strong> <?= $row['payment_status'] ?></p>
                        <p><strong>Status Pengiriman:</strong> <?= $row['shipping_status'] ?></p>
                        <p><strong>Nomor Resi:</strong> <?= $row['tracking_number'] ? $row['tracking_number'] : 'Belum tersedia' ?></p>

                        <!-- Tampilkan Detail Produk yang Dibeli -->
                        <h4>Detail Barang:</h4>
                        <?php
                        $transaction_id = $row['transaction_id'];
                        $products = mysqli_query($conn, "SELECT p.product_name, td.quantity 
                                                        FROM tb_transaction_details td 
                                                        JOIN tb_product p ON td.product_id = p.product_id 
                                                        WHERE td.transaction_id = '$transaction_id'");
                        while ($product = mysqli_fetch_assoc($products)) { ?>
                            <p>Nama Produk: <?= $product['product_name'] ?> | Jumlah: <?= $product['quantity'] ?></p>
                        <?php } ?>

                        <!-- Button Logic -->
                        <?php if ($row['payment_status'] == 'Belum Bayar') { ?>
                            <form action="cancel-transaction.php" method="POST" style="display:inline;">
                                <input type="hidden" name="transaction_id" value="<?= $transaction_id ?>">
                                <input type="submit" value="Cancel" class="btn btn-danger">
                            </form>
                            <form action="continue-payment.php" method="POST" style="display:inline;">
                                <input type="hidden" name="transaction_id" value="<?= $transaction_id ?>">
                                <input type="submit" value="Lanjutkan Pembayaran" class="btn btn-primary">
                            </form>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div> 

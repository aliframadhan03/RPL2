<?php

if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login sebagai user untuk melanjutkan pembayaran"); window.location="login.php";</script>';
    exit;
}

// Ambil semua transaksi
$transactions = mysqli_query($conn, "SELECT * FROM tb_transaction ORDER BY transaction_date DESC");

// Proses update status pembayaran dan pengiriman oleh admin
if (isset($_POST['update_status'])) {
    $transaction_id = $_POST['transaction_id'];
    $payment_status = $_POST['payment_status'];
    $shipping_status = $_POST['shipping_status'];
    $tracking_number = $_POST['tracking_number'];

    mysqli_query($conn, "UPDATE tb_transaction 
    SET payment_status = '$payment_status', shipping_status = '$shipping_status', tracking_number = '$tracking_number' 
    WHERE transaction_id = '$transaction_id'");

    echo '<script>alert("Status transaksi berhasil diperbarui!"); window.location="transaksi-admin.php";</script>';
}

// Proses pembatalan transaksi
if (isset($_POST['cancel_transaction'])) {
    $transaction_id = $_POST['transaction_id'];
    
    // Panggil fungsi dari file cancel-transaction.php
    include 'cancel-transaction.php';
    cancelTransaction($transaction_id);

    echo '<script>alert("Transaksi berhasil dibatalkan!"); window.location="transaksi-admin.php";</script>';
}

?>
<div class="untree_co-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Daftar Transaksi</h2>
                <div class="p-3 p-lg-5 border bg-white">
                    <?php while ($row = mysqli_fetch_assoc($transactions)) { ?>
                    <div class="border p-3 mb-3">
                        <form method="POST">
                            <input type="hidden" name="transaction_id" value="<?= $row['transaction_id'] ?>">
                            <p><strong>Nama:</strong> <?= $row['customer_name'] ?></p>
                            <p><strong>Alamat:</strong> <?= $row['customer_address'] ?></p>
                            <p><strong>Total Harga:</strong> Rp <?= number_format($row['total_price'], 0, ',', '.') ?></p>

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

                            <div class="form-group">
                                 <label for="payment_status"><strong>Status Pembayaran:</strong></label>
                                 <p class="form-control-static">Sudah Bayar</p>
                            </div>
                            
                            <div class="form-group">
                                 <label for="payment_status"><strong>Status Pengiriman:</strong></label>
                                 <p class="form-control-static"><?= $row['shipping_status']?></p>
                            </div>

                            <div class="form-group">
                                <label for="shipping_status"><strong>Update Status Pengiriman:</strong></label>
                                <select name="shipping_status" class="form-control">
                                    <option value="Sedang Dikemas" >Sedang Dikemas</option>
                                    <option value="Dalam Pengiriman" >Dalam Pengiriman</option>
                                    <option value="Selesai" >Selesai</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tracking_number"><strong>Nomor Resi:</strong></label>
                                <input type="text" name="tracking_number" class="form-control" value="<?= $row['tracking_number'] ?>">
                            </div>

                            <!-- Tampilkan Bukti Pembayaran -->
                            <div class="form-group">
                                <label for="payment_proof"><strong>Bukti Pembayaran:</strong></label>
                                <?php if ($row['payment_proof']) { ?>
                                    <div>
                                        <img src="<?= BASEURL; ?><?= htmlspecialchars($row['payment_proof']) ?>" alt="Bukti Pembayaran" style="max-width: 300px; max-height: 300px;">
                                    </div>
                                <?php } else { ?>
                                    <p>Tidak ada bukti pembayaran yang diunggah.</p>
                                <?php } ?>
                            </div>
                            <button type="submit" name="update_status" class="btn btn-primary">Perbarui Status</button>
                            
                        </form>
                        <form method="POST" action="cancel-transaction-admin.php"> 
                            <div class="form-group">
                                <!-- Tombol Cancel -->
                                <?php if ($row['shipping_status'] == 'Belum Dikemas') { ?>
                                    <input type="hidden" name="transaction_id" value="<?= $row['transaction_id'] ?>">
                                    <button type="submit" name="cancel_transaction" class="btn btn-danger">Batalkan Transaksi</button>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

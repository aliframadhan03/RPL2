<?php
// Pastikan pengguna telah login sebelum mengakses halaman ini
session_start();
if (!isset($_SESSION['id'])) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

// Ambil transaksi user yang sedang login
$id_user = $_SESSION['id'];
$query_transaksi = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id_user = $id_user ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="style.css"> <!-- Ganti dengan stylesheet Anda -->
</head>
<body>
    <div class="container">
        <h3>Riwayat Transaksi</h3>
        <?php if (mysqli_num_rows($query_transaksi) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($query_transaksi)) : ?>
                <div class="transaksi-item">
                    <p><strong>Nama Penerima:</strong> <?= $row['nama_penerima'] ?></p>
                    <p><strong>Alamat Pengiriman:</strong> <?= $row['alamat_pengiriman'] ?></p>
                    <p><strong>Total Harga:</strong> Rp.<?= number_format($row['total_harga'], 0, ",", ".") ?></p>
                    <p><strong>Status Pembayaran:</strong> <?= $row['status_pembayaran'] ?></p>
                    <p><strong>Status Pengiriman:</strong> <?= $row['status_pengiriman'] ?></p>
                    <p><strong>Nomor Resi:</strong> <?= $row['nomor_resi'] ?></p>

                    <?php
                    // Ambil detail transaksi
                    $id_transaksi = $row['id_transaksi'];
                    $query_detail = mysqli_query($conn, "SELECT * FROM tb_transaksi_detail WHERE id_transaksi = $id_transaksi");
                    ?>

                    <h4>Detail Barang:</h4>
                    <ul>
                        <?php while ($detail = mysqli_fetch_assoc($query_detail)) : ?>
                            <li><?= $detail['nama_produk'] ?> - Jumlah: <?= $detail['jumlah'] ?> - Harga: Rp.<?= number_format($detail['harga'], 0, ",", ".") ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Belum ada transaksi yang dilakukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>

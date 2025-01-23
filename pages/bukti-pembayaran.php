<?php
session_start();
include('db_connection.php'); // Make sure to include your database connection

if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login untuk melanjutkan checkout."); window.location="login.php";</script>';
    exit;
}

// Cek apakah keranjang tidak kosong
if (empty($_SESSION['cart'])) {
    echo '<script>alert("Keranjang belanja kosong."); window.location="keranjang.php";</script>';
    exit;
}

// Hitung total harga dari produk di keranjang
$total_price = 0;
foreach ($_SESSION['cart'] as $id => $jumlah) {
    $product_query = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = $id");
    $product = mysqli_fetch_array($product_query);
    $total_price += $product['product_price'] * $jumlah;
}

// Proses upload bukti pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi dan proses upload
    $payment_proof = $_FILES['payment_proof'];
    $target_dir = "../bukti_pembayaran/";
    $target_file = $target_dir . basename($payment_proof["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo '<script>alert("File sudah ada."); window.location="checkout.php";</script>';
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($payment_proof["size"] > 500000) { // Limit file size to 500 KB
        echo '<script>alert("Ukuran file terlalu besar."); window.location="checkout.php";</script>';
        $uploadOk = 0;
    }

    // Cek format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<script>alert("Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan."); window.location="checkout.php";</script>';
        $uploadOk = 0;
    }

    // Jika semua validasi lolos, upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($payment_proof["tmp_name"], $target_file)) {
            echo '<script>alert("Bukti pembayaran berhasil diupload!"); window.location="checkout.php";</script>';
            // Lakukan tindakan setelah upload berhasil, seperti menyimpan informasi pembayaran ke database
        } else {
            echo '<script>alert("Terjadi kesalahan saat mengupload file."); window.location="checkout.php";</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Same CSS as before or customized */
    </style>
</head>
<body>

<div class="checkout-container">
    <h2 class="checkout-title">Proses Checkout</h2>
    
    <h3>Detail Pesanan</h3>
    <ul class="product-list">
        <?php foreach ($_SESSION['cart'] as $id => $jumlah) : ?>
            <?php
            $product_query = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = $id");
            $product = mysqli_fetch_array($product_query);
            ?>
            <li>
                <strong><?= htmlspecialchars($product['product_name']); ?></strong> (Jumlah: <?= $jumlah; ?>) - 
                Rp. <?= number_format($product['product_price'] * $jumlah, 0, ',', '.'); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h4>Total Harga: Rp. <?= number_format($total_price, 0, ',', '.'); ?></h4>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="total_price" value="<?= $total_price; ?>">

        <h3>Upload Bukti Pembayaran</h3>
        <div class="form-group">
            <label for="payment_proof">Pilih file:</label>
            <input type="file" name="payment_proof" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Upload Bukti Pembayaran" class="btn">
        </div>
    </form>
    
    <div class="cancel-link">
        <a href="keranjang.php">Kembali ke Keranjang</a>
    </div>
</div>

</body>
</html>

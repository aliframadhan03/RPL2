<?php

if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login untuk melanjutkan checkout."); window.location="login.php";</script>';
    exit;
}

// Ambil data pengguna dari database
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '" . $_SESSION['id'] . "'");
$user = mysqli_fetch_object($query);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css"> <!-- Path ke CSS Anda -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .checkout-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .checkout-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .checkout-details {
            margin-bottom: 20px;
        }
        .product-list {
            list-style-type: none;
            padding: 0;
        }
        .product-list li {
            border-bottom: 1px solid #eaeaea;
            padding: 10px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #FFB300;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background-color: #FFB300;
        }
        .cancel-link {
            text-align: center;
            margin-top: 20px;
        }
        .cancel-link a {
            text-decoration: none;
            color: #FFB300;
        }
    </style>
    <script>
        function confirmOrder() {
            alert("Pesanan berhasil!");
            alert("Lanjutkan ke halaman pembayaran.");
        }
    </script>
</head>
<body>

<div class="checkout-container">
    <h2 class="checkout-title">Halaman Checkout</h2>
    <div class="checkout-details">
        <h3>Informasi Pengguna</h3>
        <p><strong>Nama:</strong> <?= htmlspecialchars($user->user_name); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user->username); ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($user->user_address); ?></p>
        
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
        
        <form action="process-checkout.php" method="POST" onsubmit="confirmOrder()">
            <input type="hidden" name="total_price" value="<?= $total_price; ?>">
            
            <h3>Metode Pembayaran</h3>

            <!-- Pilihan Pembayaran E-Wallet -->
            <div class="form-group">
                <label for="payment_method">E-Wallet:</label>
                <input type="radio" name="payment_method" value="Dana - 081387269994" required> Dana - 081387269994<br>
                <input type="radio" name="payment_method" value="Gopay - 081387269994"> Gopay - 081387269994<br>
                <input type="radio" name="payment_method" value="Ovo - 081387269994"> Ovo - 081387269994<br>
            </div>

            <!-- Pilihan Pembayaran Transfer Bank -->
            <div class="form-group">
                <label for="payment_method">Transfer Bank:</label>
                <input type="radio" name="payment_method" value="BNI - 78321504" required> BNI - 78321504<br>
                <input type="radio" name="payment_method" value="Mandiri - 78321504"> Mandiri - 78321504<br>
                <input type="radio" name="payment_method" value="BSI - 78321504"> BSI - 78321504<br>
            </div>

            <input type="hidden" name="customer_name" value="<?= htmlspecialchars($user->user_name); ?>">
            <input type="hidden" name="customer_address" value="<?= htmlspecialchars($user->user_address); ?>">

            <div class="form-group">
                <input type="submit" name="checkout" value="Bayar Sekarang" class="btn">
            </div>
        </form>
        
        <div class="cancel-link">
            <a href="keranjang.php">Kembali ke Keranjang</a>
        </div>
    </div>
</div>

</body>
</html>

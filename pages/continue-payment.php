<?php
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Anda harus login terlebih dahulu."); window.location="login.php";</script>';
    exit;
}

// Retrieve transaction_id from the form or URL
if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
} else {
    echo '<script>alert("Transaksi tidak ditemukan."); window.location="index.php";</script>';
    exit;
}

// Retrieve transaction details from the database to validate
$query = mysqli_query($conn, "SELECT * FROM tb_transaction WHERE transaction_id = '$transaction_id' AND user_id = '".$_SESSION['id']."'");
$transaction = mysqli_fetch_assoc($query);

if (!$transaction) {
    echo '<script>alert("Transaksi tidak ditemukan."); window.location="index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanjutkan Pembayaran</title>
    <link rel="stylesheet" href="style.css"> <!-- Path ke CSS Anda -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .payment-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .payment-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #FFB300;
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h2 class="payment-title">Lanjutkan Pembayaran untuk Transaksi #<?= htmlspecialchars($transaction_id); ?></h2>

    <form action="process-payment.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction_id); ?>">

        <div class="form-group">
            <label for="payment_proof">Upload Bukti Pembayaran (JPG, PNG, PDF):</label>
            <input type="file" name="payment_proof" id="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <div class="form-group">
            <input type="submit" name="submit_payment" value="Upload Bukti Pembayaran" class="btn">
        </div>
    </form>

    <div class="back-link">
        <a href="index.php">Kembali ke Halaman Utama</a>
    </div>
</div>

</body>
</html>

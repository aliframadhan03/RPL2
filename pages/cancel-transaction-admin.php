<?php

// Pastikan koneksi ke database sudah terhubung
include 'db_connection.php'; // Sesuaikan nama file koneksi Anda

// Cek apakah pengguna sudah login
session_start();
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login terlebih dahulu."); window.location="login.php";</script>';
    exit;
}

// Cek apakah transaction_id tersedia di POST
if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Mulai transaksi untuk memastikan atomisitas
    mysqli_begin_transaction($conn);

    try {
        // Langkah 1: Update status pengiriman transaksi menjadi 'Dibatalkan'
        $query = "UPDATE tb_transaction SET shipping_status = 'Dibatalkan' WHERE transaction_id = '$transaction_id'";
        
        if (!mysqli_query($conn, $query)) {
            throw new Exception("Error updating transaction: " . mysqli_error($conn));
        }

        // Langkah 2: Ambil semua produk terkait dengan transaksi ini
        $details_query = "SELECT product_id, quantity FROM tb_transaction_details WHERE transaction_id = '$transaction_id'";
        $details_result = mysqli_query($conn, $details_query);

        if (!$details_result) {
            throw new Exception("Error retrieving transaction details: " . mysqli_error($conn));
        }

        // Langkah 3: Loop melalui setiap produk dalam transaksi dan perbarui stok
        while ($row = mysqli_fetch_assoc($details_result)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Update stok produk dengan menambahkan quantity kembali
            $update_stock_query = "UPDATE tb_product SET product_stock = product_stock + $quantity WHERE product_id = $product_id";

            if (!mysqli_query($conn, $update_stock_query)) {
                throw new Exception("Error updating product stock: " . mysqli_error($conn));
            }
        }

        // Commit transaksi jika semua query berhasil
        mysqli_commit($conn);

        // Transaksi dibatalkan dengan sukses
        echo '<script>alert("Transaksi berhasil dibatalkan dan stok dikembalikan."); window.location="transaksi-admin.php";</script>';
    } catch (Exception $e) {
        // Rollback transaksi jika ada query yang gagal
        mysqli_rollback($conn);
        echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.location="transaksi-admin.php";</script>';
    }
} else {
    // transaction_id tidak ditemukan
    echo '<script>alert("Transaction ID tidak ditemukan."); window.location="transaksi-admin.php";</script>';
}
?>

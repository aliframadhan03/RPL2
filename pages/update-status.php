<?php
include 'data-user.php'; // Sesuaikan dengan file konfigurasi koneksi database

if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    $payment_status = $_POST['payment_status'];
    $shipping_status = $_POST['shipping_status'];
    $tracking_number = $_POST['tracking_number'];

    $update_query = "UPDATE tb_transaction 
                     SET payment_status = '$payment_status', shipping_status = '$shipping_status', tracking_number = '$tracking_number'
                     WHERE transaction_id = '$transaction_id'";

    if (mysqli_query($conn, $update_query)) {
        echo '<script>alert("Status transaksi berhasil diperbarui!"); window.location="data-user.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat memperbarui status."); window.location="data-user.php";</script>';
    }
}
?>

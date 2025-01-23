<?php
if (isset($_POST['submit_payment'])) {
    // Ensure the transaction ID is available
    $transaction_id = $_POST['transaction_id'];
    
    // Handle file upload
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        // Define the target directory for uploads
        $target_dir = "bukti_pembayaran/";
        
        // Get the file details
        $file_name = basename($_FILES["payment_proof"]["name"]);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $target_file = $target_dir . $transaction_id . '_' . time() . '.' . $file_type;

        // Validate file type (JPG, PNG, or PDF)
        $allowed_types = array('jpg', 'jpeg', 'png', 'pdf');
        if (!in_array($file_type, $allowed_types)) {
            echo '<script>alert("Hanya file JPG, PNG, dan PDF yang diperbolehkan."); window.location="continue-payment.php?transaction_id=' . $transaction_id . '";</script>';
            exit;
        }

        // Move the file to the target directory
        if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
            // Update the database with the payment proof and status
            $query = "UPDATE tb_transaction 
                      SET payment_proof = '$target_file', payment_status = 'Sudah Dibayar' 
                      WHERE transaction_id = '$transaction_id'";

            if (mysqli_query($conn, $query)) {
                echo '<script>alert("Bukti pembayaran berhasil diupload!"); window.location="transaksi-user.php";</script>';
            } else {
                echo '<script>alert("Gagal mengupdate transaksi: ' . mysqli_error($conn) . '"); window.location="continue-payment.php?transaction_id=' . $transaction_id . '";</script>';
            }
        } else {
            echo '<script>alert("Gagal mengupload bukti pembayaran."); window.location="continue-payment.php?transaction_id=' . $transaction_id . '";</script>';
        }
    } else {
        echo '<script>alert("Tidak ada file yang diupload atau terjadi kesalahan."); window.location="continue-payment.php?transaction_id=' . $transaction_id . '";</script>';
    }
}
?>

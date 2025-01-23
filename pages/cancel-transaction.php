<?php

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login terlebih dahulu."); window.location="login.php";</script>';
    exit;
}

// Check if the transaction_id is passed via POST
if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Start a transaction to ensure atomicity
    mysqli_begin_transaction($conn);

    try {
        // Step 1: Update the transaction's payment_status to 'Dibatalkan'
        $query = "UPDATE tb_transaction SET payment_status = 'Dibatalkan' WHERE transaction_id = '$transaction_id' AND user_id = '" . $_SESSION['id'] . "'";
        
        if (!mysqli_query($conn, $query)) {
            throw new Exception("Error updating transaction: " . mysqli_error($conn));
        }

        // Step 2: Retrieve all products related to this transaction
        $details_query = "SELECT product_id, quantity FROM tb_transaction_details WHERE transaction_id = '$transaction_id'";
        $details_result = mysqli_query($conn, $details_query);

        if (!$details_result) {
            throw new Exception("Error retrieving transaction details: " . mysqli_error($conn));
        }

        // Step 3: Loop through each product in the transaction and return the stock
        while ($row = mysqli_fetch_assoc($details_result)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Update the product stock by adding the quantity back
            $update_stock_query = "UPDATE tb_product SET product_stock = product_stock + $quantity WHERE product_id = $product_id";

            if (!mysqli_query($conn, $update_stock_query)) {
                throw new Exception("Error updating product stock: " . mysqli_error($conn));
            }
        }

        // Commit the transaction if all queries were successful
        mysqli_commit($conn);

        // Transaction canceled successfully
        echo '<script>alert("Transaksi berhasil dibatalkan dan stok dikembalikan."); window.location="transaksi-user.php";</script>';
    } catch (Exception $e) {
        // Rollback the transaction if any query failed
        mysqli_rollback($conn);
        echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.location="transaksi-user.php";</script>';
    }
} else {
    // No transaction_id was provided
    echo '<script>alert("Transaksi tidak ditemukan."); window.location="transaksi-user.php";</script>';
}
?>

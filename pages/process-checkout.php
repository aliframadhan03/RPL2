<?php

if (!isset($_SESSION['id'])) {
    echo '<script>alert("Login untuk melanjutkan checkout."); window.location="login.php";</script>';
    exit;
}

// Ambil data pengguna
$user_id = $_SESSION['id'];
$customer_name = $_POST['customer_name'] ?? ''; // Nama pengguna diambil dari sesi
$customer_address = $_POST['customer_address'] ?? ''; // Alamat pengguna diambil dari sesi
$total_price = $_POST['total_price'] ?? 0;
$transaction_date = date('Y-m-d H:i:s');
$payment_status = 'Belum Bayar';
$shipping_status = 'Belum Dikemas';
$tracking_number = generateTrackingNumber(); // Fungsi untuk menghasilkan nomor pelacakan

// Insert data ke tabel tb_transaction
$query = "INSERT INTO tb_transaction (user_id, customer_name, customer_address, total_price, transaction_date, payment_status, shipping_status, tracking_number, payment_proof) 
          VALUES ('$user_id', '$customer_name', '$customer_address', '$total_price', '$transaction_date', '$payment_status', '$shipping_status', '$tracking_number', NULL)";

if (mysqli_query($conn, $query)) {
    // Ambil transaction_id yang baru saja dimasukkan
    $transaction_id = mysqli_insert_id($conn);

    // Insert data ke tabel tb_transaction_details
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Ambil harga dan stok produk dari database
        $product_query = mysqli_query($conn, "SELECT product_price, product_stock FROM tb_product WHERE product_id = $product_id");
        $product = mysqli_fetch_array($product_query);
        $price = $product['product_price'];
        $stock = $product['product_stock'];

        // Cek apakah stok mencukupi
        if ($stock < $quantity) {
            echo '<script>alert("Stok barang tidak mencukupi untuk produk ID: ' . $product_id . '"); window.location="keranjang.php";</script>';
            exit;
        }

        // Insert detail transaksi
        $detail_query = "INSERT INTO tb_transaction_details (transaction_id, product_id, quantity, price) 
                        VALUES ('$transaction_id', '$product_id', '$quantity', '$price')";
        mysqli_query($conn, $detail_query);

        // Kurangi stok barang
        $new_stock = $stock - $quantity;
        $update_stock_query = "UPDATE tb_product SET product_stock = $new_stock WHERE product_id = $product_id";
        mysqli_query($conn, $update_stock_query);
    }

    // Kosongkan keranjang setelah checkout berhasil
    unset($_SESSION['cart']);

    // Redirect ke continue-payment.php dengan POST
    echo '<form id="redirectForm" action="continue-payment.php" method="POST" style="display: none;">
            <input type="hidden" name="transaction_id" value="' . htmlspecialchars($transaction_id) . '">
          </form>
          <script>
              document.getElementById("redirectForm").submit();
          </script>';
} else {
    echo '<script>alert("Terjadi kesalahan: ' . mysqli_error($conn) . '"); window.location="keranjang.php";</script>';
}

// Fungsi untuk menghasilkan nomor pelacakan
function generateTrackingNumber() {
    $prefix_length = 3; // Panjang prefix
    $suffix_length = 10; // Panjang suffix
    $prefix = generateRandomString($prefix_length); // Menghasilkan prefix acak
    $suffix = strtoupper(generateRandomString($suffix_length)); // Menghasilkan suffix acak
    return $prefix . $suffix;
}

// Fungsi untuk menghasilkan string acak
function generateRandomString($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Karakter yang digunakan
    $randomString = '';
    for ($i = 0; $length > $i; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>

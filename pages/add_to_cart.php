<?php
session_start(); // Pastikan session dimulai

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Periksa apakah keranjang belanja ada di session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Tambahkan produk ke keranjang
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    echo 'Produk berhasil ditambahkan ke keranjang!';
} else {
    echo 'Gagal menambahkan produk ke keranjang.';
}
?>

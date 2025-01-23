<?php

// Simpan transaksi
if (isset($_POST['submit_transaksi'])) {
    $id_user = $_SESSION['id'];
    $nama_penerima = mysqli_real_escape_string($conn, $_POST['nama_penerima']);
    $alamat_pengiriman = mysqli_real_escape_string($conn, $_POST['alamat_pengiriman']);
    $produk = $_POST['produk']; // array(id_produk => jumlah)
    
    // Hitung total harga
    $total_harga = 0;
    foreach ($produk as $id_produk => $jumlah) {
        $query_produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk = $id_produk");
        $data_produk = mysqli_fetch_assoc($query_produk);
        $total_harga += $data_produk['harga'] * $jumlah;
    }

    // Simpan ke tabel transaksi
    $insert_transaksi = mysqli_query($conn, "INSERT INTO tb_transaksi (id_user, nama_penerima, alamat_pengiriman, total_harga) 
                                              VALUES ('$id_user', '$nama_penerima', '$alamat_pengiriman', '$total_harga')");
    
    if ($insert_transaksi) {
        $id_transaksi = mysqli_insert_id($conn);

        // Simpan detail transaksi
        foreach ($produk as $id_produk => $jumlah) {
            $query_produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk = $id_produk");
            $data_produk = mysqli_fetch_assoc($query_produk);

            $nama_produk = $data_produk['nama_produk'];
            $harga = $data_produk['harga'];

            mysqli_query($conn, "INSERT INTO tb_transaksi_detail (id_transaksi, id_produk, nama_produk, jumlah, harga) 
                                 VALUES ('$id_transaksi', '$id_produk', '$nama_produk', '$jumlah', '$harga')");
        }

        echo '<script>alert("Transaksi berhasil ditambahkan!"); window.location="riwayat_transaksi.php";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan transaksi!");</script>';
    }
}
?>

//Transaksi User
<form method="POST" action="">
    <h3>Formulir Transaksi</h3>
    <div>
        <label>Nama Penerima:</label>
        <input type="text" name="nama_penerima" required>
    </div>
    <div>
        <label>Alamat Pengiriman:</label>
        <textarea name="alamat_pengiriman" required></textarea>
    </div>
    <div>
        <label>Pilih Produk:</label>
        <select name="produk[id_produk]" required>
            <?php
            $query_produk = mysqli_query($conn, "SELECT * FROM tb_produk");
            while ($row = mysqli_fetch_assoc($query_produk)) {
                echo '<option value="'.$row['id_produk'].'">'.$row['nama_produk'].' - Rp.'.$row['harga'].'</option>';
            }
            ?>
        </select>
        <input type="number" name="produk[jumlah]" min="1" required>
    </div>
    <button type="submit" name="submit_transaksi">Beli</button>
</form>


//Riwayat Transaksi User
<?php

// Ambil transaksi user
$id_user = $_SESSION['id'];
$query_transaksi = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id_user = $id_user ORDER BY created_at DESC");

echo '<h3>Riwayat Transaksi</h3>';
while ($row = mysqli_fetch_assoc($query_transaksi)) {
    echo '<div>';
    echo '<p>Nama Penerima: '.$row['nama_penerima'].'</p>';
    echo '<p>Alamat Pengiriman: '.$row['alamat_pengiriman'].'</p>';
    echo '<p>Total Harga: Rp.'.$row['total_harga'].'</p>';
    echo '<p>Status Pembayaran: '.$row['status_pembayaran'].'</p>';
    echo '<p>Status Pengiriman: '.$row['status_pengiriman'].'</p>';
    echo '<p>Nomor Resi: '.$row['nomor_resi'].'</p>';
    
    // Ambil detail transaksi
    $id_transaksi = $row['id_transaksi'];
    $query_detail = mysqli_query($conn, "SELECT * FROM tb_transaksi_detail WHERE id_transaksi = $id_transaksi");

    echo '<h4>Detail Barang:</h4>';
    while ($detail = mysqli_fetch_assoc($query_detail)) {
        echo '<p>'.$detail['nama_produk'].' - Jumlah: '.$detail['jumlah'].' - Harga: Rp.'.$detail['harga'].'</p>';
    }
    echo '</div><hr>';
}
?>

//Riwayat transaksi admin 
<?php

// Ambil semua transaksi
$query_transaksi = mysqli_query($conn, "SELECT * FROM tb_transaksi ORDER BY created_at DESC");

echo '<h3>Riwayat Semua Transaksi</h3>';
while ($row = mysqli_fetch_assoc($query_transaksi)) {
    echo '<div>';
    echo '<p>Nama Penerima: '.$row['nama_penerima'].'</p>';
    echo '<p>Alamat Pengiriman: '.$row['alamat_pengiriman'].'</p>';
    echo '<p>Total Harga: Rp.'.$row['total_harga'].'</p>';
    echo '<p>Status Pembayaran: '.$row['status_pembayaran'].'</p>';
    echo '<p>Status Pengiriman: '.$row['status_pengiriman'].'</p>';
    echo '<p>Nomor Resi: '.$row['nomor_resi'].'</p>';
    
    // Ambil detail transaksi
    $id_transaksi = $row['id_transaksi'];
    $query_detail = mysqli_query($conn, "SELECT * FROM tb_transaksi_detail WHERE id_transaksi = $id_transaksi");

    echo '<h4>Detail Barang:</h4>';
    while ($detail = mysqli_fetch_assoc($query_detail)) {
        echo '<p>'.$detail['nama_produk'].' - Jumlah: '.$detail['jumlah'].' - Harga: Rp.'.$detail['harga'].'</p>';
    }
    echo '</div><hr>';
}
?>



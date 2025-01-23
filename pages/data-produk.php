
<div class="untree_co-section before-footer-section">
<div class="container">
    <div class="row mb-5 bg-white pt-4 rounded">
    <div class="col-md-12 d-flex">
        <button class="btn btn-primary" onclick="window.location='<?= BASEURL; ?>aksi-produk.php'">Tambah Produk</button>
    </div>
    <form class="col-md-12" method="post">
        <div class="site-blocks-table">
        <table class="table">
            <thead> 
                <tr> 
                    <th width="40px">No</th> 
                    <th width="150px">Kategori</th> 
                    <th width="150px">Produk</th>
                    <th width="100px">Stock</th>
                    <th width="150px">Harga</th>
                    <th width="200px">Deskripsi</th>
                    <th width="90px">Gambar</th>
                    <th width="70px">Status</th>
                    <th width="120px">Aksi</th> 
                </tr> 
            </thead> 
            <tbody>
                 <?php 
                $no = 1; 
                $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
                if(mysqli_num_rows($produk) > 0) { 
                    while($row = mysqli_fetch_array($produk)) { 
                ?> 
                <tr> 
                    <td><?php echo $no++ ?></td> 
                    <td><?php echo $row['category_name'] ?></td>
                    <td><?php echo $row['product_name'] ?></td>
                    <td><?php echo $row['product_stock'].' Barang'; ?></td>
                    <td>Rp. <?php echo number_format($row['product_price']) ?></td>
                    <td><?php echo $row['product_description'] ?></td> 
                    <td><img src="produk/<?php echo $row['product_image'] ?>" width="60px"></td>
                    <td><?php echo ($row['product_status'] == 0) ? 'Tidak Aktif' : 'Aktif'; ?></td>
                    <td> 
                        <a href="aksi-produk.php?id=<?php echo $row['product_id'] ?>">Edit</a> || 
                        <a href="hapus.php?aksi=produk&id=<?php echo $row['product_id'] ?>" onclick="return confirm('Hapus Produk?')">Hapus</a> 
                    </td> 
                </tr> 
                <?php }} else { ?> 
                        <tr> 
                            <td colspan="8">Tidak Ada Data!</td> 
                        </tr> 
                <?php } ?> 
            </tbody>
        </table>
        </div>
    </form>
    </div>
</div>
</div>

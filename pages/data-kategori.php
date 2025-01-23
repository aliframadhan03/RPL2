
<div class="untree_co-section before-footer-section">
<div class="container">
    <div class="row mb-5 bg-white pt-4 rounded">
    <div class="col-md-12 d-flex">
        <button class="btn btn-primary" onclick="window.location='<?= BASEURL; ?>aksi-kategori.php'">Tambah Kategori</button>
    </div>
    <form class="col-md-12" method="post">
        <div class="site-blocks-table">
        <table class="table">
            <thead>
            <tr>
                <th class="product-thumbnail">No</th>
                <th class="product-name">Nama</th>
                <th class="product-price">Aksi</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                            $no = 1; 
                            $kategori = mysqli_query ($conn, "SELECT * FROM tb_category ORDER BY category_id DESC"); 
                            if(mysqli_num_rows($kategori) > 0) { 
                            while($row = mysqli_fetch_array($kategori)) { 
                        ?>
                        <tr> 
                            <td><?php echo $no++ ?></td> 
                            <td><?php echo $row['category_name'] ?></td> 
                            <td> 
                                <a href="aksi-kategori.php?id=<?php echo $row['category_id'] ?>">Edit</a> || 
                                <a href="hapus.php?aksi=kategori&id=<?php echo $row['category_id'] ?>" onclick="return confirm ('Yakin Ingin Hapus Kategori?')">Hapus</a> 
                            </td> 
                        </tr> 
                        <?php }} else { ?> 
                                <tr> 
                                    <td colspan="3">Tidak Ada Data</td> 
                                </tr> 
                        <?php } ?> 

            </tbody>
        </table>
        </div>
    </form>
    </div>
</div>
</div>

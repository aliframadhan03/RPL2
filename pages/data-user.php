
<div class="untree_co-section before-footer-section">
    <div class="container">
        <div class="row mb-5 bg-white pt-4 rounded">
            <div class="col-md-12 d-flex">
                <button class="btn btn-primary" onclick="window.location='<?= BASEURL; ?>aksi-user.php'">Tambah User</button>
                <button class="btn btn-secondary ml-2" onclick="window.location='transaksi-admin.php'">Kelola Transaksi</button>
            </div>
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <table class="table">
                        <thead> 
                            <tr> 
                                <th width="40px">No</th>
                                <th width="150px">Nama</th>
                                <th width="150px">Username</th>
                                <th width="150px">Email</th>
                                <th width="200px">Alamat</th>
                                <th width="120px">Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody>
                            <?php 
                            $no = 1; 
                            $user = mysqli_query($conn, "SELECT * FROM tb_user WHERE role = 2 ORDER BY user_id ASC");
                            if(mysqli_num_rows($user) > 0) { 
                                while($row = mysqli_fetch_array($user)) { 
                            ?> 
                            <tr> 
                                <td><?php echo $no++ ?></td> 
                                <td><?php echo $row['user_name'] ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['user_email'] ?></td> 
                                <td><?php echo $row['user_address'] ?></td> 
                                <td> 
                                    <a href="aksi-user.php?id=<?php echo $row['user_id'] ?>">Edit</a> || 
                                    <a href="hapus.php?aksi=user&id=<?php echo $row['user_id'] ?>" onclick="return confirm('Hapus Pengguna?')">Hapus</a> 
                                </td>

                            <?php }} else { ?> 
                                <tr> 
                                    <td colspan="7">Tidak Ada Data!</td> 
                                </tr> 
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Nis</th>
                <th>Jenis Kelamin</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sqlU = $koneksi->query("SELECT * FROM tb_users WHERE level <> 'super_admin'");
            while ($dataU = $sqlU->fetch_assoc()) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="text-capitalize"><?= $dataU['name']; ?></td>
                    <td><?= $dataU['username']; ?></td>
                    <td><?= $dataU['nis']; ?></td>
                    <td><?= $dataU['jk']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detail-user<?= $dataU['id_user']; ?>"><i class="fa-solid fa-info"></i></button>
                        
                        <?php if ($_SESSION['super_admin']) {
                            if ($dataU['level'] == 'admin') {
                                echo '<button class="btn btn-danger btn-sm" id="removeAdmin" data-id="' . $dataU['id_user'] . '"><i class="fa-solid fa-user-xmark"></i></button>';
                            } else {
                                echo '<button class="btn btn-warning btn-sm" id="admin" data-id="' . $dataU['id_user'] . '"><i class="fa-solid fa-user-shield"></i></button>';
                            }
                        }
                        ?>
                    </td>
                </tr>
    
                <!-- Modal -->
                <div class="modal fade" id="detail-user<?= $dataU['id_user']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Nama</p>
                                        <p>Username</p>
                                        <p>NIS</p>
                                        <p>Jenis Kelamin</p>
                                        <p>Tanggal Lahir</p>
                                        <p>No Telepon</p>
                                        <p>Alamat</p>
                                        <p>Tanggal Daftar </p>
                                        <p>Terakhir Diupdate</p>
                                    </div>
    
                                    <div class="text-end">
                                        <p class="text-capitalize"><?= $dataU['name']; ?></p>
                                        <p><?= $dataU['username']; ?></p>
                                        <p><?= $dataU['nis']; ?></p>
                                        <p><?= $dataU['jk']; ?></p>
                                        <p><?= $dataU['tgl_lahir']; ?></p>
                                        <p><?= $dataU['no_hp']; ?></p>
                                        <p><?= $dataU['alamat']; ?></p>
                                        <p><?= date("d/m/Y H:i", strtotime($dataU['created_at']));?></p>
                                        <p><?php if($dataU['update_at'] == null){
                                            echo date("d/m/Y H:i", strtotime($dataU['created_at']));
                                        }else{
                                            echo date("d/m/Y H:i", strtotime($dataU['update_at']));
                                        }?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </tbody>
    </table>
</div>
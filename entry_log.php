<?php

include 'connect.php' ;

if (empty($session_login))
    header('location: login.php');

$id = $_GET['id'];
$check_data = "SELECT * FROM `transaksi_resi_pengiriman` WHERE id = ?";
$check_data = $connect->prepare($check_data);
$check_data->execute([$id]);

if ($check_data->rowCount() == 0)
    header('location: admin.php');

$fetch_data = $check_data->fetch();

if (isset($_POST['tambah'])){
    $tanggal = $_POST['tanggal'];
    $kota = $_POST['kota'];
    $keterangan = $_POST['keterangan'];

    $insert_data = "INSERT INTO `detail_log_pengiriman` SET nomor_resi = ?, tanggal = ?, kota = ?, keterangan = ?";
    $insert_data = $connect->prepare($insert_data);
    $insert_data->execute([
        $fetch_data['nomor_resi'],
        date('Y-m-d', strtotime($tanggal)),
        $kota,
        $keterangan
    ]);

    header('location: entry_log.php?id='.$id);
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            .content-web {
                padding: 25px;
                border: 1px solid #ccc;
                border-radius: 8px;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Halo, Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Data Resi Pengiriman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php">User Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="content-web my-5">
                <div class="col-md-3">
                    <form method="post">
                        <h3>Entry Log Nomor Resi</h3>
                        <p>Tanggal</p>
                        <input type="date" name="tanggal" class="form-control form-control-lg" value="<?=$fetch_data['tanggal_resi']?>"><br/>

                        <p>Kota</p>
                        <input type="text" name="kota" class="form-control form-control-lg"><br/>

                        <p>Keterangan</p>
                        <textarea class="form-control" rows="5" name="keterangan"></textarea><br/>

                        <div class="d-grid gap-2">
                            <button name="tambah" class="btn btn-dark btn-lg">Entry</button>
                        </div>
                    </form>
                </div>

                <table class="table my-5 table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" width="200">Tanggal Resi</th>
                            <th scope="col" width="300">Kota</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $check_list = "SELECT * FROM `detail_log_pengiriman` WHERE nomor_resi = ?";
                        $check_list = $connect->prepare($check_list);
                        $check_list->execute([$fetch_data['nomor_resi']]);

                        if ($check_list->rowCount() > 0):
                        
                            while($data = $check_list->fetch(PDO::FETCH_ASSOC)): ?>
                            
                                <tr>
                                    <td><?=date('d/m/Y', strtotime($data['tanggal']))?></td>
                                    <td><?=$data['kota']?></td>
                                    <td><?=$data['keterangan']?></td>
                                </tr>
                            
                            <?php endwhile ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<?php

include 'connect.php';

if (empty($session_login))
    header('location: login.php');

if (isset($_POST['tambah'])){
    $tanggal = $_POST['tanggal'];
    $nomor_resi = $_POST['nomor_resi'];
    $check_nomor = $connect->prepare("SELECT * FROM `transaksi_resi_pengiriman` WHERE nomor_resi = ?");
    $check_nomor->execute([$nomor_resi]);

    if ($check_nomor->rowCount() > 0)
        $msg = 'Nomor resi sudah ada.';
    else
    {
        $insert_data = "INSERT INTO `transaksi_resi_pengiriman` SET nomor_resi = ?, tanggal_resi = ?";
        $insert_data = $connect->prepare($insert_data);
        $insert_data->execute([
            $nomor_resi, 
            date('Y-m-d', strtotime($tanggal))
        ]);

        if ($insert_data)
            header('location: ?msg=berhasil_ditambahkan');
        else
            $msg = 'Data gagal ditambahkan';
    }
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
                padding: 20px;
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
                        <h3>Entry Nomor Resi</h3>

                        <?php if (isset($msg) && $_GET['msg'] == 'berhasil_ditambahkan'): ?>
                        <div class="alert alert-success">Data berhasil ditambahkan</div>
                        <?php endif ?>

                        <p>Tanggal</p>
                        <input type="date" name="tanggal" class="form-control form-control-lg"><p></p>

                        <p>Nomor Resi</p>
                        <input type="text" name="nomor_resi" class="form-control form-control-lg"><p></p>

                        <?=isset($msg) ? '<div class="alert alert-danger">'.$msg.'</div>' : '' ?>

                        <div class="d-grid gap-2">
                            <button name="tambah" class="btn btn-dark btn-lg">Entry</button>
                        </div>
                    </form>
                </div>

                <table class="table my-5 table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" width="145">Tanggal Resi</th>
                            <th scope="col" width="500">Nomor Resi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $check_data = "SELECT * FROM `transaksi_resi_pengiriman` ORDER BY tanggal_resi ASC";
                        $check_data = $connect->prepare($check_data);
                        $check_data->execute();

                        if ($check_data->rowCount() > 0): 
                            while ($data = $check_data->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?=date('d/m/Y', strtotime($data['tanggal_resi']))?></td>
                                    <td><?=$data['nomor_resi']?></td>
                                    <td>
                                        <a href="entry_log.php?id=<?=$data['id']?>" class="btn btn-primary btn-sm">Entry Log</a>
                                        <a href="hapus.php?id=<?=$data['id']?>" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
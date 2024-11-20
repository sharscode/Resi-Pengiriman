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

if (isset($_POST['hapus'])){
    $delete_data = "DELETE FROM `transaksi_resi_pengiriman` WHERE id = ?";
    $delete_data = $connect->prepare($delete_data);
    $delete_data->execute([ $id ]);

    header('location: admin.php');
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
                <h3>Hapus Entry</h3>
                <p>Apakah Anda yakin ingin menghapus data dengan nomor resi <b><?=$fetch_data['nomor_resi']?></b>?</p><br/>

                <form method="post">
                    <a href="admin.php" class="btn btn-secondary">&laquo; Batalkan</a> 
                    <button class="btn btn-danger" name="hapus">Hapus</button>
                </form>
            </div>
        </div>
    </body>
</html>

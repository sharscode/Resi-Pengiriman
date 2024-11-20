<?php

include 'connect.php';

if (empty($session_login))
    header('location: login.php');


if (isset($_POST['simpan'])){
    $id = $_GET['id'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    if (empty($username) || empty($nama) || empty($password))
        $msg = 'Tidak boleh ada yang kosong!';

    else{
        $check_pengguna = "SELECT * FROM `user_admin` WHERE username = ? AND id != ?";
        $check_pengguna = $connect->prepare($check_pengguna);
        $check_pengguna->execute([$username, $session_login]);

        if ($check_pengguna->rowCount() > 0)
            $msg = 'Username telah digunakan';
        
        else{
            $update_data = "UPDATE `user_admin` SET username = ?, password = ?, nama_admin = ? WHERE id = ?";
            $update_data = $connect->prepare($update_data);
            $update_data->execute([
                $username,
                $password,
                $nama,
                $id
            ]);

            if ($update_data)
                header('location: user.php');
            else
                $msg = 'Data gagal diperbarui';
        }
    }
}

if (isset($_POST['tambah'])){
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    if (empty($username) || empty($nama) || empty($password))
        $msg = 'Semua harap diisi!';

    else{
        $check_pengguna = "SELECT * FROM `user_admin` WHERE username = ?";
        $check_pengguna = $connect->prepare($check_pengguna);
        $check_pengguna->execute([$username]);

        if ($check_pengguna->rowCount() > 0)
            $msg = 'Username telah digunakan';
        
        else{
            $update_data = "INSERT INTO `user_admin` SET username = ?, password = ?, nama_admin = ?";
            $update_data = $connect->prepare($update_data);
            $update_data->execute([
                $username,
                $password,
                $nama
            ]);

            if ($update_data)
                header('location: user.php');
            else
                $msg = 'Data gagal ditammbahkan';
        }
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'nonaktifkan'){
    $id = $_GET['id'];
    $nonaktifkan = "UPDATE `user_admin` SET status_aktif = ? WHERE id = ? AND id != ?";
    $nonaktifkan = $connect->prepare($nonaktifkan);
    $nonaktifkan->execute([0, $id, $session_login]);

    header('location: user.php');
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
                <h3>Entry New User Admin</h3>
                <div class="row">
                    <div class="col-md-3">
                        <form method="post">
                            <?php if (isset($_GET['act']) && $_GET['act'] == 'edit'):
                                $id = $_GET['id'];
                                $check_user = "SELECT * FROM `user_admin` WHERE id = ?";
                                $check_user = $connect->prepare($check_user);
                                $check_user->execute([$id]);
                                $fetch_data = $check_user->fetch();
                                
                                if ($check_user->rowCount() == 0):
                                    echo '<div class="alert alert-danger">User tidak ditemukan</div>';
                                    
                                else: ?>

                            <h3>Edit User</h3>

                            <br/>
                            <p>Username</p>
                            <input type="text" name="username" class="form-control"
                                value="<?=$fetch_data['username']?>"><br/>

                            <p>Nama</p>
                            <input type="text" name="nama" class="form-control"
                                value="<?=$fetch_data['nama_admin']?>"><br/>

                            <p>Password</p>
                            <input type="password" name="password" class="form-control"><br/>

                            <div class="d-grid gap-2">
                                <button class="btn btn-dark " name="simpan">Simpan</button>
                            </div>

                            <?php endif ?>

                            <?php else: ?>

                            <br/>
                            <p>Username</p>
                            <input type="text" name="username" class="form-control"><br/>

                            <p>Nama</p>
                            <input type="text" name="nama" class="form-control"><br/>

                            <p>Password</p>
                            <input type="password" name="password" class="form-control"><br/>

                            <div class="d-grid gap-2">
                                <button class="btn btn-dark " name="tambah">Tambah</button>
                            </div>

                            <?php endif ?>

                            <?=isset($msg) ? '<br/><div class="alert alert-danger">'.$msg.'</div>' : ''?>

                        </form>
                    </div>

                    <div class="col-md-9">
                        <!-- <br/> -->
                        <p></p>
                        <p></p>
                        <h3>Data Admin</h3>
                        <p></p>
                        <table class="table table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $check_user = "SELECT * FROM `user_admin` ORDER BY id ASC";
                                $check_user = $connect->prepare($check_user);
                                $check_user->execute();

                                if ($check_user->rowCount() > 0):
                                    while($data= $check_user->fetch(PDO::FETCH_ASSOC)) : ?>
                                        <tr>
                                            <td><?=$data['id']?></td>
                                            <td><?=$data['username']?></td>
                                            <td><?=$data['nama_admin']?></td>
                                            <td><?=$data['status_aktif'] == 1 ? 'Aktif' : 'Tidak Aktif'?></td>
                                            <td>
                                                <?php if ($data['status_aktif'] != 0): ?>
                                                    <a href="?act=edit&id=<?=$data['id']?>" class="btn btn-primary btn-sm">Edit</a>

                                                    <a href="?act=nonaktifkan&id=<?=$data['id']?>" class="btn btn-danger btn-sm">Nonaktifkan</a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endwhile?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
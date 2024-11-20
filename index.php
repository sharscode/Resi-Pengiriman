<?php

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');

    $search = isset($_POST['search']) ? $_POST['search'] : '';

    if (!empty($search)){
        $check_search = "SELECT * FROM `detail_log_pengiriman` WHERE nomor_resi = ? ORDER BY tanggal ASC";
        $check_search = $connect->prepare($check_search);
        $check_search->execute([$search]);
    }
    else{
        $check_search = "SELECT * FROM `detail_log_pengiriman` ORDER BY tanggal ASC";
        $check_search = $connect->prepare($check_search);
        $check_search->execute();
    }

    $list_data = [];
    if ($check_search->rowCount() > 0){
        while($data = $check_search->fetch(PDO::FETCH_ASSOC))
            $list_data[] = [
                'tanggal' => date('d/m/Y', strtotime($data['tanggal'])),
                'kota' => $data['kota'],
                'keterangan' => $data['keterangan']
            ];
    }
    echo json_encode($list_data);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cek Pengiriman</title>
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
                <a class="navbar-brand" href="#">WELCOME!</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="content-web my-5">
                <h3>Cek Pengiriman</h3>

                <form id="form-pengiriman" class="col-md-3 my-3">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nomor Pengiriman"
                            aria-label="Recipient's username" aria-describedby="basic-addon2" name="search">
                        <button class="btn btn-dark">Lihat</button>
                    </div>
                </form>

                <div id="output-pengiriman">Loading...</div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script>
            $(function(){
                const ajax_pengiriman = (cari = '') =>{
                    const outputDiv = $("#output-pengiriman")
                    $.ajax({
                        url: 'index.php',
                        type: 'POST',
                        data: cari,
                        success: function(output){
                            if (output.length == 0)
                                outputDiv.html(`<p class="mt-5">Tidak ada data yang tersimpan.</p>`)

                            else{
                                let output_append = `
                                    <table class="table table-bordered mt-5">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <td width="150">Tanggal</td>
                                                <td width="200">Kota</td>
                                                <td>Keterangan</td>
                                            </tr>
                                        </thead>`

                                $.each(output, (index, value) =>{
                                    output_append += `
                                        <tr>
                                            <td>${value.tanggal}</td>
                                            <td>${value.kota}</td>
                                            <td>${value.keterangan}</td>
                                        </tr>`
                                })
                                
                                output_append += '</table>'

                                outputDiv.html(output_append)
                            }
                        },
                        error:function() {
                            alert('Terjadi kesalahan pada server.')
                        }
                    })
                }

                $("#form-pengiriman").submit(function(e){
                    e.preventDefault();

                    const search = $(this).serialize();

                    ajax_pengiriman(search)
                })

                ajax_pengiriman()
            })
        </script>
    </body>
</html>
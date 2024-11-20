<?php

session_start();

try {
    $connect = new PDO('mysql:host=localhost;dbname=db_uastekweb', 'root', '');
} catch(PDOException $e) {
    die('Gagal terkoneksi ke database!<br/>Error: '.$e);
}

$session_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';

?>
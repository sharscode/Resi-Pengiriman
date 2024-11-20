<?php

include 'connect.php';

unset($_SESSION['login']);

header('location: index.php');

?>
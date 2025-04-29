<?php
//mendefinisikan Database
define('HOST', 'localhost'); //127.0.0.1
define('USER', 'root');
define('PASS','');
define('DB', 'noted');

//menjalankan query connect ke database
$con = mysqli_connect(HOST,USER,PASS,DB) or die("Unable to Connect");
//if($con){echo "Koneksi Terhubung";} untuk cek apakah sudah terhubung cek ke chrome localhost/Android/praktikum/koneksi.php
?>
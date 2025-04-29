<?php
// Membuat koneksi ke database
require_once('koneksi.php');

// Memastikan parameter user_id dikirimkan
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode(array('error' => 'User ID is required or empty!'));
    exit;
}

// Mengambil user_id dari parameter GET dan memastikan itu adalah angka
$user_id = $_GET['user_id'];

// Validasi user_id untuk memastikan itu adalah angka
if (!is_numeric($user_id)) {
    echo json_encode(array('error' => 'Invalid User ID!'));
    exit;
}

// Menghindari SQL Injection
$user_id = mysqli_real_escape_string($con, $user_id);

// Membuat query SQL untuk menampilkan folder berdasarkan user_id
$sql = "SELECT * FROM tb_folders WHERE user_id = '$user_id'";

// Menyimpan hasil dari database 
$r = mysqli_query($con, $sql);

// Jika query gagal
if (!$r) {
    echo json_encode(array('error' => 'Database query failed!'));
    exit;
}

// Deklarasi array untuk menyimpan data folder
$result = array();

// Fetch nilai r ke dalam array per baris 
while ($row = mysqli_fetch_array($r)) {
    array_push($result, array(
        "folder_id" => $row['folder_id'],
        "name" => $row['name']
    ));
}

// Melakukan JSON Encoding dan mengirimkan hasil
echo json_encode(array('result' => $result));

// Menutup koneksi
mysqli_close($con);
?>

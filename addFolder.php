<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil nilai yang dikirimkan oleh front-end
    $name = $_POST['name'];
    $user_id = $_POST['user_id']; // Menambahkan user_id

    // Membangun query SQL dengan user_id
    $sql = "INSERT INTO tb_folders (name, user_id) VALUES('$name', '$user_id')";

    // Koneksi ke database
    require_once('koneksi.php');
    if (mysqli_query($con, $sql)) {
        echo "Success Adding Folder!";
    } else {
        echo "Fail Adding Folder!";
    }

    // Menutup koneksi MySQL
    mysqli_close($con);
} else {
    echo "REQUEST OTHER THAN POST";
}
?>
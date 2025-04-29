<?php
    // Memastikan parameter folder_id dan user_id dikirimkan
    if (!isset($_GET['folder_id']) || !isset($_GET['user_id'])) {
        echo "Folder ID and User ID are required!";
        exit;
    }

    // Mengambil nilai yang dikirimkan oleh front-end
    $id = $_GET['folder_id'];
    $user_id = $_GET['user_id'];

    // Membangun query SQL dengan validasi user_id
    $sql = "DELETE FROM tb_folders WHERE folder_id = '$id' AND user_id = '$user_id'";

    // Koneksi ke database
    require_once('koneksi.php');
    if (mysqli_query($con, $sql)) {
        echo "Success Deleted the Folder!";
    } else {
        echo "Fail to Delete Folder!";
    }

    // Menutup koneksi MySQL
    mysqli_close($con);
?>
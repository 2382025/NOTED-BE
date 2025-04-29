<?php
    // Memastikan parameter id dan user_id dikirimkan
    if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
        echo "Note ID and User ID are required!";
        exit;
    }

    // Mengambil nilai yang dikirimkan oleh front-end
    $id = $_GET['id'];
    $user_id = $_GET['user_id'];

    // Membangun query SQL dengan validasi user_id
    $sql = "DELETE FROM tb_notes WHERE id = '$id' AND user_id = '$user_id'";

    // Koneksi ke database
    require_once('koneksi.php');
    if (mysqli_query($con, $sql)) {
        echo "Success Deleted the Note!";
    } else {
        echo "Fail to Delete Note!";
    }

    // Menutup koneksi MySQL
    mysqli_close($con);
?>
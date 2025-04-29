<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil nilai yang dikirimkan oleh front-end
    $title = $_POST['title'];
    $content = $_POST['content'];
    $folder_id = $_POST['folder_id'];
    $user_id = $_POST['user_id']; // Menambahkan user_id

    // Membangun query SQL dengan user_id
    $sql = "INSERT INTO tb_notes (title, content, folder_id, user_id) VALUES('$title', '$content', '$folder_id', '$user_id')";

    // Koneksi ke database
    require_once('koneksi.php');
    if (mysqli_query($con, $sql)) {
        echo "Success Adding Note!";
    } else {
        echo "Fail Adding Note!";
    }

    // Menutup koneksi MySQL
    mysqli_close($con);
} else {
    echo "REQUEST OTHER THAN POST";
}
?>

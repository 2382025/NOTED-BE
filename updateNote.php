<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil nilai yang dikirimkan oleh front-end
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_POST['user_id']; // Menambahkan user_id

    // Membuat query SQL dengan validasi user_id
    $sql = "UPDATE tb_notes SET 
                title = '$title', 
                content = '$content' 
            WHERE id = '$id' AND user_id = '$user_id'"; // Validasi berdasarkan id dan user_id

    // Trigger koneksi
    require_once('koneksi.php');
    if (mysqli_query($con, $sql)) {
        echo "Success Updating Note!";
    } else {
        echo "Fail Editing Note!";
    }

    // Menutup koneksi
    mysqli_close($con);
} else {
    echo "REQUEST OTHER THAN POST";
}
?>

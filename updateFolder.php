<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('koneksi.php'); // koneksi dulu

    // Mengambil nilai dari POST dan amankan
    $id = mysqli_real_escape_string($con, $_POST['folder_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']); // Tambahkan user_id

    // Membuat query SQL yang benar
    $sql = "UPDATE tb_folders SET 
                name = '$name'
            WHERE folder_id = '$id' AND user_id = '$user_id'"; // Validasi berdasarkan folder_id dan user_id

    if (mysqli_query($con, $sql)) {
        echo "Success Updating Folder!";
    } else {
        echo "Fail Editing Folder!";
    }

    mysqli_close($con);
} else {
    echo "REQUEST OTHER THAN POST";
}
?>

<?php 
// Memastikan parameter folder_id dan user_id dikirimkan
if (!isset($_GET['folder_id']) || !isset($_GET['user_id'])) {
    echo "Folder ID and User ID are required!";
    exit;
}

// Mengambil nilai dari parameter GET
$folder_id = $_GET['folder_id'];
$user_id = $_GET['user_id'];

// Koneksi ke database
require_once('koneksi.php');

// Membuat query SQL dengan validasi user_id
$sql = "SELECT * FROM tb_notes WHERE folder_id = '$folder_id' AND user_id = '$user_id'";
$r = mysqli_query($con, $sql);

$result = array();

// Looping semua data
while ($row = mysqli_fetch_array($r)) {
    array_push($result, array(
        "id" => $row['id'],
        "title" => $row['title'],
    ));
}

// Mengembalikan hasil dalam format JSON
echo json_encode(array('result' => $result));

// Menutup koneksi
mysqli_close($con);
?>

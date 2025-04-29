<?php 
// Memastikan parameter id dan user_id dikirimkan
if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
    echo json_encode(array("message" => "Note ID and User ID are required!"));
    exit;
}

// Mengambil nilai dari parameter GET
$id = $_GET['id'];
$user_id = $_GET['user_id'];

// Koneksi ke database
require_once('koneksi.php');

// Menyiapkan query SQL dengan prepared statement
$sql = "SELECT * FROM tb_notes WHERE id = ? AND user_id = ?";

// Menyiapkan prepared statement
$stmt = mysqli_prepare($con, $sql);

// Mengikat parameter
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);

// Menjalankan query
mysqli_stmt_execute($stmt);

// Mendapatkan hasil query
$result = mysqli_stmt_get_result($stmt);

$response = array();
if ($row = mysqli_fetch_assoc($result)) {
    array_push($response, array(
        "id" => $row['id'],
        "title" => $row['title'],
        "content" => $row['content'],
        "folder_id" => $row['folder_id'],
        "created_at" => $row['created_at']
    ));
    echo json_encode(array('result' => $response));
} else {
    echo json_encode(array("message" => "Note not found or access denied!"));
}

// Menutup prepared statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($con);
?>

<?php
header('Content-Type: application/json'); // Menentukan tipe konten sebagai JSON
require_once('koneksi.php');

// Memastikan parameter user_id dikirimkan
if (!isset($_GET['user_id'])) {
    echo json_encode(array("message" => "User ID is required!"));
    exit;
}

// Mengambil user_id dari parameter GET dan melakukan sanitasi (pastikan user_id berupa angka)
$user_id = intval($_GET['user_id']);  // Menggunakan intval untuk mencegah input yang tidak valid

// Memastikan user_id valid (misalnya, user_id harus lebih dari 0)
if ($user_id <= 0) {
    echo json_encode(array("message" => "Invalid User ID!"));
    exit;
}

// Membuat query SQL menggunakan prepared statement untuk menampilkan catatan berdasarkan user_id
$sql = "SELECT * FROM tb_notes WHERE user_id = ?";

// Menyiapkan prepared statement
$stmt = mysqli_prepare($con, $sql);

// Bind parameter (mengikat nilai user_id ke query)
mysqli_stmt_bind_param($stmt, "i", $user_id);

// Menjalankan query
mysqli_stmt_execute($stmt);

// Menyimpan hasil query
$result = mysqli_stmt_get_result($stmt);

// Deklarasi array untuk menyimpan data catatan
$notes = array();

// Mengambil hasil query dan menyimpannya dalam array
while ($row = mysqli_fetch_assoc($result)) {
    array_push($notes, array(
        "id" => $row['id'],
        "title" => $row['title']
    ));
}

// Melakukan JSON Encoding
echo json_encode(array('result' => $notes));

// Menutup prepared statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($con);
?>

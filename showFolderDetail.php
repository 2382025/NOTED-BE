<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('koneksi.php');

    // Ambil data dari POST
    $folder_id = $_POST['folder_id'] ?? '';
    $user_id = $_POST['user_id'] ?? '';

    if (empty($folder_id) || empty($user_id)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
        exit;
    }

    // Hindari SQL Injection
    $folder_id = mysqli_real_escape_string($con, $folder_id);
    $user_id = mysqli_real_escape_string($con, $user_id);

    // Ambil catatan yang sesuai dengan folder dan user
    $sql = "SELECT id, title FROM tb_notes WHERE folder_id = '$folder_id' AND user_id = '$user_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $notes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }

        echo json_encode([
            'status' => 'success',
            'result' => $notes
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . mysqli_error($con)
        ]);
    }

    mysqli_close($con);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>

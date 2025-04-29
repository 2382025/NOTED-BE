<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('koneksi.php');
    
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    if (empty($input['id']) || empty($input['user_id'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
        exit;
    }
    
    $id = mysqli_real_escape_string($con, $input['id']);
    $user_id = mysqli_real_escape_string($con, $input['user_id']);
    
    $sql = "DELETE FROM tb_notes WHERE id = '$id' AND user_id = '$user_id'";
    
    if (mysqli_query($con, $sql)) {
        $affected = mysqli_affected_rows($con);
        if ($affected > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Note deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No note found']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
    
    mysqli_close($con);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
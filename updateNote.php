<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Require database connection
    require_once('koneksi.php');
    
    // Get all input data
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    // Validate required fields
    $required = ['id', 'title', 'content', 'user_id'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => "Missing required field: $field"
            ]);
            exit;
        }
    }
    
    // Prepare data with sanitization
    $id = mysqli_real_escape_string($con, $input['id']);
    $title = mysqli_real_escape_string($con, $input['title']);
    $content = mysqli_real_escape_string($con, $input['content']);
    $user_id = mysqli_real_escape_string($con, $input['user_id']);
    $folder_id = isset($input['folder_id']) ? mysqli_real_escape_string($con, $input['folder_id']) : null;
    
    // Build SQL query
    $sql = "UPDATE tb_notes SET 
                title = '$title', 
                content = '$content', 
                folder_id = " . ($folder_id ? "'$folder_id'" : "NULL") . " 
            WHERE id = '$id' AND user_id = '$user_id'";
    
    // Execute query
    if (mysqli_query($con, $sql)) {
        $affected_rows = mysqli_affected_rows($con);
        if ($affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Note updated successfully',
                'affected_rows' => $affected_rows
            ]);
        } else {
            echo json_encode([
                'status' => 'no_change',
                'message' => 'No changes made or note not found'
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . mysqli_error($con),
            'sql_error' => mysqli_errno($con)
        ]);
    }
    
    mysqli_close($con);
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}
?>
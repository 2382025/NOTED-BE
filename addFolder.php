<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    if (!isset($_POST['name']) || !isset($_POST['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }

    $name = trim($_POST['name']);
    $user_id = trim($_POST['user_id']);

    if (empty($name) || empty($user_id)) {
        echo json_encode(['success' => false, 'message' => 'Folder name or user ID is empty']);
        exit;
    }

    require_once('koneksi.php');

    $sql = "INSERT INTO tb_folders (name, user_id) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $name, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Success Adding Folder!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database execution failed']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Prepared statement error']);
    }

    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

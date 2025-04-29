<?php
header("Content-Type: application/json");

require_once('koneksi.php');

$response = ["status" => "error", "message" => "Unknown error"];

try {
    // Pastikan ini POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response["message"] = "Invalid request method";
        echo json_encode($response);
        exit;
    }

    // Ambil data dari POST form
    $folder_id = $_POST['folder_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    // Validasi
    if (!$folder_id || !$user_id) {
        $response["message"] = "Folder ID and User ID are required";
        echo json_encode($response);
        exit;
    }

    // Pastikan numeric
    if (!is_numeric($folder_id) || !is_numeric($user_id)) {
        $response["message"] = "Invalid ID format";
        echo json_encode($response);
        exit;
    }

    // Konversi ke integer
    $folder_id = (int)$folder_id;
    $user_id = (int)$user_id;

    // Lakukan penghapusan
    $stmt = $con->prepare("DELETE FROM tb_folders WHERE folder_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $folder_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            "status" => "success",
            "message" => "Folder deleted successfully"
        ];
    } else {
        $response["message"] = "Folder not found or no permission";
    }

    $stmt->close();
} catch (Exception $e) {
    $response["message"] = "Database error: " . $e->getMessage();
} finally {
    $con->close();
}

echo json_encode($response);
?>
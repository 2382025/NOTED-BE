<?php
header("Content-Type: application/json");
require_once('koneksi.php');

$response = ["status" => "error", "message" => "Unknown error"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $current_password = $_POST['current_password'] ?? null;
    $new_password = $_POST['new_password'] ?? null;

    if (!$user_id || !$current_password || !$new_password) {
        $response["message"] = "All fields are required";
        echo json_encode($response);
        exit;
    }

    try {
        // Verifikasi password saat ini
        $stmt = $con->prepare("SELECT password FROM tb_users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $response["message"] = "User not found";
            echo json_encode($response);
            exit;
        }

        $user = $result->fetch_assoc();
        if (!password_verify($current_password, $user['password'])) {
            $response["message"] = "Current password is incorrect";
            echo json_encode($response);
            exit;
        }

        // Update password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $con->prepare("UPDATE tb_users SET password = ? WHERE user_id = ?");
        $update_stmt->bind_param("si", $hashed_password, $user_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            $response = [
                "status" => "success",
                "message" => "Password changed successfully"
            ];
        } else {
            $response["message"] = "Failed to change password";
        }

        $update_stmt->close();
    } catch (Exception $e) {
        $response["message"] = "Database error: " . $e->getMessage();
    }
} else {
    $response["message"] = "Invalid request method";
}

echo json_encode($response);
?>
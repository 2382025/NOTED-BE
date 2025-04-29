<?php
// Menghubungkan ke database
require_once('koneksi.php');

// Set response sebagai JSON
header('Content-Type: application/json');

// Validasi parameter 'action'
if (!isset($_GET['action'])) {
    echo json_encode(["status" => "error", "message" => "Invalid action!"]);
    exit;
}

$action = $_GET['action'];

if ($action == 'create') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tb_users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "User created successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create user: " . mysqli_error($con)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    }
}
elseif ($action == 'read') {
    $sql = "SELECT user_id, name, email FROM tb_users";
    $result = mysqli_query($con, $sql);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $users]);
}
elseif ($action == 'update') {
    $id = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($id && $name && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE tb_users SET name=?, email=?, password=? WHERE user_id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $hashedPassword, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "User updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update user: " . mysqli_error($con)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    }
}
elseif ($action == 'delete') {
    $id = $_GET['user_id'] ?? '';

    if ($id) {
        $sql = "DELETE FROM tb_users WHERE user_id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "User deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete user: " . mysqli_error($con)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing user_id"]);
    }
}
elseif ($action == 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $sql = "SELECT * FROM tb_users WHERE email=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                echo json_encode([
                    "status" => "success",
                    "user_id" => $user['user_id'],
                    "name" => $user['name'],
                    "email" => $user['email']
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Incorrect password"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Email not found"]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing email or password"]);
    }
}
else {
    echo json_encode(["status" => "error", "message" => "Invalid action!"]);
}

mysqli_close($con);
?>

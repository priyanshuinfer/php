<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include("db.php");

try {
    $stmt = $conn->prepare("SELECT id, name, email, user_type FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode(["success" => true, "users" => $users]);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>

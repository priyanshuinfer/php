<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("db.php");  // your DB connection

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "error" => "Missing picture ID"]);
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM pictures WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["success" => false, "error" => "Not found"]);
}

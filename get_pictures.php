<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("db.php"); // your database connection file

// Fetch all pictures
$stmt = $conn->prepare("SELECT id, src, title FROM pictures");
$stmt->execute();
$result = $stmt->get_result();

$pictures = [];
while ($row = $result->fetch_assoc()) {
    $pictures[] = $row;
}

echo json_encode($pictures);
$conn->close();

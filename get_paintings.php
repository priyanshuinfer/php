<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // allow requests from React frontend

include("db.php"); // your database connection file

// Fetch all paintings
$stmt = $conn->prepare("SELECT id, src, title FROM paintings");
$stmt->execute();
$result = $stmt->get_result();

$paintings = [];
while ($row = $result->fetch_assoc()) {
    $paintings[] = $row;
}

echo json_encode($paintings);
$conn->close();

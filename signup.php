<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



include("db.php"); 

$data = json_decode(file_get_contents("php://input"), true);
$required = ["name", "email", "password", "address", "productType", "userType"];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(["success" => false, "error" => "Missing field: $field"]);
        exit();
    }
}
$name = $data["name"];
$email = $data["email"];
$password = password_hash($data["password"], PASSWORD_DEFAULT);
$address = $data["address"];
$productType = $data["productType"];
$userType = $data["userType"];

try {
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo json_encode(["success" => false, "error" => "Email already registered"]);
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, address, product_type, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $password, $address, $productType, $userType);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Account created successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Database insert failed", "details" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => "Exception occurred", "details" => $e->getMessage()]);
}
?>

<?php
// 1. Set Response Headers for JSON API format
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// 2. Database Credentials
// 2. Database Credentials
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = 13624; // Railway's public external port

// ADD $port AS THE 5TH ITEM HERE:
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// 4. Retrieve Raw JSON Input data from Fetch API
$inputRaw = file_get_contents("php://input");
$data = json_decode($inputRaw, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid data format received."]);
    exit();
}

// 5. Clean and Assign variables
$name = isset($data['name']) ? trim($data['name']) : '';
$email = isset($data['email']) ? trim($data['email']) : '';
$organization = isset($data['organization']) ? trim($data['organization']) : '';
$purpose = isset($data['purpose']) ? trim($data['purpose']) : '';
$message = isset($data['message']) ? trim($data['message']) : '';

// 6. Server-side Validation
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(["success" => false, "message" => "Please fill all required fields (Name, Email, Message)."]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}

// 7. Use Prepared Statements to insert safely (Prevents SQL Injection)
$stmt = $conn->prepare("INSERT INTO contact_inquiries (name, email, organization, purpose, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $organization, $purpose, $message);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Inquiry saved successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "SQL Error: " . $stmt->error]);
}

// Close Connections
$stmt->close();
$conn->close();
?>
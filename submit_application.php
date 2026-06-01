<?php
// 1. Setup CORS and Headers so Vercel is allowed to talk to it
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests from the browser
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 2. Database Credentials (Pulled from Railway Environment Variables)
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = 13624; // Railway's public external port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Extract JSON Payload Stream
$inputRaw = file_get_contents("php://input");
$data = json_decode($inputRaw, true);

// Check if data actually exists to prevent crashes
if (!$data) {
    echo json_encode(["success" => false, "message" => "No application data received."]);
    exit();
}

// Safely assign variables using null coalescing to prevent "Undefined array key" crashes
$role = $data['role'] ?? '';
$company = $data['company'] ?? '';
$first_name = $data['first_name'] ?? '';
$last_name = $data['last_name'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$city = $data['city'] ?? '';
$qualification = $data['qualification'] ?? '';
$year_of_study = $data['year_of_study'] ?? '';
$skills = $data['skills'] ?? '';
$motivation = $data['motivation'] ?? '';
$portfolio = $data['portfolio'] ?? '';

$stmt = $conn->prepare("
INSERT INTO applications
(role, company, first_name, last_name, email, phone, city,
qualification, year_of_study, skills, motivation, portfolio)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssss",
    $role, $company, $first_name, $last_name, $email, $phone, $city,
    $qualification, $year_of_study, $skills, $motivation, $portfolio
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Application submitted successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error submitting application: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
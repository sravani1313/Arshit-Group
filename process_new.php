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

// ADD $port AS THE 5TH ITEM HERE:
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
$email = isset($data['email']) ? trim($data['email']) : '';

// Validation 
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email structure provided."]);
    exit();
}

// Cross-examine database for existing record logs to prevent duplicate constraint execution crashes
$checkStmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "This corporate email layout is already in the inner circle."]);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Secure Prepared statement execution 
$stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Subscription cataloged!"]);
} else {
    echo json_encode(["success" => false, "message" => "Database execution anomaly: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
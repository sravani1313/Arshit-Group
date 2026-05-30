<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// 2. Database Credentials (Pulled from Railway Environment Variables)
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}


$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("
INSERT INTO applications
(role, company, first_name, last_name, email, phone, city,
qualification, year_of_study, skills, motivation, portfolio)

VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssss",
    $data['role'],
    $data['company'],
    $data['first_name'],
    $data['last_name'],
    $data['email'],
    $data['phone'],
    $data['city'],
    $data['qualification'],
    $data['year_of_study'],
    $data['skills'],
    $data['motivation'],
    $data['portfolio']
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Application submitted successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error submitting application"
    ]);
}

$conn->close();
?>




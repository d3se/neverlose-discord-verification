<?php
header('Content-Type: application/json');


//connect to sql
$host = 'host';
$db   = 'databaseee';
$user = 'uschernam';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    //wtf no connect 😱
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if (!isset($_POST['token'])) {
    //NIERTU TOKEN ❌
    echo json_encode(['status' => 'error', 'message' => 'Token not provided']);
    exit;
}

$token = $_POST['token'];

// ANTI iphacker1337 (dont sql inject) 😱😁🙌
$stmt = $pdo->prepare("SELECT username, verified FROM verification_tokens WHERE token = ?");
$stmt->execute([$token]);
$row = $stmt->fetch();

if ($row) {
    if ($row['verified']) {
        // if verified is 1, (which happens after verification who could have though 🤷‍♂️) it will not go further
        echo json_encode(['status' => 'error', 'message' => 'Token already verified']);
    } else {
         $stmt = $pdo->prepare("UPDATE verification_tokens SET verified = 1 WHERE token = ?");
         $stmt->execute([$token]);
        // TOKEN REAL, USER NEW 😎(now verified, so he cant verify it again)
        echo json_encode(['status' => 'success', 'username' => $row['username']]);
    }
} else {
    // if someone try to HACK (HACKER1337 (IPHACKER)), anti work ❌
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
}
?>
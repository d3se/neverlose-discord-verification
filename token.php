<?php
//comment out so anonymous can not hack :)

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



header('Content-Type: application/json');

$host = 'host';
$db   = 'databaseee';
$user = 'uschernam';
$pass = 'password';
$charset = 'utf8mb4';

if (!isset($_POST['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Username not provided']);
    
    exit;
}


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//paste options better handling
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
//BEST
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$username = $_POST['username'];

//intialize check for already requested tokens ✅ (anti anonymous hacker (sql injecttt))
$stmt = $pdo->prepare("SELECT token FROM verification_tokens WHERE username = ?");
$stmt->execute([$username]);
$existingToken = $stmt->fetchColumn();

if ($existingToken) {
    echo json_encode(['status' => 'success', 'token' => $existingToken]);
    exit;
}

//smart unique (ultra unique)
function generateUniqueToken($pdo) {
    do {
        //can make lower of higher amount dont matter since its always unique (excpet every nigga in the russia will use ur lua)
        $token = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM verification_tokens WHERE token = ?");
        $stmt->execute([$token]);
        $count = $stmt->fetchColumn();
    } while($count > 0);

    return $token;
}
//genration procccess (new function wow)
$token = generateUniqueToken($pdo);
//paste sql databaze (preparedd)
$stmt = $pdo->prepare("INSERT INTO verification_tokens (username, token) VALUES (?, ?)");
$stmt->execute([$username, $token]);
//response with status and the token for this username (which is unique, and if same user tries to generate new, it will print the one he generated the times before)
echo json_encode(['status' => 'success', 'token' => $token]);
?>

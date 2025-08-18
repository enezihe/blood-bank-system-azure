<?php
require_once __DIR__ . '/conn.php';
/** @var \mysqli $conn */   // <-- hint for the IDE


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', '1');

/** Normalize many possible inputs (e.g., "O Positive", "o+", " ab - ", "3") to canonical form like "O+" */
function normalize_blood_input(string $v): string {
    $v = strtoupper(trim($v));
    // Map common words to symbols
    $v = str_replace(['POSITIVE','NEGATIVE','PLUS','MINUS'], ['+','-','+','-'], $v);
    // Remove spaces
    $v = str_replace(' ', '', $v);
    return $v;
}

// 1) Collect input
$name        = trim($_POST['fullname'] ?? '');
$number_raw  = trim($_POST['mobileno'] ?? '');
$email       = trim($_POST['emailid'] ?? '');
$age         = isset($_POST['age']) ? (int)$_POST['age'] : 0;
$gender      = trim($_POST['gender'] ?? '');
$blood_raw   = $_POST['blood'] ?? '';
$address     = trim($_POST['address'] ?? '');

// 2) Resolve blood group (supports either label or numeric ID)
$blood_group = normalize_blood_input((string)$blood_raw);

// If numeric ID is posted (e.g., 1..8), look up the actual group from DB
if (ctype_digit($blood_group)) {
    $stmt = $conn->prepare('SELECT UPPER(TRIM(blood_group)) AS g FROM blood WHERE blood_id = ? LIMIT 1');
    $id = (int)$blood_group;
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $blood_group = $row['g'];
    }
}

// Build allowed list from DB
$allowed = [];
$res = $conn->query('SELECT UPPER(TRIM(blood_group)) AS g FROM blood');
while ($row = $res->fetch_assoc()) { $allowed[] = $row['g']; }

// 3) Validation
$number = preg_replace('/\D+/', '', $number_raw);

$errors = [];
if ($name === '')                                   { $errors[] = 'Name is required.'; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL))     { $errors[] = 'Valid email is required.'; }
if ($age < 16 || $age > 120)                        { $errors[] = 'Age must be between 16 and 120.'; }
if (!in_array($blood_group, $allowed, true))        { $errors[] = 'Invalid blood group.'; }
if (strlen($number) < 7 || strlen($number) > 15)    { $errors[] = 'Phone must be 7–15 digits.'; }

if ($errors) {
    http_response_code(400);
    echo '<div class="alert alert-danger"><ul><li>' . implode('</li><li>', $errors) . '</li></ul></div>';
    exit;
}

// 4) Insert
$stmt = $conn->prepare("
    INSERT INTO donor_details
      (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address)
    VALUES (?,?,?,?,?,?,?)
");
$stmt->bind_param('sssisss', $name, $number, $email, $age, $gender, $blood_group, $address);
$stmt->execute();

// 5) Redirect
header('Location: /Blood-Bank-And-Donation-Management-System/admin/donor_list.php');
exit;

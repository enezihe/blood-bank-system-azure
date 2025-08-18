<?php
// /savedata.php — DRY connection, optional email, robust blood-group handling
require_once __DIR__ . '/conn.php';
error_reporting(E_ALL); ini_set('display_errors', '1');

/** Normalize inputs like "O Positive", "o +", "AB-" → "O+", "AB-", etc. */
function normalize_blood_input(string $v): string {
    $v = strtoupper(trim($v));
    $v = str_replace(['POSITIVE','NEGATIVE','PLUS','MINUS'], ['+','-','+','-'], $v);
    return str_replace(' ', '', $v);
}

// Collect + normalize
$name        = trim($_POST['fullname'] ?? '');
$number_raw  = trim($_POST['mobileno'] ?? '');
$email       = trim($_POST['emailid'] ?? '');            // optional
$age         = isset($_POST['age']) ? (int)$_POST['age'] : 0;
$gender      = trim($_POST['gender'] ?? '');
$blood_raw   = $_POST['blood'] ?? '';
$address     = trim($_POST['address'] ?? '');

// Resolve blood group (accept label or numeric id)
$blood_group = normalize_blood_input((string)$blood_raw);
if ($blood_group !== '' && ctype_digit($blood_group)) {
    $stmt = $conn->prepare('SELECT UPPER(TRIM(blood_group)) AS g FROM blood WHERE blood_id = ? LIMIT 1');
    $id = (int)$blood_group; $stmt->bind_param('i', $id); $stmt->execute();
    if ($row = $stmt->get_result()->fetch_assoc()) { $blood_group = $row['g']; }
}
// Allowed list from DB (source of truth)
$allowed = []; $rs = $conn->query('SELECT UPPER(TRIM(blood_group)) AS g FROM blood');
while ($r = $rs->fetch_assoc()) { $allowed[] = $r['g']; }

// Validation
$number = preg_replace('/\D+/', '', $number_raw);
$errors = [];
if ($name === '')                                   { $errors[] = 'Name is required.'; }
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))
{ $errors[] = 'Valid email is required when provided.'; }
if ($age < 16 || $age > 120)                        { $errors[] = 'Age must be between 16 and 120.'; }
if (!in_array($blood_group, $allowed, true))        { $errors[] = 'Invalid blood group.'; }
if (strlen($number) < 7 || strlen($number) > 15)    { $errors[] = 'Phone must be 7–15 digits.'; }
if ($errors) { http_response_code(400);
    echo '<div class="alert alert-danger"><ul><li>'.implode('</li><li>', $errors).'</li></ul></div>'; exit; }

// Insert
$stmt = $conn->prepare("
  INSERT INTO donor_details
    (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address)
  VALUES (?,?,?,?,?,?,?)
");
$stmt->bind_param('sssisss', $name, $number, $email, $age, $gender, $blood_group, $address);
$stmt->execute();

// Redirect
header('Location: /Blood-Bank-And-Donation-Management-System/admin/donor_list.php');
exit;

<?php
$name        = htmlspecialchars(trim($_POST['fullname']));
$number      = htmlspecialchars(trim($_POST['mobileno']));
$email       = htmlspecialchars(trim($_POST['emailid']));
$age         = intval($_POST['age']);
$gender      = htmlspecialchars(trim($_POST['gender']));
$blood_group = intval($_POST['blood']);
$address     = htmlspecialchars(trim($_POST['address']));

$conn = mysqli_connect("localhost", "root", "", "blood_donation") or die("Connection error");

$stmt = $conn->prepare("INSERT INTO donor_details (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssisss", $name, $number, $email, $age, $gender, $blood_group, $address);

if ($stmt->execute()) {
    header("Location: http://localhost/Blood-Bank-And-Donation-Management-System/admin/donor_list.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

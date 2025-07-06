<?php
// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Collect form data
$name = $_POST['fullname'];
$number = $_POST['mobileno'];
$email = $_POST['emailid'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$blood_group = $_POST['blood'];
$address = $_POST['address'];

// Connect to the correct database
$conn = mysqli_connect("localhost", "root", "", "blood_bank_database") or die("Connection error");

// Insert donor record
$sql = "INSERT INTO donor_details (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) 
        VALUES ('$name', '$number', '$email', '$age', '$gender', '$blood_group', '$address')";

$result = mysqli_query($conn, $sql) or die("Query unsuccessful.");

// Redirect to donor list page after success
header("Location: http://localhost/Blood-Bank-And-Donation-Management-System/admin/donor_list.php");
exit();

mysqli_close($conn);
?>

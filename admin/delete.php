<?php
include 'conn.php';

// Validate and sanitize the 'id' parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $donor_id = intval($_GET['id']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM donor_details WHERE donor_id = ?");
    $stmt->bind_param("i", $donor_id);

    if ($stmt->execute()) {
        // Redirect to donor list on success
        header("Location: donor_list.php");
        exit();
    } else {
        echo "Error deleting donor: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Invalid or missing ID
    echo "Invalid donor ID.";
}

$conn->close();
?>

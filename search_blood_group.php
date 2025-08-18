<?php
// search_blood_group.php — secure, DRY, and XSS-safe version

require __DIR__ . '/conn.php'; // use shared connection

// Normalize and validate input
$blood = strtoupper(trim($_POST['blood'] ?? ''));
$ALLOWED = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];

if ($blood === '' || !in_array($blood, $ALLOWED, true)) {
    echo '<div class="alert alert-danger">Please select a valid blood group.</div>';
    exit;
}

// Query using prepared statements
$stmt = $conn->prepare("
    SELECT donor_name, donor_number, donor_gender, donor_age, donor_address, donor_blood
    FROM donor_details
    WHERE donor_blood = ?
    ORDER BY RAND()
    LIMIT 5
");
$stmt->bind_param('s', $blood);
$stmt->execute();
$res = $stmt->get_result();

// Render results
if ($res->num_rows > 0): ?>
    <div class="row">
        <?php while ($row = $res->fetch_assoc()):
            // Escape output to prevent XSS
            $name    = htmlspecialchars($row['donor_name'],    ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $number  = htmlspecialchars($row['donor_number'],  ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $gender  = htmlspecialchars($row['donor_gender'],  ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $age     = htmlspecialchars((string)$row['donor_age'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $address = htmlspecialchars($row['donor_address'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $bgroup  = htmlspecialchars($row['donor_blood'],   ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            ?>
            <div class="col-lg-4 col-sm-6 portfolio-item"><br>
                <div class="card" style="width:300px">
                    <img class="card-img-top" src="image/blood_drop_logo.jpg" alt="Blood Drop" style="width:100%;height:300px">
                    <div class="card-body">
                        <h3 class="card-title"><?= $name ?></h3>
                        <p class="card-text">
                            <b>Blood Group:</b> <b><?= $bgroup ?></b><br>
                            <b>Mobile No.:</b> <?= $number ?><br>
                            <b>Gender:</b> <?= $gender ?><br>
                            <b>Age:</b> <?= $age ?><br>
                            <b>Address:</b> <?= $address ?><br>
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="alert alert-danger">No donor found for the selected blood group.</div>
<?php endif;

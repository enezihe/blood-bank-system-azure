<?php
// /contact_us.php — secure, DRY, and Bootstrap 4 compatible

// Session for CSRF token
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$active = 'contact';
require __DIR__ . '/head.php';   // page header / navbar (assumes it does not call session_start again)
require __DIR__ . '/conn.php';   // shared DB connection ($conn)

// Simple CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf'];

$success = '';
$errors  = [];

// Handle form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    if (!hash_equals($csrf, $_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid request token. Please refresh the page and try again.';
    } else {
        // Collect + normalize inputs
        $name    = trim($_POST['fullname'] ?? '');
        $phone   = trim($_POST['contactno'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Normalize phone: keep digits only (store canonical 7–15 digits)
        $phone_digits = preg_replace('/\D+/', '', $phone);

        // Server-side validation
        if ($name === '')                                 $errors[] = 'Full name is required.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))   $errors[] = 'A valid email address is required.';
        if (strlen($phone_digits) < 7 || strlen($phone_digits) > 15)
            $errors[] = 'Phone number must be 7–15 digits.';
        if ($message === '')                              $errors[] = 'Message is required.';
        if (strlen($message) > 2000)                      $errors[] = 'Message is too long (max 2000 characters).';

        // Insert if valid
        if (!$errors) {
            $stmt = $conn->prepare("
                INSERT INTO contact_query (query_name, query_mail, query_number, query_message)
                VALUES (?,?,?,?)
            ");
            $stmt->bind_param('ssss', $name, $email, $phone_digits, $message);
            $stmt->execute();
            $success = 'Query sent. We will contact you shortly.';
            // Optional: clear POST fields after success
            $_POST = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Contact the Blood Bank & Donation System" />
    <meta name="author" content="Blood Bank" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div id="page-container" style="margin-top:50px; position: relative; min-height: 84vh;">
    <div class="container">
        <div id="content-wrap" style="padding-bottom:50px;">
            <h1 class="mt-4 mb-3">Contact</h1>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <h3>Send us a Message</h3>

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?= htmlspecialchars($success, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if ($errors): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form name="sentMessage" method="post" action="">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control" id="name" name="fullname" required
                                   value="<?= htmlspecialchars($_POST['fullname'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="contactno" required
                                   value="<?= htmlspecialchars($_POST['contactno'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                            <small class="form-text text-muted">Digits only; we store a canonical 7–15 digit number.</small>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea rows="10" class="form-control" id="message" name="message" required maxlength="2000"
                                      style="resize:none"><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
                        </div>

                        <button type="submit" name="send" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <div class="col-lg-4 mb-4">
                    <h2>Contact Details</h2>
                    <br>
                    <?php
                    $rs = $conn->query("SELECT contact_address, contact_mail, contact_phone FROM contact_info");
                    if ($rs && $rs->num_rows > 0):
                        while ($row = $rs->fetch_assoc()):
                            $addr = htmlspecialchars($row['contact_address'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                            $mail = htmlspecialchars($row['contact_mail'] ?? '',    ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                            $phon = htmlspecialchars($row['contact_phone'] ?? '',   ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                            ?>
                            <p><h4>Address:</h4><?= $addr ?></p>
                            <p><h4>Contact Number:</h4><?= $phon ?></p>
                            <p><h4>Email:</h4><a href="mailto:<?= $mail ?>"><?= $mail ?></a></p>
                        <?php
                        endwhile;
                    else:
                        echo '<div class="alert alert-info">Contact information is not available.</div>';
                    endif;
                    ?>
                </div>
            </div><!-- /.row -->
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
</div>
</body>
</html>

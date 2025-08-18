<?php
// admin/update_page_details.php

// Use the shared connection (admin/conn.php should require the root conn.php)
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/session.php';

// Guard: only allow authenticated admins
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '<div class="alert alert-danger"><b>Please login first to access the admin portal.</b></div>';
    echo '<form method="post" action="login.php" class="form-horizontal">
            <div class="form-group">
              <div class="col-sm-8 col-sm-offset-4" style="float:left">
                <button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button>
              </div>
            </div>
          </form>';
    exit;
}

// Whitelist for page types -> human-readable titles
$PAGE_TYPES = [
    'aboutus'      => 'About Us',
    'donor'        => 'Why Become Donor',
    'needforblood' => 'The Need For Blood',
    'bloodtips'    => 'Blood Tips',
    'whoyouhelp'   => 'Who You Could Help',
    'bloodgroups'  => 'Blood Groups',
    'universal'    => 'Universal Donors And Recipients',
];

// Validate requested page type
$type = $_GET['type'] ?? '';
if (!array_key_exists($type, $PAGE_TYPES)) {
    http_response_code(400);
    echo '<div class="alert alert-danger"><b>Invalid page type.</b></div>';
    exit;
}

// CSRF token (very simple)
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf'];

// Handle update (POST)
$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!hash_equals($csrf, $_POST['csrf'] ?? '')) {
        http_response_code(403);
        echo '<div class="alert alert-danger"><b>Invalid CSRF token.</b></div>';
        exit;
    }

    // Accept rich HTML from editor; rely on auth + context. Consider additional sanitization in production.
    $data = $_POST['data'] ?? '';

    $stmt = $conn->prepare('UPDATE pages SET page_data = ? WHERE page_type = ?');
    $stmt->bind_param('ss', $data, $type);
    $stmt->execute();
    $flash = '<div class="alert alert-success"><b>Page data updated successfully.</b></div>';
}

// Fetch current content to prefill editor
$stmt = $conn->prepare('SELECT page_data FROM pages WHERE page_type = ? LIMIT 1');
$stmt->bind_param('s', $type);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$currentData = $row['page_data'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Page Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & deps -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- nicEdit (filename is lowercase in repo) -->
    <script type="text/javascript" src="nicedit.js"></script>

    <style>
        #sidebar{position:relative;margin-top:-20px}
        #content{position:relative;margin-left:210px}
        @media screen and (max-width: 600px) {
            #content { position:relative;margin-left:auto;margin-right:auto; }
            #area4{ width: 70vw; min-height: 50vh; font-family: tahoma; }
            .nicEdit-panel > div > * { opacity: 1 !important; }
            .nicEdit-buttonContain { padding: .5em; }
            .nicEdit-selectContain{ margin-top: 8px; padding:.5em }
            .nicEdit-selectTxt{ font-family: Tahoma !important; font-size: 12px !important; }
            .nicEdit-main{ outline: 0; }
        }
    </style>

    <script>
        // Initialize nicEdit after DOM ready
        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel: true}).panelInstance('area4');
        });
    </script>
</head>
<body style="color:black">
<div id="header"><?php include 'header.php'; ?></div>

<div id="sidebar">
    <?php $active = ""; include 'sidebar.php'; ?>
</div>

<div id="content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row"><div class="col-md-12">
                    <h1 class="page-title">Update Page Details</h1>
                </div></div>
            <hr>

            <?php if ($flash) { echo $flash; } ?>

            <div class="row">
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">Page Details</div>
                        <div class="panel-body">

                            <!-- Selected Page label -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Selected Page:</label>
                                <div class="col-sm-8" style="padding-top:7px;">
                                    <?php echo htmlspecialchars($PAGE_TYPES[$type], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                </div>
                            </div>

                            <!-- Edit form -->
                            <form name="update_page" method="post" action="?type=<?php echo urlencode($type); ?>">
                                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="hr-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Page Details:</label>
                                    <div class="col-sm-8">
                                        <!-- Show current HTML in editor; do not escape to keep existing markup editable -->
                                        <textarea cols="60" rows="10" id="area4" name="data"><?php echo $currentData; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4"><br>
                                        <button class="btn btn-primary" name="submit" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div> <!-- /row -->
        </div>
    </div>
</div> <!-- /content -->
</body>
</html>

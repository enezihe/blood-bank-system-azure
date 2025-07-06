<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'conn.php';

if (isset($_POST["login"])) {
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // ❌ Old insecure method (matches raw text passwords)
  // $sql = "SELECT * FROM admin_info WHERE admin_username='$username' AND admin_password='$password'";

  // ✅ Secure method: First get the user by username
  $sql = "SELECT * FROM admin_info WHERE admin_username='$username'";
  $result = mysqli_query($conn, $sql) or die("Query failed.");

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // ✅ Use password_verify to compare hashed password
    if (password_verify($password, $row['admin_password'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION["username"] = $username;
      header("Location: dashboard.php");
      exit(); // Always exit after redirect
    } else {
      $loginError = "Username and Password are not matched!";
    }
  } else {
    $loginError = "Username and Password are not matched!";
  }
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body background="admin_image/blood-cells.jpg">

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="container" style="margin-top:200px;">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h1 class="mt-4 mb-3" style="color:#D2F015;">
            Blood Bank & Management
            <br>Admin Login Portal
          </h1>
        </div>
      </div>

      <div class="card" style="height:250px; background-image:url('admin_image/glossy1.jpg');">
        <div class="card-body">
          <div class="row justify-content-lg-center justify-content-mb-center">
            <div class="col-lg-6 mb-6">
              <div class="font-italic" style="font-weight:bold">Username<span style="color:red">*</span></div>
              <input type="text" name="username" placeholder="Enter your username" class="form-control"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
          </div>

          <div class="row justify-content-lg-center justify-content-mb-center">
            <div class="col-lg-6 mb-6"><br>
              <div class="font-italic" style="font-weight:bold">Password<span style="color:red">*</span></div>
              <input type="password" name="password" placeholder="Enter your Password" class="form-control" required>
            </div>
          </div>

          <div class="row justify-content-lg-center justify-content-mb-center">
            <div class="col-lg-4 mb-4" style="text-align:center"><br>
              <input type="submit" name="login" class="btn btn-primary" value="LOGIN" style="cursor:pointer">
            </div>
          </div>

          <?php
          if (isset($loginError)) {
            echo '<br><div class="alert alert-danger font-weight-bold">' . $loginError . '</div>';
          }
          ?>
        </div>
      </div>
    </div>
  </form>
</body>
</html>

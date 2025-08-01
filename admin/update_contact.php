<?php
include 'conn.php';
include 'session.php';
session_start();
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    #sidebar { position: relative; margin-top: -20px }
    #content { position: relative; margin-left: 210px }
    @media screen and (max-width: 600px) {
      #content {
        margin-left: auto;
        margin-right: auto;
      }
    }
  </style>
</head>
<body style="color:black">
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>
  <div id="header"><?php include 'header.php'; ?></div>
  <div id="sidebar">
    <?php $active = "contact"; include 'sidebar.php'; ?>
  </div>
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h1 class="page-title">Update Contact Info</h1>
          </div>
        </div>
        <hr>

        <?php
        // Fetch existing contact info
        $fetch = mysqli_query($conn, "SELECT * FROM contact_info WHERE contact_id = 1");
        $row = mysqli_fetch_assoc($fetch);

        if (isset($_POST['update'])) {
          $address = $_POST['address'];
          $email = $_POST['email'];
          $number = $_POST['contactno'];

          $sql = "UPDATE contact_info 
                  SET contact_address = '{$address}', 
                      contact_mail = '{$email}', 
                      contact_phone = '{$number}' 
                  WHERE contact_id = 1";
          $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");

          echo '<div class="alert alert-success"><b>Contact Details Updated Successfully.</b></div>';

          // Refresh data
          $fetch = mysqli_query($conn, "SELECT * FROM contact_info WHERE contact_id = 1");
          $row = mysqli_fetch_assoc($fetch);
        }
        ?>

        <div class="row">
          <div class="col-md-10">
            <div class="panel panel-default">
              <div class="panel-heading">Contact Details</div>
              <div class="panel-body">
                <form method="post" name="change_contact" class="form-horizontal">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="address" required><?php echo $row['contact_address']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Email ID</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" name="email" value="<?php echo $row['contact_mail']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Contact Number</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="contactno" value="<?php echo $row['contact_phone']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                      <button class="btn btn-primary" name="update" type="submit">Update</button>
                    </div>
                  </div>
                </form>
              </div> <!-- panel-body -->
            </div> <!-- panel -->
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
} else {
  echo '<div class="alert alert-danger"><b>Please Login First To Access Admin Portal.</b></div>';
  ?>
  <form method="post" action="login.php" class="form-horizontal">
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-4">
        <button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button>
      </div>
    </div>
  </form>
<?php } ?>
</body>
</html>

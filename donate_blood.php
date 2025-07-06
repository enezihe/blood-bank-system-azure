<?php
$active = 'donate';
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Donate Blood</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php include('head.php'); ?>

  <div id="page-container" style="margin-top:50px; position:relative; min-height:84vh;">
    <div class="container" id="content-wrap" style="padding-bottom:50px;">
      <div class="row">
        <div class="col-lg-6">
          <h1 class="mt-4 mb-3">Donate Blood</h1>
        </div>
      </div>

      <form name="donor" action="savedata.php" method="post" autocomplete="off">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Full Name<span style="color:red">*</span></label>
            <input type="text" name="fullname" class="form-control" required>
          </div>
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Mobile Number<span style="color:red">*</span></label>
            <input type="text" name="mobileno" class="form-control" pattern="[0-9]{10,11}" title="Enter valid number" required>
          </div>
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Email ID</label>
            <input type="email" name="emailid" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Age<span style="color:red">*</span></label>
            <input type="number" name="age" class="form-control" min="18" max="65" required>
          </div>
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Gender<span style="color:red">*</span></label>
            <select name="gender" class="form-control" required>
              <option value="" disabled selected>Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="col-lg-4 mb-4">
            <label class="font-italic">Blood Group<span style="color:red">*</span></label>
            <select name="blood" class="form-control" required>
              <option value="" selected disabled>Select</option>
              <?php
              $sql = "SELECT * FROM blood";
              $result = mysqli_query($conn, $sql) or die("Query failed.");
              while ($row = mysqli_fetch_assoc($result)) {
                // Remove spaces in value attribute
                echo '<option value="' . $row['blood_id'] . '">' . $row['blood_group'] . '</option>';
              }
              ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 mb-4">
            <label class="font-italic">Address<span style="color:red">*</span></label>
            <textarea class="form-control" name="address" rows="3" required></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 mb-4">
            <input type="submit" name="submit" class="btn btn-primary" value="Submit" style="cursor:pointer">
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include('footer.php'); ?>
</body>

</html>

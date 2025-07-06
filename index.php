<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Home - Blood Bank</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS & JS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

<div class="header">
  <?php $active = "home"; include 'head.php'; ?>
</div>

<?php include 'ticker.php'; ?>

<div id="page-container" style="margin-top:50px; position: relative; min-height: 84vh;">
  <div class="container" id="content-wrap" style="padding-bottom:75px;">

    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-ride="carousel">
      <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
      </ul>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="image/_107317099_blooddonor976.jpg" alt="Donor" width="100%" height="500">
        </div>
        <div class="carousel-item">
          <img src="image/Blood-facts_10-illustration-graphics__canteen.png" alt="Facts" width="100%" height="500">
        </div>
      </div>
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

    <br>
    <h1 class="text-center" style="font-size:45px;">Welcome to BloodBank & Donor Management System</h1>
    <br>

    <!-- Info Boxes -->
    <div class="row">
      <?php
        $pageTypes = [
          'needforblood' => 'The need for blood',
          'bloodtips' => 'Blood Tips',
          'whoyouhelp' => 'Who you could Help'
        ];
        foreach ($pageTypes as $type => $title):
          $sql = "SELECT * FROM pages WHERE page_type='$type'";
          $result = mysqli_query($conn, $sql);
          $content = '';
          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $content = $row['page_data'];
          }
      ?>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <h4 class="card-header bg-info text-white"><?php echo $title; ?></h4>
            <p class="card-body overflow-auto" style="padding-left:2%; height:120px; text-align:left;">
              <?php echo $content; ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Random Donors -->
    <h2>Blood Donor Names</h2>
    <div class="row">
      <?php
        $sql = "SELECT donor_details.*, blood.blood_group 
                FROM donor_details 
                JOIN blood ON donor_details.donor_blood = blood.blood_id 
                ORDER BY RAND() LIMIT 6";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)):
      ?>
        <div class="col-lg-4 col-sm-6 portfolio-item mb-4">
          <div class="card" style="width:100%;">
            <img class="card-img-top" src="image/blood_drop_logo.jpg" alt="Donor" style="width:100%; height:300px;">
            <div class="card-body">
              <h3 class="card-title"><?php echo $row['donor_name']; ?></h3>
              <p class="card-text">
                <b>Blood Group:</b> <?php echo $row['blood_group']; ?><br>
                <b>Mobile No.:</b> <?php echo $row['donor_number']; ?><br>
                <b>Gender:</b> <?php echo $row['donor_gender']; ?><br>
                <b>Age:</b> <?php echo $row['donor_age']; ?><br>
                <b>Address:</b> <?php echo $row['donor_address']; ?><br>
              </p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Blood Groups Info -->
    <div class="row">
      <div class="col-lg-6">
        <h2>Blood Groups</h2>
        <p>
          <?php
            $sql = "SELECT * FROM pages WHERE page_type='bloodgroups'";
            $result = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
              echo $row['page_data'];
            }
          ?>
        </p>
      </div>
      <div class="col-lg-6">
        <img class="img-fluid rounded" src="image/blood_donationcover.jpeg" alt="Blood Donation">
      </div>
    </div>

    <hr>

    <!-- Universal Donors Section -->
    <div class="row mb-4">
      <div class="col-md-8">
        <h4>Universal Donors and Recipients</h4>
        <p>
          <?php
            $sql = "SELECT * FROM pages WHERE page_type='universal'";
            $result = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
              echo $row['page_data'];
            }
          ?>
        </p>
      </div>
      <div class="col-md-4">
        <a class="btn btn-lg btn-secondary btn-block" href="donate_blood.php" style="background-color:#7FB3D5; color:#273746;">
          Become a Donor
        </a>
      </div>
    </div>

  </div> <!-- #content-wrap -->
</div> <!-- #page-container -->

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>

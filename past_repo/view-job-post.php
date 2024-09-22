<?php

//To Handle Session Variables on This Page
session_start();


//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Job Search</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

<header style="background:#7D0A0A;"  class="main-header">
<br>
    <!-- Logo -->
    <a href="index.php" class="logo logo-bg">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>J</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span style="font-size:3vw;" class="logo-lg"><img src="img\logo.png" width="200" alt=""></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <li>
            <a href="login.php" class="nav-btn1">Login</a>
          </li>
          <li>
            <a href="sign-up.php" style="border: 1px solid white; margin-right: 12rem; font-weight: bold;">Sign Up</a>
          </li>  
        </ul>
      </div>
    </nav>
    <br>
  </header>



  <div class="content-wrapper" style="margin-left: 0px;">

  <?php
  
    $sql = "SELECT * FROM job_post INNER JOIN company ON job_post.id_company=company.id_company WHERE id_jobpost='$_GET[id]'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) 
    {
      while($row = $result->fetch_assoc()) 
      {
  ?>

    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">          
          <div class="col-md-9 bg-white padding-2" style="min-height: 910px;">
            <div class="pull-left">
              <h2 style="font-size: 42px;"><b><?php echo $row['jobtitle']; ?></b></h2>
            </div>
            <div class="pull-right">
              <a href="jobs.php" class="btn btn-default btn-lg btn-flat margin-top-20" style="background-color:#952323; color:white"><i class="fa fa-arrow-circle-left"></i> Back</a>
            </div>
            <div class="clearfix"></div>
            
            <div style="display:flex; gap:6px;">
              <input type="text" id="country-input" value="<?php echo $row['country']; ?>" hidden/>
              <input type="text" id="state-input" value="<?php echo $row['state']; ?>" hidden/>
              <input type="text" id="city-input" value="<?php echo $row['city']; ?>" hidden/>

              <div style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                <i class="fa fa-location-arrow text-green"></i> 
                <?php echo $row['country']; ?>, <?php echo $row['state']; ?>, <?php echo $row['city']; ?>
              </div>
              <div style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                <i class="fa fa-calendar text-green"></i> <?php echo date("d-M-Y", strtotime($row['createdat'])); ?>
              </div>
              <div style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                <i class="fa fa-money text-blue"></i> ₱<?php echo $row['minimumsalary']; ?> - ₱<?php echo $row['maximumsalary']; ?>
              </div>
            </div>
            <hr>
            <div style="display: flex; flex-direction:column; gap:10px;">
              <span style="font-size:24px; font-weight:600;">Job Description</span>
              <?php echo stripcslashes($row['description']); ?>
            </div>
            <?php 
            if(isset($_SESSION["id_user"]) && empty($_SESSION['companyLogged'])) { ?>
            <div>
              <a href="apply.php?id=<?php echo $row['id_jobpost']; ?>" class="btn btn-success btn-flat margin-top-50">Apply</a>
            </div>
            <?php } ?>
            
            
          </div>
          <div class="col-md-3">
            <div class="thumbnail">
              <img src="uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo">
              <div class="caption text-center">
                <h3><?php echo $row['companyname']; ?></h3>
                <p><a href="#" class="btn btn-primary btn-flat" role="button">More Info</a>
                <hr>
                <div style="display:flex;flex-direction:column; gap:15px;">
                  <div style="display: flex; justify-content:space-between; gap:15px;">
                    <div style="display:flex; align-items:center;"><a href="" style="background-color: red; padding:6px; color:white;"><i class="fa fa-warning"></i> Report</a></div>
                    <div style="display:flex; align-items:center;"><a href="" style="background-color: #F2E8C6; padding:6px; color:black;"><i class="fa fa-envelope"></i> Email</a></div>
                  </div>                  
                  
                  <div style="display:flex;">
                  <a href="" style="background-color: #F2E8C6; padding:6px; color:black; width:100%"><i class="fa fa-address-card-o"></i> Apply</a></div>
                </div>
              </div>
            </div>
            <div class="thumbnail">
              <div id="map" style=" height: 400px; width: 100%;"></div>

            </div>
            
          </div>
        </div>
      </div>
    </section>

    <?php 
      }
    }
    ?>

    

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px; background:#7D0A0A">
    <div class="text-center" style="color: white;">
      <strong>Copyright &copy; 2024 <a href="#">Job Search</a>.</strong> All rights
    reserved.
    </div>
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  async function getCoordinates(location) {
    const apiKey = 'c98d255dbab0488689b35d8bb790a593'; // Replace with your OpenCage API key
    const url = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(location)}&key=${apiKey}`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.results.length > 0) {
            const { lat, lng } = data.results[0].geometry;
            return { lat, lng };
        } else {
            alert('Location not found');
            return null;
        }
    } catch (error) {
        console.error('Error fetching coordinates:', error);
        alert('Error fetching coordinates');
        return null;
    }
  }

  async function showLocationMap() {
      const country = document.getElementById('country-input').value;
      const state = document.getElementById('state-input').value;
      const city = document.getElementById('city-input').value;

      if (!country || !state || !city) {
          alert('Please enter country, state, and city');
          return;
      }

      const location = `${city}, ${state}, ${country}`;
      const coordinates = await getCoordinates(location);
      if (!coordinates) return;

      const map = L.map('map').setView([coordinates.lat, coordinates.lng], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      L.marker([coordinates.lat, coordinates.lng]).addTo(map)
          .bindPopup(location)
          .openPopup();
  }
  showLocationMap()
</script>

</body>
</html>

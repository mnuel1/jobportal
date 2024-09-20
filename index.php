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
    <nav class="navbar navbar-static-top" style="padding:10px">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="index.php" style="font-size:15px; font-weight:500">Home</a>
          </li>
          <li>
            <a href="#about" style="font-size:15px; font-weight:500" >About Us</a>
          </li>
          <li>
            <a href="#candidates" style="font-size:15px; font-weight:500">Candidates</a>
          </li>
          <li>
            <a href="#company" style="font-size:15px; font-weight:500; margin-right: 50px;">Company</a>
          </li>
          
          <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
          <li>
            <a href="login.php" class="nav-btn1">Login</a>
          </li>
          <li>
            <a href="sign-up.php" style="border: 1px solid white; margin-right: 12rem; font-weight: bold;">Sign Up</a>
          </li>  
          
          <?php } else { 

            if(isset($_SESSION['id_user'])) { 
          ?>        
          <li>
            <a href="user/index.php">Dashboard</a>
          </li>
          <?php
          } else if(isset($_SESSION['id_company'])) { 
          ?>        
          <li>
            <a href="company/index.php">Dashboard</a>
          </li>
          <?php } ?>
          <li>
            <a href="logout.php">Logout</a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </nav>

  </header>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">

    <section class="content-header bg-main">
      <div class="container">
        <div class="row">
          
          <div class="col-md-14 text-center ">
            <br> <br> <br> <br> <br> <br> <br>
            <h1 style="color:black; font-weight:bold; font-size:64px">ALL JOBS IN ONE PLACE</h1>
            <p style="font-weight:200; color:black; font-size:32px; margin-bottom:10px">One search, One click</p>
            <br>
            <br>
            <p><a class="home-btn" href="jobs.php" role="button">SEARCH JOBS</a></p>
            <br>
          </div>
        </div>
      </div>
    </section>
  <br><br><br>
    <section class="content-header" >
      <div class="container">
        <div class="row">
          <div class="col-md-12 row-md-12 latest-job margin-bottom-20">
            <h1 class="text-center" style="font-weight:600">LATEST JOB</h1>
            <?php 
          /* Show any 4 random job post
           * 
           * Store sql query result in $result variable and loop through it if we have any rows
           * returned from database. $result->num_rows will return total number of rows returned from database.
          */
          $sql = "SELECT * FROM job_post Order By Rand() Limit 3";
          $result = $conn->query($sql);
          if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
              $sql1 = "SELECT * FROM company WHERE id_company='$row[id_company]'";
              $result1 = $conn->query($sql1);
              if($result1->num_rows > 0) {
                while($row1 = $result1->fetch_assoc()) 
                {
             ?>
            <div class="attachment-block clearfix">
              <img class="attachment-img" src="img/images.png" alt="Attachment Image">
              <div class="attachment-pushed">
                <h4 class="attachment-heading"><a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>"><?php echo $row['jobtitle']; ?></a> <span class="attachment-heading pull-right">₱<?php echo $row['maximumsalary']; ?>/Month</span></h4>
                <div class="attachment-text">
                    <div><strong><?php echo $row1['companyname']; ?> | <?php echo $row1['city']; ?> | Experience <?php echo $row['experience']; ?> Years</strong></div>
                </div>
              </div>
            </div>
          <?php
              }
            }
            }
          }
          ?>

          </div>
        </div>
      </div>
    </section>
    <section id="about" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1 style="font-weight:600">ABOUT US</h1>                      
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <img src="img/aabout.jpg" width="800" class="img-responsive">
          </div>
          <div class="col-md-6 about-text margin-bottom-20">
            <p>The online JobSearch application allows job seekers and recruiters to connect.The application provides the ability for job seekers to create their accounts, upload their profile and resume, search for jobs, apply for jobs, view different job openings. The application provides the ability for companies to create their accounts, search candidates, create job postings, and view candidates applications.
            </p>
            <p>
              This website is used to provide a platform for potential candidates to get their dream job and excel in yheir career.
              This site can be used as a paving path for both companies and job-seekers for a better life .
              
            </p>

          </div>
        </div>
      </div>
    </section>
<br><br><br>
    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1 style="font-weight:600">CANDIDATES</h1>
            <p>Finding a job just got easier. Create a profile and apply with single mouse click.</p>            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/browses.jpg" alt="Browse Jobs">
              <div class="caption">
                <h3 class="text-center">Browse Jobs</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/applyy.jpg" alt="Apply & Get Interviewed">
              <div class="caption">
                <h3 class="text-center">Apply & Get Interviewed</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/startt.jpg" alt="Start A Career">
              <div class="caption">
                <h3 class="text-center">Start A Career</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="company" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1 style="font-weight:600"> COMPANIES </h1>
            <p>Hiring? Register your company for free, browse our talented pool, post and track job applications</p>            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail company-img">
              <img src="img/postajob.jpg" alt="Browse Jobs">
              <div class="caption">
                <h3 class="text-center">Post A Job</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail company-img">
              <img src="img/managee.jpg" alt="Apply & Get Interviewed">
              <div class="caption">
                <h3 class="text-center">Manage & Track</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail company-img">
              <img src="img/hire.jpg" alt="Start A Career">
              <div class="caption">
                <h3 class="text-center">Hire</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="statistics" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1 style="font-weight:600"> OUR STATISTICS</h1>
          </div>
        </div>
        <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="color:white;background-color: #5F8670;">
            <div class="inner">
               <?php
                      $sql = "SELECT * FROM job_post";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Job Offers</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box " style=" color:white;background-color: #B80000;">
            <div class="inner">
               <?php
                      $sql = "SELECT * FROM company WHERE active='1'";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Registered Company</p>
            </div>
            <div class="icon">
                <i class="ion ion-briefcase"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style="height: 300px;">
          <!-- small box -->
          <div class="small-box" style="color:white; background-color: #FF9800;">
            <div class="inner">
              <?php
                      $sql = "SELECT * FROM users WHERE resume!=''";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>CV'S/Resume</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-list"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="color:white; background-color: #820300;">
            <div class="inner">
               <?php
                      $sql = "SELECT * FROM users WHERE active='1'";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Daily Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      </div>
    </section>

    
  </div>
  <footer class="footer">
     <div class="container1">
      <div class="row1">
        <div class="footer-col">
          <h4>company</h4>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About us</a></li>
            <li><a href="#candidates">Candidates</a></li>
            <li><a href="#company">Companies</a></li>
          </ul>
        </div>          
        <!-- <div class="footer-col">
          <h4>follow us</h4>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div> -->
      </div>
     </div>
     <hr>
     <div style="display: flex; align-items:center; justify-content:center; margin-top: 20px;">     
      <p style="color:white;">
        <strong>Copyright &copy; 2024 <a href="#">Job Search</a>.</strong> All rights
        reserved.
      </p>
     </div>
    
  </footer>
  <!-- /.content-wrapper

  <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2016-2017 <a href="jonsnow.netai.net">Job Portal</a>.</strong> All rights
    reserved.
    </div>
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar 
  <div class="control-sidebar-bg"></div>

</div>
 ./wrapper -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>

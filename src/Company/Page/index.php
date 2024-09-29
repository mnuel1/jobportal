<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
  header("Location: /src/index.php");
  exit();
}

require_once("../../../database/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAREERCITY</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
</head>
<body>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>

  
    <div class="container-fluid d-flex justify-content-center gap-2" style="padding-top: calc(6rem + 42px);">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/company-sidebar.php';?>
    
        <div class="container larger bg-light mx-auto">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#company" 
                aria-controls="offcanvasWithBothOptions">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h1 class="text-center my-4">OVERVIEW
            <span style="color: #7D0A0A;"></span></h1>        
            <div class="alert alert-warning alert-dismissible fade show" role="alert" 
            style="display: flex; align-items:center; gap:4px; background-color:#0A2E7D; color:white;">
                <i class="fa-solid fa-info"></i> 
                In this dashboard you are able to change your account settings, post and manage your jobs. Got a question? Do not hesitate to drop us a mail.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#CA2B2D;">
                            <img src="/assets/image 29.png" alt="Stat 2 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">JOB POSTED</div>
                            <?php
                                $sql = "SELECT * FROM job_post WHERE id_company='$_SESSION[id_company]'";
                                $result = $conn->query($sql);
                                $totalno = $result->num_rows > 0 ? $result->num_rows : 0;
                            ?>
                            <div class="number"><?php echo $totalno; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#EAC03D;">
                            <img src="/assets/image 31.png" alt="Stat 2 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">APPLICATION FOR JOBS</div>
                            <?php
                                $sql = "SELECT * FROM apply_job_post 
                                LEFT JOIN job_post ON job_post.id_jobpost = apply_job_post.id_jobpost
                                WHERE job_post.id_company='$_SESSION[id_company]'";
                                $result = $conn->query($sql);
                                $totalno = $result->num_rows > 0 ? $result->num_rows : 0;
                            ?>
                            <div class="number"><?php echo $totalno; ?></div>
                        </div>
                    </div>
                </div>                
            </div>

        </div>
    </div>
      

<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

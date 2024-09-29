<?php

session_start();

if(empty($_SESSION['id_admin'])) {
    header("Location: /src/index.php");
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/db.php");

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
<body >

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>

    <div class="container-fluid d-flex justify-content-center gap-2" style="padding-top: calc(6rem + 42px);">
        
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-sidebar.php';?>
        
        <div class="container larger bg-light mx-auto">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#offcanvasWithBothOptions" 
                aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars"></i></button>
            
            <h1 class="text-center my-4">OUR 
            <span style="color: #7D0A0A;">STATISTICS</span></h1>
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#253D80;">
                            <img src="/assets/image 26.png" alt="Stat 1 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">ACTIVE COMPANY REGISTERED</div>
                            <?php
                                $sql = "SELECT * FROM company WHERE active='1'";
                                $result = $conn->query($sql);
                                $totalno = $result->num_rows > 0 ? $result->num_rows : 0;
                            ?>
                            <div class="number"><?php echo $totalno; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#253D80;">
                            <img src="/assets/image 26.png" alt="Stat 2 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">PENDING COMPANY APPROVAL</div>
                            <?php
                                $sql = "SELECT * FROM company WHERE active='2'";
                                $result = $conn->query($sql);
                                $totalno = $result->num_rows > 0 ? $result->num_rows : 0;
                            ?>
                            <div class="number"><?php echo $totalno; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#CA2B2D;">
                            <img src="/assets/image 29.png" alt="Stat 3 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">REGISTERED APPLICANTS</div>
                            <?php
                                $sql = "SELECT * FROM users WHERE active='1'";
                                $result = $conn->query($sql);
                                $totalno = $result->num_rows > 0 ? $result->num_rows : 0;
                            ?>
                            <div class="number"><?php echo $totalno; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="statistic-box">
                        <div class="statistic-left" style="background-color:#CA2B2D;">
                            <img src="/assets/image 29.png" alt="Stat 4 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">PENDING APPLICANTS CONFIRMATION</div>
                            <?php
                                $sql = "SELECT * FROM users WHERE active='0'";
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
                            <img src="/assets/image 31.png" alt="Stat 5 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">TOTAL JOB POSTS</div>
                            <?php
                                $sql = "SELECT * FROM job_post";
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
                            <img src="/assets/image 31.png" alt="Stat 6 Image"> 
                        </div>
                        <div class="statistic-right">
                            <div class="title">TOTAL APPLICATIONS</div>
                            <?php
                                $sql = "SELECT * FROM apply_job_post";
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

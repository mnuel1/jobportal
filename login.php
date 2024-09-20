<?php 
session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) { 
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Job Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/mystyle.css" rel="stylesheet" />
    
</head>
<body id="page-top">
    <nav class="navbar navbar-expand-lg text-uppercase fixed-top" style="background-color: #CA2B2D;" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">JobSearch</a>
            <button class="navbar-toggler text-uppercase font-weight-bold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #CA2B2D; color: white;">                    
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="jobs.php">Jobs</a></li>
                                                                    
                    <li class="nav-item mx-0 mx-lg-1" style="margin-left: 20px; margin-right: 20px;">
                        <hr class="d-lg-none" style="border-top: 2px solid white; width: 100%; margin: 10px 0;">
                    </li>

                    <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded auth-link" href="login.php">Login</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded auth-link" href="sign-up.php">Sign-up</a></li>
                    <?php } else { 

                        if(isset($_SESSION['id_user'])) { 
                    ?>  
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded auth-link" href="user/index.php">Dashboard</a></li>
                    <?php
                        } else if(isset($_SESSION['id_company'])) { 
                    ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded auth-link" href="company/index.php">Dashboard</a></li>
                    <?php } ?>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded auth-link" href="logout.php">Log-out</a></li>                       
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper text-center">
        <section class="content-header login-section">
            <div class="container">
                <h1 class="display-4">LOG IN</h1>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="small-box candidate-login">
                            <div class="inner">
                                <h3>Candidates Login</h3>
                            </div>
                            <a href="login-candidates.php" class="small-box-footer">
                                Login <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="small-box company-login">
                            <div class="inner">
                                <h3>Company Login</h3>
                            </div>
                            <a href="login-company.php" class="small-box-footer">
                                Login <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

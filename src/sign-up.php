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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>JobSearch</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
            
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
    <style>
        
        .container-fluid {
            position: relative;
            padding-bottom: 100px; /* Adjust this if needed for spacing */
        }
        .min-vh-100 {
            min-height: 100vh;
        }
        .small-box {
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.3s;
        }       

        .small-box-footer {
            display: block;
            color: white;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 0 0 8px 8px;
            transition: background-color 0.3s;
        }
        .candidate-login {
            background-color: #253D80;
            color: white;
        }
        .company-login {
            background-color: #EAC03D;
            color: white;
        }
        .box-title {
            text-transform: uppercase;
            font-size: 2.5rem
        }
        
        @media (max-width: 768px) {
            .box-title {
                font-size: 1.8rem;
            }           
        }

        @media (max-width: 576px) {
            .box-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body id="page-top">
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php'; ?>

    <div class="masthead container-fluid d-flex align-items-center min-vh-100 position-relative">
        <div class="w-100 d-flex flex-column flex-md-row" style="flex-grow: 1; z-index: 1; position: relative;">
            <!-- Left Section -->
            <div class="col-md-6 d-flex flex-column justify-content-center p-4 z-5" >
                <div class="d-flex flex-column justify-content-between small-box candidate-login my-3" style="height: 300px;">
                    <div class="inner text-center">
                        <h3 class="box-title">Candidates Registration</h3>
                    </div>
                    <a href="/src/Candidate/register-candidates.php" class="buttons buttons-color">
                        <i class="fa fa-arrow-right" style="margin-right: 1rem;"></i> REGISTER 
                    </a>
                    <div></div>
                </div>
                
            </div>
            <div style="border: 1px solid lightgray;"> </div>
            <!-- Right Section -->
            <div class="col-md-6 d-flex flex-column justify-content-center p-4 z-5">
                <div class="d-flex flex-column justify-content-between small-box company-login my-3" style="height: 300px;">
                    <div class="inner text-center">
                        <h3 class="box-title">Company Registration </h3>
                    </div>
                    <a href="/src/Company/register-company.php" class="buttons buttons-color">
                        <i class="fa fa-arrow-right" style="margin-right: 1rem;"></i> REGISTER 
                    </a>
                    <div></div>
                </div>
            </div>
        </div>

        <!-- Background Image -->
        <div class="fixed-bottom" style="z-index: 0; pointer-events: none; ">
            <img src="/assets/bot.png" alt="Footer Background" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="/js/scripts.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>

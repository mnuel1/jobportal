<?php
//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../database/db.php");
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
        
        <link rel="preconnect" href="https://fonts.googleapis.com">    
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Koulen">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/mystyle.css" rel="stylesheet" />
        <link href="/css/body.css" rel="stylesheet" />
        
    </head>

    <style>
        .float-btn {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: white; /* Button color */
            color: black;
            border-radius: 50px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .float-btn i {
            margin-top: 20px;
            font-size: 44px;
        }

        .float-btn:hover {
            background-color: #A02222; /* Darker color on hover */
            color: white;
            text-decoration: none;
        }
        .masthead {
            position: relative;
            overflow: hidden;
        }

        /* Responsive image */
        .masthead img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
        }
        

        /* Responsive button placement */
        .header-btn {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translateX(-50%); 
        }

        /* Button styling */
        .search {
            color: #7D0A0A;
            background-color: #E7E0DC;
            padding: 1rem 5rem;
            border-radius: 6px;
            font-size: 20px;
            font-weight:bold;
        }

        .search:hover {
            background-color: #D6CCC7; 
            color: #7D0A0A;
        }
        .header-t {
            position: absolute;
            top: 20%;
            left: 4%;
        }
        
        .p-text {        
            color:gray; 
            font-weight:200; 
            font-size:23px;
        }
        .header-text {            
            text-shadow: 0px 4px lightgray;
            font-weight: bold;
            font-size: 50px;
            color: black;
            text-transform: uppercase;            
        }


        @media (max-width: 1464px) {
            /* Adjust button for smaller screens */
            .header-btn {
                top: 75%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .header-t {
                top: 23%;
                left: 5%;
            }

            .p-text {                    
                font-size:25px;
            }
            .header-text {                          
                font-size: 35px;              
            }
            
        }
        
        @media (max-width: 1254px) {
            /* Adjust button for smaller screens */
            .header-btn {
                top: 75%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .header-t {
                top: 27%;
                left: 5%;
            }

            .p-text {                    
                font-size:15px;
            }
            .header-text {                          
                font-size: 25px;              
            }
            .search {
             
                padding: .5rem 1rem;
             
                font-size: 12px;
             
            }
        }

        @media (max-width: 990px) {
            /* Adjust button for smaller screens */
            .header-btn {
                top: 75%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .header-t {
                top: 37%;
                left: 5%;
            }

            .p-text {                    
                font-size:15px;
            }
            .header-text {                          
                font-size: 25px;              
            }
            .search {
             
                padding: .5rem 1rem;             
                font-size: 12px;
             
            }
        }

        @media (max-width: 576px) {
            /* Mobile-specific styles */
            .header-btn {
                top: 80%;
                left: 50%;
                transform: translateX(-50%);
            }
            .header-t {
                top: 50%;
                left: 5%;
            }

            .p-text {                    
                font-size:9px;
            }
            .header-text {                          
                font-size: 14px;              
            }
            .search {
             
                padding: .5rem 1rem;
             
                font-size: 12px;
             
            }
    }

    </style>
   
<body id="page-top">
    <!-- Floating Button -->
    <a href="#page-top" class="float-btn">
        <i class="fa fa-arrow-up"></i> <!-- You can change the icon to any FontAwesome icon -->
    </a>
    <!-- Navigation-->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/navigation.php'; ?>

    
    <header class="masthead bg-white text-white text-center">
        <!-- Background Image -->
        <img src="/assets/TCU 1.png" alt="TCU Image">

        <!-- Text Section (Header and Subheader) -->            
        <div class="row h-100 align-items-center justify-content-start">
            <div class="col-lg-8 text-start header-t">
                <!-- Header Text -->
                <h1 class="header-text">
                    PESO Taguig: Your Gateway to <br> Employment and Opportunities</h1>
                <!-- Subheader Text -->
                <p class="p-text">Bridge between job seekers and employers, 
                    fostering partnerships <br> with local businesses, companies, and industries.</p>
            </div>
        </div>
        

        <!-- Button Section -->
        <div class="header-btn">
            <a href="/src/job/jobs.php" class="search">SEARCH JOBS</a>
        </div>
    </header>


    <section class="page-section text-dark mb-0" id="job-listings" style="background-color: #E7E0DC;">
        <div class="container">
            <!-- Job Listings Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase" style="margin-bottom: 1rem;">Latest Jobs</h2>
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
                    $sql1 = "SELECT company.*, baranggay.name as baranggay_name FROM company JOIN baranggay ON company.baranggay_id = baranggay.baranggay_id
                    WHERE id_company='$row[id_company]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                        while($row1 = $result1->fetch_assoc()) 
                        {
            ?>
            <!-- Job Boxes -->    
            <a href="/src/Job/view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                <div class="col-12 mb-4">
                    <div class="job-box d-flex align-items-center border rounded p-3">
                        <img src="/assets/unnamed 1.png" alt="Job 1" class="d-none d-sm-block" style="width: 80px; height: 80px; margin-right:1rem">
                        <div class="flex-grow-1">
                            <h4 class="job-title mb-1"><?php echo $row['jobtitle']; ?></h4>
                            <p class="job-description mb-0"><?php echo $row1['companyname']; ?> | <?php echo $row1['baranggay_name']; ?> | <?php echo $row['experience']; ?> Years</p>
                        </div>
                        <div class="">
                            <h5 class="salary mb-0">₱<?php echo $row['maximumsalary']; ?>/Month</h5>
                        </div>
                    </div>
                </div>
            </a>


            <?php
                        }
                    }   
                }
            }
            ?>
            
        </div>
    </section>


    <!-- About Section-->
    <section class="page-section text-white mb-0" id="about" style="background-color: #CA2B2D;">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white">About us</h2>
            
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            
            <!-- About Section Content-->
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="/assets/screenshot-1726870553020.png" alt="Description" class="img-fluid"> <!-- Add your image URL here -->
                </div>
                <div class="col-lg-6">
                    <p class="lead">PESO Taguig operates under the mandate of the Department of Labor and Employment (DOLE) to facilitate employment opportunities and provide comprehensive employment services to the local community.</p>
                    <p class="lead">PESO Taguig connects job seekers with available job openings in various industries and sectors. Whether you're a fresh graduate, a skilled worker, or someone looking for a career change, PESO Taguig can assist you in finding employment opportunities that match your skills and qualifications.</p>
                </div>
            </div>
                            
        </div>
    </section>
    <section class="page-section text-white mb-0" id="statistics" style="background-color: #CA2B2D;">
        <div class="container">
            <!-- Statistics Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase">Our Statistics</h2>
            
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            
            <!-- Statistics Boxes -->
            <div class="row text-center justify-content-between">
                <div class="col-md-3 mb-4">
                    <div class="statistic-box d-flex bg-primary justify-content-between align-items-center p-4">
                        <div class="me-3">
                            <?php
                                $sql = "SELECT * FROM job_post";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    $totalno = $result->num_rows;
                                } else {
                                    $totalno = 0;
                                }
                            ?>
                            <h3 class="statistic-number" style="text-align:left"><?php echo $totalno; ?> +</h3>
                            <p class="statistic-description">Job Offers</p>
                        </div>
                        <img src="/assets/image 14.png" alt="Projects" class="img-fluid" style="width: 60px; height: 60px;">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="statistic-box d-flex bg-success justify-content-between align-items-center p-4">
                        <div class="me-3">
                            <?php
                                $sql = "SELECT * FROM company WHERE active='1'";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    $totalno = $result->num_rows;
                                } else {
                                    $totalno = 0;
                                }
                            ?>
                            <h3 class="statistic-number" style="text-align:left" ><?php echo $totalno; ?> +</h3>
                            <p class="statistic-description">Registered Company</p>
                        </div>
                        <img src="/assets/image 13.png" alt="Clients" class="img-fluid" style="width: 60px; height: 60px;">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="statistic-box d-flex bg-warning justify-content-between align-items-center p-4">
                        <div class="me-3">
                            <?php
                                $sql = "SELECT * FROM users WHERE resume!=''";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    $totalno = $result->num_rows;
                                } else {
                                    $totalno = 0;
                                }
                            ?>
                            <h3 class="statistic-number" style="text-align:left"><?php echo $totalno; ?> +</h3>
                            <p class="statistic-description">CV'S/Resume</p>
                        </div>
                        <img src="/assets/image 15.png" alt="Awards" class="img-fluid" style="width: 60px; height: 60px;">
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="statistic-box d-flex bg-danger justify-content-between align-items-center p-4">
                        <div class="me-3">
                            <?php
                                $sql = "SELECT * FROM users WHERE active='1'";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    $totalno = $result->num_rows;
                                } else {
                                    $totalno = 0;
                                }
                            ?>
                            <h3 class="statistic-number" style="text-align:left"><?php echo $totalno; ?> +</h3>
                            <p class="statistic-description">Daily Users</p>
                        </div>
                        <img src="/assets/image 16.png" alt="Experience" class="img-fluid" style="width: 60px; height: 60px;">
                    </div>
                </div>
            </div>


        </div>
    </section>
    

    <section class="page-section text-dark mb-0" id="candidates" style="background-color: #E7E0DC;">
        <div class="container">
            <!-- Services Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase">Applicant</h2>
            <p class="text-center">
                Finding a job just got easier. Create a profile and apply with single mouse click.
            </p>
            
            <!-- Icon Divider-->
            <div class="divider-custom divider-dark mb-5">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"></div>
                <div class="divider-custom-line"></div>
            </div>
            
            <!-- Services Boxes -->
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/4 1.png" alt="Service 1" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Browse for Jobs</h3>     
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/4 2.png" alt="Service 2" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Apply & Get Interviewed</h3>     
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/4 3.png" alt="Service 3" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Start A Career</h3>     
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="page-section text-dark mb-0" id="companies" style="background-color: #E7E0DC;">
        <div class="container">
            <!-- Services Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase">companies</h2>
            <p class="text-center">
                Hiring? Register your company for free, browse our talented pool, post and track job applications
            </p>
            
            <!-- Icon Divider-->
            <div class="divider-custom divider-dark mb-5">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"></div>
                <div class="divider-custom-line"></div>
            </div>
            
            <!-- Services Boxes -->
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/1.png" alt="Service 1" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Post A Job</h3>                            
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/2.png" alt="Service 2" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Manage & Track Job Applications</h3>                            
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="service-box p-4 border rounded d-flex flex-column align-items-center">
                        <img src="/assets/3.png" alt="Service 3" class="img-fluid mb-3" style="max-width: 100%; height: auto; flex-grow: 1; object-fit: cover;">
                        <h3 class="service-title">Hire</h3>                            
                    </div>
                </div>
            </div>

        </div>
    </section>
    
    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">
                        Manila, Taguig, Bacolod
                        <br />
                        Dubai, 123
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Around the Web</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>                        
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>                        
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">Contact</h4>
                    <p class="lead mb-0">
                        (+63) 09999                            
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; JobSearch 2023</small></div>
    </div>
            
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="/js/scripts.js"></script>
</body>
</html>

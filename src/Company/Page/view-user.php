<?php

//To Handle Session Variables on This Page
session_start();

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
        
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <?php
                        $sql = "SELECT * FROM users
                        LEFT JOIN baranggay ON baranggay.baranggay_id = users.baranggay_id 
                        WHERE id_users='$_GET[id]'";
                        $result = $conn->query($sql);
                        
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="d-flex justify-content-between mb-4">
                        <div class="d-flex gap-4">
                        <div style="width: 80px; height: 80px; background-color: black; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            <?php echo strtoupper($row['lastname'][0]); ?>
                        </div>

                            <div>
                                <h2><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></h2>
                                <h5>Age: <?php echo $row['age']; ?></h2>    
                            </div>                            
                        </div>
                        
                    <a href="my-job-post.php" class="button-create">
                        <i class="fa fa-arrow-left" style="margin-right: 1rem;"></i> Back
                    </a>
                    </div>
                    <div class="clearfix"></div>                
                    <div>                    
                        <span class="badge text-bg-info">
                            <i class="fa fa-location-arrow text-green"></i> 
                            <?php echo $row['work_type']; ?> 
                        </span>
                        <span class="badge text-bg-info">
                            <i class="fa fa-location-arrow text-green"></i> 
                            <?php echo $row['name']; ?> 
                        </span>
                       
                        
                    </div>
                    <hr>
         
                <?php
                        }
                    }
                ?>
                </div>
            </div>
                
        </div>
    </div>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

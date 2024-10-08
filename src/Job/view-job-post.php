<?php

//To Handle Session Variables on This Page
session_start();


//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../../database/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CAREERCITY</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

    
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/loading.php';?>

    <div class="content-wrapper" style="margin-left: 0px; padding-top: calc(6rem + 42px);">

        <?php

            $sql = "SELECT *, baranggay.name as baranggay_name 
                FROM job_post 
                INNER JOIN company ON job_post.id_company = company.id_company 
                INNER JOIN baranggay ON baranggay.baranggay_id = company.baranggay_id
                WHERE id_jobpost='$_GET[id]'";
            $result = $conn->query($sql);
            if($result->num_rows > 0)  {
                while($row = $result->fetch_assoc())  {
        ?>

        <section id="candidates" class="content-header">
            <div class="container">
                <div class="row">          
                    <div class="col-md-9 bg-white p-4" >
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 style="font-size: 42px;"><b><?php echo $row['jobtitle']; ?></b></h2>                        
                            <a href="jobs.php" class="buttons-sm buttons-color">
                                <i class="fa fa-arrow-left" style="margin-right:1rem"></i> Back</a>
                        </div>
                      
                        <div style="display:flex; gap:6px;">              
                            <input type="text" id="baranggay-input" value="<?php echo $row['baranggay_name']; ?>" hidden/>              
                            <div class="badge text-bg-info" style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                                <i class="fa fa-location-arrow text-green"></i> 
                                <?php echo $row['baranggay_name']; ?>, Taguig City, Philippines
                            </div>
                            <div class="badge text-bg-info" style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                                <i class="fa fa-calendar text-green"></i> <?php echo date("d-M-Y", strtotime($row['createdAt'])); ?>
                            </div>
                            <div class="badge text-bg-info" style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                                <i class="fa fa-money-bill text-blue"></i> ₱<?php echo $row['minimumsalary']; ?> - ₱<?php echo $row['maximumsalary']; ?>
                            </div>
                            <div class="badge text-bg-info" style="display:flex; gap:4px; align-items:center; justify-content:center; padding:4px; border: 1px solid #F2F3F5;">
                                <?php echo $row['job_type']; ?>
                            </div>
                        </div>

                        <hr>

                        <div style="display: flex; flex-direction:column; gap:10px;">
                            <span style="font-size:24px; font-weight:600;">Job Description</span>
                            <?php echo stripcslashes($row['description']); ?>
                        </div>
                                                                            
                    </div>
                    <div class="col-md-3 d-flex flex-column gap-3">
                        <div class="card">
                            <div class="card-header" style="background-color:white;">
                                <img src="../../uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo" style="max-width: 100%;">
                            </div>
                            <div class="card-body">
                                <div class="caption text-center d">
                                    <h3><?php echo $row['companyname']; ?></h3>
                                    <p><a href="#" class="btn btn-primary btn-flat" role="button">More Info</a></p>
                                    <hr>
                                    <div class="d-flex flex-column gap-1 align-items-center justify-content-center">
                                        <div class="d-flex flex-column flex-lg-row align-items-center gap-2">
                                            <a href="#" class="btn btn-danger btn-flat">
                                                <i class="fa fa-warning"></i> Report
                                            </a>                                            
                                            <a href="#" class="btn btn-warning btn-flat">
                                                <i class="fa fa-envelope"></i> Email
                                            </a>
                                        </div>
                                        <?php                                                    
                                            if (isset($_SESSION["id_user"]) && empty($_SESSION['companyLogged'])) {
                                                
                                                $status = isset($_GET["status"]) ? urldecode($_GET["status"]) : '';
                                                
                                                if (empty($status)) {
                                                    ?>
                                                        <div style="display:flex; align-items:center;">
                                                            <a href="#" data-id="<?php echo $row['id_jobpost']; ?>" class="apply btn btn-success btn-flat">Apply</a>
                                                        </div>
                                                    <?php
                                                } else {                                                            
                                                    if ($status === 'Under Review') {
                                                        echo "<p class='text-bg-info p-2' >Your application is under review.</p>";
                                                    } else if ($status === 'Rejected') {
                                                        echo "<p class='text-bg-danger p-2'>Your application was rejected.</p>";
                                                    } else if ($status === 'Accepted') {
                                                        echo "<p class='text-bg-success p-2'>Your application was accepted. Congratulations!</p>";
                                                    } else if ($status === 'Pending') {
                                                        echo "<p class='text-bg-secondary p-2'>Your application is pending review.</p>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card flex-grow-1" style="height:50%;">
                            <div class="card-body">
                                <div id="map" style="height: 400px; width: 100%;"></div>
                            </div>
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

   

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
            return null;
        }
    } catch (error) {
        console.error('Error fetching coordinates:', error);        
        return null;
    }
  }

  async function showLocationMap() {
     
      const baranggay = document.getElementById('baranggay-input').value;
     
      if (!baranggay) {          
          return;
      }

      const location = `${baranggay}, Taguig City, Philippines`;
      const coordinates = await getCoordinates(location);
      if (!coordinates) return;

      const map = L.map('map').setView([coordinates.lat, coordinates.lng], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

      L.marker([coordinates.lat, coordinates.lng]).addTo(map)
          .bindPopup(location)
          .openPopup();
  }
  showLocationMap()
</script>
<script>
    $(".apply").on("click", function(e) {
        e.preventDefault();
        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        const jobPostId = this.getAttribute('data-id');

        $("#loading-screen").removeClass("hidden");
        $.ajax({
            url: `../Candidate/process/apply.php?id_jobpost=${jobPostId}`, // Update with your actual PHP script path
            type: 'GET',           
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                    setTimeout(function() {
                        $("#loading-screen").addClass("hidden");
                        window.history.back();                        
                    }, 3000);
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                    $("#loading-screen").addClass("hidden");
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $("#loading-screen").addClass("hidden");
            }
        });
    });
</script>
</body>
</html>

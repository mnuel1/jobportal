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
    <title>JobSearch</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php';?>

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
                        <?php if(isset($_SESSION["id_user"]) && empty($_SESSION['companyLogged'])) { ?>
                        <div>
                            <a href="apply.php?id=<?php echo $row['id_jobpost']; ?>" class="btn btn-success btn-flat margin-top-50">Apply</a>
                        </div>
                        <?php } ?>
                                                    
                    </div>
                    <div class="col-md-3 d-flex flex-column gap-3">
                        <div class="card">
                            <div class="card-header" style="background-color:white;">
                                <img src="../../uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo" style="max-width: 100%;">
                            </div>
                            <div class="card-body">
                                <div class="caption text-center">
                                    <h3><?php echo $row['companyname']; ?></h3>
                                    <p><a href="#" class="btn btn-primary btn-flat" role="button">More Info</a></p>
                                    <hr>
                                    <div style="display:flex; flex-direction:column; gap:15px;">
                                        <div style="display: flex; justify-content:space-between; gap:15px;">
                                            <div style="display:flex; align-items:center;">
                                                <a href="" style="background-color: red; padding:6px; color:white;">
                                                    <i class="fa fa-warning"></i> Report
                                                </a>
                                            </div>
                                            <div style="display:flex; align-items:center;">
                                                <a href="" style="background-color: #F2E8C6; padding:6px; color:black;">
                                                    <i class="fa fa-envelope"></i> Email
                                                </a>
                                            </div>
                                        </div>                                        
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
     
      const baranggay = document.getElementById('baranggay-input').value;
     
      if (!baranggay) {
          alert('Please enter country, baranggay, and city');
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

</body>
</html>

<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
  }
  
require_once("../../../database/db.php");

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Query to get total number of records (for pagination)
$total_query = "SELECT COUNT(*) as total FROM job_post WHERE id_company='$_SESSION[id_company]' AND 
job_post.jobtitle LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

// Query to get paginated and filtered results
$sql = "SELECT *
        FROM job_post         
        WHERE id_company='$_SESSION[id_company]' AND  job_post.jobtitle LIKE '%$search%'
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JobSearch</title>
    
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
</head>

<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>

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

            <h1 class="text-center my-4"> MY
            <span style="color: #253D80;">JOB POST</span></h1>
            <p style="font-size: small; color:gray"><i>In this section you can view all job posts created by you.</i></p>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/search.php';?>
            
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="box-body table-responsive no-padding">
                        <table id="example2" class="table table-hover">
                            <thead style="background-color: #7D0A0A; color:white; text-align:left">
                            <th>Job Title</th>
                            <th>View</th>
                            </thead>
                            <tbody>
                            <?php                        
                            if($result->num_rows > 0) {
                                $i = 0;
                                while($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['jobtitle']; ?></td>
                                <td><a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                    <i class="fa-regular fa-eye"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            </tbody>                    
                        </table>
                        <?php
                            $total_pages = ceil($total_rows / $limit);
                            if ($total_pages > 1) {
                                echo '<nav><ul class="pagination">';
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                                }
                                echo '</ul></nav>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            
          </div>
        </div>
     
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

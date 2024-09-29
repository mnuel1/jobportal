<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_user'])) {
  header("Location: /src/index.php");
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/db.php");

// Pagination variables
$limit = 5; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$id = $_SESSION['id_user'];
// Build SQL query
$sql = "SELECT * FROM job_post 
        INNER JOIN apply_job_post ON job_post.id_jobpost = apply_job_post.id_jobpost 
        WHERE apply_job_post.id_users = '".$_SESSION['id_user']."'
        ORDER BY apply_job_post.createdAt DESC";

// Count total rows for pagination
$total_sql = str_replace('*', 'COUNT(*) as total', $sql);
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Add pagination limit
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);


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

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/candidate-sidebar.php';?>
        
        <div class="container larger bg-light mx-auto">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#candidate" 
                aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars"></i></button>
            
            <h1 class="text-center my-4">MY 
            <span style="color: #253D80;">NOTIFICATIONS</span></h1>
                                                
            <div>                  
                <div>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                                // Determine the class based on the job status
                                $statusClass = '';
                                $color = ''; // Initialize color
                                switch ($row['status']) {
                                    case 0:
                                        $statusClass = 'Pending'; // Pending (yellow)
                                        $color = 'text-warning'; 
                                        $message = "Your application is still pending. We will notify you once there is an update.";
                                        break;
                                    case 1:
                                        $statusClass = 'Rejected'; // Rejected (red)
                                        $color = 'text-danger'; 
                                        $message = "Unfortunately, your application has been rejected. We encourage you to apply for other positions.";
                                        break;
                                    case 2:
                                        $statusClass = 'Under Review'; // Under review (light blue)
                                        $color = 'text-info'; 
                                        $message = "Your application is currently under review. Our team will get back to you soon.";
                                        break;
                                    case 3:
                                        $statusClass = 'Accepted'; // Accepted (green)
                                        $color = 'text-success'; 
                                        $message = "Congratulations! Your application has been accepted. Please check your email for further instructions.";
                                        break;
                                    case 4:
                                        $statusClass = 'Accepted for interview'; // Accepted
                                        $color = 'text-success'; 
                                        $message = "Congratulations! You have received an interview schedule. Please check your email for further instructions.";
                                        break;
                                    case 5:
                                        $statusClass = 'Invited'; // Under review (light blue)
                                        $color = 'text-info'; 
                                        $message = "You are invited to apply in this job.";
                                        break;
                                        
                                    default:
                                        $statusClass = ''; // Default if no status matches
                                        $message = '';
                                }
                                ?>
                            <a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>&status=<?php echo $statusClass; ?>">
                                <div class="col-12 mb-4">                                    
                                    <div class="job-box d-flex align-items-center border rounded p-2">
                                        <img src="/assets/unnamed 1.png" alt="Job 1" class="d-none d-sm-block" style="width: 80px; height: 80px; margin-right:1rem">
                                        <div class="flex-grow-1">
                                            <h4 class="job-title mb-1"><?php echo $row['jobtitle']; ?></h4>
                                            
                                            <!-- Message based on status -->
                                            <p class="<?php echo $color; ?> msg-status"><?php echo $message; ?></p>                                            
                                        </div>
                                        <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                                            <h5 class="salary mb-0">₱<?php echo $row['maximumsalary']; ?>/Month</h5>
                                            <h5 class="<?php echo $color; ?>" style="font-size:small;"><?php echo $statusClass; ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No jobs found.</p>
                    <?php endif; ?>
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
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

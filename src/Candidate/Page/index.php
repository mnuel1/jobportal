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
$sql = "SELECT job_post.*, apply_job_post.status, apply_job_post.createdAt,
        company.companyname, company.logo, baranggay.name as baranggay_name, company.baranggay_id
        FROM apply_job_post 
        JOIN job_post ON job_post.id_jobpost = apply_job_post.id_jobpost 
        JOIN company ON job_post.id_company = company.id_company 
        JOIN baranggay ON company.baranggay_id = baranggay.baranggay_id
        WHERE apply_job_post.id_users = $id ";

// Count total rows for pagination
$total_sql = str_replace('job_post.*', 'COUNT(*) as total', $sql);
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
    <title>JobSearch</title>
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
            
            <h1 class="text-center my-4">RECENT 
            <span style="color: #7D0A0A;">APPLICATIONS</span></h1>
            <p style="font-size: small; color:gray"><i>Below you will find job roles you have applied for</i></p>
            <div class="">                  
                <div class="">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                <div class="col-12 mb-4">
                                    <?php
                                    // Determine the class based on the job status
                                    $statusClass = '';
                                    switch ($row['status']) {
                                        case 0:
                                            $statusClass = 'Pending'; // Pending (yellow)
                                            $color = 'text-warning'; // Pending (yellow)
                                            break;
                                        case 1:
                                            $statusClass = 'Rejected'; // Rejected (red)
                                            $color = 'text-danger'; // Pending (yellow)
                                            break;
                                        case 2:
                                            $statusClass = 'Under Review'; // Under review (light blue)
                                            $color = 'text-info'; // Pending (yellow)
                                            break;
                                        case 3:
                                            $statusClass = 'Accepted'; // Accepted (green)
                                            $color = 'text-success'; // Pending (yellow)
                                            break;
                                        default:
                                            $statusClass = ''; // Default class if needed
                                    }
                                    ?>
                                    <div class="job-box d-flex align-items-center border rounded p-3">
                                        <img src="/assets/unnamed 1.png" alt="Job 1" class="d-none d-sm-block" style="width: 80px; height: 80px; margin-right:1rem">
                                        <div class="flex-grow-1">
                                            <h4 class="job-title mb-1"><?php echo $row['jobtitle']; ?></h4>
                                            <p class="job-description mb-0"><?php echo $row['companyname']; ?> | 
                                            <?php echo $row['baranggay_name']; ?> | <?php echo $row['experience']; ?> Years | <?php echo $row['job_type']; ?></p>
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

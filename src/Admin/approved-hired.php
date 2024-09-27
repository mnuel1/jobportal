<?php

session_start();

if(empty($_SESSION['id_admin'])) {
    header("Location: /src/index.php");
    exit();
}

require_once("../../database/db.php");

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Query to get total number of records (for pagination)
$total_query = "SELECT COUNT(DISTINCT apply_job_post.id_apply) as total 
    FROM apply_job_post
    LEFT JOIN users ON users.id_users = apply_job_post.id_users
    LEFT JOIN job_post ON job_post.id_jobpost  = apply_job_post.id_jobpost
    LEFT JOIN company ON company.id_company  = job_post.id_company 
    WHERE CONCAT(users.firstname, ' ', users.lastname) LIKE '%$search%' 
    OR company.companyname LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

// Query to get paginated and filtered results
$sql = "SELECT DISTINCT apply_job_post.id_apply, apply_job_post.*, 
    CONCAT(users.firstname, ' ', users.lastname) as fullname, 
    users.resume, company.companyname as companyname
    FROM apply_job_post
    LEFT JOIN users ON users.id_users = apply_job_post.id_users
    LEFT JOIN job_post ON job_post.id_jobpost  = apply_job_post.id_jobpost
    LEFT JOIN company ON company.id_company  = job_post.id_company 
    WHERE CONCAT(users.firstname, ' ', users.lastname) LIKE '%$search%' 
    OR company.companyname LIKE '%$search%'
    LIMIT $limit OFFSET $offset";

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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/confirmModal.php';?>

    
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
            <h1 class="text-center my-4">JOB APPLICANT 
            <span style="color: #7D0A0A;">STATUS BOARD</span></h1>
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search here..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="buttons-sm buttons-color" type="submit">Search</button>
                </div>
            </form>
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead style="background-color: #7D0A0A; color:white; text-align:left;">
                                <th>Name</th>
                                <th>Date Submission</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>View</th>
                                <th>Notify</th>
                                
                            </thead>
                            <tbody>
                                <?php                                    
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) 
                                        {
                                            switch ($row['status']) {
                                                case 0:
                                                    $status = "Pending";
                                                    $class = "text-bg-warning";                                                
                                                    break;
                                                case 1:
                                                    $status = "Rejected";
                                                    $class = "text-bg-danger";
                                                    break;
                                                case 2:
                                                    $status = "Under Review";
                                                    $class = "text-bg-info";
                                                    break;
                                                case 3:
                                                    $status = "Accepted";
                                                    $class = "text-bg-success";
                                                    break;
                                                default:
                                                    $status = "";
                                                    break;
                                            }
                                ?>
                            <tr style="text-align: left;">
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['createdAt']; ?></td>
                                <td><?php echo '<span class="badge ' . $class . '">' . $status . '</span>'; ?></td>
                                <td><?php echo $row['companyname']; ?></td>                                 
                                <?php if($row['resume'] != '') { ?>
                                    <td>
                                        <a href="/uploads/resume/<?php echo $row['resume']; ?>" 
                                    download="<?php echo $row['fullname'].' Resume'; ?>">
                                    <i class="fa-regular fa-file-pdf"></i>
                                    </a>
                                </td>
                                <?php } else { ?>
                                    <td>No Resume Uploaded</td>
                                <?php } ?>

                                <td><i class="fa-regular fa-envelope"></i></td>
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

    <div class="modal modal-success fade" id="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Candidate Profile</h4>
          </div>
          <div class="modal-body">
              <h3><b>Applied On</b></h3>
              <p>24/04/2017</p>
              <br>
              <h3><b>Email</b></h3>
              <p>test@test.com</p>
              <br>
              <h3><b>Phone</b></h3>
              <p>44907512447</p>
              <br>
              <h3><b>Website</b></h3>
              <p>jonsnow.netai.net</p>
              <br>
              <h3><b>Application Message</b></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>

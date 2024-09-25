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
$total_query = "SELECT COUNT(*) as total FROM users LEFT JOIN baranggay ON baranggay.baranggay_id = users.baranggay_id 
WHERE CONCAT(users.firstname, ' ', users.lastname) LIKE '%$search%' OR users.email LIKE '%$search%' OR users.contactno LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

// Query to get paginated and filtered results
$sql = "SELECT users.*, baranggay.name as baranggay_name 
        FROM users 
        LEFT JOIN baranggay ON baranggay.baranggay_id = users.baranggay_id 
        WHERE CONCAT(users.firstname, ' ', users.lastname) LIKE '%$search%' OR users.email LIKE '%$search%' OR users.contactno LIKE '%$search%' 
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
            <h1 class="text-center my-4">CANDIDATES 
            <span style="color: #7D0A0A;">DATABASE</span></h1>
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
                            <thead style="background-color: #7D0A0A; color:white;">
                                <th>Candidate</th>
                                <th>Highest Qualification</th>
                                <th>Skills</th>
                                <th>Baranggay</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Download Resume</th>
                            </thead>
                            <tbody>
                                <?php                                    
                                    if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) 
                                    {     

                                        $skills = $row['skills'];
                                        $skills = explode(',', $skills);
                                ?>
                            <tr>
                                <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                                <td><?php echo $row['qualification']; ?></td>
                                <td>
                                    <?php
                                        foreach ($skills as $value) {
                                            echo ' <span class="badge text-bg-info">'.$value.'</span>';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $row['baranggay_name']; ?></td>
                                <td>Taguig City</td>
                                <td>Metro Manila</td>
                                <?php if($row['resume'] != '') { ?>
                                    <td style="display:flex; justify-content:center">
                                        <a href="/uploads/resume/<?php echo $row['resume']; ?>" 
                                    download="<?php echo $row['firstname'].' Resume'; ?>">
                                    <i class="fa-regular fa-file-pdf"></i>
                                    </a>
                                </td>
                                <?php } else { ?>
                                    <td>No Resume Uploaded</td>
                                <?php } ?>
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

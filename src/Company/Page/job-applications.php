<?php
//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
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
    <title>JobSearch</title>
    
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

    <style>
        .cont {
            background: white;
            padding: 1rem;
            color: white;
        }

        .cont:hover {
            background-color: #CA2B2D;
        }
    </style>
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

            <h1 class="text-center my-4"> RECENT
            <span style="color: #253D80;">APPLICATIONS</span></h1>
            <p style="font-size: small; color:gray"><i>Below you will find job applications that applied to your job post.</i></p>
          
                <?php                     
                $sql = "SELECT apply_job_post.id_apply, apply_job_post.createdAt as createdAt, apply_job_post.status,
                apply_job_post.id_users, apply_job_post.id_jobpost, job_post.jobtitle, users.firstname, users.lastname, users.email
                FROM job_post 
                INNER JOIN apply_job_post ON job_post.id_jobpost=apply_job_post.id_jobpost 
                INNER JOIN users ON users.id_users=apply_job_post.id_users 
                WHERE job_post.id_company='$_SESSION[id_company]'";
                    $result = $conn->query($sql);

                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {     
                ?>
                <a href="user-application.php?id=<?php echo $row['id_users']; ?>&id_jobpost=<?php echo $row['id_jobpost']; ?>&id_apply=<?php echo $row['id_apply']; ?>&email=<?php echo $row['email']; ?>&jobtitle=<?php echo $row['jobtitle']; ?>&status=<?php echo $row['status']; ?>">
                    <div class="col-12 mb-4">
                        <?php                        
                        $statusClass = '';
                        $color = ''; 
                        switch ($row['status']) {
                            case 0:
                                $statusClass = 'Pending'; 
                                $color = 'text-warning';                                 
                                break;
                            case 1:
                                $statusClass = 'Rejected'; 
                                $color = 'text-danger';                                 
                                break;
                            case 2:
                                $statusClass = 'Under Review'; 
                                $color = 'text-info';                                 
                                break;
                            case 3:
                                $statusClass = 'Accepted'; 
                                $color = 'text-success';                                 
                                break;
                            default:
                                $statusClass = ''; 
                        }
                        ?>
                        <div class="job-box d-flex align-items-center border rounded p-3">                            
                            <div class="flex-grow-1">
                                <h4 class="job-title mb-1"><?php echo $row['jobtitle'].' @ ('.$row['firstname'].' '.$row['lastname'].')'; ?></h4>                    
                                <div>
                                    <i class="fa fa-calendar"></i>
                                    <span class="ms-2"><?php echo $row['createdAt']; ?></span> 
                                </div>                               
                            </div>
                            <div class="d-flex flex-column justify-content-between" style="height: 100%;">                                
                                <h5 class="<?php echo $color; ?>" style="font-size:small;"><?php echo $statusClass; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            <!--  -->

            <?php
              }
            }
            ?>
    
<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

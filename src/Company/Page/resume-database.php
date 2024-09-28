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
        <div class="container larger bg-light mx-auto" style="padding: 24px;">
            <button 
                style="margin-top: 20px;"
                class="btn btn-primary d-block d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#company" 
                aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-bars"></i></button>
            
            <h1 class="text-center my-4">TALENT
            <span style="color: #253D80;">DATABASE</span></h1>
            <p style="font-size: small; color:gray"><i>In this section you can download resume of all applicants who applied to your job posts</i></p>          
          
                                
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <div class="box-body table-responsive no-padding">
                        <table id="example2" class="table table-hover">
                            <thead style="background-color:#7D0A0A; text-align:left; color:white">
                                <th>Applicant</th>
                                <th>Highest Qualification</th>
                                <th>Skills</th>
                                <th>Baranggay</th>                            
                                <th>Download Resume</th>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT users.*, baranggay.name as baranggay FROM job_post 
                                INNER JOIN apply_job_post ON job_post.id_jobpost=apply_job_post.id_jobpost  
                                INNER JOIN users ON users.id_users=apply_job_post.id_users 
                                INNER JOIN baranggay ON baranggay.baranggay_id = users.baranggay_id
                                WHERE job_post.id_company='$_SESSION[id_company]' GROUP BY users.id_users";

                                    $result = $conn->query($sql);

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
                                    echo ' <span class="badge text-bg-success">'.$value.'</span>';
                                }
                                ?>
                                </td>
                                <td><?php echo $row['baranggay']; ?></td>
                                
                                <td>
                                    <a href="/uploads/resume/<?php echo $row['resume']; ?>" download="<?php echo $row['firstname'].' Resume'; ?>">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>

                            <?php

                                }
                            }
                            ?>

                            </tbody>                    
                        </table>
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

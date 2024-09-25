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
$total_query = "SELECT COUNT(*) as total FROM job_post INNER JOIN company ON job_post.id_company=company.id_company 
WHERE job_post.jobtitle LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

// Query to get paginated and filtered results
$sql = "SELECT job_post.*, company.companyname  
        FROM job_post 
        INNER JOIN company ON job_post.id_company=company.id_company 
        WHERE job_post.jobtitle LIKE '%$search%'
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
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
            <h1 class="text-center my-4">ACTIVE JOB 
            <span style="color: #7D0A0A;">POSTS</span></h1>
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search here..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="buttons-sm buttons-color" type="submit">Search</button>
                </div>
            </form>                          
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <div class="box-body table-responsive no-padding">
                    <table id="example2" class="table table-hover">
                        <thead style="background-color: #7D0A0A; color:white; text-align:left">
                            <th>Job Name</th>
                            <th>Company Name</th>
                            <th>Date Created</th>
                            <th>View</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                        <?php                        
                            if($result->num_rows > 0) {
                                $i = 0;
                                while($row = $result->fetch_assoc()) {
                            ?>
                        <tr style="text-align:left">
                            <td><?php echo $row['jobtitle']; ?></td>
                            <td><?php echo $row['companyname']; ?></td>
                            <td><?php echo date("d-M-Y", strtotime($row['createdAt'])); ?></td>
                            <td>
                                <a href="/src/Job/view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">                                
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="deletejobpost" data-toggle="modal" data-target="#confirmDeleteModal" 
                                data-id="<?php echo $row['id_jobpost']; ?>">
                                    <i class="fa fa-trash trash" ></i>
                                </a>
                            </td>
                            
                           
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
                    

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- JQuery JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   

<script>

    let jobpost_id
    $('#confirmThis').on('click', function() {

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);
        console.log('./process/delete-job-post.php?id=' + jobpost_id);
        
        if (actionType === 'delete') {         
            var deleteUrl = './process/delete-job-post.php?id=' + jobpost_id;
            
            $.ajax({
                url: deleteUrl, 
                method: 'GET',
                success: function(response) {                
                    if (response.success) {
                        // Show success message
                        toastSuccessMsg.textContent = response.message;
                        successToast.show();   
                        
                        // Hide the modal after action
                        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                        confirmModal.hide();                 
                    } else {
                        toastErrorMsg.textContent = response.message;
                        errorToast.show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });            
        } 
    });

    $('.deletejobpost').on('click', function (event) {
        event.preventDefault(); // Prevent default anchor behavior
              
        const modal = document.getElementById('confirmModal')
        const msg = document.getElementById('confirm-msg')
        msg.textContent = `Are you sure you want to delete this job post? Deleting a job post
        is irreversible.`
        
        var delCompanyModal = new bootstrap.Modal(modal);    
        delCompanyModal.show(); // Show toast
        actionType = "delete";
        jobpost_id = $(this).data('id');
             
       
    });

</script>
</body>
</html>

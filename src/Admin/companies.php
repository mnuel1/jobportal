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
$total_query = "SELECT COUNT(*) as total FROM company LEFT JOIN baranggay ON baranggay.baranggay_id = company.baranggay_id WHERE company.companyname LIKE '%$search%' OR company.email LIKE '%$search%' OR company.contactno LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

// Query to get paginated and filtered results
$sql = "SELECT company.*, baranggay.name as baranggay_name 
        FROM company 
        LEFT JOIN baranggay ON baranggay.baranggay_id = company.baranggay_id 
        WHERE company.companyname LIKE '%$search%' OR company.email LIKE '%$search%' OR company.contactno LIKE '%$search%' 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    
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
            <h1 class="text-center my-4">COMPANIES 
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
                            <thead style="background-color: #7D0A0A; color:white; ">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Account Creator Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Baranggay</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['companyname']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['contactno']; ?></td>
                                            <td><?php echo $row['baranggay_name']; ?></td>
                                            <td>Taguig City</td>
                                            <td>Metro Manila</td>
                                            <td>
                                                <?php
                                                if ($row['active'] == '1') {
                                                    echo "Activated";
                                                } else if ($row['active'] == '2') {
                                                    echo '                                                   
                                                    <div class="statuscont"> 
                                                        <a 
                                                            class="statusBtn" 
                                                            data-url="./process/reject-company.php?id=' . $row['id_company'] . '" 
                                                            data-action="reject">
                                                            Reject
                                                        </a> 
                                                        <a 
                                                            class="statusBtn" 
                                                            data-url="./process/approve-company.php?id=' . $row['id_company'] . '" 
                                                            data-action="approve">
                                                            Approve
                                                        </a>
                                                    </div>
                                                    ';
                                                    
                                                } else if ($row['active'] == '3') {
                                                    echo '<a href="./process/approve-company.php?id=' . $row['id_company'] . '">Reactivate</a>';
                                                } else {
                                                    echo "Rejected";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="#" class="deleteCompany" data-toggle="modal" data-target="#confirmDeleteModal" 
                                                data-id="<?php echo $row['id_company']; ?>">
                                                    <i class="fa fa-trash trash" ></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="9">No companies found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
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
    let companyId = null; 
    let actionUrl = null;
    let actionType = null;
    
    $('#confirmThis').on('click', function() {

        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);

        if (actionType === 'delete') {         
            var deleteUrl = './process/delete-company.php?id=' + companyId;
            
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

        // Handle approve or reject actions
        if (actionType === 'reject') {
            $.ajax({
                url: actionUrl, 
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
        } else if (actionType === 'approve') {
            $.ajax({
                url: actionUrl, 
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

    $('.statusBtn').on('click', function(event) {
        event.preventDefault(); // Prevent the default action (navigation)

        // Get the action URL and type from the clicked element's data attributes
        actionUrl = $(this).data('url');
        actionType = $(this).data('action');

        const modal = document.getElementById('confirmModal')
        const msg = document.getElementById('confirm-msg')
        if (actionType === 'reject') {
            msg.textContent = 'Are you sure you want to reject this company?';
        } else if (actionType === 'approve') {
            msg.textContent = 'Are you sure you want to approve this company?';
        }

        // Show the confirmation modal
        var confirmModal = new bootstrap.Modal(modal);
        confirmModal.show();
    });

    $('.deleteCompany').on('click', function (event) {
        event.preventDefault(); // Prevent default anchor behavior
              
        const modal = document.getElementById('confirmModal')
        const msg = document.getElementById('confirm-msg')
        msg.textContent = `Are you sure you want to delete this company? Deleting a company
        is irreversible.`
        
        var delCompanyModal = new bootstrap.Modal(modal);    
        delCompanyModal.show(); // Show toast
        actionType = "delete";
        companyId = $(this).data('id');
             
       
    });

</script>
</body>
</html>

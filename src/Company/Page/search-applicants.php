<?php
    session_start();
    //If user Not logged in then redirect them back to homepage. 
    if(empty($_SESSION['id_company'])) {
        header("Location: /src/index.php");
        exit();
    }

    require_once("../../../database/db.php");
    // Pagination variables
    $limit = 5; // Number of results per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Search and Filter
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $baranggay = isset($_GET['baranggay']) ? $_GET['baranggay'] : '';    
    $type = isset($_GET['type']) ? $_GET['type'] : 0;

    // Build SQL query
    $sql = "SELECT users.*, baranggay.name as baranggay_name FROM users             
            JOIN baranggay ON users.baranggay_id = baranggay.baranggay_id
            WHERE 1=1";

    if ($search) {
        $sql .= " AND CONCAT(users.firstname, ' ', users.lastname) LIKE '%" . $conn->real_escape_string($search) . "%'";
    }
    if ($baranggay) {
        $sql .= " AND users.baranggay_id = '" . $conn->real_escape_string($baranggay) . "'";
    }
    if ($type) {
        $sql .= " AND work_type = '" . $conn->real_escape_string($type) . "'";
    }

    // Count total rows for pagination
    $total_sql = str_replace('users.*', 'COUNT(*) as total', $sql);
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
    
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
        
  
    <style>
        a {
            color: black;
            text-decoration: none;
        }
        a:hover {
            color: #CA2B2D;
        }
        
        @media (max-width: 768px) {
            .job-title {
                font-size: 1rem; /* Job title font size */
            }
            .job-description {
                font-size: 0.5rem; /* Job description font size */
            }
            .salary {       
                font-size: 1rem; /* Salary font size */
            }
        }

        @media (max-width: 576px) {
            .job-title {
                font-size: .75rem; /* Job title font size */
            }
            .job-description {
                font-size: 0.5rem; /* Job description font size */
            }
            .salary {       
                font-size: .75rem; /* Salary font size */
            }
        }
    </style>
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/admin-nav.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    
    
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
            
            <h1 class="text-center my-4">SEARCH FOR APPLICANTS
            <span style="color: #7D0A0A;"></span></h1>
            
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/search.php';?>

        <section id="jobs" class="content-header ">
            <div class="container">
                <div class="row bg-light p-4">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-2">Filters</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- First Dropdown -->
                                    <div class="col-12 mb-2">
                                        <div class="dropdown">
                                            <button class="d-flex justify-content-between align-items-center dropdown-toggle 
                                            w-100 p-2 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" 
                                            style="border:1px solid lightgray; background-color:white">
                                                Baranggay
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <?php
                                                    // Fetching all baranggays from the 'baranggay' table
                                                    $baranggayQuery = "SELECT baranggay_id, name FROM baranggay";
                                                    $baranggayResult = $conn->query($baranggayQuery);
                                                    if ($baranggayResult->num_rows > 0):
                                                        while ($baranggay = $baranggayResult->fetch_assoc()): ?>                                                 
                                                            <li class="nav-item">
                                                                <a class="dropdown-item" href="?baranggay=<?php echo urlencode($baranggay['baranggay_id']); ?>" class="nav-link <?php echo (isset($_GET['baranggay']) && $_GET['baranggay'] == $baranggay['name']) ? 'active' : ''; ?>">
                                                                    <?php echo htmlspecialchars($baranggay['name']); ?>
                                                                </a>
                                                            </li>
                                                        <?php endwhile;
                                                    else: ?>
                                                        <li class="nav-item">
                                                            <p>No baranggays found.</p>
                                                        </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
         
                                    <div class="col-12">
                                        <div class="dropdown">
                                            <button class="d-flex justify-content-between align-items-center  
                                            dropdown-toggle w-100 p-2 text-start" type="button" 
                                            data-bs-toggle="dropdown" aria-expanded="false" style="border:1px solid lightgray; background-color:white">
                                                Job Type
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?type=<?php echo urlencode("Full Time"); ?>" class="nav-link <?php echo (isset($_GET['type']) && $_GET['type'] == urlencode("Full Time")) ? 'active' : ''; ?>">
                                                        Full Time
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?type=<?php echo urlencode("Part Time"); ?>" class="nav-link <?php echo (isset($_GET['type']) && $_GET['type'] == urlencode("Part Time")) ? 'active' : ''; ?>">
                                                        Part Time
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <a href="view-user.php?id=<?php echo $row['id_users']; ?>">
                                    <div class="col-12 mb-4 mt-2 mt-sm-0">
                                        <div class="job-box d-flex align-items-center border rounded p-2">                                            
                                            <div class="flex-grow-1">
                                                <h4 class="job-title mb-1"><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></h4>
                                                <p class="job-description mb-0">
                                                    <?php echo $row['baranggay_name']; ?> | <?php echo $row['skills']; ?> | <?php echo $row['work_type']; ?>
                                                </p>
                                            </div>
                                            <div>
                                            <button 
                                            type="button" 
                                            class="buttons-sm buttons-color invite-button"
                                            data-id="<?php echo htmlspecialchars($row['id_users']); ?>" 
                                            data-email="<?php echo htmlspecialchars($row['email']); ?>">
                                                Invite
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No applicants found.</p>
                        <?php endif; ?>
                        <div class="d-flex align-items-center justify-content-center">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&baranggay=<?php echo urlencode($baranggay); ?>&experience=<?php echo $experience; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/inviteModal.php';?>
    <!-- Bootstrap core JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const toastSuccessMsg = document.getElementById('toast-success-msg')
    const succToast = document.getElementById('successToast')
    var successToast = new bootstrap.Toast(succToast);

    const toastErrorMsg = document.getElementById('toast-error-msg')
    const errToast = document.getElementById('errorToast')
    var errorToast = new bootstrap.Toast(errToast);            


    const inviteModal = document.getElementById("inviteModal");
    var invModal = new bootstrap.Modal(inviteModal);

    let applicantid = null
    let applicantemail = null
    $('.invite-button').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        applicantid = $(this).data('id');
        applicantemail = $(this).data('email');
        invModal.show();
    });

    $('#sendInvite').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        const jobpostSelect = document.getElementById("jobpost");
        
        const userId = applicantid;
        const userEmail = applicantemail;
        
        const jobpostID = jobpostSelect.value; 
        const jobpostTitle = jobpostSelect.options[jobpostSelect.selectedIndex].text;
      
        const formData = new FormData();
        formData.append('applicantId', userId);
        formData.append('email', userEmail);
        formData.append('jobpostId', jobpostID);
        formData.append('jobtitle', jobpostTitle);

        $.ajax({
            url: '../process/sendInvite.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();
                                        
                } else {
                    toastErrorMsg.textContent = response.message;
                    errorToast.show();
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                console.log(xhr);
                
                
                console.error('AJAX Error:', error);
            }
        });
        invModal.hide();
          
    });
    
</script>
</body>
</html>

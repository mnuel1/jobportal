<?php
    session_start();
    require_once("../../database/db.php");

    // Pagination variables
    $limit = 5; // Number of results per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Search and Filter
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $baranggay = isset($_GET['baranggay']) ? $_GET['baranggay'] : '';
    $experience = isset($_GET['experience']) ? (int)$_GET['experience'] : 0;
    $type = isset($_GET['type']) ? $_GET['type'] : 0;

    // Build SQL query
    $sql = "SELECT job_post.*, company.companyname, company.logo, baranggay.name as baranggay_name, company.baranggay_id  FROM job_post 
            JOIN company ON job_post.id_company = company.id_company 
            JOIN baranggay ON company.baranggay_id = baranggay.baranggay_id
            WHERE 1=1";

    if ($search) {
        $sql .= " AND jobtitle LIKE '%" . $conn->real_escape_string($search) . "%'";
    }
    if ($baranggay) {
        $sql .= " AND company.baranggay_id = '" . $conn->real_escape_string($baranggay) . "'";
    }
    if ($experience) {
        $sql .= " AND experience >= $experience";
    }
    if ($type) {
        $sql .= " AND job_type = '" . $conn->real_escape_string($type) . "'";
    }

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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CAREERCITY</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />
        
    <!-- Google Font -->
    
  
    <style>
        a {
            color: black;
            text-decoration: none;
        }
        a:hover {
            color: #CA2B2D;
        }

        .input-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* Divider between input, mic, and search button */
        .divider {
            width: 1px;
            background-color: #CA2B2D;
            height: 40px;
            margin: 0 5px;
        }
        .mic-btn, .search-btn {
            background-color: white; 
            border: 0px;
            border-radius: 0;
        }

        /* Hover effect for buttons */
        .search-btn:hover {
            background-color: #CA2B2D;        
            color: white;
            cursor: pointer;
        }
        .mic-btn:hover {
            color: #CA2B2D;
        }
    
        /* Add subtle hover effect for the search input */
        #searchBar:focus {
            outline: none;
            box-shadow: none;
            border-color: #CA2B2D;
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/authnavigation.php';?>

    <div class="content-wrapper" style="margin-left: 0px; padding-top: calc(6rem + 42px);">
        <section id="jobs" class="content-header ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 latest-job margin-top-50 margin-bottom-20 mb-2">
                        <h1 class="text-center" style="font-weight:700">LATEST <span style="color: #7D0A0A;">OFFERS</span></h1>
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/search.php';?>   
                    </div>
                </div>
            </div>
        </section>

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

                                    <!-- Second Dropdown -->
                                    <div class="col-12 mb-2">
                                        <div class="dropdown">
                                            <button class="d-flex justify-content-between align-items-center  
                                            dropdown-toggle w-100 p-2 text-start" type="button" 
                                            data-bs-toggle="dropdown" aria-expanded="false" style="border:1px solid lightgray; background-color:white">
                                                Experience
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?experience=1" class="nav-link <?php echo (isset($_GET['experience']) && $_GET['experience'] == '1') ? 'active' : ''; ?>">
                                                        1 Year
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?experience=2" class="nav-link <?php echo (isset($_GET['experience']) && $_GET['experience'] == '2') ? 'active' : ''; ?>">
                                                        2 Years
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?experience=3" class="nav-link <?php echo (isset($_GET['experience']) && $_GET['experience'] == '3') ? 'active' : ''; ?>">
                                                        3 Years
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?experience=4" class="nav-link <?php echo (isset($_GET['experience']) && $_GET['experience'] == '4') ? 'active' : ''; ?>">
                                                        4 Years
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="dropdown-item" href="?experience=5" class="nav-link <?php echo (isset($_GET['experience']) && $_GET['experience'] == '5') ? 'active' : ''; ?>">
                                                        5+ Years
                                                    </a>
                                                </li>
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
                                <a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                    <div class="col-12 mb-4">
                                        <div class="job-box d-flex align-items-center border rounded p-2">
                                            <img src="../../assets/unnamed 1.png" alt="Job 1" class="d-none d-sm-block" style="width: 80px; height: 80px; margin-right:1rem">
                                            <div class="flex-grow-1">
                                                <h4 class="job-title mb-1"><?php echo $row['jobtitle']; ?></h4>
                                                <p class="job-description mb-0"><?php echo $row['companyname']; ?> | 
                                                <?php echo $row['baranggay_name']; ?> | <?php echo $row['experience']; ?> Years | <?php echo $row['job_type']; ?></p>
                                            </div>
                                            <div class="">
                                                <h5 class="salary mb-0">₱<?php echo $row['maximumsalary']; ?>/Month</h5>
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

    <!-- Bootstrap core JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>

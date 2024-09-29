<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
}

require_once("../../../database/db.php");

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Query to get total number of records (for pagination)
$total_query = "SELECT COUNT(*) as total FROM mailbox 
WHERE (id_fromuser = '$_SESSION[id_company]' OR id_touser = '$_SESSION[id_company]')
AND (id_fromuser LIKE '%$search%' OR id_touser LIKE '%$search%')";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];

$sql = "SELECT * FROM mailbox 
WHERE (id_fromuser = '$_SESSION[id_company]' OR id_touser = '$_SESSION[id_company]')
AND (id_fromuser LIKE '%$search%' OR id_touser LIKE '%$search%')
LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAREERCITY</title>
    
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
            
            <h1 class="text-center my-4">MAILBOX
            <span style="color: #7D0A0A;"></span></h1>
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search here..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="buttons-sm buttons-color" type="submit">Search</button>
                </div>
            </form>
            <div class="d-flex align-items-center justify-content-end mb-2">
                <a href="create-mail.php" class="button-create buttons-color">
                    <i class="fa fa-envelope " style="margin-right: 1rem;"></i> Create</a>
            </div>
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <table id="example1" class="table table-hover table-striped">
                                <thead style="background-color:#7D0A0A; color:white;">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            <tbody>
                            <?php                               
                                if($result->num_rows >  0 ){
                                    while($row = $result->fetch_assoc()) {
                            ?>
                            <tr onclick="window.location='read-mail.php?id_mail=<?php echo $row['id_mailbox']; ?>';" style="cursor: pointer;">
                                <td class="mailbox-subject">
                                    <?php echo $row['subject']; ?>
                                </td>
                                <td class="mailbox-date">
                                    <?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?>
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
    </div>
    

  

<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
    header("Location: /src/index.php");
    exit();
}

require_once("../../../database/db.php");

$sql = "SELECT * FROM mailbox WHERE id_mailbox='$_GET[id_mail]' AND (id_fromuser='$_SESSION[id_company]' OR id_touser='$_SESSION[id_company]')";
$result = $conn->query($sql);
if($result->num_rows >  0 ){

    $row = $result->fetch_assoc();
    if($row['fromuser'] == "company") {
        $sql1 = "SELECT * FROM company WHERE id_company='$row[id_fromuser]'";
        $result1 = $conn->query($sql1);
        if($result1->num_rows >  0 ){
            $rowCompany = $result1->fetch_assoc();
        }
        $sql2 = "SELECT * FROM users WHERE id_users='$row[id_touser]'";
        $result2 = $conn->query($sql2);
        if($result2->num_rows >  0 ){
            $rowUser = $result2->fetch_assoc();
        }
    } else {
        $sql1 = "SELECT * FROM company WHERE id_company='$row[id_touser]'";
        $result1 = $conn->query($sql1);
            if($result1->num_rows >  0 ){
        $rowCompany = $result1->fetch_assoc();
        }
        $sql2 = "SELECT * FROM users WHERE id_users='$row[id_fromuser]'";
        $result2 = $conn->query($sql2);
        if($result2->num_rows >  0 ){
            $rowUser = $result2->fetch_assoc();
        }
    }
  
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
    <link href="/css/body.css" rel="stylesheet" />

    <script src="/js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'#description', height: 150 });</script>
 
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
            
            <div class="row">
              <div class="col-md-12">
                <a href="mailbox.php" class="buttons-sm buttons-color mt-4">
                    <i class="fa fa-arrow-circle-left" style="margin-right: 1rem;">
                    </i> 
                    Back
                </a>
                <div class="box box-primary">
                 
                    <div class="box-body no-padding mt-4">
                        <div class="mailbox-read-info">
                            <h3>Subject: <?php echo $row['subject']; ?></h3>
                            <h5>From: <?php echo $rowCompany['companyname']; ?>
                                <span class="mailbox-read-time pull-right">
                                    <?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?>
                                </span>
                            </h5>
                        </div>
                        <div class="mailbox-read-message"> 
                            <b>Message:</b>
                            <?php echo stripcslashes($row['message']); ?>
                        </div>                  
                    </div>                
                </div>

                <?php

                $sqlReply = "SELECT * FROM reply_mailbox WHERE id_mailbox='$_GET[id_mail]'";
                $resultReply = $conn->query($sqlReply);
                if($resultReply->num_rows > 0) {
                  while($rowReply =  $resultReply->fetch_assoc()) {
                    ?>
                  <div class="box box-primary">
                    <div class="box-body no-padding">
                      <div class="mailbox-read-info">
                        <h3>Reply Message</h3>  
                        <h5>From: <?php 
                            if($rowReply['usertype'] == "company") { echo $rowCompany['companyname']; } else { echo $rowUser['firstname']; } ?>
                          <span class="mailbox-read-time pull-right"><?php echo date("d-M-Y h:i a", strtotime($rowReply['createdAt'])); ?></span></h5>
                      </div>
                      <div class="mailbox-read-message">
                        <?php echo stripcslashes($rowReply['message']); ?>
                      </div>
                    </div>
                  </div>
                    <?php
                  }
                }
                ?>
                

                <div class="box box-primary">
                  
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3>Send Reply</h3>
                        </div>
                        <div class="mailbox-read-message">
                            <form id="replyMail" method="post">
                                <div class="form-group">
                                    <textarea class="form-control input-lg" id="description" name="description" placeholder="Job Description"></textarea>
                                    <input type="hidden" name="id_mail" value="<?php echo $_GET['id_mail']; ?>">
                                </div>
                                <div class="form-group">
                                <button type="submit" class="buttons-sm buttons-color mt-4">Reply</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>                  
                </div>


         

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    $("#replyMail").on("submit", function(e) {
        e.preventDefault();
        const descriptionContent = tinymce.get('description').getContent();
        $('#description').val(descriptionContent);
        const toastSuccessMsg = document.getElementById('toast-success-msg')
        const succToast = document.getElementById('successToast')
        var successToast = new bootstrap.Toast(succToast);

        const toastErrorMsg = document.getElementById('toast-error-msg')
        const errToast = document.getElementById('errorToast')
        var errorToast = new bootstrap.Toast(errToast);            

        $.ajax({
            url: '../process/reply-mailbox.php', // Update with your actual PHP script path
            type: 'POST',
            data: new FormData($('#replyMail')[0]), // Assuming you have a form with this ID
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                       
                if (response.success) {
                    toastSuccessMsg.textContent = response.message;
                    successToast.show();

                    $('#replyMail')[0].reset(); // Reset all fields
                    tinymce.get('description').setContent(''); // Clear TinyMCE editor
                    
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
      
    })
   

</script>
</body>
</html>

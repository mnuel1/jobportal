
<!DOCTYPE html>
<html lang="en">
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
    <link href="/css/body.css" rel="stylesheet" />
    <style>
        .login-page {
            background-color: #E7E0DC;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            
        }
        .login-box {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #CA2B2D;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .login-box-msg {
            color:white;
            text-align: center;
            font-size: 17px;
            font-weight:500
        }
        .login-logo a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 50px;
            text-align: center;
            display: block;
            margin-bottom: 20px;
        }
        .form-control-feedback {
            position: absolute;
            right: 15px;
            top: 10px;
        }
        .btn-toggle-password {
            cursor: pointer;
            border: none;
            background: none;
        }
        .login-box-body{
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: center;
        }
    </style>
</head>
<body class="login-page">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-success.php';?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/src/components/toast-error.php';?>

    <div class="login-box">
        <div class="login-logo">
            <a href="/src/index.php">JobSearch</a>
        </div>    
        <div class="login-box-body">           
            <i class="fa-regular fa-circle-check" style="width:120px; height:120px;"></i>
            <h1>ACCOUNT VERIFIED</h1>
            <a href="/src/Candidate/login-candidates.php" class="buttons-sm buttons-color-dark" style="text-decoration: none;">Go home</a>

        </div>
        <div class="fixed-bottom" style="z-index: 0; pointer-events: none; ">
            <img src="/assets/bot.png" alt="Footer Background" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

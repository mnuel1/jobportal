<nav class="navbar navbar-expand-lg text-uppercase fixed-top" style="background-color: #CA2B2D;" id="mainNav">
    <div class="container">        
        <a class="navbar-brand" href="/src/index.php"><img src="/assets/logo.png" width="250" alt=""></a>
        <button class="navbar-toggler text-uppercase font-weight-bold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #CA2B2D; color: white;">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded" href="/src/job/jobs.php">Jobs</a></li>
                <li class="nav-item mx-0 mx-lg-1" style="margin-left: 20px; margin-right: 20px;">
                    <hr class="d-lg-none" style="border-top: 2px solid white; width: 100%; margin: 10px 0;">
                </li>
                <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded login-link" href="/src/login.php">Login</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" style="border:1px solid white;" href="/src/sign-up.php">Sign-up</a></li>
                <?php } else { 
                    if(isset($_SESSION['id_user'])) { ?>  
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="/src/Candidate/Page/index.php">Dashboard</a></li>
                    <?php } else if(isset($_SESSION['id_company'])) { ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="/src/Company/Page/index.php">Dashboard</a></li>
                    <?php } ?>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-3 px-lg-3 rounded auth-link" href="/src/logout.php">Log-out</a></li>                       
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
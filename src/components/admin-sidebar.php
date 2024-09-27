<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="container smaller bg-light mx-auto d-none d-lg-block" style="overflow: hidden;"> 
    <h1 class="text-center" style="margin-top: 30px; color:#0A2E7D">WELCOME 
        <span style="color: #CA2B2D;">ADMIN</span>
    </h1>
    <hr>
    <div class="vertical-menu">
        <a href="dashboard.php" class="h4 d-flex align-items-center <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                
            <img src="/assets/image 72.png" alt="Dashboard Icon">
            Dashboard
        </a>
        <a href="active-jobs.php" class="h4 d-flex align-items-center <?= $current_page == 'active-jobs.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/image 73.png" alt="Active Jobs Icon">
            Active Jobs
        </a>
        <a href="applications.php" class="h4 d-flex align-items-center <?= $current_page == 'applications.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 74.png" alt="Applications Icon">
            Applications
        </a>
        <a href="companies.php" class="h4 d-flex align-items-center <?= $current_page == 'companies.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 77.png" alt="Companies Icon">
            Companies
        </a>
        <a href="approved-hired.php" class="h4 d-flex align-items-center <?= $current_page == 'approved-hired.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 71.png" alt="Approved/Hired Icon">
            Approved/Hired
        </a>
        <a href="/src/logout.php" class="h4 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 76.png" alt="Logout Icon">
            Logout
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <div></div>                    
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h1 class="text-center" style="margin-top: 30px;">WELCOME 
            <span style="color: #7D0A0A;">ADMIN</span>
        </h1>
        <hr>
        <div class="vertical-menu">
            <a href="dashboard.php" class="h4 d-flex align-items-center <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                
                <img src="/assets/image 72.png" alt="Dashboard Icon">
                Dashboard
            </a>
            <a href="active-jobs.php" class="h4 d-flex align-items-center <?= $current_page == 'active-jobs.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/image 73.png" alt="Active Jobs Icon">
                Active Jobs
            </a>
            <a href="applications.php" class="h4 d-flex align-items-center <?= $current_page == 'applications.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 74.png" alt="Applications Icon">
                Applications
            </a>
            <a href="companies.php" class="h4 d-flex align-items-center <?= $current_page == 'companies.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 77.png" alt="Companies Icon">
                Companies
            </a>
            <a href="approved-hired.php" class="h4 d-flex align-items-center <?= $current_page == 'approved-hired.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 71.png" alt="Approved/Hired Icon">
                Approved/Hired
            </a>
            <a href="/src/logout.php" class="h4 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 76.png" alt="Logout Icon">
                Logout
            </a>
        </div>
    </div>
</div>

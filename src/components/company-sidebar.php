<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="container smaller bg-light mx-auto d-none d-lg-block" style="overflow: hidden;"> 
    <h1 class="text-center" style="margin-top: 30px; color:#0A2E7D">WELCOME 
        <span style="color: #CA2B2D;"><?php echo strtoupper($_SESSION['name']); ?></span>
    </h1>
    <hr>
    <div class="vertical-menu">        
        <a href="index.php" class="h5 d-flex align-items-center <?= $current_page == 'index.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/image 91.png" alt="Dashboard Icon">
            Dashboard
        </a>
        <a href="edit-company.php" class="h5 d-flex align-items-center <?= $current_page == 'edit-company.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/bell 1.png" alt="My Company Icon">
            My Company
        </a>

        <a href="create-job-post.php" class="h5 d-flex align-items-center <?= $current_page == 'create-job-post.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 82.png" alt="Create Job Post Icon">
            Create Job Post
        </a>
        <a href="my-job-post.php" class="h5 d-flex align-items-center <?= $current_page == 'my-job-post.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 92.png" alt="My Job Post Icon">
            My Job Post
        </a>
        <a href="job-applications.php" class="h5 d-flex align-items-center <?= $current_page == 'job-applications.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 58.png" alt="Job Applications Icon">
            Job Application
        </a>
        <a href="mailbox.php" class="h5 d-flex align-items-center <?= $current_page == 'mailbox.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                
            <img src="/assets/image 90.png" alt="Mailbox Icon">
            Mailbox
        </a>
        <a href="settings.php" class="h5 d-flex align-items-center <?= $current_page == 'settings.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 59.png" alt="Settings Icon">
            Settings
        </a>
        <a href="resume-database.php" class="h5 d-flex align-items-center <?= $current_page == 'resume-database.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 86.png" alt="Resume Database Icon">
            Resume Database
        </a>
        <a href="search-applicants.php" class="h5 d-flex align-items-center <?= $current_page == 'search-applicants.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/search 2.png" alt="Search Applicants Icon">
            Search for applicants
        </a>
        <a href="/src/logout.php" class="h5 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 76.png" alt="Logout Icon">
            Logout
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" 
tabindex="-1" id="company" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <div></div>                    
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h1 class="text-center" style="margin-top: 30px;">WELCOME 
            <span style="color: #7D0A0A;"><?php echo strtoupper($_SESSION['name']); ?></span>
        </h1>
        <hr>
        <div class="vertical-menu">            
            <a href="index.php" class="h5 d-flex align-items-center <?= $current_page == 'index.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/image 91.png" alt="Dashboard Icon">
                Dashboard
            </a>
            <a href="edit-company.php" class="h5 d-flex align-items-center <?= $current_page == 'edit-company.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/bell 1.png" alt="My Company Icon">
                My Company
            </a>

            <a href="create-job-post.php" class="h5 d-flex align-items-center <?= $current_page == 'create-job-post.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 82.png" alt="Create Job Post Icon">
                Create Job Post
            </a>
            <a href="my-job-post.php" class="h5 d-flex align-items-center <?= $current_page == 'my-job-post.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 92.png" alt="My Job Post Icon">
                My Job Post
            </a>
            <a href="job-applications.php" class="h5 d-flex align-items-center <?= $current_page == 'job-applications.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 58.png" alt="Job Applications Icon">
                Job Application
            </a>
            <a href="mailbox.php" class="h5 d-flex align-items-center <?= $current_page == 'mailbox.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">                
                <img src="/assets/image 90.png" alt="Mailbox Icon">
                Mailbox
            </a>
            <a href="settings.php" class="h5 d-flex align-items-center <?= $current_page == 'settings.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 59.png" alt="Settings Icon">
                Settings
            </a>
            <a href="resume-database.php" class="h5 d-flex align-items-center <?= $current_page == 'resume-database.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 86.png" alt="Resume Database Icon">
                Resume Database
            </a>
            <a href="search-applicants.php" class="h5 d-flex align-items-center <?= $current_page == 'search-applicants.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/search 2.png" alt="Search Applicants Icon">
                Search for applicants
            </a>
            <a href="/src/logout.php" class="h5 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 3rem;  position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 76.png" alt="Logout Icon">
                Logout
            </a>
        </div>
    </div>
</div>


<div class="container smaller bg-light mx-auto d-none d-lg-block" style="overflow: hidden;"> 
    <h1 class="text-center" style="margin-top: 30px;">WELCOME 
        <span style="color: #7D0A0A;"><?php echo strtoupper($_SESSION['name']); ?></span>
    </h1>
    <hr>
    <div class="vertical-menu">        
        <a href="index.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/image 91.png" alt="Active Jobs Icon">
            Dashboard
        </a>
        <a href="edit-company.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/bell 1.png" alt="Active Jobs Icon">
            My Company
        </a>

        <a href="create-job-post.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 82.png" alt="Applications Icon">
            Create Job Post
        </a>
        <a href="my-job-post.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 92.png" alt="Applications Icon">
            My Job Post
        </a>
        <a href="job-applications.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 58.png" alt="Companies Icon">
            Job Application
        </a>
        <a href="mailbox.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                
            <img src="/assets/image 90.png" alt="Dashboard Icon">
            Mailbox
        </a>
        <a href="settings.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 59.png" alt="Approved/Hired Icon">
            Settings
        </a>
        <a href="resume-database.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 86.png" alt="Approved/Hired Icon">
            Resume Database
        </a>
        <a href="search-applicants.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/search 2.png" alt="Approved/Hired Icon">
            Search for applicants
        </a>
        <a href="/src/logout.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
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
            <a href="index.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/image 91.png" alt="Active Jobs Icon">
                Dashboard
            </a>
            <a href="edit-company.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/bell 1.png" alt="Active Jobs Icon">
                My Company
            </a>

            <a href="create-job-post.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 82.png" alt="Applications Icon">
                Create Job Post
            </a>
            <a href="my-job-post.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 92.png" alt="Applications Icon">
                My Job Post
            </a>
            
            <a href="job-applications.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 58.png" alt="Companies Icon">
                Job Application
            </a>
            <a href="mailbox.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">                
                <img src="/assets/image 90.png" alt="Dashboard Icon">
                Mailbox
            </a>
            <a href="settings.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 59.png" alt="Approved/Hired Icon">
                Settings
            </a>
            <a href="resume-database.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 86.png" alt="Approved/Hired Icon">
                Resume Database
            </a>
            <a href="search-applicants.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/search 2.png" alt="Approved/Hired Icon">
                Search for applicants
            </a>
            <a href="/src/logout.php" class="h2 d-flex align-items-center" style="height: 5rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 76.png" alt="Logout Icon">
                Logout
            </a>
        </div>
    </div>
</div>
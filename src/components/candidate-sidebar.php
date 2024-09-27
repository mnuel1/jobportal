<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="container smaller bg-light mx-auto d-none d-lg-block" style="overflow: hidden;"> 

    <h2 class="text-center" style="margin-top: 30px; color:#FF9800">WELCOME 
        <span style="color: black;"><?php echo strtoupper($_SESSION['name']); ?></span>
    </h2>

    <hr>
    <div class="vertical-menu">        
        <a href="index.php" class="h4 d-flex align-items-center <?= $current_page == 'index.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/image 91.png" alt="Active Jobs Icon">
            My applications
        </a>
        <a href="notification.php" class="h4 d-flex align-items-center <?= $current_page == 'notification.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
            <img src="/assets/bell 1.png" alt="Notification Icon">
            Notification
        </a>

        <a href="jobs.php" class="h4 d-flex align-items-center <?= $current_page == 'jobs.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 92.png" alt="Jobs Icon">
            Jobs
        </a>
        <a href="mailbox.php" class="h4 d-flex align-items-center <?= $current_page == 'mailbox.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 58.png" alt="Mailbox Icon">
            Mailbox
        </a>
        <a href="edit-profile.php" class="h4 d-flex align-items-center <?= $current_page == 'edit-profile.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                
            <img src="/assets/image 90.png" alt="Edit Profile Icon">
            Edit Profile
        </a>
        <a href="settings.php" class="h4 d-flex align-items-center <?= $current_page == 'settings.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 59.png" alt="Settings Icon">
            Settings
        </a>
        <a href="/src/logout.php" class="h4 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
            <img src="/assets/image 76.png" alt="Logout Icon">
            Logout
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start" 
data-bs-scroll="true" tabindex="-1" 
id="candidate" 
aria-labelledby="offcanvasWithBothOptionsLabel">
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
            <a href="index.php" class="h4 d-flex align-items-center <?= $current_page == 'index.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/image 91.png" alt="Active Jobs Icon">
                My applications
            </a>
            <a href="notification.php" class="h4 d-flex align-items-center <?= $current_page == 'notification.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                   
                <img src="/assets/bell 1.png" alt="Notification Icon">
                Notification
            </a>

            <a href="jobs.php" class="h4 d-flex align-items-center <?= $current_page == 'jobs.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 92.png" alt="Jobs Icon">
                Jobs
            </a>
            <a href="mailbox.php" class="h4 d-flex align-items-center <?= $current_page == 'mailbox.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 58.png" alt="Mailbox Icon">
                Mailbox
            </a>
            <a href="edit-profile.php" class="h4 d-flex align-items-center <?= $current_page == 'edit-profile.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">                
                <img src="/assets/image 90.png" alt="Edit Profile Icon">
                Edit Profile
            </a>
            <a href="settings.php" class="h4 d-flex align-items-center <?= $current_page == 'settings.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 59.png" alt="Settings Icon">
                Settings
            </a>
            <a href="/src/logout.php" class="h4 d-flex align-items-center <?= $current_page == 'logout.php' ? 'active' : '' ?>" style="height: 4rem; position: relative; text-decoration: none; gap: 24px;">   
                <img src="/assets/image 76.png" alt="Logout Icon">
                Logout
            </a>
        </div>
    </div>
</div>

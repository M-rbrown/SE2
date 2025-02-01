<?php 
    $current_page = basename($_SERVER['PHP_SELF']); // Get the current file name
?>

<section id="sidebar">
    <div class="container">
        <a href="#" class="LOGO"> 
            <img src="images/LOGO.png" class="image">
        </a>
    </div>
    
    <ul class="side-menu top" style="padding-left: 0px;">
        <li class="<?= ($current_page == 'admin_dashboard.php') ? 'active' : '' ?>">
            <a href="admin_dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="<?= ($current_page == 'resident.php') ? 'active' : '' ?>">
            <a href="resident.php">
                <i class='bx bxs-group'></i>
                <span class="text">Residents List</span>
            </a>
        </li>
        <li class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <a href="index.php" id="calendar-btn">
                <i class='bx bxs-calendar'></i>
                <span class="text">Calendar</span>
            </a>
        </li>
        <li class="<?= ($current_page == 'sudden.php') ? 'active' : '' ?>">
            <a href="sudden.php">
                <i class='bx bxs-megaphone'></i>
                <span class="text">Announcements</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu" style="padding-left: 0px;">
        <li class="<?= ($current_page == 'archive.php') ? 'active' : '' ?>">
            <a href="archive.php">
                <i class='bx bxs-archive'></i>
                <span class="text">Archive</span>
            </a>
        </li>
        <li>
            <a href="login.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
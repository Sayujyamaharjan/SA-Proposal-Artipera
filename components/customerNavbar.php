<?php
function Navbar($active)
{
?>
    <style>
        .activeNav {
            background-color: #e5e7eb;
            border-left: 7px solid limegreen;
        }
    </style>
    <div class="option_bar">
        <div class="web_logo">
            <a href="landing.html" class="logo">
                <img src="../assets/logo/logo1.png" alt="" class="logo_img">
            </a>
        </div>
        <div class="customerprof">
            <div class="profile_logo"></div>
            <div class="profile_text">
                <p class="profile_name">
                    <?php echo $_SESSION['name'] ?? "sayujya" ?>
                </p>
                <p class="role"><?php echo $_SESSION['role'] ?? "sayujya" ?></p>
            </div>
        </div>
        <div class="hr-line"></div>
        <div class="profile_main">
            <div class="main_contents">
                <div class="main_tab <?php echo $active === 'dashboard' ? 'activeNav' : '' ?>">
                    <img src="../assets/svg/home.svg" alt="" class="tab_img">
                    <a href="customer.php" class="tab_text">Home</a>
                </div>
                <div class="main_tab <?php echo $active === 'search' ? 'activeNav' : '' ?>">
                    <img src="../assets/svg/search.svg" alt="" class="tab_img">
                    <a href="customerSearch.php" class="tab_text">Search</a>
                </div>
                <div class="main_tab <?php echo $active === 'bookings' ? 'activeNav' : '' ?>">
                    <img src="../assets/svg/calendar-week.svg" alt="" class="tab_img">
                    <a href="customerBooking.php" class="tab_text">My Bookings</a>
                </div>
                <div class="main_tab <?php echo $active === 'saved' ? 'activeNav' : '' ?>">
                    <img src="../assets/svg/heart.svg" alt="" class="tab_img">
                    <a href="customerSaved.php" class="tab_text">Saved Workers</a>
                </div>
            </div>
        </div>
        <div class="hr-line"></div>
        <div class="bottom_option">
            <img src="../assets/svg/logout.svg" alt="" class="tab_img">
            <a href="landing.html" class="tab_text">Log Out</a>
        </div>
    </div>


<?php
}


?>
<?php
include '../php/connect.php';

function Navbar($active)
{
?>
    <style>
        a {
            text-decoration: none;
            color: black;
        }

        .activeNav {
            background-color: #e5e7eb;
            border-left: 7px solid limegreen;
        }

        .profile_link {
            text-decoration: none;
            color: black;
        }

        .profile_logo {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: 500;
        }

        .option_bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            border-right: 2px solid #e5e7eb;
            background-color: white;
            display: flex;
            flex-direction: column;
        }

        .bottom_option {
            margin-top: auto;
            padding: 20px;
            display: flex;
            gap: 15px;
            opacity: 60%;
            transition: 0.2s ease-in-out;
        }

        .bottom_section {
            margin-top: auto;
        }

        .profile_main {
            flex: 1;
        }

        .main_contents {
            margin-top: 5px;
        }
    </style>
    <div class="option_bar">
        <div class="web_logo">
            <a href="landing.php" class="logo">
                <img src="../assets/logo/logo1.png" alt="" class="logo_img">
            </a>
        </div>

        <div class="userprof">
            <?php
            $name = explode(' ', $_SESSION['name']);
            $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
            ?>
            <div class="profile_logo">
                <?php echo $initials ?>
            </div>
            <a href="../pages/profile.php" class="link_profile">
                <div class="profile_text">
                    <p class="profile_name">
                        <?php echo $_SESSION['name'] ?? "sayujya" ?>
                    </p>
                    <p class="role"><?php echo $_SESSION['role'] ?? "sayujya" ?></p>
                </div>
            </a>
        </div>
        <div class="hr-line"></div>
        <div class="profile_main">
            <div class="main_contents">
                <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] == "customer") {
                ?>
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
                <?php
                }

                if (isset($_SESSION['role']) && $_SESSION['role'] == "worker") {
                ?>
                    <div class="main_tab <?php echo $active === 'workerDashboard' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/home.svg" alt="" class="tab_img">
                        <a href="worker.php" class="tab_text">Home</a>
                    </div>
                    <div class="main_tab <?php echo $active === 'workerBookings' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/calendar-week.svg" alt="" class="tab_img">
                        <a href="workerBooking.php" class="tab_text">My Bookings</a>
                    </div>
                    <div class="main_tab <?php echo $active === 'workerSchedule' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/service.svg" alt="" class="tab_img">
                        <a href="workerSchedule.php" class="tab_text">Services</a>
                    </div>
                <?php
                }
                if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                ?>
                    <div class="main_tab <?php echo $active === 'admin' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/calendar-week.svg" alt="" class="tab_img">
                        <a href="workerBooking.php" class="tab_text">All Bookings</a>
                    </div>
                    <div class="main_tab <?php echo $active === 'adminWorker' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/worker.svg" alt="" class="tab_img">
                        <a href="adminWorker.php" class="tab_text">Workers</a>
                    </div>

                    <div class="main_tab <?php echo $active === 'adminCustomer' ? 'activeNav' : '' ?>">
                        <img src="../assets/svg/usersmany.svg" alt="" class="tab_img">
                        <a href="adminCustomer.php" class="tab_text">Customer</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="bottom_section">
            <div class="hr-line"></div>

            <div class="bottom_option">
                <img src="../assets/svg/logout.svg" alt="" class="tab_img">
                <a href="logout.php" class="tab_text">Log Out</a>
            </div>
        </div>
    </div>


<?php
}


?>
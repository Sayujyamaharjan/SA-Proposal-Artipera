<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';
$conn = mysqli_connect("localhost", "root", "", "Artipera");

$users = fetchWorkers($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <?php Navbar("dashboard") ?>
    <div class="dashboard_right">
        <p class="greetings">Welcome back, <?php echo $_SESSION['name'] ?? "Sayujya"; ?></p>
        <div class="right_stats">
            <div class="stats_box">
                <img src="../assets/svg/calendar-week blue.svg" alt="" class="stats_logo">
                <p class="stats_number">10</p>
                <p class="stats_text">Total Bookings</p>
                <p class="stats_status">This Month</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/checkbox.svg" alt="" class="stats_logo">
                <p class="stats_number">05</p>
                <p class="stats_text">Completed Bookings</p>
                <p class="stats_status">Last Completed Date</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/clock.svg" alt="" class="stats_logo">
                <p class="stats_number">03</p>
                <p class="stats_text">Pending Bookings</p>
                <p class="stats_status">Next Appointment</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/heart red.svg" alt="" class="stats_logo">
                <p class="stats_number">02</p>
                <p class="stats_text">Saved Workers</p>
                <a href="customerSaved.php" class="stats_status">View all</a>
            </div>
        </div>
        <div class=" right_recomended">
            <div class="recomended_head">
                <p class="right_heading">Recommended Workers</p>
                <a href="customerSearch.php" class="right_btn">View all</a>
            </div>
            <div class="recomended_workers">

                <?php foreach ($users as $user) {  ?>

                    <div class="workerin_customer">
                        <div class="workerprof">
                            <div class="worker_profile_logo">
                                <img
                                    src="../assets/profile/<?php echo $user['profile_image']; ?>" alt="">
                            </div>
                            <div class="worker_profile_text">
                                <a href="customerView.php?user_id=<?php echo $user['user_id'] ?>" class="worker_profile_name">
                                    <?php echo $user['name']; ?>
                                </a>
                                <p class="job">
                                    <?php echo $user['category_name']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="worker_services">
                            <?php foreach ($user['services'] as $service) { ?>
                                <div class="service">
                                    <?php echo $service['name']; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <div class="hr_line_right"></div>
                        <br>
                        <div class="booking_bottom">
                            <span class="price">
                                NPR <?php echo $user['services'][0]['price'] ?? '0'; ?>/hr
                            </span>
                            <span class="rating">
                                <img src="../assets/logo/star.png" alt="" class="rate">
                                <?php echo $user['rating'] ?? '5.0'; ?>
                            </span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="right_two_container">
            <div class=" right_container_upcomming">
                <div class="recomended_head">
                    <p class="right_heading">Upcoming Bookings</p>
                    <a href="customerBooking.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        foreach ($users as $user) {

                        ?>
                            <div class="workerin_customer upcoming">
                                <div class="workerprof">
                                    <div class="worker_profile_logo"></div>
                                    <div class="worker_profile_text">
                                        <p class="worker_profile_name">
                                            <?php echo $user['name'] ?>
                                        </p>
                                        <p class="job"><?php echo $user['category_name'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <br>
                        <?php

                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class=" right_container_upcomming" style="width: 100%;">
                <div class="recomended_head">
                    <p class="right_heading">Saved Workers</p>
                    <a href="customerSearch.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        foreach ($users as $user) {
                        ?>
                            <div class="workern_customer upcoming">
                                <div class="workerprof">
                                    <div class="worker_profile_logo"></div>
                                    <div class="worker_profile_text">
                                        <p class="worker_profile_name">
                                            <?php echo $user['name'] ?>
                                        </p>
                                        <p class="job"><?php echo $user['category_name'] ?></p>
                                    </div>
                                </div>
                                <?php
                                $img = '<img src="../assets/logo/star.png" alt="" class="rate">';
                                ?>
                                <br>
                                <div class="booking_bottom">
                                    <span class="rating"><?php echo $img, $user['rating'] ?? "0" ?></span>
                                </div>
                            </div>
                            <br>
                        <?php
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
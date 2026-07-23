<?php
include '../components/navbar.php';

$name = "Sayujya Maharjan";
$job = "Electrician";
$role = "Customer";
$address = "Kathmandu:";
$users = [
    [
        'id' => 1,
        'name' => 'John Smith',
        'role' => 'admin',
        'email' => 'john.admin@company.com'
    ],
    [
        'id' => 2,
        'name' => 'Sarah Johnson',
        'role' => 'worker',
        'job' => 'electrician',
        'email' => 'sarah.electric@company.com',
        'services' => ['wiring', 'solar installation', 'lighting', 'panel upgrade'],
        'price' => 750,
        'rating' => 4.5
    ],
    [
        'id' => 3,
        'name' => 'Michael Brown',
        'role' => 'customer',
        'email' => 'michael.brown@email.com',
        'memberSince' => '2023'
    ],
    [
        'id' => 4,
        'name' => 'Emily Davis',
        'role' => 'worker',
        'job' => 'plumber',
        'email' => 'emily.plumb@company.com',
        'services' => ['pipe repair', 'drain cleaning', 'water heater', 'bathroom installation'],
        'price' => 900,
        'rating' => 4.8
    ],
    [
        'id' => 5,
        'name' => 'Robert Taylor',
        'role' => 'worker',
        'job' => 'carpenter',
        'email' => 'robert.carp@company.com',
        'services' => ['furniture making', 'cabinet installation', 'flooring', 'wood repair'],
        'price' => 1000,
        'rating' => 4.7
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/customer.css">
</head>

<body>
    <?php Navbar("dashboard", $name, $role) ?>
    <div class="dashboard_right">
        <p class="greetings">Welcome back, <?php echo $name ?></p>
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
                <a href="saved.php" class="stats_status">View all</a>
            </div>
        </div>
        <div class=" right_recomended">
            <div class="recomended_head">
                <p class="right_heading">Recommended Workers</p>
                <a href="search.php" class="right_btn">View all</a>
            </div>
            <div class="recomended_workers">
                <?php
                foreach ($users as $user) {
                    if ($user['role'] == "worker") {
                ?>
                        <div class="workerin_customer">
                            <div class="workerprof">
                                <div class="worker_profile_logo"></div>
                                <div class="worker_profile_text">
                                    <p class="worker_profile_name">
                                        <?php echo $user['name'] ?>
                                    </p>
                                    <p class="job"><?php echo $user['job'] ?></p>
                                </div>
                            </div>
                            <div class="worker_services">
                                <?php
                                foreach ($user["services"] as $service) {
                                ?>
                                    <div class="service">
                                        <?php echo $service ?>
                                    </div>
                                <?php
                                }
                                $img = '<img src="../assets/logo/star.png" alt="" class="rate">';
                                ?>
                            </div>
                            <br>
                            <div class="hr_line_right"></div><br>
                            <div class="booking_bottom">
                                <span class="price">NPR <?php echo $user['price'] ?>/hr</span>
                                <span class="rating"><?php echo $img, $user['rating'] ?></span>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="right_two_container">
            <div class=" right_container_upcomming">
                <div class="recomended_head">
                    <p class="right_heading">Upcoming Bookings</p>
                    <a href="search.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        foreach ($users as $user) {
                            if ($user['role'] == "worker") {
                        ?>
                                <div class="workerin_customer upcoming">
                                    <div class="workerprof">
                                        <div class="worker_profile_logo"></div>
                                        <div class="worker_profile_text">
                                            <p class="worker_profile_name">
                                                <?php echo $user['name'] ?>
                                            </p>
                                            <p class="job"><?php echo $user['job'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <br>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class=" right_container_upcomming" style="width: 100%;">
                <div class="recomended_head">
                    <p class="right_heading">Saved Workers</p>
                    <a href="search.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        foreach ($users as $user) {
                            if ($user['role'] == "worker") {
                        ?>
                                <div class="workern_customer upcoming">
                                    <div class="workerprof">
                                        <div class="worker_profile_logo"></div>
                                        <div class="worker_profile_text">
                                            <p class="worker_profile_name">
                                                <?php echo $user['name'] ?>
                                            </p>
                                            <p class="job"><?php echo $user['job'] ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    $img = '<img src="../assets/logo/star.png" alt="" class="rate">';
                                    ?>
                                    <br>
                                    <div class="booking_bottom">
                                        <span class="rating"><?php echo $img, $user['rating'] ?></span>
                                    </div>
                                </div>
                                <br>

                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
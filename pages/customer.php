<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';
$conn = mysqli_connect("localhost", "root", "", "Artipera");

$users = fetchWorkers($conn, 5);
$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            b.Booking_id,
            b.address,
            b.pricing,
            b.Booking_date,
            b.Booking_detail,
            b.status,
            b.Worker_id,
            b.user_id,
            u.name AS worker_name,
            u.profile_image AS worker_profile
        FROM booking b
        INNER JOIN users u ON b.Worker_id = u.user_id
        WHERE b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}
$sql = "
SELECT
COUNT(*) AS total_bookings,

SUM(CASE
    WHEN status='completed'
    THEN 1 ELSE 0
END) AS completed_bookings,

SUM(CASE
    WHEN status='pending'
    THEN 1 ELSE 0
END) AS pending_bookings,

MAX(CASE
    WHEN status='completed'
    THEN Booking_date
END) AS last_completed_date,

MIN(CASE
    WHEN status='approved'
    AND Booking_date >= CURDATE()
    THEN Booking_date
END) AS next_appointment,

(
    SELECT COUNT(*)
    FROM saved_workers
    WHERE user_id = $user_id
) AS total_saved

FROM booking
WHERE user_id = $user_id
";
$result = mysqli_query($conn, $sql);
$stats = mysqli_fetch_assoc($result);
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
                <p class="stats_number"><?php echo $stats['total_bookings']; ?></p>
                <p class="stats_text">Total Bookings</p>
                <p class="stats_status">This Month</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/checkbox.svg" alt="" class="stats_logo">
                <p class="stats_number"><?php echo $stats['completed_bookings']; ?></p>
                <p class="stats_text">Completed Bookings</p>
                <p class="stats_status">
                    <?php
                    echo $stats['last_completed_date']
                        ? date('M d', strtotime($stats['last_completed_date']))
                        : 'No completed bookings';
                    ?>
                </p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/clock.svg" alt="" class="stats_logo">
                <p class="stats_number"><?php echo $stats['pending_bookings']; ?></p>
                <p class="stats_text">Pending Bookings</p>
                <p class="stats_status">
                    <?php
                    echo $stats['next_appointment']
                        ? date('M d', strtotime($stats['next_appointment']))
                        : 'No upcoming booking';
                    ?>
                </p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/heart red.svg" alt="" class="stats_logo">
                <p class="stats_number">
                    <?php echo $stats['total_saved']; ?>
                </p>
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
                                <div class="worker_profile_logo">
                                    <?php
                                    $name = explode(' ', $user['name']);
                                    $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                    ?>
                                    <div class="avatar navy">
                                        <?php echo $initials; ?>
                                    </div>
                                </div>
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
                                NPR <?php echo $user['base_rate'] ?? '100'; ?>/hr
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
                    <p class="right_heading">My Bookings</p>
                    <a href="customerBooking.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            $book = $bookings[$i];
                            $bookStatus = ($book['status'] === "pending" ? "warn" : ($book['status'] === "approved" ? "approve" : ($book['status'] === "completed" ? "success" : "danger")))
                        ?>
                            <div class="workerin_customer upcoming">
                                <div class="workerprof">
                                    <div class="worker_profile_logo">
                                        <?php
                                        $name = explode(' ', $book['worker_name']);
                                        $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                        ?>
                                        <div class="avatar navy">
                                            <?php echo $initials; ?>
                                        </div>
                                    </div>
                                    <div class="worker_profile_text">
                                        <p class="worker_profile_name">
                                            <?php echo $book['Booking_detail'] ?>
                                        </p>
                                        <p class="job"><?php echo $book['worker_name'] ?></p>
                                    </div>
                                </div>
                                <div class="my_status">
                                    <div class="<?php echo $bookStatus ?>"><?php echo $book['status'] ?></div>
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
                                    <div class="worker_profile_logo">
                                        <?php
                                        $name = explode(' ', $user['name']);
                                        $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                        ?>
                                        <div class="avatar navy">
                                            <?php echo $initials; ?>
                                        </div>
                                    </div>
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
                                    <span class="rating">
                                        <img src="../assets/logo/star.png" alt="" class="rate">
                                        <?php echo $user['rating']  ?>
                                    </span>
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
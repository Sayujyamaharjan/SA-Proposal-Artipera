<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include "../components/fetchWorkers.php";

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
    <?php Navbar("saved",) ?>
    <div class="dashboard_right">
        <p class="greetings">Saved Workers</p>
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
                                <p class="job"><?php echo $user['category_name'] ?></p>
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
                        <div class="booking_bottom">
                            <a href="">
                                <button class="remove_saved">
                                    Remove
                                </button>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }

            ?>
        </div>
    </div>
</body>

</html>
<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include "../components/fetchWorkers.php";

$users = fetchSavedWorkers($conn, $_SESSION['user_id']);

if (isset($_POST['remove_saved'])) {

    $user_id = $_SESSION['user_id'];
    $worker_id = $_POST['worker_id'];

    $sql = "DELETE FROM saved_workers
            WHERE user_id = '$user_id'
            AND worker_id = '$worker_id'";

    mysqli_query($conn, $sql);

    header("Location: customerSaved.php");
    exit();
}
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
                                <a href="customerView.php?user_id=<?php echo $user['user_id'] ?>" class="worker_profile_name">
                                    <?php echo $user['name']; ?>
                                </a>
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
                                NPR <?php echo $user['base_rate'] ?? '100'; ?>/hr
                            </span>
                            <span class="rating">
                                <img src="../assets/logo/star.png" alt="" class="rate">
                                <?php echo $user['rating']; ?>
                            </span>
                        </div>
                        <div class="booking_bottom">
                            <form method="POST">
                                <input type="hidden" name="worker_id" value="<?php echo $user['Worker_id']; ?>">
                                <button type="submit" name="remove_saved" class="remove_saved">
                                    Remove
                                </button>
                            </form>
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
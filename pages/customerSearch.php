<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';

$users = fetchWorkers($conn, 50);
$selectedCategory = $_GET['category'] ?? '';
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
    <?php Navbar("search") ?>
    <div class="dashboard_right">
        <p class="greetings">Browse Workers</p>
        <form action="" method="get">
            <div class="search_feature_container">
                <div class="search_contents">
                    <p class="search_text">
                        Search by Name
                    </p>
                    <input type="search" name="search" id="search" class="search_input input_text" placeholder="Search by name">
                </div>
                <div class="search_contents">
                    <p class="search_text">
                        Skill Category
                    </p>
                    <select name="category" id="category" class="search_input input_text">
                        <option value="" selected disabled class="category">Categories</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Carpenter">Carpenter</option>
                        <option value="Painter">Painter</option>
                        <option value="Mechanic">Mechanic</option>
                    </select>
                </div>
                <div class="search_contents">
                    <p class="search_text">Location</p>
                    <select name="select" id="select" class="search_input input_text">
                        <option value="" selected disabled hidden>Select Location</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Pokhara">Pokhara</option>
                        <option value="Chitwan">Chitwan</option>
                        <option value="Butwal">Butwal</option>
                        <option value="Dharan">Dharan</option>
                        <option value="Biratnagar">Biratnagar</option>
                        <option value="Janakpur">Janakpur</option>
                        <option value="Hetauda">Hetauda</option>
                        <option value="Nepalgunj">Nepalgunj</option>
                        <option value="Itahari">Itahari</option>
                        <option value="Dhangadhi">Dhangadhi</option>
                        <option value="Tulsipur">Tulsipur</option>
                        <option value="Banepa">Banepa</option>
                        <option value="Dhulikhel">Dhulikhel</option>
                        <option value="Bharatpur">Bharatpur</option>
                        <option value="Gorkha">Gorkha</option>
                        <option value="Ilam">Ilam</option>
                        <option value="Surkhet">Surkhet</option>
                    </select>
                </div>
                <div class="search_contents">
                    <p class="search_text">Sort By</p>
                    <select name="select" id="select" class="search_input input_text">
                        <option value="" selected disabled>Sort</option>
                        <option value="Rating">Rating(High-Low)</option>
                        <option value="Rating">Rating(Low-High)</option>
                        <option value="Price">Price</option>
                    </select>
                </div>
                <div class="search_contents">
                    <button type="submit" class="search_button"><img src="../assets/svg/search.svg" alt="" class="search_button_image">
                        <span class="button_txt">Find</span></button>
                </div>
            </div>
        </form>

        <div class="search_workers">
            <?php foreach ($users as $user) {
                if ($user['role'] != "worker") {
                    continue;
                }
                if (!empty($selectedCategory) && $user['category_name'] != $selectedCategory) {
                    continue;
                }
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
                    <div class="hr_line_right"></div><br>
                    <div class="booking_bottom">
                        <span class="price">
                            NPR <?php echo $user['base_rate'] ?? '100'; ?>/hr
                        </span>
                        <span class="rating">
                            <img src="../assets/logo/star.png" alt="" class="rate">
                            <?php echo $user['rating']; ?>
                        </span>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
</body>

</html>
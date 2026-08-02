<?php include "../components/Navbar.php";
include "../php/authGuard.php";
$users = [
    [
        'name' => 'Sarah Johnson',
        'email' => 'sarah@gmail.com',
        'password' => '123456',
        'address' => 'Kathmandu',
        'role' => 'worker',
        'phone' => '9800000001',
        'profile_image' => 'sarah.jpg',
        'category_id' => 1,
        'bio' => 'Experienced Electrician specializing in residential wiring.',
        'year_of_experience' => 5,
        'id_front_photo' => 'sarah_front.jpg',
        'id_back_photo' => 'sarah_back.jpg',
        'past_work_photo' => 'sarah_work.jpg',
        'degree' => 'Diploma in Electrical Engineering'
    ],
    [
        'name' => 'Emily Davis',
        'email' => 'emily@gmail.com',
        'password' => '123456',
        'address' => 'Lalitpur',
        'role' => 'worker',
        'phone' => '9800000002',
        'profile_image' => 'emily.jpg',
        'category_id' => 2,
        'bio' => 'Professional plumber with expertise in pipe installation.',
        'year_of_experience' => 4,
        'id_front_photo' => 'emily_front.jpg',
        'id_back_photo' => 'emily_back.jpg',
        'past_work_photo' => 'emily_work.jpg',
        'degree' => 'Plumbing Technician Certificate'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/worker.css">
</head>

<body>
    <?php Navbar("workerBookings") ?>
    <div class="dashboard_right">
        <p class="greetings">My Bookings</p>
        <div class="customer_bookings">
            <?php
            foreach ($users as $user) {
                if ($user['role'] == "worker") {
            ?>
                    <div class="workerin_customer">
                        <div class="workerprof">
                            <div class="worker_profile_logo"></div>
                            <div class="bookings_contents">
                                <div class="worker_profile_text">
                                    <p class="worker_profile_name">
                                        <?php echo $user['category_name'] ?? "electrician" ?>
                                    </p>
                                    <p class="job"><?php echo $user['name'] ?></p>
                                </div>
                                <div class="My_status">Completed</div>
                            </div>
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
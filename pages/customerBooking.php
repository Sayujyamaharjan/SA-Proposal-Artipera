<?php include '../components/customerNavbar.php';
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
    ],
    [
        'name' => 'David Anderson',
        'email' => 'david@gmail.com',
        'password' => '123456',
        'address' => 'Kathmandu',
        'role' => 'worker',
        'phone' => '9800000011',
        'profile_image' => 'david.jpg'
    ],
    [
        'name' => 'Jessica White',
        'email' => 'jessica@gmail.com',
        'password' => '123456',
        'address' => 'Lalitpur',
        'role' => 'worker',
        'phone' => '9800000012',
        'profile_image' => 'jessica.jpg'
    ],
    [
        'name' => 'Kevin Harris',
        'email' => 'kevin@gmail.com',
        'password' => '123456',
        'address' => 'Bhaktapur',
        'role' => 'worker',
        'phone' => '9800000013',
        'profile_image' => 'kevin.jpg'
    ],
    [
        'name' => 'Linda Thompson',
        'email' => 'linda@gmail.com',
        'password' => '123456',
        'address' => 'Pokhara',
        'role' => 'worker',
        'phone' => '9800000014',
        'profile_image' => 'linda.jpg'
    ],
    [
        'name' => 'Christopher Walker',
        'email' => 'chris@gmail.com',
        'password' => '123456',
        'address' => 'Chitwan',
        'role' => 'worker',
        'phone' => '9800000015',
        'profile_image' => 'chris.jpg'
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
    <?php Navbar("bookings", "sayujya", "customer") ?>
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
                                        <?php echo $user['job'] ?>
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
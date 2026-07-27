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
        'id' => 6,
        'name' => 'Robert Taylor',
        'role' => 'worker',
        'job' => 'carpenter',
        'email' => 'robert.carp@company.com',
        'services' => ['furniture making', 'cabinet installation', 'flooring', 'wood repair'],
        'price' => 1000,
        'rating' => 4.7
    ],
    [
        'id' => 7,
        'name' => 'Robert Taylor',
        'role' => 'worker',
        'job' => 'carpenter',
        'email' => 'robert.carp@company.com',
        'services' => ['furniture making', 'cabinet installation', 'flooring', 'wood repair'],
        'price' => 1000,
        'rating' => 4.7
    ],
    [
        'id' => 8,
        'name' => 'Robert Taylor',
        'role' => 'worker',
        'job' => 'carpenter',
        'email' => 'robert.carp@company.com',
        'services' => ['furniture making', 'cabinet installation', 'flooring', 'wood repair'],
        'price' => 1000,
        'rating' => 4.7
    ],
    [
        'id' => 9,
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
    <?php Navbar("saved", "sayujya", "customer") ?>
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

                            ?>
                        </div>
                        <br>
                        <div class="booking_bottom">
                            <button class="remove_saved">Remove</button>
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
<?php

createDB();

include 'connect.php';
if (!$conn) {
    die("connection error ..." . mysqli_connect_error());
} else {
    TableUser($conn);
    createCategory($conn);
    createWorker($conn);
    createUsers($conn);
    createBooking($conn);
    createReview($conn);
    // }
}
function createDB()
{
    $conn = mysqli_connect("localhost", "root", "");
    $sql = "CREATE DATABASE IF NOT EXISTS Artipera";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo "<br> Database Created Successfully!!! ";
    }
}

function TableUser($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS users 
            (
            user_id int PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) not null,
            email varchar(255) not null unique,
            password varchar(255) not null,
            address varchar(255) not null,
            role varchar(255) not null,
            phone bigint unique not null,
            profile_image varchar(255) not null,
            created_at TIMESTAMP default current_timestamp
            );";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo "<br> User Table Created Successfully!!! ";
    }
}

// function createAdmin($conn)
// {
//     $users = [
//         [
//             'name' => 'Admin',
//             'email' => 'admin@gmail.com',
//             'password' => '@Admin123',
//             'address' => 'Kathmandu',
//             'role' => 'admin',
//             'phone' => '9841286400',
//             'profile_image' => 'assets/profiles/admin.png'
//         ],
//         [
//             'name' => 'Sarah Johnson',
//             'email' => 'sarah@gmail.com',
//             'password' => '123456',
//             'address' => 'Kathmandu',
//             'role' => 'worker',
//             'phone' => '9800000001',
//             'profile_image' => 'sarah.jpg'
//         ],
//         [
//             'name' => 'Emily Davis',
//             'email' => 'emily@gmail.com',
//             'password' => '123456',
//             'address' => 'Lalitpur',
//             'role' => 'worker',
//             'phone' => '9800000002',
//             'profile_image' => 'emily.jpg'
//         ],
//         [
//             'name' => 'Robert Taylor',
//             'email' => 'robert@gmail.com',
//             'password' => '123456',
//             'address' => 'Bhaktapur',
//             'role' => 'worker',
//             'phone' => '9800000003',
//             'profile_image' => 'robert.jpg'
//         ],
//         [
//             'name' => 'James Wilson',
//             'email' => 'james@gmail.com',
//             'password' => '123456',
//             'address' => 'Kathmandu',
//             'role' => 'worker',
//             'phone' => '9800000004',
//             'profile_image' => 'james.jpg'
//         ],
//         [
//             'name' => 'Sophia Miller',
//             'email' => 'sophia@gmail.com',
//             'password' => '123456',
//             'address' => 'Pokhara',
//             'role' => 'worker',
//             'phone' => '9800000005',
//             'profile_image' => 'sophia.jpg'
//         ],
//         [
//             'name' => 'Michael Brown',
//             'email' => 'michael@gmail.com',
//             'password' => '123456',
//             'address' => 'Kathmandu',
//             'role' => 'customer',
//             'phone' => '9800000006',
//             'profile_image' => 'michael.jpg'
//         ],
//         [
//             'name' => 'Olivia Martin',
//             'email' => 'olivia@gmail.com',
//             'password' => '123456',
//             'address' => 'Lalitpur',
//             'role' => 'customer',
//             'phone' => '9800000007',
//             'profile_image' => 'olivia.jpg'
//         ],
//         [
//             'name' => 'William Moore',
//             'email' => 'william@gmail.com',
//             'password' => '123456',
//             'address' => 'Bhaktapur',
//             'role' => 'customer',
//             'phone' => '9800000008',
//             'profile_image' => 'william.jpg'
//         ],
//         [
//             'name' => 'Emma Clark',
//             'email' => 'emma@gmail.com',
//             'password' => '123456',
//             'address' => 'Pokhara',
//             'role' => 'customer',
//             'phone' => '9800000009',
//             'profile_image' => 'emma.jpg'
//         ],
//         [
//             'name' => 'David Anderson',
//             'email' => 'david@gmail.com',
//             'password' => '123456',
//             'address' => 'Kathmandu',
//             'role' => 'worker',
//             'phone' => '9800000011',
//             'profile_image' => 'david.jpg'
//         ],
//         [
//             'name' => 'Jessica White',
//             'email' => 'jessica@gmail.com',
//             'password' => '123456',
//             'address' => 'Lalitpur',
//             'role' => 'worker',
//             'phone' => '9800000012',
//             'profile_image' => 'jessica.jpg'
//         ],
//         [
//             'name' => 'Kevin Harris',
//             'email' => 'kevin@gmail.com',
//             'password' => '123456',
//             'address' => 'Bhaktapur',
//             'role' => 'worker',
//             'phone' => '9800000013',
//             'profile_image' => 'kevin.jpg'
//         ],
//         [
//             'name' => 'Linda Thompson',
//             'email' => 'linda@gmail.com',
//             'password' => '123456',
//             'address' => 'Pokhara',
//             'role' => 'worker',
//             'phone' => '9800000014',
//             'profile_image' => 'linda.jpg'
//         ],
//         [
//             'name' => 'Christopher Walker',
//             'email' => 'chris@gmail.com',
//             'password' => '123456',
//             'address' => 'Chitwan',
//             'role' => 'worker',
//             'phone' => '9800000015',
//             'profile_image' => 'chris.jpg'
//         ]
//     ];

//     foreach ($users as $user) {

//         $pwh = password_hash($user['password'], PASSWORD_DEFAULT);

//         $sql = "INSERT IGNORE INTO users
//         (name,email,password,address,role,phone,profile_image)
//         VALUES
//         (
//             '{$user['name']}',
//             '{$user['email']}',
//             '$pwh',
//             '{$user['address']}',
//             '{$user['role']}',
//             '{$user['phone']}',
//             '{$user['profile_image']}'
//         )";

//         $res = mysqli_query($conn, $sql);

//         if ($res) {
//             echo "<br>{$user['name']} Created Successfully!";
//         }
//     }
// }
function createUsers($conn)
{
    $users = [
        // ADMIN
        [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '@Admin123',
            'address' => 'Kathmandu',
            'role' => 'admin',
            'phone' => '9841286400',
            'profile_image' => 'assets/profiles/admin.png'
        ],

        // CUSTOMERS
        [
            'name' => 'Michael Brown',
            'email' => 'michael@gmail.com',
            'password' => '123456',
            'address' => 'Kathmandu',
            'role' => 'customer',
            'phone' => '9800000101',
            'profile_image' => 'michael.jpg'
        ],
        [
            'name' => 'Olivia Martin',
            'email' => 'olivia@gmail.com',
            'password' => '123456',
            'address' => 'Lalitpur',
            'role' => 'customer',
            'phone' => '9800000102',
            'profile_image' => 'olivia.jpg'
        ],

        // WORKERS
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
        [
            'name' => 'Robert Taylor',
            'email' => 'robert@gmail.com',
            'password' => '123456',
            'address' => 'Bhaktapur',
            'role' => 'worker',
            'phone' => '9800000003',
            'profile_image' => 'robert.jpg',
            'category_id' => 3,
            'bio' => 'Professional house painter.',
            'year_of_experience' => 6,
            'id_front_photo' => 'robert_front.jpg',
            'id_back_photo' => 'robert_back.jpg',
            'past_work_photo' => 'robert_work.jpg',
            'degree' => 'Painting Certification'
        ],
        [
            'name' => 'James Wilson',
            'email' => 'james@gmail.com',
            'password' => '123456',
            'address' => 'Kathmandu',
            'role' => 'worker',
            'phone' => '9800000004',
            'profile_image' => 'james.jpg',
            'category_id' => 4,
            'bio' => 'Motorcycle and car mechanic.',
            'year_of_experience' => 7,
            'id_front_photo' => 'james_front.jpg',
            'id_back_photo' => 'james_back.jpg',
            'past_work_photo' => 'james_work.jpg',
            'degree' => 'Mechanical Technician Diploma'
        ],
        [
            'name' => 'Sophia Miller',
            'email' => 'sophia@gmail.com',
            'password' => '123456',
            'address' => 'Pokhara',
            'role' => 'worker',
            'phone' => '9800000005',
            'profile_image' => 'sophia.jpg',
            'category_id' => 5,
            'bio' => 'Custom furniture carpenter.',
            'year_of_experience' => 3,
            'id_front_photo' => 'sophia_front.jpg',
            'id_back_photo' => 'sophia_back.jpg',
            'past_work_photo' => 'sophia_work.jpg',
            'degree' => 'Carpentry Trade Certificate'
        ],
        [
            'name' => 'David Anderson',
            'email' => 'david@gmail.com',
            'password' => '123456',
            'address' => 'Kathmandu',
            'role' => 'worker',
            'phone' => '9800000011',
            'profile_image' => 'david.jpg',
            'category_id' => 1,
            'bio' => 'Industrial and residential electrician.',
            'year_of_experience' => 8,
            'id_front_photo' => 'david_front.jpg',
            'id_back_photo' => 'david_back.jpg',
            'past_work_photo' => 'david_work.jpg',
            'degree' => 'Electrical Engineering Diploma'
        ],
        [
            'name' => 'Jessica White',
            'email' => 'jessica@gmail.com',
            'password' => '123456',
            'address' => 'Lalitpur',
            'role' => 'worker',
            'phone' => '9800000012',
            'profile_image' => 'jessica.jpg',
            'category_id' => 2,
            'bio' => 'Home and commercial plumbing expert.',
            'year_of_experience' => 5,
            'id_front_photo' => 'jessica_front.jpg',
            'id_back_photo' => 'jessica_back.jpg',
            'past_work_photo' => 'jessica_work.jpg',
            'degree' => 'Advanced Plumbing Certification'
        ],
        [
            'name' => 'Kevin Harris',
            'email' => 'kevin@gmail.com',
            'password' => '123456',
            'address' => 'Bhaktapur',
            'role' => 'worker',
            'phone' => '9800000013',
            'profile_image' => 'kevin.jpg',
            'category_id' => 3,
            'bio' => 'Interior and exterior painting specialist.',
            'year_of_experience' => 6,
            'id_front_photo' => 'kevin_front.jpg',
            'id_back_photo' => 'kevin_back.jpg',
            'past_work_photo' => 'kevin_work.jpg',
            'degree' => 'Professional Painter Certificate'
        ],
        [
            'name' => 'Linda Thompson',
            'email' => 'linda@gmail.com',
            'password' => '123456',
            'address' => 'Pokhara',
            'role' => 'worker',
            'phone' => '9800000014',
            'profile_image' => 'linda.jpg',
            'category_id' => 4,
            'bio' => 'Vehicle repair and maintenance expert.',
            'year_of_experience' => 9,
            'id_front_photo' => 'linda_front.jpg',
            'id_back_photo' => 'linda_back.jpg',
            'past_work_photo' => 'linda_work.jpg',
            'degree' => 'Automobile Mechanics Diploma'
        ],
        [
            'name' => 'Christopher Walker',
            'email' => 'chris@gmail.com',
            'password' => '123456',
            'address' => 'Chitwan',
            'role' => 'worker',
            'phone' => '9800000015',
            'profile_image' => 'chris.jpg',
            'category_id' => 5,
            'bio' => 'Woodwork and furniture specialist.',
            'year_of_experience' => 10,
            'id_front_photo' => 'chris_front.jpg',
            'id_back_photo' => 'chris_back.jpg',
            'past_work_photo' => 'chris_work.jpg',
            'degree' => 'Advanced Carpentry Certificate'
        ],
        [
            'name' => 'Daniel Scott',
            'email' => 'daniel@gmail.com',
            'password' => '123456',
            'address' => 'Kathmandu',
            'role' => 'worker',
            'phone' => '9800000016',
            'profile_image' => 'daniel.jpg',
            'category_id' => 1,
            'bio' => 'Licensed electrician for homes and offices.',
            'year_of_experience' => 4,
            'id_front_photo' => 'daniel_front.jpg',
            'id_back_photo' => 'daniel_back.jpg',
            'past_work_photo' => 'daniel_work.jpg',
            'degree' => 'Electrical Technician Certificate'
        ]
    ];

    foreach ($users as $user) {
        $pwh = password_hash($user['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users
                (name,email,password,address,role,phone,profile_image)
                VALUES
                (
                    '{$user['name']}',
                    '{$user['email']}',
                    '$pwh',
                    '{$user['address']}',
                    '{$user['role']}',
                    '{$user['phone']}',
                    '{$user['profile_image']}'
                )";

        if (mysqli_query($conn, $sql)) {
            $user_id = mysqli_insert_id($conn);

            // If worker, insert into worker table too
            if ($user['role'] == 'worker') {
                $sql2 = "INSERT INTO worker
                        (
                            category_id,
                            user_id,
                            bio,
                            year_of_experience,
                            id_front_photo,
                            id_back_photo,
                            past_work_photo,
                            degree
                        )
                        VALUES
                        (
                            {$user['category_id']},
                            $user_id,
                            '{$user['bio']}',
                            {$user['year_of_experience']},
                            '{$user['id_front_photo']}',
                            '{$user['id_back_photo']}',
                            '{$user['past_work_photo']}',
                            '{$user['degree']}'
                        )";

                mysqli_query($conn, $sql2);
            }

            echo "<br>{$user['name']} Created Successfully!";
        }
    }
}

function createWorker($conn)
{
    $sql = "CREATE TABLE  if not exists  worker(

        Worker_id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        user_id INT NOT NULL,
        bio VARCHAR(100) NOT NULL,
        year_of_experience INT NOT NULL,

        id_front_photo VARCHAR(255) NOT NULL,
        id_back_photo VARCHAR(255) NOT NULL,
        id_status VARCHAR(255) DEFAULT 'pending', 
        past_work_photo VARCHAR(255) NOT NULL,
        work_status VARCHAR(255) DEFAULT 'pending', 
        degree VARCHAR(255) NOT NULL,
        degree_status VARCHAR(255) DEFAULT 'pending',
        FOREIGN KEY (user_id) REFERENCES users(user_id),
        FOREIGN KEY (category_id) REFERENCES category(category_id)
    )";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<br>Worker Documents Table Created Successfully!!!";
    } else {
        echo "<br>Error Creating Worker Documents Table: " . mysqli_error($conn);
    }
}

function createCategory($conn)
{
    $sql = "CREATE TABLE if not exists category (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(50) NOT NULL UNIQUE
    )";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<br>Category Table Created Successfully!!!";
    } else {
        echo "<br>Error: " . mysqli_error($conn);
    }
}

function createBooking($conn)
{
    $sql = "CREATE TABLE if not exists Booking (
            Booking_id INT AUTO_INCREMENT PRIMARY KEY,
            address VARCHAR(100) NOT NULL,
            pricing INT NOT NULL,
            Booking_date DATE NOT NULL,
            Booking_detail VARCHAR(255) NOT NULL,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            Worker_id INT NOT NULL,
            user_id INT NOT NULL,
            FOREIGN KEY (Worker_id) REFERENCES worker(Worker_id),
            FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<br>Booking Table Created Successfully!!!";
    } else {
        echo "<br>Error: " . mysqli_error($conn);
    }
}
function createReview($conn)
{
    $sql = "CREATE TABLE if not exists Review (
            Review_id INT PRIMARY KEY AUTO_INCREMENT,
            Rating INT NOT NULL,
            Comment VARCHAR(255) NOT NULL,
            Booking_id INT NOT NULL,
            FOREIGN KEY (Booking_id) REFERENCES Booking(Booking_id)
    )";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<br>Review Table Created Successfully!!!";
    } else {
        echo "<br>Error: " . mysqli_error($conn);
    }
}

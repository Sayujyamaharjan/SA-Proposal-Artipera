<?php
include '../php/connect.php';
function fetchWorkers($conn, $limit = 6)
{
    $limit = (int)$limit;
    $sql = "SELECT u.*, w.*, c.*
            FROM users u
            JOIN worker w ON w.user_id = u.user_id
            JOIN category c ON c.category_id = w.category_id
            WHERE u.role = 'worker'
            AND EXISTS (
                SELECT 1
                FROM worker_service ws
                WHERE ws.worker_id = w.worker_id
            )
            LIMIT $limit";

    $result = mysqli_query($conn, $sql);
    $workers = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $workerId = $row['Worker_id'];

        $serviceSql = "
            SELECT service_name
            FROM worker_service
            WHERE worker_id = $workerId
        ";

        $serviceResult = mysqli_query($conn, $serviceSql);

        $row['services'] = [];

        while ($service = mysqli_fetch_assoc($serviceResult)) {

            $row['services'][] = [
                'name'  => $service['service_name'],
            ];
        }
        $ratingSql = "
        SELECT ROUND(AVG(rating),1) AS rating
        FROM review
        WHERE Worker_id = $workerId
    ";

        $ratingResult = mysqli_query($conn, $ratingSql);
        $rating = mysqli_fetch_assoc($ratingResult);

        $row['rating'] = $rating['rating'] ?? "3.0";
        $workers[] = $row;
    }

    return $workers;
}

function fetchBookings($conn)
{
    $sql = "SELECT b.*, customer.name AS customer_name, worker_user.name AS worker_name
            FROM booking b
            JOIN users customer ON b.user_id = customer.user_id
            JOIN worker w ON b.Worker_id = w.Worker_id
            JOIN users worker_user ON w.user_id = worker_user.user_id";

    $result = mysqli_query($conn, $sql);

    $bookings = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }

    return $bookings;
}

function fetchSavedWorkers($conn, $user_id)
{
    $sql = "SELECT u.*, w.*, c.*
            FROM saved_workers s
            JOIN worker w ON s.worker_id = w.Worker_id
            JOIN users u ON w.user_id = u.user_id
            JOIN category c ON w.category_id = c.category_id
            WHERE s.user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    $workers = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $worker_id = $row['Worker_id'];

        $service_sql = "SELECT service_name
                        FROM worker_service
                        WHERE worker_id = '$worker_id'";

        $service_result = mysqli_query($conn, $service_sql);

        $row['services'] = [];

        while ($service = mysqli_fetch_assoc($service_result)) {
            $row['services'][] = [
                'name' => $service['service_name'],
            ];
        }
        $ratingSql = "
    SELECT ROUND(AVG(rating),1) AS rating
    FROM review
    WHERE Worker_id = $worker_id
";

        $ratingResult = mysqli_query($conn, $ratingSql);
        $rating = mysqli_fetch_assoc($ratingResult);

        $row['rating'] = $rating['rating'] ?? "3.0";
        $workers[] = $row;
    }

    return $workers;
}

function fetchCustomer($conn)
{

    $sql = "SELECT * FROM users WHERE role = 'customer'";

    $result = mysqli_query($conn, $sql);

    $customers = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
    }

    return $customers;
}

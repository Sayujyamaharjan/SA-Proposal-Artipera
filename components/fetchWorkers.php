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
            SELECT service_name, service_price
            FROM worker_service
            WHERE worker_id = $workerId
        ";

        $serviceResult = mysqli_query($conn, $serviceSql);

        $row['services'] = [];

        while ($service = mysqli_fetch_assoc($serviceResult)) {

            $row['services'][] = [
                'name'  => $service['service_name'],
                'price' => $service['service_price']
            ];
        }

        $workers[] = $row;
    }

    return $workers;
}

<?php
$conn = mysqli_connect("localhost", "root", "", "Artipera");
function fetchWorkers($conn)
{
    $sql = "SELECT users.*, worker.*, category.* FROM users
            JOIN worker ON worker.user_id = users.user_id
            JOIN category ON category.category_id = worker.category_id
            WHERE users.role = 'worker' LIMIT 6;";

    $data = [];
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, $row);
        }
    }
    return $data;
}

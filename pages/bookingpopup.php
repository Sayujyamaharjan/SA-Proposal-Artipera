<?php
session_start();
include '../components/fetchWorkers.php';

include "../php/connect.php";
$user = fetchWorkers($conn);
$userIdUrl =  $_GET['user_id'] ?? NULL;

$worker = null;
if ($user) {
    foreach ($user as $item) {
        if ((int)$item['user_id'] === (int)$userIdUrl) {
            $worker = $item;
            break;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


<body>

</body>

</html>
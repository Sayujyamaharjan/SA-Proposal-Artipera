<?php
include '../components/Navbar.php';
include '../php/authGuard.php';
include '../components/fetchWorkers.php';

$customer = fetchCustomer($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <?php Navbar("admincustomer") ?>
    <div class="dashboard_right">
        <div class="workers_table">
            <table>
                <thead>
                    <tr>
                        <th class="book">CUSTOMER</th>
                        <th>EMAIL</th>
                        <th>LOCATION</th>
                        <th>JOINED</th>
                        <th>BOOKINGS</th>
                        <th class="book_left">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($customer as $customers) { ?>
                        <tr>
                            <td>
                                <div class="worker_profile">

                                    <?php
                                    $name = explode(' ', $customers['name']);
                                    $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                    ?>
                                    <div class="avatar navy">
                                        <?php echo $initials ?>
                                    </div>
                                    <div>
                                        <?php echo $customers['name'] ?>
                                    </div>
                                </div>
                            </td>
                            <td> <?php echo $customers['email'] ?> </td>
                            <td><?php echo $customers['address'] ?></td>
                            <td><?php echo date('M Y', strtotime($customers['created_at'])) ?></td>
                            <td>3</td>
                            <td>
                                <button class="btn_view">View</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
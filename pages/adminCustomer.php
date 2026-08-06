<?php
include '../components/Navbar.php';
include '../php/authGuard.php'; ?>
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
                        <th>CUSTOMER</th>
                        <th>LOCATION</th>
                        <th>JOINED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="worker_profile">
                                <div class="avatar navy">RB</div>
                                <div>
                                    <h4>Ram Bahadur KC</h4>

                                </div>
                            </div>
                        </td>

                        <td>Kathmandu</td>
                        <td><?php echo date('M Y'); ?></td>
                        <td>
                            <button class="btn_view">View</button> &nbsp; &nbsp;
                            <button class="btn_suspend">Suspend</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="worker_profile">
                                <div class="avatar violet">SS</div>
                                <div>
                                    <h4>Sita Sharma</h4>
                                </div>
                            </div>
                        </td>

                        <td>Lalitpur</td>

                        <td><?php echo date('M Y'); ?></td>

                        <td>
                            <button class="btn_view">View</button> &nbsp; &nbsp;
                            <button class="btn_suspend">Suspend</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="worker_profile">
                                <div class="avatar green">HT</div>
                                <div>
                                    <h4>Hari Thapa</h4>
                                </div>
                            </div>
                        </td>

                        <td>Bhaktapur</td>

                        <td><?php echo date('M Y'); ?></td>

                        <td>
                            <button class="btn_view">View</button> &nbsp; &nbsp;
                            <button class="btn_suspend">Suspend</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
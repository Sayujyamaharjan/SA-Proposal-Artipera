<?php
include '../components/Navbar.php';
include '../php/authGuard.php';
include '../components/fetchWorkers.php';

$user = fetchWorkers($conn);
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
    <?php Navbar("adminworker") ?>
    <div class="dashboard_right">
        <div class="workers_section">

            <div class="verification_box">
                <h2>⏳ 2 Workers Awaiting Verification</h2>

                <div class="verification_card">
                    <div class="worker_left">
                        <div class="avatar dark">SA</div>

                        <div>
                            <h3>Suresh Adhikari</h3>
                            <p class="worker_info">
                                Welder · Bhaktapur · Applied 2025-06-08
                            </p>

                            <div class="documents">
                                <span class="submit">Submitted:</span>
                                <span class="doc_tag">Citizenship Card</span>
                                <span class="doc_tag">Trade Certificate</span>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn_docs">📄 View Docs</button>
                        <button class="btn_verify">✓ Verify</button>
                        <button class="btn_reject">✗ Reject</button>
                    </div>
                </div>

                <div class="verification_card">
                    <div class="worker_left">
                        <div class="avatar purple">ML</div>

                        <div>
                            <h3>Mina Lama</h3>
                            <p class="worker_info">
                                Interior Designer · Kathmandu · Applied 2025-06-07
                            </p>

                            <div class="documents">
                                <span class="sumbit">Submitted:</span>
                                <span class="doc_tag">Citizenship Card</span>
                                <span class="doc_tag">Diploma Certificate</span>
                                <span class="doc_tag">Portfolio</span>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn_docs">📄 View Docs</button>
                        <button class="btn_verify">✓ Verify</button>
                        <button class="btn_reject">✗ Reject</button>
                    </div>
                </div>
            </div>

            <div class="workers_table">
                <h2>All Workers (8)</h2>

                <table>
                    <thead>
                        <tr>
                            <th>WORKER</th>
                            <th>SKILL</th>
                            <th>LOCATION</th>
                            <th>RATING</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $worker) { ?>
                            <tr>
                                <td>
                                    <div class="worker_profile">
                                        <?php
                                        $name = explode(' ', $worker['name']);
                                        $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                        ?>
                                        <div class="avatar navy">
                                            <?php echo $initials; ?>
                                        </div>
                                        <div>
                                            <h4><?php echo $worker['name']; ?></h4>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $worker['address']; ?></td>
                                <td>
                                    <?php echo date('M Y', strtotime($worker['created_at'])); ?>
                                </td>
                                <td>⭐ 4.9</td>
                                <td><span class="verified">Verified</span></td>
                                <td>
                                    <button class="btn_view">View</button>&nbsp;&nbsp;
                                    <button class="btn_suspend">Suspend</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <!-- <tbody>
                        <tr>
                            <td>
                                <div class="worker_profile">
                                    <div class="avatar navy">RB</div>
                                    <div>
                                        <h4>Ram Bahadur KC</h4>
                                        <p>8 years exp</p>
                                    </div>
                                </div>
                            </td>
                            <td>Plumber</td>
                            <td>Kathmandu</td>
                            <td>⭐ 4.9 (124)</td>
                            <td>312</td>
                            <td><span class="verified">Verified</span></td>
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
                                        <p>6 years exp</p>
                                    </div>
                                </div>
                            </td>
                            <td>Electrician</td>
                            <td>Lalitpur</td>
                            <td>⭐ 4.8 (98)</td>
                            <td>245</td>
                            <td><span class="verified">Verified</span></td>
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
                                        <p>12 years exp</p>
                                    </div>
                                </div>
                            </td>
                            <td>Carpenter</td>
                            <td>Bhaktapur</td>
                            <td>⭐ 4.6 (87)</td>
                            <td>198</td>
                            <td><span class="verified">Verified</span></td>
                            <td>
                                <button class="btn_view">View</button> &nbsp; &nbsp;
                                <button class="btn_suspend">Suspend</button>
                            </td>
                        </tr>

                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
</body>

</html>
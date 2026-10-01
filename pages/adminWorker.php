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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
</head>

<body>
    <?php Navbar("adminWorker") ?>
    <div class="dashboard_right">
        <div class="workers_table">
            <h2>Workers</h2>

            <table id="workersTable" class="display">
                <thead>
                    <tr>
                        <th class="book">WORKER</th>
                        <th>SKILL</th>
                        <th>LOCATION</th>
                        <th>RATING</th>
                        <th>STATUS</th>
                        <th class="book_left">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user as $worker) { ?>
                        <?php
                        $name = trim($worker['name']);
                        $nameParts = explode(' ', $name);
                        $initials = strtoupper(
                            substr($nameParts[0], 0, 1) .
                            (
                                count($nameParts) > 1
                                ? substr($nameParts[count($nameParts) - 1], 0, 1)
                                : ''
                            )
                        );
                        ?>
                        <tr>
                            <td data-order="<?php echo htmlspecialchars($name); ?>">
                                <div class="worker_profile">
                                    <div class="avatar navy">
                                        <?php echo $initials; ?>
                                    </div>
                                    <div>
                                        <span>
                                            <?php echo htmlspecialchars($name); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td data-order="<?php echo htmlspecialchars($worker['category_name']); ?>">
                                <?php echo htmlspecialchars($worker['category_name']); ?>
                            </td>
                            <td data-order="<?php echo htmlspecialchars($worker['address']); ?>">
                                <?php echo htmlspecialchars($worker['address']); ?>
                            </td>
                            <td data-order="<?php echo $worker['rating']; ?>">
                                <span class="rating">
                                    <img src="../assets/logo/star.png" alt="" class="rate">
                                    <?php echo $worker['rating']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="status_badge <?php echo strtolower($worker['validation_status']); ?>">
                                    <?php echo $worker['validation_status']; ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn_view"
                                    onclick="document.getElementById('documentDialog<?php echo $worker['user_id']; ?>').showModal();">
                                    View
                                </button>
                            </td>
                        </tr>
                        <dialog class="document_dialog" id="documentDialog<?php echo $worker['user_id']; ?>">
                            <div class="document_popup">
                                <h2>Worker Documents</h2>
                                <p class="document_worker_name">
                                    <?php echo htmlspecialchars($name); ?>
                                </p>
                                <?php
                                $worker_id = $worker['user_id'];
                                $documentSql = "SELECT id_front_photo, id_back_photo, past_work_photo FROM worker WHERE user_id = '$worker_id'";
                                $documentResult = mysqli_query($conn, $documentSql);
                                $documents = mysqli_fetch_assoc($documentResult);
                                ?>
                                <?php if ($documents) { ?>
                                    <div class="document_item">
                                        <span>ID Front</span>
                                        <?php if (!empty($documents['id_front_photo'])) { ?>
                                            <a href="../<?php echo htmlspecialchars($documents['id_front_photo']); ?>"
                                                target="_blank" class="btn_view">
                                                View
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="document_item">
                                        <span>ID Back</span>
                                        <?php if (!empty($documents['id_back_photo'])) { ?>
                                            <a href="../<?php echo htmlspecialchars($documents['id_back_photo']); ?>"
                                                target="_blank" class="btn_view">
                                                View
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="document_item">
                                        <span>Past Work</span>
                                        <?php if (!empty($documents['past_work_photo'])) { ?>
                                            <a href="../<?php echo htmlspecialchars($documents['past_work_photo']); ?>"
                                                target="_blank" class="btn_view">
                                                View
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div class="document_buttons">
                                    <button type="button" class="document_accept">
                                        Accept
                                    </button>
                                    <button type="button" class="document_reject">
                                        Reject
                                    </button>
                                </div>
                                <button type="button" class="document_close"
                                    onclick="document.getElementById('documentDialog<?php echo $worker['user_id']; ?>').close();">
                                    ×
                                </button>
                            </div>
                        </dialog>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#workersTable').DataTable({
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [
                    {
                        targets: 5,
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
</body>

</html>
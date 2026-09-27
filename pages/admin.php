<?php
include '../components/Navbar.php';
include '../php/authGuard.php';
$bookings = [];

$sql = "SELECT 
            b.Booking_id,
            b.Booking_detail,
            b.Booking_date,
            b.pricing,
            b.status,
            customer.name AS customer_name,
            worker_user.name AS worker_name
        FROM booking b
        INNER JOIN users customer 
            ON b.user_id = customer.user_id
        INNER JOIN worker w 
            ON b.Worker_id = w.Worker_id
        INNER JOIN users worker_user 
            ON w.user_id = worker_user.user_id
        ORDER BY b.Booking_id DESC";

$result = mysqli_query($conn, $sql);

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.css" rel="stylesheet">
</head>

<body>
    <?php Navbar("admin") ?>
    <div class="dashboard_right">
        <div class="booking_container">
            <div class="booking_header">
                <h2>Bookings</h2>
                <p> Manage and view all customer bookings </p>
            </div>
            <table id="bookingTable" class="display">
                <thead>
                    <tr>
                        <th class="book">BOOKING ID</th>
                        <th>SERVICE</th>
                        <th>CUSTOMER</th>
                        <th>WORKER</th>
                        <th>DATE & TIME</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th class="book_left">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) { ?>
                        <tr>
                            <td>
                                <?php echo $booking['Booking_id']; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($booking['Booking_detail']); ?>
                            </td>
                            <td>
                                <div class="user_info">
                                    <div class="user_avatar">
                                        <?php
                                        $customerName = trim($booking['customer_name']);
                                        $customerParts = explode(' ', $customerName);
                                        echo strtoupper(
                                            substr($customerParts[0], 0, 1) .
                                            (
                                                count($customerParts) > 1
                                                ? substr($customerParts[count($customerParts) - 1], 0, 1)
                                                : ''
                                            )
                                        );
                                        ?>
                                    </div>
                                    <span class="user_name">
                                        <?php echo htmlspecialchars($customerName); ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="user_info">
                                    <div class="user_avatar">
                                        <?php
                                        $workerName = trim($booking['worker_name']);
                                        $workerParts = explode(' ', $workerName);
                                        echo strtoupper(
                                            substr($workerParts[0], 0, 1) .
                                            (count($workerParts) > 1
                                                ? substr($workerParts[count($workerParts) - 1], 0, 1)
                                                : ''
                                            )
                                        );
                                        ?>
                                    </div>
                                    <span class="user_name">
                                        <?php echo htmlspecialchars($workerName); ?>
                                    </span>
                                </div>
                            </td>
                            <td class="booking_date">
                                <?php
                                echo date('M d, Y', strtotime($booking['Booking_date']));
                                ?>
                                <br>
                                <span class="time">
                                    <?php
                                    echo date('h:i A', strtotime($booking['Booking_date']));
                                    ?>
                                </span>
                            </td>
                            <td class="amount">
                                NPR <?php echo number_format($booking['pricing']); ?>
                            </td>
                            <td>
                                <span class="status_badge <?php echo strtolower($booking['status']); ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="bookingDetail.php?id=<?php echo $booking['Booking_id']; ?>">
                                    <button type="button" class="view_btn">
                                        View
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#bookingTable').DataTable({
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                columnDefs: [{ targets: [7], orderable: false, searchable: false }]
            });
        }); 
    </script>
</body>

</html>
<?php

include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';

$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['submit_review'])) {

    $booking_id = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comment = trim($_POST['comment']);

    $sql = "SELECT Worker_id
            FROM booking
            WHERE Booking_id = ?
            AND user_id = ?
            AND status = 'completed'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $booking = $result->fetch_assoc();
        $worker_id = $booking['Worker_id'];

        $sql = "SELECT Review_id
                FROM review
                WHERE Booking_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $message = "You have already reviewed this booking.";

        } else {

            $sql = "INSERT INTO review
                    (Rating, Comment, Booking_id, Worker_id)
                    VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "isii",
                $rating,
                $comment,
                $booking_id,
                $worker_id
            );

            if ($stmt->execute()) {
                $message = "Review submitted successfully.";
            }
        }

    }
}
$sql = "SELECT  b.Booking_id,  b.address, b.pricing,
            b.Booking_date, b.Booking_detail,b.status,
            b.Worker_id, b.user_id,
            u.name AS worker_name,
            u.profile_image AS worker_profile,
            r.Review_id
        FROM booking b
        INNER JOIN worker w 
            ON b.Worker_id = w.Worker_id
        INNER JOIN users u 
            ON w.user_id = u.user_id
        LEFT JOIN review r
            ON b.Booking_id = r.Booking_id
        WHERE b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php Navbar("bookings") ?>
    <div class="dashboard_right">
        <p class="greetings">My Bookings</p>
        <div class="customer_bookings">
            <?php
            foreach ($bookings as $book) {
                $bookStatus = ($book['status'] === "pending" ? "warn" : ($book['status'] === "approved" ? "approve" : ($book['status'] === "completed" ? "success" : "danger")))
                    ?>

                <div class="workerin_customer">
                    <div class="workerprof">
                        <div class="worker_profile_logo">
                            <?php
                            $name = explode(' ', $book['worker_name']);
                            $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                            ?>
                            <div class="avatar navy">
                                <?php echo $initials; ?>
                            </div>
                        </div>
                        <div class="bookings_contents">
                            <div class="worker_profile_text">
                                <p class="job"><?php echo $book['worker_name'] ?></p>
                                <p class="worker_profile_name">
                                    <?php echo $book['Booking_detail'] ?>
                                </p>
                            </div>
                            <div class="booking_date">
                                <div>
                                    <span>Date</span>
                                    <strong>
                                        <?php echo date('M d', strtotime($book['Booking_date'])); ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="<?php echo $bookStatus ?>"><?php echo $book['status'] ?></div>
                            <div class="my_status">

                                <div class="my_status_buttons">
                                    <button class="button_reponse"
                                        popovertarget="booking_<?php echo $book['Booking_id']; ?>"
                                        popovertargetaction="show">
                                        View Details
                                    </button>

                                    <?php if ($book['status'] === "completed" && empty($book['Review_id'])) { ?>
                                        <button class="leave" popovertarget="popupbox_review" popovertargetaction="show"
                                            onclick="setReviewBooking(<?php echo $book['Booking_id']; ?>)">
                                            Leave Review
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <dialog class="popup-container" popover id="booking_<?php echo $book['Booking_id']; ?>">
                    <div class="popup">
                        <h2>Booking Details</h2>
                        <p>
                            <strong>Worker:</strong>
                            <?php echo $book['worker_name']; ?>
                        </p>
                        <p>
                            <strong>Location:</strong>
                            <?php echo $book['address']; ?>
                        </p>
                        <div class="time">
                            <p>
                                <strong>Date:</strong>
                                <?php echo date('d M Y', strtotime($book['Booking_date'])); ?>
                            </p>
                            <p>
                                <strong>Time:</strong>
                                <?php echo date('g:i A', strtotime($book['Booking_date'])); ?>
                            </p>
                        </div>
                        <p>
                            <strong>Description:</strong><br>
                            <?php echo $book['Booking_detail']; ?>
                        </p>
                    </div>
                </dialog>
                <?php

            }
            ?>
        </div>
    </div>

    <dialog class="popup-container-review" popover id="popupbox_review">
        <div class="review_box">
            <h1>Leave a Review</h1>
            <p class="subtitle">
                How was your experience?
            </p>
            <?php if (!empty($message)) { ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <form method="POST">
                <input type="hidden" name="booking_id" id="review_booking_id">
                <div class="star-rating">
                    <input type="radio" name="rating" id="star5" value="5" required>
                    <label for="star5">★</label>
                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4">★</label>
                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3">★</label>
                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2">★</label>
                    <input type="radio" name="rating" id="star1" value="1">
                    <label for="star1">★</label>
                </div>
                <label class="review_label">
                    Your Review
                </label>
                <textarea name="comment" placeholder="Share your experience with this worker..." required></textarea>
                <div class="btns_review">
                    <button type="submit" name="submit_review" class="submit_btn">
                        Submit Review
                    </button>
                    <a href="customerBooking.php" class="cancel_btn">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </dialog>
    <script>
        function setReviewBooking(bookingId) {
            document.getElementById("review_booking_id").value = bookingId;
        }
    </script>
    <?php if ($message != "") { ?>
        <script>
            Swal.fire({
                text: <?php echo json_encode($message); ?>,
                icon: <?php echo json_encode(
                    $message == "Review submitted successfully." ? "success" : "error"
                ); ?>,
                confirmButtonText: "OK"
            });
        </script>
    <?php } ?>
</body>

</html>
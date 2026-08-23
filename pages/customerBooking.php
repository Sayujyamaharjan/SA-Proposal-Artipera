<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            b.Booking_id,
            b.address,
            b.pricing,
            b.Booking_date,
            b.Booking_detail,
            b.status,
            b.Worker_id,
            b.user_id,
            u.name AS worker_name,
            u.profile_image AS worker_profile
        FROM booking b
        INNER JOIN worker w 
            ON b.Worker_id = w.Worker_id
        INNER JOIN users u 
            ON w.user_id = u.user_id
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
                                <p class="worker_profile_name">
                                    <?php echo $book['Booking_detail'] ?>
                                </p>
                                <p class="job"><?php echo $book['worker_name'] ?></p>
                            </div>
                            <div class="my_status">
                                <div class="<?php echo $bookStatus ?>"><?php echo $book['status'] ?></div>
                                <?php if ($book['status'] === "completed") { ?>
                                    <button class="leave" popovertarget="popupbox_review" popovertargetaction="show">Leave
                                        Review</button>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
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

                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">

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
                    <button type="submit" class="submit_btn">
                        Submit Review
                    </button>

                    <a href="customerBooking.php" class="cancel_btn">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </dialog>

</body>

</html>
<?php include '../components/navbar.php';
$name = "Sayujya Maharjan";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/customer.css">
</head>

<body>
    <?php Navbar("search", "sayujya", "customer") ?>
    <div class="dashboard_right">
        <p class="greetings">Browse Workers</p>
        <div class="search_feature_container">
            <div class="search_contents">
                <p class="search_text">
                    Search by Name
                </p>
                <input type="search" name="search" id="search" class="search_input input_text" placeholder="Search by name">
            </div>
            <div class="search_contents">
                <p class="search_text">
                    Search by Category
                </p>
                <select name="select" id="select" class="search_input input_text">
                    <option value="Electrician">Electrician</option>
                    <option value="Plumber">Plumber</option>
                    <option value="Carpenter">Carpenter</option>
                    <option value="Painter">Painter</option>
                    <option value="Mechanic">Mechanic</option>
                </select>
            </div>
            <div class="search_contents"></div>
            <div class="search_contents"></div>
            <div class="search_contents"></div>
        </div>
    </div>
</body>

</html>
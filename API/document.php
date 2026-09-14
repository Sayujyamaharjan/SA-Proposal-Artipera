<?php
header("Content-Type: application/json");
include '../php/connect.php';
include '../php/random.php';



$action = $_POST['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    switch ($action) {
        case "add_document":
            addDocument($_POST, $_FILES, $conn);
            break;

        default:
            echo json_encode([
                "status" => 400,
                "message" => "Invalid action."
            ]);
            break;
    }
}
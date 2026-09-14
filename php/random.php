<?php
session_start();
require_once __DIR__ . '/caller.php';
function addDocument($post, $files, $conn)
{
    $imagePaths = [];

    mysqli_begin_transaction($conn);

    try {
        $data = [
            'user_id' => $_SESSION['user_id'] ?? '',
        ];
        $fieldNames = [
            "id_front_photo",
            "id_back_photo",
            "past_work_photo"
        ];

        $documentPaths = uploadImages("worker_documents", $data['user_id'], $_SESSION['name'], $fieldNames);
        updateImages(
            $conn,
            "worker",
            [
                "id_front_photo",
                "id_back_photo",
                "past_work_photo"
            ],
            $data['user_id'],
            $documentPaths
        );
        mysqli_commit($conn);
        respondJson(201, "Documents added successfully.", [
            "documents" => $documentPaths
        ]);

    } catch (Exception $e) {
        mysqli_rollback($conn); // undoes insertLocation / updateLocationImages
        deleteUploadedFiles($imagePaths); // removes any files that already hit disk

        respondJson(500, $e->getMessage());
    }
}
?>
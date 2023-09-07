<?php

// like_comment.php

//include connection script and utility functions
require_once '../admin/includes/db_connect.php';
include_once('../includes/functions.php');

//database connection established and stored in $db variable
$db = dbConnect('master', 'pdo');

//initialize variables
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the comment ID and user ID from the JSON request body
    $data = json_decode(file_get_contents('php://input'), true);
    $commentId = $data['comment_id'];
    $userId = 1; // Assuming you have a way to get the user ID, replace 1 with the actual user ID

    // Validate the comment ID and user ID (you can use additional validation as per your requirements)
    $commentId = (int) $commentId;
    $userId = (int) $userId;

    // Check if the comment ID and user ID are valid
    if ($commentId > 0 && $userId > 0) {
        // Check if the user has already liked the comment to prevent duplicates
        $stmt = $db->prepare("SELECT * FROM likes WHERE comment_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $commentId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            // Insert the like into the database using prepared statements to prevent SQL injection
            $stmt = $db->prepare("INSERT INTO likes (comment_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $commentId, $userId);
            $stmt->execute();
            $stmt->close();

            // Return a JSON response with success status
            $response = array('status' => 'success');
            echo json_encode($response);
        } else {
            // Return an error message if the user has already liked the comment
            $response = array('status' => 'error', 'message' => 'You have already liked this comment.');
            echo json_encode($response);
        }
    } else {
        // Return an error message if the comment ID or user ID is invalid
        $response = array('status' => 'error', 'message' => 'Invalid comment ID or user ID.');
        echo json_encode($response);
    }
} else {
    // Return an error message if the request method is not POST
    $response = array('status' => 'error', 'message' => 'Invalid request method.');
    echo json_encode($response);
}

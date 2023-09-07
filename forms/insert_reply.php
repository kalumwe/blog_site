<?php
// insert_reply.php

//include connection script and utility functions
require_once '../admin/includes/db_connect.php';
include_once('../includes/functions.php');

//database connection established and stored in $db variable
$db = dbConnect('master', 'pdo');

//initialize variables
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the reply content and parent comment ID from the POST request
    $content = $_POST['reply-message'];
    //$name = $_POST['reply-name'];
    //$email = $_POST['reply-email'];
    $parentCommentId = $_POST['parent_comment_id'];
    $userId = (int) $_POST['user-id'];
    $postId = (int) $_POST['post-id'];

    
    // Sanitize and validate user input 
    if (validateMessage($content)) {
        $validContent = $content;
     } else {    
        $errors = 'field empty or invalid input.';
    }

    /*
    if (isset($name)) {
        $validName = safe($name);
     } else {
         $validName = NULL;
     }
 
     if (!empty($email)) {
         $validEmail = validateEmail($email);
     } else {
         $validEmail = NULL;
     }
     */

    $parentCommentId = (int) $parentCommentId;

    $testNme = 'kav';
    $testEmail ='kav@mail.com';

    // Check if the content is not empty after trimming and sanitizing
    if (!empty($content) && empty($errors)) {
        $created_at = date('Y-m-d H:i:s');

        // Insert the reply into the database using prepared statements to prevent SQL injection
        $sql = "INSERT INTO comments (parent_id, name, email, content, created_at) 
        VALUES (:parId, :nme, :email, :contnt, :created)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":parId", $parentCommentId, PDO::PARAM_INT);
        $stmt->bindParam(":pstId", $postId, PDO::PARAM_INT); 
        $stmt->bindParam(":uid", $userId, PDO::PARAM_INT); 
        $stmt->bindParam(":nme", $testNme, PDO::PARAM_STR);
        $stmt->bindParam(':email', $testEmail, PDO::PARAM_STR);
        $stmt->bindParam(':contnt', $validContent, PDO::PARAM_STR);
        $stmt->bindParam(':created', $created_at, PDO::PARAM_STR);
        $stmt->execute();

        $success = "sent";

        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit(); 

        /*
        // Return a JSON response with the newly created reply's details (ID, content, etc.)
        $replyId = $db->insert_id;
        //$commentId = $db->lastInsertId();
        $response = array(
            'status' => 'success',
            'reply_id' => $replyId,
            'name' => $validName,
            'email' => $validEmail,
            'content' => $validContent,
            'created_at' => $created_at
        );
        echo json_encode($response);*/
    } else {
        // Return an error message if the content is empty
        $errors = "Comment content cannot be empty.";
       // $response = array('status' => 'error', 'message' => 'Reply content cannot be empty.');
       // echo json_encode($response);
    }
    exit();
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request method.";
    exit();

   // $response = array('status' => 'error', 'message' => 'Invalid request method.');
   // echo json_encode($response);
}

?>

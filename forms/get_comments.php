<?php
// get_comments.php

//include connection script and utility functions
require_once '../admin/includes/db_connect.php';
include_once('../includes/functions.php');

//database connection established and stored in $db variable
$db = dbConnect('master', 'pdo');


// Query to get top-level comments and their replies
$sql = "SELECT * FROM comments WHERE parent_id IS NULL ORDER BY created_at DESC";
$result = $db->query($sql);

// Fetch the comments and their replies
$comments = array();
while ($row = $result->fetch_assoc()) {
    $commentId = $row['id'];
    $comment = array(
        'id' => $commentId,
        'content' => $row['content'],
        'created_at' => $row['created_at'],
        'replies' => array()
    );

    // Fetch the replies for this comment
    $sql = "SELECT * FROM comments WHERE parent_id = $commentId ORDER BY created_at DESC";
    $replyResult = $db->query($sql);
    while ($replyRow = $replyResult->fetch_assoc()) {
        $comment['replies'][] = array(
            'id' => $replyRow['id'],
            'content' => $replyRow['content'],
            'created_at' => $replyRow['created_at']
        );
    }

    $comments[] = $comment;
}

// Return the comments and their replies as a JSON response
echo json_encode($comments);

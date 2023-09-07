<?php
/**  insert_comment.php **/

//include connection script and utility functions
require_once '../admin/includes/db_connect.php';
include_once('../includes/functions.php');

//database connection established and stored in $db variable
$db = dbConnect('master', 'pdo');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the name, email and comment content from the POST request
    $content = $_POST['comment-message'];
    if (isset($_POST['comment-name'])) {
       $name = $_POST['comment-name'];
       $email = $_POST['comment-email'];

       if (isset($name)) {
          $validName = safe($name);
       } else {
         $errors = 'field empty or invalid input.';
       }
       if (!empty($email)) {
          $validEmail = validateEmail($email);
       } else {
         $errors = 'field empty or invalid input.';
       }
   }

   if (isset($_POST['user-id'])) { 
      $userId = (int) $_POST['user-id'];
    }
    $postId = (int) $_POST['post-id'];

    // Sanitize and validate user input 
    if (validateMessage($content)) {
        $validContent = $content;
     } else {    
        $errors = 'field empty or invalid input.';
    }

    
   
    // Check if the content is not empty after trimming and sanitizing
    if (!empty($content) && empty($errors)) {

        $created_at = date('Y-m-d H:i:s');
       // $sql = "SELECT * FROM comments WHERE email ='$email'";
       //  $result = $db->query($sql);

        // if ($result->rowCount() === 0) {
        // Insert the comment into the database using prepared statements to prevent SQL injection
        $sql = "INSERT INTO comments (parent_id, post_id, user_id, name, email, content, created_at) 
                VALUES (NULL, :pstId, :uid, :nme, :email, :contnt, :created)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":pstId", $postId, PDO::PARAM_INT);
       // isset($_POST['user-id']) ? $stmt->bindParam(":uid", $userId, PDO::PARAM_INT) : $stmt->bindValue(':uid', NULL, PDO::PARAM_NULL); 
        //isset($_POST['comment-name']) ? $stmt->bindParam(":nme", $validName, PDO::PARAM_STR) : $stmt->bindValue(':nme', NULL, PDO::PARAM_NULL); 
       // isset($_POST['comment-email']) ? $stmt->bindParam(":email",  $validEmail, PDO::PARAM_INT) : $stmt->bindValue(':email', NULL, PDO::PARAM_NULL);   
        if (isset($userId)) {      
             $stmt->bindParam(":uid", $userId, PDO::PARAM_INT);  
           } else {
             $stmt->bindValue(':uid', NULL, PDO::PARAM_NULL); 
           } 
        if (isset($_POST['comment-name'])) {                    
           $stmt->bindParam(":nme", $validName, PDO::PARAM_STR);
          } else {
             $stmt->bindValue(':nme', NULL, PDO::PARAM_NULL);
          }
        if (isset($_POST['comment-email'])) {   
           $stmt->bindParam(':email', $validEmail, PDO::PARAM_STR);
       } else {
           $stmt->bindValue(':email', NULL, PDO::PARAM_NULL);
       }
        $stmt->bindParam(':contnt', $validContent, PDO::PARAM_STR);
        $stmt->bindParam(':created', $created_at, PDO::PARAM_STR);
        $result = $stmt->execute();
             
        $success = "sent";
        echo $success;
        //return to prev page
        //$url = $_SERVER['HTTP_REFERER'];
        // header("Location: $url");
        //exit(); 
    
       // } else { 
        //    echo "email already exists";
       //  }
        
        /*
        // Return a JSON response with the newly created comment's details (ID, content, etc.)
        $commentId = $db->insert_id;
        //$commentId = $db->lastInsertId();
        $response = array(
            'status' => 'success',
            'comment_id' => $commentId,
            'name' => $validName,
            'email' => $validEmail,
            'content' => $validContent,
            'created_at' => $created_at
        );
        echo json_encode($response);*/
    } else {
        // Handle the error when the content is empty
        $errors = "Comment content cannot be empty.";
        //exit();

        /*
        // Return an error message if the content is empty
        $response = array('status' => 'error', 'message' => 'Comment content cannot be empty.');
        echo json_encode($response);*/
    }
} else {
     // Handle the error for invalid request method
     echo "Invalid request method.";
     exit();

     /*
    // Return an error message if the request method is not POST
    $response = array('status' => 'error', 'message' => 'Invalid request method.');
    echo json_encode($response);*/
}

?>
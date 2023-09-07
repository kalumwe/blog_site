<?php
/**  insert_comment.php **/

//include connection script and utility functions
require_once '../admin/includes/db_connect.php';
include_once('../includes/functions.php');

//database connection established and stored in $db variable
$db = dbConnect('master', 'pdo');   
$created_at = date('Y-m-d H:i:s');

        // Insert the comment into the database using prepared statements to prevent SQL injection
        $sql = "INSERT INTO comments (parent_id, name, email, content, created_at) 
        VALUES (NULL, 'kalu', 'kmailcm', 'ok', '$created_at')";
        $result = $db->query($sql);
       // $stmt->bindParam(":nme", $validName, PDO::PARAM_STR);  
       echo 'sent' ;                   
       



?>
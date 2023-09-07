<?php
ob_start();
session_start();

//defne location for error logs file
define('ERROR_LOG','C:/Temp/logs/blog_errors.log');

try {

   require_once './admin/includes/db_connect.php';
   require_once './includes/functions.php';
   require_once './includes/utility_funcs.php';

   // get variable for file name and include the file if it exists
    $page = isset($_GET['page']) ? safe($_GET['page']) : 'home';
    $navLinks = ['home', 'single-post', 'category', 'home', 'about', 'contact', 'search-result'];
    
  //redirect to home if get page doesn't exist
     if (!in_array($page, $navLinks)) {
         $page = 'home';
     }
      
  //redirect to home if get id is not set on category page
      if (!isset($_GET['id']) && isset($_GET['category'])) {
          header("Location: http://localhost:8080/blog_site/index.php");
       }

       if (isset($_SESSION['userId'])) {
          $user_id = $_SESSION['userId'];
       }

//initialize variables
  $errors = [];
  $error =[];
  $success = false;

// create database connection
$conn = dbConnect('read', 'pdo');

//retrieve contact details
$sql = "SELECT * FROM site_settings LIMIT 1";
$result = $conn->query($sql);
$error = $conn->errorInfo()[2];

//get records
if ($result->rowCount() > 0) {
  foreach($result->fetch() as $k => $val){
    $meta[$k] = $val;
  }
} else {
  $error = "No records found.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Index</title>

  <?php include_once('./includes/external-links.php'); ?>
  
</head>

<body>

  <!-- Header -->
    <?php include'./includes/header.php'; ?>
  <!-- End Header -->

  <main id="main">
     <?php include $page.'.php'; ?>
  </main>
  <!-- End #main -->

  <!-- Footer -->
 <?php include'./includes/footer.php'; ?>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php
 } catch (PDOException $e) {
                echo $e->getMessage();
                echo "Data can't be retrieved";
                // print "An Exception occurred. Message: " . $e->getMessage();
                //print "The system is busy please again try later";
                // $date = date('m.d.y h:i:s');                
                // $eMessage = $date . " | Exception Error | " , $errormessage . |\n";
                // error_log($eMessage,3,ERROR_LOG);
                // e-mail support person to alert there is a problem
                // error_log("Date/Time: $date - Exception Error, Check error log for
                //details", 1, noone@helpme.com, "Subject: Exception Error \nFrom:
                // Error Log <errorlog@helpme.com>" . "\r\n");

  } catch (PDOError $e) {
                echo $e->getMessage();
                echo "Data cannot be retrieved";
                // print "An Error occurred. Message: " . $e->getMessage();
                // print "The system is busy please try later";
                // $date = date('m.d.y h:i:s');        
                // $eMessage = $date . " | Error | " , $errormessage . |\n";
                // error_log($eMessage,3,ERROR_LOG);
                // e-mail support person to alert there is a problem
                // error_log("Date/Time: $date - Error, Check error log for
                //details", 1, noone@helpme.com, "Subject: Error \nFrom: Error Log
                // <errorlog@helpme.com>" . "\r\n");

  }
         
    $conn = null;
?>
</body>

</html>

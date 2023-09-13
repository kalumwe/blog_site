<?php
/** search-result.php **/

ob_start();
session_start();

//defne location for error logs file
define('ERROR_LOG','C:/Temp/logs/blog_errors.log');

try {

   require_once './admin/includes/db_connect.php';
   require_once './includes/functions.php';
   require_once './includes/utility_funcs.php';

// create database connection
$conn = dbConnect('read', 'pdo');

//retrieve contact details
$sql = "SELECT * from site_settings limit 1";
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

//initialize variables
  $errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //sanitize, filter and validate POST value
  $search = safe(trim($_GET['search_post']));
  if ((!empty($search)) && (strlen($search) <= 20)) {
    // remove ability to create link in email
    $patterns = array("/http/", "/https/", "/\:/","/\/\//","/www./");
    $search = preg_replace($patterns," ", $search);
    $search = filter_var( $search, FILTER_SANITIZE_STRING);
    $search = (filter_var($search, FILTER_SANITIZE_STRIPPED));
    $ok = true;
}  else { 
    $errors = 'Search input missing or exceeded max number of characters.';
}

// set maximum number of records
define('SHOWMAX', 5);

// prepare SQL to get total records
 $getTotal = "SELECT COUNT(*) FROM posts p INNER JOIN category c ON c.id = p.category_id 
              INNER JOIN author a ON a.id = p.author_id WHERE (p.title LIKE '%$search%')
              OR (p.post LIKE '%$search%') OR (c.name LIKE '%$search%')  
              OR (a.first_name LIKE '%$search%')  OR (a.last_name LIKE '%$search%') AND p.status = 1";

// submit query and store result as $totalPix
$total = $conn->query($getTotal);
$totalPix = $total->fetch()[0];

// set the current page (401)
$curPage = (isset ($_GET['curPage'])) ? (int) $_GET['curPage'] : 0;
$curPage = safe($curPage);

// calculate the start row of the subset
$startRow = $curPage * SHOWMAX;
$pages = ceil ($totalPix/SHOWMAX);
if ($startRow > $totalPix) {    //(401)
   $startRow = 0;
   $curPage = 0;
}

if ($curPage >= $pages) {
  $startRow = 0;
    $curPage = 0;
}

//get page url
$currentURL = 'search-result.php?search_post';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <row charset="utf-8">
  <row content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index</title>
  <?php include_once('./includes/external-links.php'); ?> 
</head>
<body>

  <!-- ======= Header ======= -->
   <?php include'./includes/header.php'; ?>
  <!-- End Header -->
  <main id="main">
    <!-- ======= Search Results ======= -->
    <section id="search-result" class="search-result">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <h3 class="category-title">Search Results</h3>
            <?php 


//get all records associated with the stored get variable
  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
          CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
          INNER JOIN author a ON a.id = p.author_id WHERE (p.title LIKE '%$search%')
          OR (p.post LIKE '%$search%') OR (c.name LIKE '%$search%')  
          OR (a.first_name LIKE '%$search%')  OR (a.last_name LIKE '%$search%') 
          AND p.status = 1  LIMIT $startRow,". SHOWMAX;
  $result = $conn->query($sql);
  $error = $conn->errorInfo()[2];

      //Display the results and sanitize results
        if($result->rowCount() > 0) {
          while($row = $result->fetch()) { 
        ?>

            <div class="d-md-flex post-entry-2 small-img">
              <a href="index.php?page=single-post&id=<?php echo isset($row['id']) ? safe($row['id']) : ''; ?>" class="me-4 thumbnail">
                <img src="assets/img/<?php echo isset($row['img_path']) ? safe($row['img_path']) : ''; ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta">
                  <span class="date"><?php echo isset($row['category']) ? safe($row['category']) : ''; ?></span>
                 <span class="mx-1">&bullet;</span> <span><?php echo isset($row['published']) ? safe($row['published']) : ''; ?></span>
               </div>
                <h3><a href="index.php?page=single-post&id=<?php echo isset($row['id']) ? safe($row['id']) : ''; ?>">
                <?php echo isset($row['title']) ? safe($row['title']) : ''; ?></a></h3>
                 <?php
                       $extract = getFirst($row['post'], 2);  ?>
                      <p><?php echo isset($row['post']) ? html_entity_decode($extract[0]) : ''; ?></p>

                <div class="d-flex align-items-center author">
                  <div class="photo">
                    <img src="assets/img/<?php echo isset($row['profile_picture']) ? safe($row['profile_picture']) : ''; ?>" 
                    alt=""  width='60' height='42'></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo isset($row['author_name']) ? safe($row['author_name']) : ''; ?></h3>
                  </div>
                </div>
              </div>
            </div>

      <?php }
        } else {
            echo "<p class='mx-auto'>No posts found.</p>";
        }
      ?>
            
            <!-- Paging -->
            <div class="text-start py-4">
              <div class="custom-pagination">
                
              <?php //prev link
                    if ($curPage > 0) { ?>
                <a href="<?= $currentURL ?>&curPage=<?= $curPage -1 ?>" class="prev">Prevous</a>
                 <?php  } else {
                          // otherwise leave the cell empty
                          echo '&nbsp;';
                        } 
                  //display page number links
                      for ($i = 1; $i <= $pages; $i++) {
                         if ($i == $curPage) { ?>
                    <a href="<?= $currentURL ?>&curPage=<?= $i-1 ?>" class=""><?= $i ?></a>
                   <?php } else { ?>
            <a href="<?= $currentURL ?>&curPage=<?= $i-1 ?>" class="<?php if ($i == $curPage + 1) { echo " active "; } ?>"><?= $i ?></a>
                   <?php } 
                      }

                    //next link
                    if ($startRow+SHOWMAX < $totalPix) { ?>
                <a href="<?= $currentURL ?>&curPage=<?= $curPage +1 ?>" class="next">Next</a>
                <?php  } else {
                          // otherwise leave the cell empty
                            echo '&nbsp;';
                        } ?>
              </div>
            </div><!-- End Paging -->
          </div>
          <div class="col-md-3">           
            <!-- ======= Sidebar ======= -->
             <?php include'side_bar.php'; ?>

        </div>
      </div>     
    </div>
    </section> <!-- End Search Result -->

    </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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
    $conn =null;    
?>
</body>

</html>


  
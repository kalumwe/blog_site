<?php
/** catehory.php **/
ob_start();

try {
//store get value in variable
$catId = (int) $_GET['id']; 
   require_once './admin/includes/db_connect.php';
   require_once './includes/functions.php';
   require_once './includes/utility_funcs.php';

  //defne location for error logs file
  //define('ERROR_LOG','C:/Temp/logs/errors.log');

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

//rederirect to home page if record id doesn't exist
$sql ="SELECT * FROM category WHERE id='$catId'";
$query = $conn->query($sql);
if ($query->rowCount() == 0) {
   header("Location: http://localhost:8080/blog_site/index.php");

}

// set maximum number of records
define('SHOWMAX', 5);

// prepare SQL to get total records
 $getTotal = "SELECT COUNT(*) FROM posts p INNER JOIN category c ON c.id = p.category_id 
              INNER JOIN author a ON a.id = p.author_id  WHERE p.category_id ='$catId' AND p.status = 1";

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
$currentURL = 'category.php';

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
    <section>
      <div class="container">
        <div class="row">
    <?php 

//get all records associated with the stored get variable
  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
          CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
          INNER JOIN author a ON a.id = p.author_id WHERE  p.category_id ='$catId' AND p.status = 1 ORDER BY date(p.date_published) DESC
          LIMIT $startRow,". SHOWMAX;
  $result = $conn->query($sql);
  $error = $conn->errorInfo()[2];

    //Display the results and sanitize results
        if($result->rowCount() > 0) { 
          while($meta = $result->fetch()) {  ?>
          <div class="col-md-9" data-aos="fade-up">
            <h3 class="category-title">Category: <?php echo isset($meta['category']) ? safe($meta['category']) : ''; ?></h3>

            <div class="d-md-flex post-entry-2 half">
              <a href="index.php?page=single-post&id=<?php echo isset($meta['id']) ? safe($meta['id']) : ''; ?>" class="me-4 thumbnail">
                <img src="assets/img/<?php echo isset($meta['img_path']) ? safe($meta['img_path']) : ''; ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?php echo isset($meta['category']) ? safe($meta['category']) : ''; ?></span> <span class="mx-1">&bullet;</span>
                 <span><?php echo isset($meta['published']) ? safe($meta['published']) : ''; ?></span></div>
                <h3><a href="index.php?page=single-post&id=<?php echo isset($meta['id']) ? safe($meta['id']) : ''; ?>">
                <?php echo isset($meta['title']) ? safe($meta['title']) : ''; ?></a></h3>
                <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst(html_entity_decode($meta['post']), 3);  ?>
                      <p><span class="firstcharacter">
                        <?php echo isset($meta['post']) ? getFirstLetter($extract[0]) : ''; ?></span>
                        <?php echo isset($meta['post']) ? removeFirstLetter($extract[0]) : ''; ?></p>

                <div class="d-flex align-items-center author">
                  <div class="photo">
                    <img src="assets/img/<?php echo isset($meta['profile_picture']) ? safe($meta['profile_picture']) : ''; ?>" 
                    alt="" class="" width='60' height='42'></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo isset($meta['author_name']) ? safe($meta['author_name']) : ''; ?></h3>
                  </div>
                </div>
              </div>
            </div>

          <?php
            }
           } else {
            echo "<p class='mx-auto'>No posts found.</p>";
          }
          ?>

           <!--PAGINATION NAV LINKS-->
            <div class="text-start py-4">
              <div class="custom-pagination">

              <?php //prev link
                    if ($curPage > 0) { ?>
                <a href="<?= $currentURL ?>&curPage=<?= $curPage -1 ?>" class="prev">Prevous</a>
                 <?php  } else {
                          // otherwise leave the cell empty
                          echo '&nbsp;';
                        } ?>


                  <?php 
                  //display page number links
                      for ($i = 1; $i <= $pages; $i++) {
                         if ($i == $curPage) { ?>
                    <a href="<?= $currentURL ?>&curPage=<?= $i-1 ?>" class="active"><?= $i ?></a>
                   <?php } else { ?>
            <a href="<?= $currentURL ?>&curPage=<?= $i-1 ?>" class="<?php if ($i == $curPage + 1) { echo " active "; } ?>"><?= $i ?></a>
                   <?php } 
                      }
                    ?>
                
                <?php //next link
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
    </section>
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
 
 $conn = null;       
?>
</body>

</html>


  
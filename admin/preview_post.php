<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: http://localhost:8080/blog_site/admin/index.php");
    exit();
}

$postId = (int) $_GET['id']; 

//rederirect to home page if record id doesn't exist
$sql ="SELECT * FROM posts WHERE id='$postId'";
$query = $conn->query($sql);
$row = $query->fetch();
if ($query->rowCount() == 0) {
   header("Location: http://localhost:8080/blog_site/admin/index.php");
   exit();
}

//get all records associated with the stored get variable
if (!is_null($row["author_id"])) {
    $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
          CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
          INNER JOIN author a ON a.id = p.author_id  WHERE p.id ='$postId'";
} else {
   $sql = "SELECT p.*, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published 
         FROM posts p INNER JOIN category c ON c.id = p.category_id  WHERE p.id ='$postId'";    
}
  $result = $conn->query($sql);
  $error = $conn->errorInfo()[2];


  foreach($result->fetch() as $key => $value) {
    $meta[$key] = $value;
  }

?>

<div class="container-fluid px-4">
        <div class="row my-3" d-flex>
           <div class="col-lg-4">
            <div class="post-entry-1 lg" data-id="<?php echo isset($meta['id']) ? (int) $meta['id'] : ''; ?>">            
              <h2><?php echo isset($meta['title']) ? $user->safe($meta['title']) : ''; ?></h2>
                <div class="post-meta my-3 text-muted"><span class="date"><?php echo isset($meta['category']) ? $user->safe($meta['category']) : ''; ?></span>
                   <span class="mx-1">&bullet;</span> <span><?php echo isset($meta['published']) ? $user->safe($meta['published']) : ''; ?></span></div>

              <div class="d-flex align-items-center avator">
                <div class="photo me-2"><img src="assets/img/<?php echo isset($meta['profile_picture']) ? $user->safe($meta['profile_picture']) : ''; ?>" alt="" class="rounded-circle"  width='40' height='40' class=""></div>
                <div class="name">
                  <h6 class="m-0 p-0 mb-2"><?php echo isset($meta['author_name']) ? $user->safe($meta['author_name']) : ''; ?></h6>
                </div>
              </div>

                <p class="post_comments my-3 mx-1"><strong><?php  
                $getTotal = 'SELECT COUNT(*) FROM comments WHERE post_id='.$meta['id'].'';
                $total = $conn->query($getTotal);
                $total_comments = $total->fetch()[0];
                echo $total_comments; ?></strong> comment(s)</p>
  
             </div>
           </div>
          <div class="col-lg-7">
                <img src="../assets/img/<?php echo isset($meta['img_path']) ? $user->safe($meta['img_path']) : ''; ?>" alt="" class="img-fluid mx-auto rounded">
           </div>
         </div>
         <div class="col-lg-12 my-5">
              <p class="mb-4 d-block"><?php echo isset($meta['post']) ? html_entity_decode($meta['post']) : ''; ?></p>
         </div>

           <a href="index.php?page=posts" class="prev_page  rounded-circle bg-secondary text-light">
             <i class="fa fa-arrow-left"></i></a>

</div>

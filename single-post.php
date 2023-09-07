<?php 
/** single-post.php **/

//store get value in variable
$postId = (int) $_GET['id']; 

//rederirect to home page if record id doesn't exist
$sql ="SELECT * FROM posts WHERE id='$postId'";
$query = $conn->query($sql);
if ($query->rowCount() == 0) {
   header("Location: http://localhost:8080/blog_site/index.php");

}

//get all records associated with the stored get variable
  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
          CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
          INNER JOIN author a ON a.id = p.author_id  WHERE p.id ='$postId'";
  $result = $conn->query($sql);
  $error = $conn->errorInfo()[2];

//Get the results  
  foreach($result->fetch() as $key => $value) {
    $meta[$key] = $value;
  }
?>

    <section class="single-post-content">
      <div class="container">
        <div class="row">
          <div class="col-md-9 post-content" data-aos="fade-up">     

<?php //Display the results and sanitize results
        if($result->rowCount() > 0) { ?>
            <!-- ======= Single Post Content ======= -->
            <div class="single-post">
              <div class="post-meta"><span class="date"><?php echo isset($meta['category']) ? safe($meta['category']) : ''; ?></span>
               <span class="mx-1">&bullet;</span> <span><?php echo isset($meta['published']) ? safe($meta['published']) : ''; ?></span></div>
              <h1 class="mb-5"><?php echo isset($meta['title']) ? safe($meta['title']) : ''; ?></h1>
              <?php              
                  //first two sentences of article in $extract[0] are immediately displayed.
                  isset($meta['post']) ? html_entity_decode($meta['post']) : '';
                  $extract = getFirst(html_entity_decode($meta['post']), 2);    ?>
                  <p><span class="firstcharacter"><?php echo getFirstLetter($extract[0]); ?></span>
              <?php echo removeFirstLetter($extract[0]); ?></p>

              <figure class="my-4 mx-auto" >
                <img src="assets/img/<?php echo isset($meta['img_path']) ? safe($meta['img_path']) : ''; ?>" alt="" width="900" 
                class="img-fluid mx-auto">
                <figcaption><?php echo isset($meta['caption']) ? safe($meta['caption']) : ''; ?></figcaption>
              </figure>
              <p><?php echo $extract[1]; ?></p>

            </div><!-- End Single Post Content -->
            <i class="bi-heart mr-2" id="likeComment_<?php echo (int) $meta['id'] ?>"
               onclick="likeComment(<?php echo (int) $meta['id'] ?>)"></i>              
       <?php 
        } 
           //include send comment script to send, sanitize and validate input values 
          //get total number of comments and store it variable
            $sql = "SELECT COUNT(*) FROM comments WHERE parent_id IS NULL AND post_id=$postId";
            $total = $conn->query($sql);
            $totalComments = $total->fetch()[0];

            // Query to get top-level comments and their replies
            $sql = "SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS uname, u.profile_picture FROM comments c INNER JOIN users u ON u.id=c.user_id WHERE c.parent_id IS NULL AND c.post_id=$postId ORDER BY created_at DESC";
            $result = $conn->query($sql);

        ?>
            <!-- ======= Comments ======= -->
            <div class="comments" id="comments">
              <h5 class="comment-title py-4"><?= $totalComments ?> comments</h5>
              <div class="comment d-flex mb-4">
              <?php 
                //if(mysqli_num_rows($result) > 0) {
                if ($result->rowCount() > 0) {
                  while($rowComment = $result->fetch()) {
                    $timeElapsed = getTimeElapsed($rowComment['created_at']);
                    $parentCommentId = (int) $rowComment['id'];
                ?> 
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="./admin/assets/img/<?php echo isset($_SESSION['userId']) ? safe($rowComment['profile_picture']) : 
                         safe($rowComment['image_path']); ?>" alt="" class="img-fluid">
                  </div>
                </div>

                <div class="flex-grow-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex align-items-baseline">
                    <h6 class="me-2"><?php echo isset($_SESSION['userId']) ? safe($rowComment['uname']) : 
                         safe($rowComment['name']); ?>. </h6>
                    <span class="text-muted"><?= $timeElapsed ?></span>
                  </div>
                  <div class="comment-body"><?= safe($rowComment['content']) ?></div>
                  <button class="btn reply-btn my-4" id="replyBtn" onclick="displayReplyForm(<?= $parentCommentId ?>)">Reply</button>
                  
                 <form action="forms/insert_reply.php" method="post" role="form" class="replyForm" id="replyForm_<?= $parentCommentId ?>">
                  <div id="sendreply"></div>
                  <div class="col-12 mb-3">
                    <div class="form-group">
                    <textarea class="form-control" id="reply-message" placeholder=""
                              data-rule="required" data-msg="Please write your comment" required 
                              cols="30" rows="5" name="reply-message"></textarea>
                      <div class="validation"></div>
                     </div>
                   </div>
                    <input type="hidden" name="parent_comment_id" value="<?php echo $parentCommentId ?>" /> 
                   <div class="col-12">
                    <input type="submit" class="btn btn-primary" name="send-reply" value="Reply">
                   </div>
                  </form>
             <?php
              //get total number of replies and store it variable
               $sql = "SELECT COUNT(*) FROM comments WHERE parent_id='$parentCommentId' AND post_id=$postId";
               $totalRpl = $conn->query($sql);
               $totalReply = $totalRpl->fetch()[0];

               // Fetch the replies for this comment
               $sql = "SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS uname, u.profile_picture FROM comments c INNER JOIN users u ON u.id=c.user_id WHERE c.parent_id = $parentCommentId  AND c.post_id=$postId ORDER BY created_at DESC";
               $replyResult = $conn->query($sql);

              ?>
                 <div class="comment-replies bg-light p-3 mt-3 rounded">
                    <h6 class="comment-replies-title mb-4 text-muted text-uppercase"><?= $totalReply ?> replies</h6>
              <?php 
                //show reply message 
                //if(mysqli_num_rows($result) > 0) {
                if ($replyResult->rowCount() > 0) {
                  while($rowReplies = $replyResult->fetch()) {
                    $timeElapsed = getTimeElapsed($rowReplies['created_at']);
                    //$parentCommentId = (int) $rowComment['id'];
                ?> 
                    <div class="reply d-flex mb-4">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                          <img class="avatar-img" src="assets/img/person-4.jpg" alt="" class="img-fluid">
                        </div>
                      </div>

                      <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="reply-meta d-flex align-items-baseline">
                          <h6 class="mb-0 me-2"><?php echo isset($_SESSION['userId']) ? safe($rowReplies['uname']) : 
                         safe($rowReplies['name']); ?>. </h6>
                          <span class="text-muted"><?= $timeElapsed ?></span>
                        </div>
                        <div class="reply-body"><?= safe($rowReplies['content']) ?></div>
                      </div>
                    </div>                     
            <?php }
                } else {
                    echo "";
                } 
            ?>
                  </div>
                </div>
              </div>
              <div class="comment d-flex">
                <div class="flex-shrink-0">                  
              </div>

          <?php }
            } else {
                echo "<p class='mx-auto'>No comments</p>";
            } 
          ?>

              </div>
            </div><!-- End Comments -->

            <!-- ======= Comments Form ======= -->
            <div class="row justify-content-center mt-5">

              <div class="col-lg-12">
              <?php 
                if (isset($errors)) {
                    echo '<ul class="mt-3">';
                    foreach ($errors as $error) {
                       echo "<li class=' text-danger'>$error</li>";
                    }
                    echo '</ul>';
                }
              ?>
                <h5 class="comment-title">Leave a Comment</h5>
                <form action="forms/insert_comment.php" method="post" role="form" class="commentFor" id="commentFor" onsubmit="">

                <div class="row">
                  <?php 
                     if (!isset($_SESSION['userId'])) { ?>
                  <div class="col-lg-6 mb-3">
                    <div class="form-group">
                    <label for="comment-name">Name</label>
                    <input type="text" class="form-control" id="comment-name" name="comment-name" placeholder="Enter your name"
                           data-rule="minlen:4" data-msg="Please enter at least 4 chars"
                           value="<?php if (isset($_POST['comment-name'])) echo htmlspecialchars($_POST['comment-name'], ENT_QUOTES); ?>">
                      <div class="validation "></div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-3">
                    <div class="form-group">
                    <label for="comment-email">Email</label>
                    <input type="text" class="form-control" id="comment-email" name="comment-email" placeholder="Enter your email"
                           data-rule="email" data-msg="Please enter a valid email"
                           value="<?php if (isset($_POST['comment-email'])) echo htmlspecialchars($_POST['comment-email'], ENT_QUOTES); ?>">
                      <div class="validation"></div>
                  </div>
                </div>
              <?php } else { echo ''; }?>
                  <div class="col-12 mb-3">
                    <div class="form-group">
                    <label for="comment-message">Message</label>
                    <textarea class="form-control" id="comment-message" placeholder="Write your comment"
                              data-rule="required" data-msg="Please write your comment"
                              cols="30" rows="10" name="comment-message"></textarea>
                    <div class="validation"></div>
                  </div>
                </div>
              <?php if (isset($_SESSION['userId'])) { ?>
                <input type="hidden" name="user-id" value="<?php echo (int) $user_id ?>" />
              <?php } ?>
                <input type="hidden" name="post-id" value="<?php echo (int) $meta['id'] ?>" />

                  <div class="col-12">
                    <input type="submit" class="btn btn-primary" name="send-comment" value="Post comment">
                  </div>
                </div>
              </div>
            </form>

          <?php 
          //show sent message
            if ($success) {
               echo "<p class='text-success'>$success</p>";
            }
          ?>
            </div><!-- End Comments Form -->

          </div>
          <div class="col-md-3">
            <!-- ======= Sidebar ======= -->
          <?php include'side_bar.php'; ?>

          </div>
        </div>
      </div>
    </section>
  

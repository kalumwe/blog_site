 <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">
        <div class="row g-5">
          <div class="col-lg-4">
          <h3 class="footer-heading">Recent Posts</h3>

<ul class="footer-links footer-blog-entry list-unstyled">

<?php  
//get posts for the past 4 weeks
$sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
        CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
        INNER JOIN author a ON a.id = p.author_id  WHERE p.date_published > DATE_SUB(NOW(), INTERVAL 44 WEEK) AND p.status = 1
        ORDER BY date(p.date_published) DESC LIMIT 5";
$result = $conn->query($sql);
$error = $conn->errorInfo()[2];
  //$qry = $conn->query("SELECT * from category where status = 1"); 
  while($row=$result->fetch()) {

   ?>
  <li>
    <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>" class="d-flex align-items-center">
      <img src="assets/img/<?= safe($row['img_path']) ?>" alt="" class="img-fluid me-3">
      <div>
        <div class="post-meta d-block"><span class="date"><?= safe($row['category']) ?></span>
         <span class="mx-1">&bullet;</span> <span><?= safe($row['published']) ?></span></div>
        <span><?= safe($row['title']) ?></span>
      </div>
    </a>
  </li>
<?php } ?>

</ul>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="index.php?page=home"><i class="bi bi-chevron-right"></i> Home</a></li>
              <li><a href="index.php?page=home"><i class="bi bi-chevron-right"></i> Blog</a></li>
              <li><a href="category.php"><i class="bi bi-chevron-right"></i> Categories</a></li>
              <li><a href="index.php?page=about"><i class="bi bi-chevron-right"></i> About us</a></li>
              <li><a href="index.php?page=contact"><i class="bi bi-chevron-right"></i> Contact</a></li>
            </ul>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Categories</h3>
            <ul class="footer-links list-unstyled">
      <?php             
         $sql = "SELECT * from category where status = 1";
         $result = $conn->query($sql);
         $error = $conn->errorInfo()[2];

              //$qry = $conn->query("SELECT * from category where status = 1"); 
            while($row=$result->fetch()) {
               ?>
              <li><a href="category.php?id=<?php echo (int) $row['id'] ?>"> <i class="bi bi-chevron-right"></i>
                <?php echo safe($row['name']) ?></a></li>
       <?php } ?>
            </ul>
          </div>
          <div class="col-lg-4">
          <h3 class="footer-heading">About KaluBlog</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
            <p><a href="about.html" class="footer-link-more">Learn More</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-legal">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>KaluBlog</span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              Developed by <a href="">Kalu</a>
            </div>
         </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="https://github.com/kalumwe" class="twitter"><i class="bi bi-github"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <!--<a href="#" class="google-plus"><i class="bi bi-skype"></i></a>-->
              <a href="https://www.linkedin.com/in/kalumba-mweshi-347b01251/" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>
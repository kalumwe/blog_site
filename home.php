 <?php

            $sql = "SELECT p.*,c.name AS category FROM posts p INNER JOIN category c ON c.id = p.category_id 
                 WHERE p.status = 1 ORDER BY date(p.date_published) DESC LIMIT 5";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
          
?>

    <!-- ======= Hero Slider Section ======= -->
    <section id="hero-slider" class="hero-slider">
      <div class="container-md" data-aos="fade-in">
        <div class="row">
          <div class="col-12">
            <div class="swiper sliderFeaturedPosts">
              <div class="swiper-wrapper">
                <?php 

              if($result->rowCount() > 0) {
                  while($row=$result->fetch()){
                    ?>
                <div class="swiper-slide" data-id="<?php echo (int) $row['id'] ?>">
                  
                  <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"  class="img-bg d-flex align-items-end" style="background-image: url('assets/img/<?php echo safe($row['img_path']) ?>');">
                    <div class="img-bg-inner">
                      <h2><?php echo safe($row['title']) ?></h2>
                      <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst($row['post'], 2);    ?>
                      <p><?php echo html_entity_decode($extract[0]); ?></p>
                    </div>
                  </a>
                </div>
                      
        <?php } 
            } else {
                $error = "No records found.";
            } ?>

              </div>
              <div class="custom-swiper-button-next">
                <span class="bi-chevron-right"></span>
              </div>
              <div class="custom-swiper-button-prev">
                <span class="bi-chevron-left"></span>
              </div>

              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Hero Slider Section -->

    <!-- ======= Post Grid Section ======= -->
    <section id="posts" class="posts">
      <div class="container" data-aos="fade-up">
        <div class="row g-5">
          <div class="col-lg-4">
        <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'Fashion' 
             ORDER BY date(p.date_published) DESC LIMIT 0,1";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
      ?>
            <div class="post-entry-1 lg" data-id="<?php echo (int) $row['id'] ?>">
              <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
                <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid"></a>
              <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span>
               <span class="mx-1">&bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
              <h2><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h2>
              <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst($row['post'], 1);    ?>
                      <p class="mb-4 d-block"><?php echo html_entity_decode($extract[0]); ?></p>

              <div class="d-flex align-items-center author">
                <div class="photo"><img src="assets/img/<?php if (!empty($row['profile_picture'])) { echo safe($row['profile_picture']); } else { echo 'default.jpg'; } ?>" alt=""  width='40' height='42' class=""></div>
                <div class="name">
                  <h3 class="m-0 p-0"><?php echo safe($row['author_name']); ?></h3>
                </div>
              </div>
            </div>
         
       <?php } 
          } else {
              $error = "No records found.";
          } ?>

          </div>

          <div class="col-lg-8">
            <div class="row g-5">
              <div class="col-lg-4 border-start custom-border">
                <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 ORDER BY date(p.date_published) DESC LIMIT 1,3";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
      ?>
                <div class="post-entry-1" data-id="<?php echo (int) $row['id'] ?>">
                  <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
                    <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span> <span class="mx-1">
                  &bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
                  <h2><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h2>
                </div>
               
                <?php } 
                } else {
                   $error = "No records found.";
                } ?>

              </div>

              <div class="col-lg-4 border-start custom-border">
               <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 ORDER BY date(p.date_published) DESC LIMIT 4,3";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
      ?>
                <div class="post-entry-1" data-id="<?php echo (int) $row['id'] ?>">
                  <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
                    <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span> <span class="mx-1">
                  &bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
                  <h2><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h2>
                </div>

                <?php } 
                } else {
                   $error = "No records found.";
                } ?>

              </div>

              <!-- Trending Section -->
              <div class="col-lg-4">

                <div class="trending">
                  <h3>Trending</h3>
                  <ul class="trending-post">
                    <li>
                <?php

                  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
                  CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
                  INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND p.trending = 1 ORDER BY date(p.date_published)
                   DESC LIMIT 5";
                  $result = $conn->query($sql);
                  $error = $conn->errorInfo()[2];

                  $counter = 1;
                  //if($result->rowCount() > 0) {
                   while($row=$result->fetch()) {
          
                ?>           
                    <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
                        <span class="number"><?php echo $counter ?></span>
                        <h3><?php echo safe($row['title']) ?></h3>
                        <span class="author"><?php echo safe($row['author_name']); ?></span>
                      </a>

                       <?php
                        $counter=$counter+1;
                      } 
                   // } else {
                    //   $error = "No records found.";
                    //} ?>
                    </li>
                    
                  </ul>
                </div>

              </div> <!-- End Trending Section -->
            </div>
          </div>

        </div> <!-- End .row -->
      </div>
    </section> <!-- End Post Grid Section -->

    <!-- ======= Culture Category Section ======= -->
    <section class="category-section">
      <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Culture</h2>
          <div><a href="index.php?page=category&id=3" class="more">See All Culture</a></div>
        </div>

        <div class="row">
          <div class="col-md-9">
             <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'culture' 
             ORDER BY date(p.date_published) DESC LIMIT 0,1";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
            ?>
            <div class="d-lg-flex post-entry-2" data-id="<?php echo (int) $row['id'] ?>">
              <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>" class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span>
                 <span class="mx-1">&bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
                <h3><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h3>
                 <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst($row['post'], 3);    ?>
                <p><?php echo html_entity_decode($extract[0]); ?></p>
                <div class="d-flex align-items-center author">
                  <div class="photo"><img src="assets/img/<?php if (!empty($row['profile_picture'])) { echo safe($row['profile_picture']); } else { echo 'default.jpg'; } ?>" alt="" width='40' height='42' class=""></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo safe($row['author_name']); ?></h3>
                  </div>
                </div>
              </div>
            </div>
          <?php } } ?>
          </div>

          <div class="col-md-3">
          <?php
            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'culture' 
             ORDER BY date(p.date_published) DESC LIMIT 1,2";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            if($result->rowCount() > 0) {
                 while($row=$result->fetch()) {         
            ?>
            <div class="post-entry-1 border-bottom" data-id="<?php echo (int) $row['id'] ?>">
              <div class="post-meta"><span class="date">
                <?php echo safe(ucfirst($row['category'])); ?></span> <span class="mx-1">&bullet;</span>
                 <span><?php echo safe($row['published']) ?></span></div>
              <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
              <?php echo safe($row['title']) ?></a></h2>
              <span class="author mb-3 d-block"><?php echo safe($row['author_name']); ?></span>
            </div>
          <?php } } ?>

          </div>
        </div>
      </div>
    </section><!-- End Culture Category Section -->

    <!-- ======= Technology Category Section ======= -->
    <section class="category-section">
      <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Technology</h2>
          <div><a href="index.php?page=category&id=7" class="more">See All Technology</a></div>
        </div>

          <div class="row">
          <div class="col-md-9">
             <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'technology' 
             ORDER BY date(p.date_published) DESC LIMIT 0,1";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
            ?>
            <div class="d-lg-flex post-entry-2" data-id="<?php echo (int) $row['id'] ?>">
              <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>" class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span>
                 <span class="mx-1">&bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
                <h3><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h3>
                 <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst($row['post'], 3);    ?>
                <p><?php echo html_entity_decode($extract[0]); ?></p>
                <div class="d-flex align-items-center author">
                  <div class="photo"><img src="assets/img/<?php if (!empty($row['profile_picture'])) { echo safe($row['profile_picture']); } else { echo 'default.jpg'; } ?>" alt="" width='40' height='42' class=""></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo safe($row['author_name']); ?></h3>
                  </div>
                </div>
              </div>
            </div>
          <?php } } ?>
          </div>

          <div class="col-md-3">
          <?php
            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'technology' 
             ORDER BY date(p.date_published) DESC LIMIT 1,2";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            if($result->rowCount() > 0) {
                 while($row=$result->fetch()) {         
            ?>
            <div class="post-entry-1 border-bottom" data-id="<?php echo (int) $row['id'] ?>">
              <div class="post-meta"><span class="date">
                <?php echo safe(ucfirst($row['category'])); ?></span> <span class="mx-1">&bullet;</span>
                 <span><?php echo safe($row['published']) ?></span></div>
              <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
              <?php echo safe($row['title']) ?></a></h2>
              <span class="author mb-3 d-block"><?php echo safe($row['author_name']); ?></span>
            </div>
          <?php } } ?>

          </div>
        </div>
      </div>
    </section><!-- End Business Category Section -->

    <!-- ======= Lifestyle Category Section ======= -->
    <section class="category-section">
      <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Travel</h2>
          <div><a href="index.php?page=category&id=10" class="more">See All Travel</a></div>
        </div>

          <div class="row">
          <div class="col-md-9">
             <?php

            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'travel' 
             ORDER BY date(p.date_published) DESC LIMIT 0,1";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");

          if($result->rowCount() > 0) {
             while($row=$result->fetch()) {
          
            ?>
            <div class="d-lg-flex post-entry-2" data-id="<?php echo (int) $row['id'] ?>">
              <a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>" class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                <img src="assets/img/<?php echo safe($row['img_path']) ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?php echo safe(ucfirst($row['category'])); ?></span>
                 <span class="mx-1">&bullet;</span> <span><?php echo safe($row['published']) ?></span></div>
                <h3><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['title']) ?></a></h3>
                 <?php
                      //first two sentences of article in $extract[0] are immediately displayed.
                       $extract = getFirst($row['post'], 3);    ?>
                <p><?php echo html_entity_decode($extract[0]); ?></p>
                <div class="d-flex align-items-center author">
                  <div class="photo"><img src="assets/img/<?php if (!empty($row['profile_picture'])) { echo safe($row['profile_picture']); } else { echo 'default.jpg'; } ?>" alt="" width='40' height='42' class=""></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo safe($row['author_name']); ?></h3>
                  </div>
                </div>
              </div>
            </div>
          <?php } } ?>
          </div>

          <div class="col-md-3">
          <?php
            $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
             CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
             INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND c.name = 'travel' 
             ORDER BY date(p.date_published) DESC LIMIT 1,2";
            $result = $conn->query($sql);
            $error = $conn->errorInfo()[2];
            if($result->rowCount() > 0) {
                 while($row=$result->fetch()) {         
            ?>
            <div class="post-entry-1 border-bottom" data-id="<?php echo (int) $row['id'] ?>">
              <div class="post-meta"><span class="date">
                <?php echo safe(ucfirst($row['category'])); ?></span> <span class="mx-1">&bullet;</span>
                 <span><?php echo safe($row['published']) ?></span></div>
              <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>">
              <?php echo safe($row['title']) ?></a></h2>
              <span class="author mb-3 d-block"><?php echo safe($row['author_name']); ?></span>
            </div>
          <?php } } ?>

          </div>
        </div>
      </div>
    </section><!-- End Lifestyle Category Section -->

 <!-- /** side_bar.php **/ -->

        <div class="aside-block">

              <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">Popular</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Trending</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-other-tab" data-bs-toggle="pill" data-bs-target="#pills-other" type="button" role="tab" aria-controls="pills-other" aria-selected="false">Other</button>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">

                <!-- Popular -->
                <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                <?php

                  //retrieve popular posts
                  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
                  CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
                  INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND p.popular = 1 ORDER BY date(p.date_published)
                   DESC LIMIT 5";
                  $result = $conn->query($sql);
                  $error = $conn->errorInfo()[2];
                 //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");
                   
                    $counter = 1;
                   while($row=$result->fetch()) { ?>
                  <div class="post-entry-1 border-bottom" data-id="<?= (int) $row['id'] ?>">
                    <div class="post-meta"><span class="date"><?= safe(ucfirst($row['category'])); ?></span>
                     <span class="mx-1">&bullet;</span> <span><?= safe($row['published']) ?></span></div>
                    <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?= safe($row['title']) ?></a></h2>
                    <span class="author mb-3 d-block"><?= safe($row['author_name']) ?></span>
                  </div>
                <?php } ?>
                </div> <!-- End Popular -->

                <!-- Trending -->
                <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
                 <?php

                 //retrieve trending posts
                  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
                  CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
                  INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND p.trending = 1 ORDER BY date(p.date_published)
                   DESC LIMIT 5";
                  $result = $conn->query($sql);
                  $error = $conn->errorInfo()[2];
                 //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");
                   
                    $counter = 1;
                   while($row=$result->fetch()) { ?>
                  <div class="post-entry-1 border-bottom" data-id="<?= (int) $row['id'] ?>">
                    <div class="post-meta"><span class="date"><?= safe(ucfirst($row['category'])); ?></span>
                     <span class="mx-1">&bullet;</span> <span><?= safe($row['published']) ?></span></div>
                    <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?= safe($row['title']) ?></a></h2>
                    <span class="author mb-3 d-block"><?= safe($row['author_name']) ?></span>
                  </div>
                <?php } ?>
                </div> <!-- End Trending -->

                <!-- Latest -->
                <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
                <?php

                 //retrieve latest posts
                  $sql = "SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
                  CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
                  INNER JOIN author a ON a.id = p.author_id  WHERE p.status = 1 AND p.latest = 1 ORDER BY date(p.date_published)
                   DESC LIMIT 5";
                  $result = $conn->query($sql);
                  $error = $conn->errorInfo()[2];
                 //$qry = $qry = $conn->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id where p.status = 1 order by date(p.date_published) desc limit 5");
                   
                    $counter = 1;
                   while($row=$result->fetch()) { ?>
                  <div class="post-entry-1 border-bottom" data-id="<?= (int) $row['id'] ?>">
                    <div class="post-meta"><span class="date"><?= safe(ucfirst($row['category'])); ?></span>
                     <span class="mx-1">&bullet;</span> <span><?= safe($row['published']) ?></span></div>
                    <h2 class="mb-2"><a href="index.php?page=single-post&id=<?php echo (int) $row['id'] ?>"><?= safe($row['title']) ?></a></h2>
                    <span class="author mb-3 d-block"><?= safe($row['author_name']) ?></span>
                  </div>
                <?php } ?>
                </div> <!-- End Latest -->
                <!-- Latest -->
                <div class="tab-pane fade" id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab">
                <?php
                //other news
                ?>
               </div>
              </div>
            </div>

            <div class="aside-block">
              <h3 class="aside-title">Video</h3>
              <div class="video-post">
                <a href="https://www.youtube.com/watch?v=AiFfDjmd0jU" class="glightbox link-video">
                  <span class="bi-play-fill"></span>
                  <img src="assets/img/<?php echo (isset($meta['img_path']) && !empty($meta['img_path'])) ? safe($meta['img_path']) : "sports-1.jpg"; ?>" alt="" class="img-fluid">
                </a>
              </div>
            </div><!-- End Video -->

            <div class="aside-block">
              <h3 class="aside-title">Categories</h3>
              <ul class="aside-links list-unstyled">
        <?php
              
       // create database connection
         $conn = dbConnect('read', 'pdo');
         $sql = "SELECT * from category where status = 1";
         $result = $conn->query($sql);
         $error = $conn->errorInfo()[2];

              //$qry = $conn->query("SELECT * from category where status = 1"); 
            while($row=$result->fetch()) {
               ?>
              <li><a href="category.php?id=<?php echo (int) $row['id'] ?>"><i class="bi bi-chevron-right"></i> <?php 
              echo safe($row['name']) ?></a></li>
      <?php } ?>
               
              </ul>
            </div><!-- End Categories -->

            <div class="aside-block">
              <h3 class="aside-title">Tags</h3>
              <ul class="aside-tags list-unstyled">
                 <?php
              
      // create database connection and retrieve category options
         $conn = dbConnect('read', 'pdo');
         $sql = "SELECT * from category where status = 1";
         $result = $conn->query($sql);
         $error = $conn->errorInfo()[2];

            while($row=$result->fetch()) {
               ?>
              <li><a href="category.php?id=<?php echo (int) $row['id'] ?>"><?php echo safe($row['name']) ?></a></li>
      <?php } ?>
              </ul>
    </div><!-- End Tags -->

      
       
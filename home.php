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

    <!-- ======= Business Category Section ======= -->
    <section class="category-section">
      <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Business</h2>
          <div><a href="category.html" class="more">See All Business</a></div>
        </div>

        <div class="row">
          <div class="col-md-9 order-md-2">

            <div class="d-lg-flex post-entry-2">
              <a href="single-post.html" class="me-4 thumbnail d-inline-block mb-4 mb-lg-0">
                <img src="assets/img/post-landscape-3.jpg" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                <h3><a href="single-post.html">What is the son of Football Coach John Gruden, Deuce Gruden doing Now?</a></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio placeat exercitationem magni voluptates dolore. Tenetur fugiat voluptates quas, nobis error deserunt aliquam temporibus sapiente, laudantium dolorum itaque libero eos deleniti?</p>
                <div class="d-flex align-items-center author">
                  <div class="photo"><img src="assets/img/person-4.jpg" alt="" class="img-fluid"></div>
                  <div class="name">
                    <h3 class="m-0 p-0">Wade Warren</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4">
                <div class="post-entry-1 border-bottom">
                  <a href="single-post.html"><img src="assets/img/post-landscape-5.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">11 Work From Home Part-Time Jobs You Can Do Now</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                  <p class="mb-4 d-block">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero temporibus repudiandae, inventore pariatur numquam cumque possimus</p>
                </div>

                <div class="post-entry-1">
                  <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">5 Great Startup Tips for Female Founders</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-7.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">How to Avoid Distraction and Stay Focused During Video Calls?</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                  <p class="mb-4 d-block">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero temporibus repudiandae, inventore pariatur numquam cumque possimus</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">How to Avoid Distraction and Stay Focused During Video Calls?</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">17 Pictures of Medium Length Hair in Layers That Will Inspire Your New Haircut</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">9 Half-up/half-down Hairstyles for Long and Medium Hair</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">Life Insurance And Pregnancy: A Working Mom’s Guide</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">The Best Homemade Masks for Face (keep the Pimples Away)</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Business</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">10 Life-Changing Hacks Every Working Mom Should Know</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Business Category Section -->

    <!-- ======= Lifestyle Category Section ======= -->
    <section class="category-section">
      <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Lifestyle</h2>
          <div><a href="category.html" class="more">See All Lifestyle</a></div>
        </div>

        <div class="row g-5">
          <div class="col-lg-4">
            <div class="post-entry-1 lg">
              <a href="single-post.html"><img src="assets/img/post-landscape-8.jpg" alt="" class="img-fluid"></a>
              <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2><a href="single-post.html">11 Work From Home Part-Time Jobs You Can Do Now</a></h2>
              <p class="mb-4 d-block">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero temporibus repudiandae, inventore pariatur numquam cumque possimus exercitationem? Nihil tempore odit ab minus eveniet praesentium, similique blanditiis molestiae ut saepe perspiciatis officia nemo, eos quae cumque. Accusamus fugiat architecto rerum animi atque eveniet, quo, praesentium dignissimos</p>

              <div class="d-flex align-items-center author">
                <div class="photo"><img src="assets/img/person-7.jpg" alt="" class="img-fluid"></div>
                <div class="name">
                  <h3 class="m-0 p-0">Esther Howard</h3>
                </div>
              </div>
            </div>

            <div class="post-entry-1 border-bottom">
              <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">The Best Homemade Masks for Face (keep the Pimples Away)</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

            <div class="post-entry-1">
              <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
              <h2 class="mb-2"><a href="single-post.html">10 Life-Changing Hacks Every Working Mom Should Know</a></h2>
              <span class="author mb-3 d-block">Jenny Wilson</span>
            </div>

          </div>

          <div class="col-lg-8">
            <div class="row g-5">
              <div class="col-lg-4 border-start custom-border">
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-6.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2><a href="single-post.html">Let’s Get Back to Work, New York</a></h2>
                </div>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-5.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 17th '22</span></div>
                  <h2><a href="single-post.html">How to Avoid Distraction and Stay Focused During Video Calls?</a></h2>
                </div>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-4.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Mar 15th '22</span></div>
                  <h2><a href="single-post.html">Why Craigslist Tampa Is One of The Most Interesting Places On the Web?</a></h2>
                </div>
              </div>
              <div class="col-lg-4 border-start custom-border">
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-3.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2><a href="single-post.html">6 Easy Steps To Create Your Own Cute Merch For Instagram</a></h2>
                </div>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-2.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Mar 1st '22</span></div>
                  <h2><a href="single-post.html">10 Life-Changing Hacks Every Working Mom Should Know</a></h2>
                </div>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="assets/img/post-landscape-1.jpg" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2><a href="single-post.html">5 Great Startup Tips for Female Founders</a></h2>
                </div>
              </div>
              <div class="col-lg-4">

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">How to Avoid Distraction and Stay Focused During Video Calls?</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">17 Pictures of Medium Length Hair in Layers That Will Inspire Your New Haircut</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">9 Half-up/half-down Hairstyles for Long and Medium Hair</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">Life Insurance And Pregnancy: A Working Mom’s Guide</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">The Best Homemade Masks for Face (keep the Pimples Away)</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                  <h2 class="mb-2"><a href="single-post.html">10 Life-Changing Hacks Every Working Mom Should Know</a></h2>
                  <span class="author mb-3 d-block">Jenny Wilson</span>
                </div>

              </div>
            </div>
          </div>

        </div> <!-- End .row -->
      </div>
    </section><!-- End Lifestyle Category Section -->

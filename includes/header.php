<?php 
/** header.php **/
?>
<header id="header" class="header d-flex align-items-center fixed-top">
  <div id="topbar" class=" d-lg-flex align-items-center fixed-top">
    <div class="container d-flex align-items-space-between my-2">
      <div class="contact-info ">
        <i class="bi-envelope mr-2"></i><a href="mailto:<?php echo isset($meta['email']) ? safe($meta['email']) : '' ?>" id="envelope">
        <?php echo isset($meta['email']) ? safe($meta['email']) : '' ?></a>
        <i class="bi-phone mr-2"></i> <?php echo isset($meta['contact']) ? safe($meta['contact']) : '' ?>
      </div>
      <?php 
      if (isset($_SESSION['name'])) { ?>
      <span id="welcome_user" class="mr-4">Welcome <?= safe($_SESSION['name']) ?></span>
      <?php } else {
        echo '';
      } ?>
      </div>     
    </div>
    <div id="navBar" class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php?page=home" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class=" "><?php echo isset($meta['site_name']) ? htmlspecialchars_decode($meta['site_name']) : 'Kalu<strong class="text-orangeRed">Blog</strong>' ?></h1>
      </a>

      <nav id="navbar" class="navbar ">
        <ul>
          <li><a href="index.php?page=home">Blog</a></li>
          <li class="dropdown"><a href=""><span>Categories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
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
          </li>

          <li><a href="index.php?page=about">About</a></li>
          <li><a href="index.php?page=contact">Contact</a></li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative d-flex">
         <div class="d-none d-lg-block">
        <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
        <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
        <a href="#" class="mx-2"><span class="bi-instagram"></span></a>
        <?php if (!isset($_SESSION['userId'])) { ?>
        <a href="#" class="mx-2"  data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">
          <span class="bi-person-fill"></span></a>
        <?php } else { ?>
          
          <a href="" class="mx-2 dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" 
          aria-expanded="false"><span class="bi-person-fill"></span></a>         
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a href="" class="dropdown-item">Logout</a>
          </div>
      
        <?php } ?>
      </div>


        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
        <i class="bi bi-list mobile-nav-toggle my-auto"></i>

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form action="search-result.php" method="get" class="search-form" name="searchForm" onsubmit="return(submitSearch());">
            <button class="icon bi-search my-auto " type="submit" id="bi-search"></button>
            <input type="text" placeholder="Search" class="form-control" name="search_post" id="search_post"
             onchange="" onblur="disappear()" onclick="">
            <button  class="btn js-search-close"><span class="bi-x"></span></button>
            <span class="text-small text-danger " id ="search_error"></span>
          </form>
          
          
        </div><!-- End Search Form -->

        <!--- Login modal --->
        <div class="modal fade login" id="loginModal">
          <div class="modal-dialog login animated">
              <div class="modal-content">
                 <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Login with</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                             <div class="content">
                                <div class="social">
                                    <a class="circle github" href="#">
                                        <i class="fa fa-github fa-fw"></i>
                                    </a>
                                    <a id="google_login" class="circle google" href="#">
                                        <i class="fa fa-google-plus fa-fw"></i>
                                    </a>
                                    <a id="facebook_login" class="circle facebook" href="#">
                                        <i class="fa fa-facebook fa-fw"></i>
                                    </a>
                                </div>
                                <div class="division">
                                    <div class="line l"></div>
                                      <span>or</span>
                                    <div class="line r"></div>
                                </div>
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <form method="" action="" accept-charset="UTF-8">
                                    <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                    <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                    <input class="btn btn-default btn-login" type="button" value="Login" onclick="loginAjax()">
                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form">
                                <form method="" html="{:multipart=>true}" data-remote="true" action="" accept-charset="UTF-8">
                                <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="button" value="Create account" name="commit">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                             <span>Already have an account?</span>
                             <a href="javascript: showLoginForm();">Login</a>
                        </div>
                    </div>
              </div>
          </div>
      </div>
      <!--- End of login modal  -->

      </div>

    </div>

  </header>


<?php 
/*** index.php ***/
ob_start();
 session_start();

 //try {
 //include file(class) 
include_once 'includes/admin_class.php';

//create object
$user = new Action();

$conn = dbConnect('master', "pdo");

if ($_SESSION['user_type'] !== 1) {
    header("location:http://localhost:8080/blog_site/login.php");  
}

//save session 'id' in variable
if (isset($_SESSION[ 'userId']) && is_numeric($_SESSION[ 'userId'])) {
    $user_id =  $_SESSION[ 'userId'];
    $userName = $_SESSION['name'];
} else {
    header("location:http://localhost:8080/blog_site/login.php");  
}

//if get_session function is false redirect to login page                  
if (!$user->get_session()) { 
    header("location:http://localhost:8080/blog_site/login.php"); 
} 

// Generate and store token 
if (!isset($_SESSION['hotel_sess_token'])) {
    $_SESSION[ 'hotel_sess_token'] = bin2hex(random_bytes(32));
    $sessionToken = $_SESSION[ 'hotel_sess_token'];
}

//logout if GET 'q' is set
if (isset($_GET['q']))  { 
   $user->logout();
   header("location:http://localhost:8080/blog_site/login.php"); 
} 

//Directory for images
$imageDir = './images/';

// get variable for file name and include the file if it exists
    $page = isset($_GET['page']) ? $user->safe($_GET['page']) : 'dashboard';

    $navLinks = ['dashboard', 'posts', 'manage-posts', 'category', 'manage-category', 'about', 'contact', 'preview_post',
                'user-account', 'settings', 'site_settings', 'search-result', 'author', 'manage-author', '404'];
    
    $file = $page.'.php'; 
  //redirect to home if get page doesn't exist
     if (!in_array($page, $navLinks) || (!file_exists($file))) {
        header("location:http://localhost:8080/blog_site/admin/404.php");
     }
     
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Admin </title>
        <?php include'includes/external-links.php' ?>
         
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-light">
            <!-- Navbar Brand-->
            <?php include'includes/topbar.php' ?> 

        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <!--Side Navbar Brand-->
                     <?php include'includes/sidebar.php' ?> 

                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    
                <?php
                    $file = $page.'.php';
                    include $file; 
                ?>
                <div id="preloader"></div>
             
            </main>

              <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
                <footer class="py-4 bg-light mt-auto">

                     <?php include 'includes/footer.php' ?> 

                </footer>
            </div>
        </div>


     <!-- Confirmation Modal-->
 <div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="my-2 msg" id=""></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="">Confirm.</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="delmes">Are you sure you want to publish this post?</div>
                <div class="modal-footer">
                    <form id="confirm_form" method="post" action="">
                    <input name="Item_id" id="Item_id" type="hidden" value="">
                   
                    <button class='btn btn-primary' type="submit" name="confirm" id='confirm' onclick="">Continue</button> 
                    
                    </form>
                    <button class="btn btn-secondary ml-3" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


<!-- Delete Post Modal-->
 <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="<?= (int)($row['id']) ?>"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="my-2 msg" id="del_msg"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Are you sure you want to delete this Post
                        <span id="delmes"></span>?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="delmes">Select "Delete" below if you are ready to delete.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="del_form" class="del_form" method="post" action="">                   
                    <input name="item_id" id="item_id" class="item_id" type="hidden" >
                   
                    <button class='btn btn-danger' type="submit"  name="delete" id='delete' onclick="">Delete</button> 
                    
                    </form><br>
                    
                </div>

            </div>
        </div>
    </div>

<!-- Category Modal -->
    <div class="modal fade" id="uni_modal" role='dialog' tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button class="btn btn-secondary ml-3" type="button" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>

       
    </body>
</html>

<script type="text/javascript">
 //upload image and store image file name
            function displayImg(input,_this) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        _this.parent().parent().parent().find('.img-field').attr('src', e.target.result);
                        _this.siblings('label').html(input.files[0]['name'])
                        _this.siblings('input[name="fname"]').val('<?php echo strtotime(date('y-m-d H:i:s')) ?>_'+input.files[0]['name'])
                        var p = $('<p></p>')
                        
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

</script>
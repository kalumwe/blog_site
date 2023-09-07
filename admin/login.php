<?php 
include 'includes/admin_class.php';
$user = new Action();
  
?>
<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<style>body{padding-top: 60px;}</style>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/login-register.css" rel="stylesheet" />
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	 <script src="js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
    <script src="js/login-register.js" type="text/javascript"></script>
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 d-flex " >
                 <a class="btn big-login" data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">Log in</a>
                 <a class="btn big-register ml-4" id="big-register" data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Register</a></div>
            <div class="col-sm-3"></div>
        </div>


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
                                    <form method="post" action="includes/ajax.php?action=login"  id="login_user" accept-charset="UTF-8">
                                    <input id="emailusername" class="form-control" type="text" placeholder="Email or Username" name="emailusername"
                                      value="<?php if (isset($_POST['emailusername'])) echo htmlspecialchars($_POST['emailusername'], ENT_QUOTES); ?>">
                                    <input id="password" class="form-control" type="password" placeholder="Password" name="password"
                                      value="<?php if (isset($_POST['password'])) echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>">
                                    <input class="btn btn-default btn-login" type="submit" value="Login" onclick="loginAja()" name="login">
                                    <?php 
                                    if (isset($errors)) { 
                                        foreach ($errors as $error) { ?>
                                    <p class="alert-danger"><?= $error ?></p>
                                    <?php } 
                                     } ?>

                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form">
                                <form method="post" html="{:multipart=>true}" data-remote="true" action="includes/ajax.php?action=register" accept-charset="UTF-8">
                                <input id="name" class="form-control" type="text" placeholder="Name" name="name"
                                  value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>">
                                <input id="username" class="form-control" type="text" placeholder="Username" name="username"
                                  value="<?php if (isset($_POST['username'])) echo htmlspecialchars($_POST['username'], ENT_QUOTES); ?>">
                                <input id="email" class="form-control" type="text" placeholder="Email" name="email"
                                 value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
                                <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="submit" value="Create account" 
                                 name="commit">
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
    </div>

<script type="text/javascript">
     $(document).ready(function(){
        openLoginModal();
    });

    //register user
     $(document).ready(function() {
            $("#login_user").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "admin/includes/ajax.php?action=login", // Replace with the actual path to your PHP file
                    type: "POST",
                    //method: 'POST',
                    data:  formData, // Serialize form data
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) { 

                      if (data.status == 1) {
                           window.location.href = data.url;
                       }                      
                      
                      if (data.status == 0) {
                         $("#error-message").text(data.message);
                         $("#error-message").attr("class", "alert alert-danger");
                         $("#error-message").fadeIn();
                         setTimeout(function() {
                            $("#error-message").fadeOut();
                         }, 3000); 
                      } 

                    },
                    error: function() {
                        console.log("Error fetching data.");
                    }
                });
            });
        });

//validate change password form
function validateForm() {

    // Reset error message
    $('#error-message').empty();
    
    // Field validation
    let isValid = true;
    $('.required').each(function() {
        if ($(this).val() === '') {
            isValid = false;
            $('#error-message').text('All fields are required.');
            $('#error-message').addClass('alert alert-danger');
            return false; // Exit the loop
        }
    });    
}

</script>


</body>
</html>

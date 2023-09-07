
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register Kalu Blog</title>
         <link href="admin/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
         <script src="./admin/js/jquery.min.js"></script>
        <script src="./admin/js/check-password-strength.js"></script>
        <script src="./admin/js/my_scripts.js"></script>
        <style type="text/css">
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif,"Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        #progressBar {
            width: 100%;
            height: 7px;  
        }
  
        .weak {
            background-color: #ff4d4d;
        }
  
        .medium {
            background-color: #ffad4d;
        }

        .strong {
            background-color: #4dff4d;
        }

    </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center mb-4">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div id="message"></div>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="admin/includes/ajax.php?action=register" id="register_user">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control required" type="text" placeholder="Enter your first name" 
                                                        id="first_name" name="first_name" required
                                                        value="<?php if (isset($_POST['first_name'])) echo $user->safe($_POST['first_name']); ?>"/>
                                                        <label for="first_name">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                    <input class="form-control required" type="text" placeholder="Enter your last name" 
                                                      id="last_name" name="last_name" required
                                                      value="<?php if (isset($_POST['last_name'])) echo $user->safe($_POST['last_name']); ?>" />
                                                        <label for="last_name">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control required" type="email" placeholder="name@example.com"
                                                  id="email" name="email" required
                                                  value="<?php if (isset($_POST['email'])) echo $user->safe($_POST['email']); ?>"/>
                                                <label for="email">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" placeholder="Username" name="username"
                                                         required value="<?php if (isset($_POST['username'])) 
                                                                  echo htmlspecialchars($_POST['username'], ENT_QUOTES); ?>"/>
                                                        <label for="username">Username</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                     <input class="form-control required" type="password" placeholder="Create a password"   id="password" name="password" onkeyup="checkPasswordStrength(this.value)"
                                                         value="<?php if (isset($_POST['password'])) echo $user->safe($_POST['password']); ?>" required/>
                                                        <label for="password">Password</label>
                                                        <div id="progressBar"></div>
                                                           <div class="d-flex">
                                                              <i id="strengthIcon"></i><span id="passwordStrength"></span></div>
                                                           </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control required" type="password" placeholder="Confirm password"
                                                          id="password_confirmation" name="password_confirmation" required
                                                          value="<?php if (isset($_POST['password_confirmation'])) echo $user->safe($_POST['password_confirmation']); ?>" />
                                                        <label for="password_confirmation">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary btn-block" type="submit"
                                                    onclick="validateForm()">Create Account</button></div>
                                            </div>
                                        </form>
                                        <div id="error-message"></div>
                                         <div class="error-message my-1"></div>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <?php include './admin/includes/footer.php'; ?> 
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

<script type="text/javascript">
    //register user
     $(document).ready(function() {
            $("#register_user").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "admin/includes/ajax.php?action=register", // Replace with the actual path to your PHP file
                    type: "POST",
                    //method: 'POST',
                    data:  formData, // Serialize form data
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                      //data =JSON.parse(data)
                      if (data.status == 1) {
                         $("#message").text(data.message);
                         $("#message").attr("class", "alert alert-success");
                         $("#message").fadeIn();
                         setTimeout(function() {
                            $("#message").fadeOut();
                         }, 3000); 
                         setTimeout(function() {
                           window.location.href = 'login.php'; // Reload the page after a delay
                           }, 2000);
                        // alert_toast("Data successfully updated.",'success');
                      } 

                      if (data.status == 2) {
                         $("#error-message").text(data.message);
                         $("#error-message").attr("class", "alert alert-danger");
                         $("#error-message").fadeIn();
                         setTimeout(function() {
                            $("#error-message").fadeOut();
                         }, 3000); 
                      } 

                     /* if (data.status == 3) {
                         $("#error-message").text(data.message);
                         $("#error-message").attr("class", "alert alert-danger");
                         $("#error-message").fadeIn();
                         setTimeout(function() {
                            $("#error-message").fadeOut();
                         }, 5000); 
                      } */
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
    $('.error-message').empty();
    
    // Field validation
    let isValid = true;
    $('.required').each(function() {
        if ($(this).val() === '') {
            isValid = false;
            $('.error-message').text('All fields are required.');
            $('.error-message').addClass('alert alert-danger my-1');
            return false; // Exit the loop
        }
    });

    
}

</script>

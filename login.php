<?php 
include './admin/includes/admin_class.php';
$user = new Action();

try {
   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login Kalu Blog</title>
        <link href="admin/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="./admin/js/jquery.min.js"></script>
        <style type="text/css">
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif,"Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="admin/includes/ajax.php?action=login" id='login_user'>
                                            <div class="form-floating mb-3">
                                                <input class="form-control required" id="emailusername" type="text" placeholder="name@example.com" name="emailusername" required
                                                value="<?php if (isset($_POST['emailusername'])) echo htmlspecialchars($_POST['emailusername'], ENT_QUOTES); ?>"/>
                                                <label for="emailusername">Email address or Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control required" id="password" type="password" placeholder="Password" name="password" required
                                                value="<?php if (isset($_POST['password'])) echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div id="error-message"></div>
                                            <?php 
                                      if (!empty($errors)) { ?> 
                                          <div class="alert alert-danger"> 
                                        <?php foreach ($errors as $error) { ?>
                                            <p><?= $error ?></p>
                                        <?php } 
                                          echo "</div>";
                                        } ?>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <button class="btn btn-primary" type="submit" name="login" 
                                                        onclick="validateForm()">Login</button>
                                            </div>
                                        </form>
                                        <div id="error-message"></div>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
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
<?php
 } catch (PDOException $e) {
                echo $e->getMessage();
                echo "Data can't be retrieved";
                // print "An Exception occurred. Message: " . $e->getMessage();
                //print "The system is busy please again try later";
                // $date = date('m.d.y h:i:s');                
                // $eMessage = $date . " | Exception Error | " , $errormessage . |\n";
                // error_log($eMessage,3,ERROR_LOG);
                // e-mail support person to alert there is a problem
                // error_log("Date/Time: $date - Exception Error, Check error log for
                //details", 1, noone@helpme.com, "Subject: Exception Error \nFrom:
                // Error Log <errorlog@helpme.com>" . "\r\n");

  } catch (PDOError $e) {
                echo $e->getMessage();
                echo "Data cannot be retrieved";
                // print "An Error occurred. Message: " . $e->getMessage();
                // print "The system is busy please try later";
                // $date = date('m.d.y h:i:s');        
                // $eMessage = $date . " | Error | " , $errormessage . |\n";
                // error_log($eMessage,3,ERROR_LOG);
                // e-mail support person to alert there is a problem
                // error_log("Date/Time: $date - Error, Check error log for
                //details", 1, noone@helpme.com, "Subject: Error \nFrom: Error Log
                // <errorlog@helpme.com>" . "\r\n");

  }
          
?>

<script>

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
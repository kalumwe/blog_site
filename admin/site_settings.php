<?php
      $qry = $conn->query("SELECT * FROM site_settings LIMIT 1");
      foreach ($qry->fetch() as $key => $value) {
        $meta[$key] = $value;
      }
?>

<div class="" id="message"></div>
 <div class="col-md-10 mx-auto">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Site Settings</h5>
              </div>
              <div class="card-body">
                <form action="./includes/ajax.php?action=site_settings" method="post" id="site_settings">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" class="form-control required" placeholder="Site Name" id="site_name" name="site_name"
                         value="<?php echo isset($meta['site_name']) ? $meta['site_name'] : '';
                         if (isset($_POST['site_name'])) echo $user->safe($_POST['site_name']); ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="contact">Site Contact</label>
                        <input type="text" class="form-control required" placeholder="Site Contact" id="contact" name="contact"
                         value="<?php echo isset($meta['contact']) ? $meta['contact'] : '';
                         if (isset($_POST['contact'])) echo $user->safe($_POST['contact']); ?>" required>
                      </div>
                    </div>
                    </div>
                   <div class="row">
                     <div class="col-md-12 pr-1">
                      <div class="form-group">
                        <label for="email">Site Email</label>
                        <input type="text" class="form-control required" placeholder="Site Email"  id="email" name="email"
                         value="<?php echo isset($meta['email']) ? $user->safe($meta['email']) : '';
                          if (isset($_POST['email'])) echo $user->safe($_POST['email']); ?>" required>
                      </div>
                    </div>
                  </div>
                    <div class="form-group mx-lg-1">
                        <label for="content" class="control-label">Site About Content</label>
                        <textarea type="text" id="content" name="content"  class="text-jqte form-control required"cols="30" rows="15" >
                          <?php echo isset($meta['about']) ? html_entity_decode($meta['about']) : '' ?>
                        </textarea>                                   
                    </div>
                    <input type="hidden" name="hotel_sess_token" value="<?= $sessionToken ?>">
                    <div class="row">
                    <div class="update ml-auto mr-auto d-flex justify-content-center my-2 mb-5">
                     <button type="submit" name="save_site_setting" class="btn btn-primary btn-round mx-auto px-5" 
                     onclick="validateForm()">
                      Save</button>
                    </div>
                  </div>
                </form>
                <div class="error-message" id="error-message"></div>
              </div>
            </div>
        </div>

<script>
   //Initialize TinyMCE editor -->
        tinymce.init({
            selector: '#content'
        });

         //site settings
     $(document).ready(function() {
            $("#site_settings").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "./includes/ajax.php?action=site_settings", // Replace with the actual path to your PHP file
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
                            location.reload(); // Reload the page after a delay
                           }, 2000);
                        // alert_toast("Data successfully updated.",'success');
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

</script>
         
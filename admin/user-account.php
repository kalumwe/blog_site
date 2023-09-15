<?php
$qry = $conn->query("SELECT * FROM users  WHERE id=".(int) $user_id);
      foreach ($qry->fetch() as $key => $value) {
        $meta[$key] = $value;
      }

      $imageDir = './assets/img/';
      if ( !empty($meta['profile_picture'])) {
          $image = $imageDir . basename($meta['profile_picture']);
          if (file_exists($image) && is_readable($image)) {
              $imageSize = getimagesize($image)[3];
          }
      }
?>

<div class="" id="message"></div>
<div class="content my-5">
   <div class="row  mx-2">
          <div class="col-md-4">
            <div class="card card-user ">
              <div class="image ">
                <img class="img-fluid" src="./assets/img/bg_profile2.jpg" alt="..." >
              </div>
              <div class="card-body" style="margin-top: -20px; ">
                <div class="author">
                  <?php
                   if (!empty($imageSize)) { ?>
                  <a href="#">
                    <img class="avatar border-gray profile_img" src="<?= $image ?>" alt="..." >
                  <?php } else { ?>
                    <img class="avatar border-gray" src="<?= $imageDir."undraw_profile.svg" ?>" alt="...">
                  <?php } ?> 
                    <h5 class="title"><?= $user->safe($meta['first_name'])." ".$user->safe($meta['last_name']) ?></h5>
                  </a>
                  <p class="description text-muted" >
                    @<?= $user->safe($meta['username']) ?>
                  </p>
                </div>
                <p class="description text-center">
                  "I like the way you work it <br>
                  No diggity <br>
                  I wanna bag it up"
                </p>
              </div>
            </div>

          </div>
          <div class="col-md-8 mx-auto">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
              </div>
              <div class="card-body">
                <form action="./includes/ajax.php?action=update_user" method="post" id="user_update" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control required" placeholder="First Name" id="first_name" name="first_name"
                         value="<?php echo isset($meta['first_name']) ? $user->safe($meta['first_name']) : '';
                         if (isset($_POST['first_name'])) echo $user->safe($_POST['first_name']); ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control required" placeholder="Last Name" id="last_name" name="last_name"
                          value="<?php echo isset($meta['last_name']) ? $user->safe($meta['last_name']) : '';
                          if (isset($_POST['last_name'])) echo $user->safe($_POST['last_name']); ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label for="company">Company (disabled)</label>
                        <input type="text" class="form-control" disabled placeholder="Company" value="Kalu Code Inc.">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control required" placeholder="Username" id="username" name="username"
                         value="<?php echo isset($meta['username']) ? $user->safe($meta['username']) : '';
                          if (isset($_POST['username'])) echo $user->safe($_POST['username']); ?>" required>
                      </div>
                    </div>
                    <div class="col-md-5 pl-1">
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email"  class="form-control required" placeholder="Email" id="email" name="email"
                         value="<?php echo isset($meta['email']) ? $user->safe($meta['email']) : '';
                          if (isset($_POST['email'])) echo $user->safe($_POST['email']); ?>" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Home Address" value="Lusaka, Zambia" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="City" value="Lusaka" disabled>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" placeholder="Country" value="Zambia" disabled>
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Postal Code</label>
                        <input type="number" class="form-control" placeholder="ZIP Code" disabled>
                      </div>
                    </div>
                  </div>
                  <label for="img" class="control-label">Update Profile Image</label>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                                 <div class="input-group mb-3 col-md-3">
                                   <div class="input-group-prepend mr-2">
                                     <span class="input-group-text " id="">Upload</span>
                                   </div><div>&nbsp;&nbsp;&nbsp;</div>
                                   <div class="custom-file mt-1">
                                      <input type="file" name="img" class="custom-file-input" id="img" aria-describedby=""  
                                      accept="image/*" onchange="displayImg(this,$(this))" >
                                     
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>About Me</label>
                        <textarea class="form-control textarea" disabled>Oh so, your weak rhyme You doubt I'll bother, reading into it
                        </textarea>
                      </div>
                    </div>
                  </div>
                        <input type="hidden" name="id" value="<?php echo isset($user_id) ? (int) $user_id : '' ?>">
                  <div class="row">
                    <div class="update ml-auto mr-auto d-flex justify-content-center my-2 mb-5">
                      <button type="submit" class="btn btn-primary btn-round mx-auto" onclick="validateForm()">Update Profile</button>
                    </div>
                  </div>
                </form>
                <div class="error-message" id="error-message"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
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
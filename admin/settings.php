
<div class="" id="message"></div>
 <div class="col-md-10 mx-auto">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Change Password</h5>
              </div>
              <div class="card-body">
                <form action="./includes/ajax.php?action=settings" method="post" id="change_password">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="old_password">Old Passord</label>
                        <input type="text" class="form-control required" placeholder="Old Passord" id="old_password" name="old_password"
                         value="<?php if (isset($_POST['old_password'])) echo $user->safe($_POST['old_password']); ?>" required>
                      </div>
                    </div>
                   </div>
                   <div class="row">
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="new_password">New Passord</label>
                        <input type="text" class="form-control required" placeholder="New Passord" id="new_password" name="new_password"
                          value="<?php if (isset($_POST['new_password'])) echo $user->safe($_POST['new_password']); ?>"
                          onkeyup="checkPasswordStrength(this.value)" required>
                          <div id="progressBar"></div>
                            <div class="d-flex">
                             <i id="strengthIcon"></i><span id="passwordStrength"></span></div>
                        </div>
                      </div>                      
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="comfirm_passord">Comfirm Passord</label>
                        <input type="text" class="form-control required" placeholder="Comfirm Passord" id="comfirm_passord"
                            name="comfirm_password" required
                           value="<?php if (isset($_POST['comfirm_password'])) echo $user->safe($_POST['comfirm_password']); ?>">
                      </div>
                     </div>
                   </div>
                    <input type="hidden" name="id" value="<?php echo isset($user_id) ? (int) $user_id : '' ?>">
                    <input type="hidden" name="hotel_sess_token" value="<?= $sessionToken ?>">
                    <div class="row">
                    <div class="update ml-auto mr-auto d-flex justify-content-center">
                      <button type="submit" name="changePassword" class="btn btn-primary btn-round mx-auto px-3 mb-5 mt-3" 
                      onclick="validateForm()
                      ">Change Password</button>
                    </div>
                  </div>
                </form>
                <div class="error-message" id="error-message"></div>
              </div>
            </div>
        </div>

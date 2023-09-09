    <?php 
    if(isset($_GET['id'])){

			$qry = $conn->query("SELECT a.*, a.id AS aId, p.title, a.profile_picture, p.id AS pId,
			       DATE_FORMAT(updated_at, '%d %M, %Y, %H.%i.%S') AS updated FROM author a LEFT JOIN
			       posts p ON a.id = p.author_id WHERE a.id=".(int)$_GET['id']);
			foreach ($qry->fetch() as $key => $value) {
				$meta[$key] = $value;
			}
		}
	?>

            <div class="container">
                       <div class="row justify-content-center mt-2">
                            <div class="col-lg-11">
                                <div class="card shadow-lg border-0 rounded-lg mt-2">
                                    <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">
                                    	<?php if (isset($_GET['id'])) {echo "Edit";} else {echo "Add";}  ?> Author</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="./includes/ajax.php?action=save_author" method="post" id="manage-author" 
                                              enctype="multipart/form-data">
                                        	
                                            <div class="row mx-lg-2">
                                              	<label for="">Author</label>
						                     <div class="col-lg-6">
                                             <div class="form-floating mb-5">
                                            	<label for="first_name">First Name</label>
                                               <input class="form-control required" id="first_name" name="first_name" type="text" placeholder=""
                                                 value="<?php echo isset($meta['first_name']) ? $user->safe($meta['first_name']) : '';
                                                     if (isset($_POST['first_name'])) echo $user->safe($_POST['first_name']); ?>" />
                                              </div> 
						                     
				                              </div>
				                             <div class="col-lg-6">
                                             <div class="form-floating mb-5">
                                            	<label for="last_name">Last Name</label>
                                               <input class="form-control required" id="last_name" name="last_name" type="text" placeholder=""
                                                 value="<?php echo isset($meta['last_name']) ? $user->safe($meta['last_name']) : '';
                                                     if (isset($_POST['last_name'])) echo $user->safe($_POST['last_name']); ?>" />
                                              </div> 						                     
				                            </div>
				                            </div>
                                           
                                             <div class="col-lg-7 mx-lg-3 mb-5">
                                               <label for="name">Blog Title</label>
                                                <select type="text" id="name" name="name[]" class="form-control required" multiple >
						                          <option value=""></option>
						                        <?php
						                          $post = $conn->query("SELECT * FROM posts ORDER BY title ASC");
						                          while($row= $post->fetch()){
						                        ?>
						                          <option value="<?php echo (int) $row['id'] ?>" 
						                        <?php echo isset($meta['pId']) && $meta['pId'] == $row['id'] ? 'selected' : '' ?>><?php echo $user->safe($row['title']) ?>
						                          </option>
						                        <?php } ?>
					                            </select>
                                                
                                             
                                            </div>

                                            <div class="col-lg-7">
                                            <div class="form-control mb-5 mx-lg-3">
					                         <label for="img" class="control-label">Add Profile Image</label>
						                    <div>
						                       <img src="./assets/img/<?php echo isset($meta['profile_picture']) ? $user->safe($meta['profile_picture']) : '' ?>" alt="" class="img-field m-4 rounded" />
						                        <br>
							                   <div class="input-group mb-3 col-md-3">
							                     <div class="input-group-prepend mr-2">
							                       <span class="input-group-text " id="">Upload</span>
							                     </div><div>&nbsp;&nbsp;&nbsp;</div>
							                     <div class="custom-file mt-1">
							                        <input type="file" name="img" class="custom-file-input" id="img" aria-describedby=""       accept="image/*" onchange="displayImg(this,$(this))" />
							                       
							                      </div>
							                    </div>
						                     </div>
						                    </div>
						                    </div>
                                          <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? (int) $_GET['id'] : '' ?>">
                                            <div class=" my-2 ms-3 error-message" id="error-message" ></div>
				                            <center><button type="submit" class="btn btn-primary btn-block col-md-2 px-5 my-4">Save</button></center>
                                        </form>
                                        <!--<a href="index.php?page=posts" class="prev_page  rounded-circle bg-secondary text-light">
                                           <i class="fa fa-arrow-left"></i></a>-->
                                    </div>
                                    <div class="" id="message"></div>
                                </div>

                            </div>
                        </div>
                    </div>
       



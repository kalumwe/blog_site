    <?php 
    if(isset($_GET['id'])){

			$qry = $conn->query("SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published,
                   '%b %D \'%y') AS published, a.first_name, a.last_name FROM posts p INNER JOIN category c 
			       ON c.id = p.category_id INNER JOIN author a ON a.id = p.author_id WHERE p.id=".(int)$_GET['id']);
			foreach ($qry->fetch() as $key => $value) {
				$meta[$key] = $value;
			}
		}
	?>

            <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    	<h3 class="text-center font-weight-light my-4">
                                    	<?php if (isset($_GET['id'])) {echo "Edit";} else {echo "Add";}  ?> Post</h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <form action="./includes/ajax.php?action=save_post" method="post" id="manage-post" enctype="multipart/form-data">
                                        	<div class="col-lg-7 mx-lg-3">
                                            <div class="form-floating mb-5">
                                            	<label for="name">Title</label>
                                               <input class="form-control required" id="name" name="name" type="text" placeholder=""
                                                 value="<?php echo isset($meta['title']) ? $user->safe($meta['title']) : '';
                                                     if (isset($_POST['name'])) echo $user->safe($_POST['name']); ?>" />
                                                     <div class="error-message" id=""></div>
                                             </div> 
                                            </div>

                                            <div class="col-lg-7 mx-lg-3">
                                             <div class="form-floating mb-5">
                                                <select type="text" id="category_id" name="category_id" class="form-control required">
						                          <option value=""></option>
						                        <?php
						                          $cat = $conn->query("SELECT * from category where status = 1 order by name asc");
						                          while($row= $cat->fetch()){
						                        ?>
						                          <option value="<?php echo (int) $row['id'] ?>" 
						                        <?php echo isset($meta['category_id']) && $meta['category_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $user->safe($row['name']) ?>
						                          </option>
						                        <?php } ?>
					                            </select>
                                                <label for="category_id">Category</label>
                                                <div class="error-message" id=""></div>

                                             </div>
                                            </div>
                                           
                                            <div class="col-lg-7" id="add_author">
                                            <div class="form-control mb-5 mx-lg-3">
					                         <label for="img" class="control-label">Add Image to Content</label>
						                    <div>
						                       <img src="../assets/img/<?php echo isset($meta['img_path']) ? $user->safe($meta['img_path']) : '' ?>" alt="" class="img-field my-4 rounded" />
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

                                            <div class="row mx-lg-2">
                                              	<label for="">Add New Author</label>
						                     <div class="col-lg-6">
                                             <div class="form-floating mb-5">
                                            	<label for="first_name">First Name</label>
                                               <input class="form-control" id="first_name" name="first_name" type="text" placeholder=""
                                                 value="<?php echo isset($meta['first_name']) ? $user->safe($meta['first_name']) : '';
                                                     if (isset($_POST['first_name'])) echo $user->safe($_POST['first_name']); ?>" />
                                              </div> 
						                     
				                              </div>
				                             <div class="col-lg-6">
                                             <div class="form-floating mb-5">
                                            	<label for="last_name">Last Name</label>
                                               <input class="form-control" id="last_name" name="last_name" type="text" placeholder=""
                                                 value="<?php echo isset($meta['last_name']) ? $user->safe($meta['last_name']) : '';
                                                     if (isset($_POST['last_name'])) echo $user->safe($_POST['last_name']); ?>" />
                                              </div> 
						                     
				                            </div>
				                            </div>

				                            <div class="col-lg-7 mx-lg-4 mb-2" >   
                                              	<input type="checkbox" id="authors">
				                                <label for="authors" class="mx-2">Select Author:</label>                                             
                                            </div>

                                          <div class="col-lg-7 mx-lg-3" id="hiddenInput" style="display: none;">
                                              <div class="form-floating mb-5">
                                                 <select type="text" id="author_id" name="author_id" class="form-control">
						                          <option value=""></option>
						                        <?php
						                          $cat = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS author_name FROM author");
						                          while($row= $cat->fetch()){
						                        ?>
						                          <option value="<?php echo (int) $row['id'] ?>" 
						                        <?php echo isset($meta['author_id']) && $meta['author_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $user->safe($row['author_name']) ?>
						                          </option>
						                        <?php } ?>
					                            </select>
					                            <label for="category_id">Author</label>
                                               </div>
                                           </div>
                                              </div>
                                             </div>
                                            <div class="form-group mx-lg-3">
                                            	<label for="post" class="control-label">Description</label>
					                            <textarea type="text" id="post" name="post"  class="text-jqte form-control required"
					                             cols="30" rows="15" >
					                           	<?php
					                           	 echo isset($meta['post']) ? html_entity_decode($meta['post']) : '' ?>
					                           	</textarea>
					                          
				                            </div>
				                          <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? (int) $_GET['id'] : '' ?>"><center class="mt-3 mb-5"><button type="submit" class="btn btn-primary btn-block col-md-2 my-4 
				                          	px-5"
				                          	onclick="validateForm()">Save</button></center>
                                        </form>
                                        <div class="" id="message"></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


<script>	
    //Initialize Quill editor -->
        var quill = new Quill('#pos', {
            theme: 'snow'
        });

    //Initialize TinyMCE editor -->
        tinymce.init({
            selector: '#post'
        });

    //Initialize Jqte editor
        $('#pos').jqte();

</script>
               

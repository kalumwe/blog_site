 
    <div class="container-fluid px-4">          
        <div class="row mt-3" d-flex>
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats shadow">
              <div class="card-body ">
                <div class="row">
                     <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Authors</p>
                      <p class="card-title"><?= $user->getTotalAuthor() ?><p>
                    </div>
                  </div>
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa-solid fa-users text-secondary"></i>
                    </div>
                  </div>
                 
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class=" mb-4">
            <a href="index.php?page=manage-author" class="btn btn-primary btn-sm  ml-auto mr-auto py-2 btn-round" 
                id="new_author">
                <i class="fa fa-plus"></i> New Author</a>
        </div>
            
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-users me-1"></i>
                                <strong>Authors</strong>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>                                         
                                            <th>Image</th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>                                         
                                            <th>Image</th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                <?php 

                                    $qry = $conn->query("SELECT *, CONCAT(first_name, ' ', last_name) AS author_name,  
                                            DATE_FORMAT(updated_at, '%d %M, %Y, %H.%i') AS updated FROM author"); 
                                    $counter = 1;
                                    while ($row=$qry->fetch()) {
                                       
                                        echo "        
                                        <tr>
                                            <td>" .$counter. "</td>
                                            <td>" .$user->safe($row['author_name']). "</td>";
                                            //image location
                                             $loc ="./assets/img/";
                                             if (!empty($row['profile_picture'])) {
                                                $dp = $loc. $user->safe($row['profile_picture']);
                                             if (file_exists($dp) && is_readable($dp)) {
                                                $imageSize = getimagesize($dp)[3];                                                   
                                                if (!empty($imageSize)) { 

                                        echo "
                                            <td>
                                             <div class='d-flex justify-content-center mx-auto my-auto'>"; 
                                        echo " <img class='img profile_img my-auto rounded-circle border-gray' src= '" .$dp . "' width='70' height='70' alt='' " .$imageSize . " '></div></td>";
                                                } 
                                            } else {
                                        echo "<td> 
                                               <div class='d-flex justify-content-center mx-auto my-auto'>
                                                 <img class='img-fit rounded-circle' alt='default profile picture'
                                                   src='".$loc."undraw_profile.svg' width='75' height='75'></div></td>";

                                            } 
                                        } else {
                                            echo "<td class=''> 
                                            <div class='d-flex justify-content-center my-auto'>                                  
                                                  <img class='img-fit rounded-circle' alt='default profile picture'
                                                   src='".$loc."undraw_profile.svg' width='75' height='75'></div></td>";

                                        } 
                                        echo "
                                            <td>" .$user->safe($row['updated']) ."</td>
                                            <td class='d-flex justify-content-center'>
                                             <div class='btn-group-vertical btn-group-sm' id='collapsibleMenu' 
                                              role='group' aria-label='Button Group'>
                                           <ul class='navbar-nav flex-column '>
                                           <li class='nav-item mx-auto'>
                                           <a href='index.php?page=manage-author&id=".(int)($row['id'])."' class='btn btn-primary btn-icon-split btn-sm mb-1 edit_category' role='button'>
                                            <span class='icon text-white-50'>
                                              <i class='fas fa-pencil-alt'></i>
                                            </span>
                                            <span class='text'></span>
                                          </a></li>
                                         <li class='nav-item mx-auto'>
                                         <a href='./includes/ajax.php?action=remove_author&id=".(int)($row['id'])."' class='btn btn-danger btn-icon-split btn-sm mb-1 remove_author' 
                                             data-toggle='modal' data-target='#delete_author_modal' data-id = '".$user->safe($row['id'])."' role='button'   >
                                          <span class='icon text-white-50'>
                                            <i class='fas fa-trash'></i>
                                         </span>
                                        <span class='text '></span>
                                        </a></li>
                                        </ul>
                                        </div>
                                            </td>
                                        </tr>
                                       
                                   ";
                                   $counter=$counter+1;
                                    } 
                                    
                                    ?>
                                     </tbody>
                                </table>
                                <div class="" id="message"></div>
                            </div>
                        </div>
                    </div>





<!-- Delete Author Modal-->
 <div class="modal fade" id="delete_author_modal" tabindex="-1" role="dialog" aria-labelledby="<?= (int)($row['id']) ?>"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="my-2 msg" id="del_msg"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Are you sure you want to delete this Author
                        <span id="delmes"></span>?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="delmes">Select "Delete" below if you are ready to delete.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="del_author_form" class="del_form" method="post" action="">                   
                    <input name="author_id" id="author_id" class="item_id" type="hidden" >
                   
                    <button class='btn btn-danger' type="submit"  name="delete_author" id='delete_author' onclick="">Delete</button> 
                    
                    </form><br>
                    
                </div>

            </div>
        </div>
    </div>
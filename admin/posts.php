
     <div class="container-fluid px-4">
        <div class="row mt-3" d-flex>
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats shadow">
              <div class="card-body ">
                <div class="row">
                     <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Posts</p>
                      <p class="card-title"><?= $user->getTotalPosts() ?><p>
                    </div>
                  </div>
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa-solid fa-blog text-primary"></i>
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

             <div class="mb-4">
                <a href="index.php?page=manage-posts" type="button" class="btn btn-primary btn-sm btn-block ml-auto mr-auto py-2 btn-round"  id="new_post">
                    <i class="fa fa-plus"></i> New Post</a>
              </div>
        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-blog me-1"></i>
                                <strong>Blog Posts</strong>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Category</th>                                         
                                            <th>Status</th>
                                            <th>published</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>published</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                <?php 

                                    $qry = $conn->query("SELECT p.*, c.name AS category, DATE_FORMAT(p.date_published,
                                     '%b %D \'%y') AS published FROM posts p INNER JOIN category c ON c.id = p.category_id "); 
                                    $counter = 1;
                                    while ($row=$qry->fetch()) {
                                        
                                        if ($row['status'] == 1) {
                                            $status = "Published";
                                            } else {
                                            $status = "Not published";
                                            $status .= "<a href='./includes/ajax.php?action=publish_post&id=".(int)($row['id'])."' class='btn btn-primary btn-icon-split btn-sm my-2 mx-auto publish_post'   
                                             data-toggle='modal' data-target='#confirm_modal' data-id='".(int)$row['id']."' role='button' onclick='openModalConf(".(int)($row['id']).")' >";
                                            $status .= "<span class='icon text-white-50'>
                                                          <i class='fa-solid fa-pen-to-square'></i>
                                                        </span>
                                                     <span class='text-white mr-1 '>Publish</span>
                                                </a>";      
                                            }

                                        echo "        
                                        <tr>
                                            <td>" .$counter. "</td>
                                            <td>" .$user->safe($row['title']). "</td>
                                            <td>" .$user->safe($row['category']) ."</td>
                                            <td>" .$status."</td>
                                            <td>" .$user->safe($row['published']) ."</td>
                                            <td class='d-flex justify-content-center>
                                             <div class='btn-group-vertical btn-group-sm' id='collapsibleMenu' 
                                              role='group' aria-label='Button Group'>
                                    <ul class='navbar-nav flex-column '>
                                    <li class='nav-item mx-auto'>
                                    <a href='index.php?page=manage-posts&id=".(int)($row['id'])."' class='btn btn-primary btn-icon-split btn-sm mb-1 edit_category' id='edit_category' role='button'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-pencil-alt'></i>
                                    </span>
                                    <span class='text'></span>
                                        </a></li>
                                        <li class='nav-item mx-auto'>
                                        <a href='index.php?page=preview_post&id=".(int)($row['id'])."'
                                         class='btn btn-info btn-icon-split btn-sm mb-1' role='button'>
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-info-circle'></i>
                                        </span>
                                        <span class='text'></span>
                                    </a></li>
                                    <li class='nav-item mx-auto'>
                                    <a href='./includes/ajax.php?action=remove_post&id=".(int)($row['id'])."' class='btn btn-danger btn-icon-split btn-sm mb-1 remove_post' id=''
                                      data-toggle='modal' data-target='#delete_modal' data-id = '".$user->safe($row['id'])."' role='button' onclick='openModal("; echo (int)($row['id']); echo ")'  >
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-trash'></i>
                                        </span>
                                        <span class='text '></span>
                                    </a></li>
                                    </ul>
                                   </div>
                                            </td>
                                        </tr> ";
                                    $counter=$counter+1;
                                    } 
                                    
                                    ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>






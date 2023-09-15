     
<?php
// Get data from the database
//$Data = $user->load_postCategory();
//$decodedData = json_decode($jsonData, true);
?>
   
        <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
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
                  <i class="fa fa-eye"></i>
                  <a href="index.php?page=posts" class="text-muted text-decoration-none"> View all</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats shadow">
              <div class="card-body ">
                <div class="row">
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Categories</p>
                      <p class="card-title"><?= $user->getTotalCategory() ?><p>
                    </div>
                  </div>
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa-solid fa-clipboard-list text-danger"></i>

                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-eye"></i>
                  <a href="index.php?page=category" class="text-muted text-decoration-none"> View all</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats shadow">
              <div class="card-body ">
                <div class="row">
                    <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Comments</p>
                      <p class="card-title "><?= $user->getTotalComments() ?><p>
                    </div>
                  </div>
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa-solid fa-comments text-success"></i>

                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-eye"></i>
                  <a href="index.php?page=Comments" class="text-muted text-decoration-none"> View all</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats shadow">
              <div class="card-body ">
                <div class="row">
                     <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Users</p>
                      <p class="card-title"><?= $user->getTotalUsers() ?><p>
                    </div>
                  </div>
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa-solid fa-users text-warning"></i>
                    </div>
                  </div>
                 
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  <a href="index.php?page=dashboard" class="text-muted text-decoration-none"> Update Now</a>
                </div>
              </div>
            </div>
          </div>
         </div>
                  <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <strong>Blog Posts</strong>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Author</th>
                                            <th>Title</th>
                                            <th>Category</th>                                         
                                            <th>Status</th>
                                            <th>published</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       
                                        <tr>
                                            <th>Author</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>published</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                <?php 

                                    $qry = $conn->query("SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published,
                                     '%b %D \'%y') AS published, CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id INNER JOIN author a ON a.id = p.author_id "); 

                                    while ($row=$qry->fetch()) {
                                        if ($row['status'] == 1) {
                                            $status = "Published";
                                            } else {
                                            $status = "Not published";  
                                            }

                                        // Use a while loop to iterate through the decoded data
                                              //while ($row = $Data) { 
                                                 // foreach ($Data as $row) {
                                        echo "        
                                        <tr>
                                            <td>" .$user->safe($row['author_name']). "</td>
                                            <td>" .$user->safe($row['title']). "</td>
                                            <td>" .$user->safe($row['category']) ."</td>
                                            <td>" .$user->safe($status) ."</td>
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
                                        </tr>
                                       
                                   ";
                                } ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




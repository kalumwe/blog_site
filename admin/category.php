     
<?php 
    if(isset($_POST['category_id'])){

            $qry = $conn->query("SELECT * FROM category WHERE p.id=".(int)$_POST['category_id']);
            foreach ($qry->fetch() as $key => $value) {
                $meta[$key] = $value;
            }
        }
    ?>
   
    <div class="container-fluid px-4">
        <div class="row mt-3" d-flex>
         <div class="col-lg-4 col-md-6 col-sm-6">
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
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>
              </div>
            </div>
          </div>
        </div>

       <div class="mb-4">
                <a href="" type="button" class="btn btn-primary btn-sm btn-block ml-auto mr-auto py-2 btn-round" id="new_category" data-toggle='modal' data-target='#category_moda' data-id = '' role='button' onclick=''>
                    <i class="fa fa-plus"></i> New Category</a>
            </div>
            
                   <div class="" id="message"></div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-clipboard-list me-1"></i>
                                <strong>Categories</strong>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>                                         
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       
                                        <tr>
                                             <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>                                         
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                <?php 

                                    $qry = $conn->query("SELECT * FROM category WHERE status =1"); 
                                    $counter = 1;
                                    while ($row=$qry->fetch()) {
                                        
                                        echo "        
                                          <tr>
                                            <td>" .$counter. "</td>
                                            <td>" .$user->safe($row['name']). "</td>
                                            <td>" .$user->safe($row['description']) ."</td>
                                           <td class=''>
                                           <div class='d-flex justify-content-center'>
                                            <div class='btn-group-horizontal btn-group-sm ml-3' id='collapsibleMenu' 
                                             role='group' aria-label='Button Group'>
                                    
                                      <a href='' type='button' class='btn btn-primary btn-icon-split btn-sm mb-1 ml-3 edit_category' data-id = '".$user->safe($row['id'])."' role='button' 
                                          id='edit_category".$user->safe($row['id'])."'>
                                      <span class='icon text-white-50'>
                                        <i class='fas fa-pencil-alt'></i>
                                      </span>
                                      <span class='text-white'></span>
                                        </a>
                                    <a href='./includes/ajax.php?action=remove_post&id=".(int)($row['id'])."' 
                                     class='btn btn-danger btn-icon-split btn-sm mb-1 remove_category' id=''
                                      data-toggle='modal' data-target='#delete_modal' data-id = '".$user->safe($row['id'])."' role='button' onclick='openModal("; echo (int)($row['id']); echo ")'  >
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-trash'></i>
                                        </span>
                                        <span class='text-white '></span>
                                    </a>
                                   </div>
                                   </div>
                                            </td>
                                        </tr>
                                       
                                   ";
                                   $counter=$counter+1;
                                    } 
                                    
                                    ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

    <script>
        $('#new_category').click(function() {
            uni_modal('New Category','manage-category.php');
        })

       $('.edit_category').click(function() {
            uni_modal("Edit Category",'manage-category.php?id='+$(this).attr('data-id'));
        })

       $(document).ready(function(){
            load_tbl()
        })
       
    </script>

   





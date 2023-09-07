<?php 
    if(isset($_GET['id'])){
            
        include './includes/db_connect.php';
        $conn = dbConnect('read', 'pdo');
        $qry = $conn->query("SELECT * FROM category WHERE id=".(int)$_GET['id']);
        foreach ($qry->fetch() as $key => $value) {
            $meta[$key] = $value;
        }
    }

?>
        <div class="" id="message"></div>                  
        <div class="container">
                       <div class="row justify-content-center mt-2">
                            <div class="col-lg-11">
                                <div class="card shadow-lg border-0 rounded-lg mt-2">
                                   
                                    <div class="card-body">
                                      <form action="./includes/ajax.php?action=save_category" method="post" id="manage_category">
                                        
                                             <div class="form-floating mb-5">
                                                <label for="category_name">Name</label>
                                               <input class="form-control required" id="name" name="name" type="text" 
                                               placeholder=""  value="<?php echo isset($meta['name']) ? $user->safe($meta['name']) : '';
                                                     if (isset($_POST['category_name'])) echo $user->safe($_POST['category_name']); ?>" />
                                              </div>    

                                             
                                             <div class="form-floating mb-5">
                                                <label for="description">Description</label>
                                                <textarea type="text" id="description" name="description" class="form-control required" required><?php echo isset($meta['description']) ? $meta['description'] : '' ?></textarea>
                                              </div>                                             
                                        

                                <input type="hidden" name="category_id" value="<?php echo isset($_GET['id']) ? (int) $_GET['id'] : '' ?>">
                                        </form>
                                        <div class="" id="msg"></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

    <script>
   //Add category
    $('#manage_category').submit(function(e){
        e.preventDefault();
         //var formData = new FormData(this);

        start_load()
        $.ajax({
            url:'./includes/ajax.php?action=save_category',
            method:'POST',
            data: $(this).serialize(),
            dataType: "json",

            error:err=>{
                console.log(err)
            },

            success:function(resp){
                if(resp.status == 1) {
                     $("#msg").text(resp.msg);
                         $("#msg").attr("class", "alert alert-success");
                         $("#msg").fadeIn();
                         setTimeout(function() {
                            $("#msg").fadeOut();
                         }, 3044); 
                         setTimeout(function() {
                            location.reload(); // Reload the page after a delay
                         }, 2000); // Reload after 2 seconds 

                } 
                if(resp.status == 2) {
                     $("#msg").text(resp.msg);
                         $("#msg").attr("class", "alert alert-warning");
                         $("#msg").fadeIn();
                         setTimeout(function() {
                            $("#msg").fadeOut();
                         }, 3044); 
                   }
                if(resp.status == 0) {
                     $("#msg").text(resp.msg);
                         $("#msg").attr("class", "alert alert-danger");
                         $("#msg").fadeIn();
                         setTimeout(function() {
                            $("#msg").fadeOut();
                         }, 3044); 

                } 
            }
        })

    })


</script>
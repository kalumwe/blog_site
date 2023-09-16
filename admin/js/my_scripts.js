
 $('#new_post').click(function() {
    location.replace('index.php?page=manage-posts')
})

 $('#new_author').click(function(){
    location.replace('index.php?page=manage-author')
 })


window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
}

window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
    })
}

//category modal
window.uni_modal = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                $('#uni_modal').modal('show')
                end_load()
            }
        }
    })
}

//delete post
    $(document).ready(function() {
        $(".remove_post").on("click", function() {
           var itemId = $(this).attr("data-id");
           // console.log(itemId);
           $("#item_id").val(itemId);
          
        });

            $("#del_form").submit(function(event) {
                event.preventDefault(); 
                var itemId = $("#item_id").val();

               //console.log(itemId);
               $.ajax({
                    url: "./includes/ajax.php?action=remove_post&id="+itemId,
                    method: "POST",
                    data: { itemId: itemId },
                   // dataType: "json",
                    success: function(data) {
                     // data =JSON.parse(data)
                      if (data == 1) {
                        $("#delete_modal").modal("hide");
                         $(".msg").text("Deleted successfully");
                         $(".msg").attr("class", "alert alert-warning");
                         $(".msg").fadeIn();
                         setTimeout(function() {
                            $(".msg").fadeOut();
                         }, 3044); 
                          setTimeout(function() {
                            location.reload(); // Reload the page after a delay
                           }, 2000); // Reload after 2 seconds 
                      } else {
                         $("#delete_modal").modal("hide");
                         $(".msg").text(data.message);
                         $(".msg").attr("class", "alert alert-danger");
                         $(".msg").fadeIn();
                         setTimeout(function() {
                            $("#message").fadeOut();
                         }, 3000); 
                      }
                    },
                    error: function() {
                        $("#delete_modal").modal("hide");
                        console.log("Error fetching data.");
                        
                    }
                });
            });
        });

//publish post
     $(document).ready(function() {
        $(".publish_post").on("click", function() {
           var itemId = $(this).attr("data-id");
            console.log(itemId);
           $("#Item_id").val(itemId);
          
        });

            $("#confirm_form").submit(function(e) {
                e.preventDefault(); // Prevent normal form submission
                var itemId = $("#Item_id").val();

               console.log(itemId+"k");
               $.ajax({
                    url: "./includes/ajax.php?action=publish_post&id="+itemId,
                    method: "POST",
                    data: { itemId: itemId },
                   // dataType: "json",
                    success: function(data) {
                     // data =JSON.parse(data)
                      if (data == 1) {
                        $("#confirm_modal").modal("hide");
                         $(".msg").text("Published successfully");
                         $(".msg").attr("class", "alert alert-success");
                         $(".msg").fadeIn();
                         setTimeout(function() {
                            $(".msg").fadeOut();
                         }, 3044); 
                          setTimeout(function() {
                            location.reload(); // Reload the page after a delay
                           }, 2000); // Reload after 2 seconds 
                        // alert_toast("Data successfully updated.",'success');
                      } 
                    },
                    error: function() {
                        $("#confirm_modal").modal("hide");
                        console.log("Error fetching data.");

                    }
                });
            });
        });

     //select author checkbox
  $(document).ready(function() {
    $("#authors").on("change", function() {
      var isChecked = $(this).prop("checked");
      
      if (isChecked) {
        $("#hiddenInput").show();  // Display hidden input
        $("#first_name").prop("disabled", true);  // Disable text input        
        $("#last_name").prop("disabled", true);          
        $("#author_id").prop("disabled", false);  // Disable text input
      } else {
        $("#hiddenInput").hide(); 
        $("#first_name").prop("disabled", false);  
        $("#last_name").prop("disabled", false);  
        $("#author_id").prop("disabled", true);  
      }
    });
  });

  //save post
        $(document).ready(function() {
            $("#manage-post").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "./includes/ajax.php?action=save_post", // Replace with the actual path to your PHP file
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
                         }, 3044); 
                         setTimeout(function() {
                            window.location.href = data.url; // Reload the page after a delay
                        }, 2000);
                        // alert_toast("Data successfully updated.",'success');
                      } 
                      if (data.status == 0) {
                         $("#error-message").text(data.message);
                         $("#error-message").attr("class", "alert alert-danger");
                         $("#error-message").fadeIn();
                         setTimeout(function() {
                            $("#error-message").fadeOut();
                         }, 7044); 
                      } 
                      if (data.status == 5) {
                         window.location.href = data.url; 
                      } 
                    },
                    error: function() {
                        console.log("Error fetching data.");
                       
                    }
                });
            });
        });


//remove author
    $(document).ready(function() {
        $(".remove_author").on("click", function() {
           var itemId = $(this).attr("data-id");
           // console.log(itemId);
           $("#author_id").val(itemId);         
        });

            $("#del_author_form").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var itemId = $("#author_id").val();

               //console.log(itemId);
               $.ajax({
                    url: "./includes/ajax.php?action=remove_author&id="+itemId,
                    method: "POST",
                    data: { itemId: itemId },
                   // dataType: "json",
                    success: function(data) {
                     // data =JSON.parse(data)
                      if (data == 1) {
                        $("#delete_author_modal").modal("hide");
                         $("#del_msg").text("Deleted successfully");
                         $("#del_msg").attr("class", "alert alert-warning");
                         $("#del_msg").fadeIn();
                         setTimeout(function() {
                            $("#del_msg").fadeOut();
                         }, 3044); 
                          setTimeout(function() {
                            location.reload(); // Reload the page after a delay
                           }, 2000); // Reload after 2 seconds 
                        // alert_toast("Data successfully updated.",'success');
                      } 
                    },
                    error: function() {
                        $("#delete_author_modal").modal("hide");
                        console.log("Error fetching data.");
                       
                    }
                });
            });
        });

//Add/Edit author
     $(document).ready(function() {
            $("#manage-author").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "./includes/ajax.php?action=save_author", // Replace with the actual path to your PHP file
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
                            window.location.href = data.url; 
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
                       if (data.status == 5) {
                         window.location.href = data.url; 
                      } 
                    },
                    error: function() {
                        console.log("Error fetching data.");
                        
                    }
                });
            });
        });

//remove category
    $(document).ready(function() {
        $(".remove_category").on("click", function() {
           var itemId = $(this).attr("data-id");
           // console.log(itemId);
           $("#item_id").val(itemId);
          
        });

            $("#del_form").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var itemId = $("#item_id").val();

               //console.log(itemId);
               $.ajax({
                    url: "./includes/ajax.php?action=remove_category&id="+itemId,
                    method: "POST",
                    data: { itemId: itemId },
                   // dataType: "json",
                    success: function(data) {
                     // data =JSON.parse(data)
                      if (data == 1) {
                        $("#delete_modal").modal("hide");
                         $(".msg").text("Deleted successfully");
                         $(".msg").attr("class", "alert alert-warning");
                         $(".msg").fadeIn();
                         setTimeout(function() {
                            $(".msg").fadeOut();
                         }, 3044); 
                          setTimeout(function() {
                            location.reload(); // Reload the page after a delay
                           }, 2000); // Reload after 2 seconds 
                        // alert_toast("Data successfully updated.",'success');
                      } else {
                         $("#delete_modal").modal("hide");
                         $(".msg").text(data.message);
                         $(".msg").attr("class", "alert alert-danger");
                         $(".msg").fadeIn();
                         setTimeout(function() {
                            $("#message").fadeOut();
                         }, 3000); 
                      }
                    },
                    error: function() {
                        $("#delete_modal").modal("hide");
                        console.log("Error fetching data.");
                        
                    }
                });
            });
        });

    //Add/Edit user
     $(document).ready(function() {
            $("#user_update").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "./includes/ajax.php?action=update_user", // Replace with the actual path to your PHP file
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
                    },
                    error: function() {
                        console.log("Error fetching data.");
                        
                    }
                });
            });
        });

//change password
     $(document).ready(function() {
            $("#change_password").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission
                var formData = new FormData(this);

                $.ajax({
                    url: "./includes/ajax.php?action=settings", // Replace with the actual path to your PHP file
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

                      if (data.status == 2) {
                         $("#error-message").text(data.message);
                         $("#error-message").attr("class", "alert alert-danger");
                         $("#error-message").fadeIn();
                         setTimeout(function() {
                            $("#error-message").fadeOut();
                         }, 3000); 
                      } 

                      if (data.status == 3) {
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

//validate change password form
function validateForm() {
    // Reset error message
    $('.error-message').empty();
   
    // Field validation
    let isValid = true;
    $('.required').each(function() {
        if ($(this).val() === '') {
            isValid = false;
            $('.error-message').text('All fields are required.');
            $('.error-message').addClass('alert alert-danger');
            $(".error-message").fadeIn();
                setTimeout(function() {
                    $(".error-message").fadeOut();
                }, 5000); 
            return false; // Exit the loop
        }
    });

    
}






<!-- css -->
        <!-- Favicons -->
        <link href="../assets/img/favicon.ico" rel="icon">
        <link href="../assets/img/favicon.ico" rel="apple-touch-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/my_styles.css" rel="stylesheet" />
        <link href="css/jquery-te-1.4.0.css" rel="stylesheet" />
          <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
        <!-- Fonts and icons     -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <style type="text/css">
     
        img.img-field {
            max-width: 20vw;
            max-height: 11vh;
        }  

        #message, .msg {
            padding: 20px; 
            position: fixed;
            top: 75px;
            right: 30px;
            width: 344px;
            transition: 0.5s;
            z-index: 2;
               
        }  
        @media (min-width: 576px) {
         #error-message {
           width: 440px;     
        }
      }
        .content {
            overflow: hidden;
        }
        .prev_page {
            position: relative;
            margin-left: 1.5rem;
            top: -1rem;
            padding: 10px;
            padding-left: 11px;
            padding-right: 11px;
        }
       .profile_img {
         overflow: hidden;
         object-fit: cover;
    }
        </style>

<!-- js -->       
        <script src="js/jquery.min.js"></script>
        <script src="./assets/jquery.easing/jquery.easing.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous">
        </script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="../assets/jquery/jquery-te-1.4.0.min.js"></script>

      <!-- Include Quill JavaScript -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

      <!-- Include TinyMCE JavaScript -->
        <script src="https://cdn.tiny.cloud/1/rbqblm517xlugsdtkmaqn37l5rz5ftz4r14d1g3k96v8q1lk/tinymce/5/tinymce.min.js"></script>
        <script src="js/check-password-strength.js"></script>
        <script src="js/my_scripts.js"></script>
     

<script type="text/javascript">
       
function openModal(item_id) {
    var deleteUrl = "./includes/ajax.php?action=remove_post&id=" + item_id;
    document.getElementById("delete").setAttribute("href", deleteUrl);
    //document.getElementById("delform").setAttribute("action", deleteUrl);
    console.log(deleteUrl);


}

function openModalConf(item_id) {
    var Url = "./includes/ajax.php?action=publish_post&id=" + item_id;
    document.getElementById("confirm").setAttribute("href", Url);
    document.getElementById("Item_id").setAttribute("value", item_id);
    console.log(Url);
    console.log(item_id);


}

function openModalCat(item_id) {
    var catId =  item_id;
    document.getElementById("category_id").setAttribute("value", catId);
    document.getElementById("category_id").value = catId;
    //document.getElementById("delform").setAttribute("action", deleteUrl);
    console.log(catId);


}

</script>




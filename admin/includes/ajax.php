<?php

use PhpSolutions\Authenticate\CheckPassword;
include 'admin_class.php';

$crud = new Action();

$action = $_GET['action'];
if (isset($_GET['id'])) {
   $itemId = (int) $_GET['id'];
}

$errors = [];

//call register function 
if ($action == 'register') {
	require_once __DIR__ . '/./PhpSolutions/Authenticate/CheckPassword.php';

    $result2 = [];
	$register = false;

	//sanitize, validate and filter user input
	$first_name = $_POST['first_name'];
	$first_name = $crud->validateFirstname($first_name, 'first_name');
    
    $last_name = $_POST['last_name'];
	$last_name = $crud->validateLastname($last_name, 'last_name');
 
	$username = $_POST['username'];
	$username = $crud->validateUsername($username, 'username');
 
	$email = $_POST['email'];
	$email = $crud->validateEmail($email, 'email');

	$u_pass1 = $_POST['password'];
	$u_pass2 = $_POST['password_confirmation'];
	$password = $crud->validatePassword($u_pass1, $u_pass2, 'password', 'password_confirmation');
	
    //get errors 
    $errors1 = $crud->getErrors();

    //create object and call methods
    $checkPwd = new CheckPassword($u_pass1, 8);
    $checkPwd->requireMixedCase(true);
    $checkPwd->requireNumbers(1);
    $checkPwd->requireSymbols(1);
    if ($checkPwd->check()) {
        $result1 = ['Password OK'];
    } else {
        $result2 = $checkPwd->getErrors();
    }

    //get errors   
    $errors = array_merge($errors1, $result2);
 
	//call function if errors are empty
	if (empty($errors1)) {
		$register = $crud->registerUser($first_name, $last_name, $username, $email, $password);
	} else {
		$result = [];
        foreach ($errors as $string) {
          $sentences = explode('.', $string); // Split by full stops
          $sentences = array_map('trim', $sentences); // Remove leading/trailing spaces
          $sentences = array_filter($sentences); // Remove empty elements
          $formatted = implode("<br>", $sentences); // Join with line breaks
          $formatted = str_replace(',', '', $formatted); // Remove commas
          $result[] = $formatted;
        }
        echo $result;

        if ($u_pass2 !== $u_pass1) {
			header("Content-Type: application/json");
			echo json_encode(array('status'=>3, 'message'=>"passwords don't match"));
			//echo $result;
		}
      	
	}
	if ($register) {
		echo $register;
	}
	/*if ($register && (!isset($_POST['id']))) {
		echo 'registered. redirecting to login page.';
		?>
        <meta http-equiv="refresh" content="3;url=../login.php" />
        <?php
	}*/
}

//call update user function 
if ($action == 'update_user') {
	$update = false;

	//sanitize, validate and filter user input
	$first_name = $_POST['first_name'];
	$first_name = $crud->validateFirstname($first_name, 'first_name');
    
    $last_name = $_POST['last_name'];
	$last_name = $crud->validateLastname($last_name, 'last_name');
 
	$username = $_POST['username'];
	$username = $crud->validateUsername($username, 'username');
 
	$email = $_POST['email'];
	$email = $crud->validateEmail($email, 'email');
 
    //get errors 
    $errors = $crud->getErrors();
 
	
	//call function if errors are empty
	if (empty($errors)) {
		$update = $crud->updateUser($first_name, $last_name, $username, $email);
	} else {
		foreach ($errors as $error) {
			echo $error;
		}		
	}
	if ($update) {		
		echo $update;
    }
}

//call login function
if ($action == 'login') {	
	$login = false;
	$error ='';

	//check if empty and store error in $errors ????
	$emailUsername = trim($crud->safe($_POST['emailusername']));
	$emailUsername = filter_var($emailUsername, FILTER_SANITIZE_STRING);

	$password = trim($crud->safe($_POST['password']));
	$password = filter_var($password, FILTER_SANITIZE_STRING);

 //check if input is empty
 if (empty($_POST['emailusername']) || empty($_POST['password'])) {
	 $error = 'Username/Password is missing';
 }
 
 //call function if errors are empty
 if (empty($error)) {
	 $login = $crud->login($emailUsername, $password);
     echo $login;
 } 
	
}

if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
	  echo $logout;
}

if($action == 'site_settings') {
	if ((strlen($_POST['site_name']) > 100) || (strlen($_POST['contact']) > 20) || (strlen($_POST['email']) > 40) 
         || (strlen($_POST['content']) > 544)) {
        header("Content-Type: application/json");
		echo json_encode(array('status'=>0, 'message'=>'exceeded max number of charactors'));
		exit();
	}
	if (empty($_POST)) {
		header("Content-Type: application/json");
		echo json_encode(array('status'=>0, 'message'=>'All fields are required'));
		exit();
	}

	$save = $crud->save_settings();
	if($save)
		echo $save;
}

if($action == 'save_category') {
	if (empty($_POST['name']) || empty($_POST['description'])) {
		header("Content-Type: application/json");
		echo json_encode(array('status'=>0, 'msg'=>'All fields are required.'));
		exit();
	}
	$save = $crud->save_category();
	if($save) 
		echo $save;
}

if($action == 'load_category'){
	$list = $crud->load_category();
	if($list)
		echo $list;
}

if($action == 'load_post'){
	$list = $crud->load_post();
	if($list)
		echo $list;
}

if($action == 'remove_category'){
	$remove = $crud->remove_category($itemId);
	if($remove)
		echo $remove;
}

if ($action == 'publish_post') {
	$published = $crud->publish_post($itemId);
	if ($published)
		echo $published;
}

if ($action == 'remove_post') {
	$remove = $crud->remove_post($itemId);
	if($remove)
		echo $remove;
}

if ($action == 'save_author')  {
  //reqiure recaptcha congig file
  //require("cap.php");

 //SANITIZE AND VALIDATE POST VALUES !!
    $firstname = $_POST['first_name'];
    $firstname = $crud->validateFirstname($firstname, 'first_name');

    $lastname = $_POST['last_name'];
    $lastname = $crud->validateLastname($lastname, 'last_name');

    //get errors 
    $errors = $crud->getErrors();

    if (empty($errors)) {
       $save = $crud->save_author();
       if ($save) {
    	  echo $save;
       }
   } else {
   	foreach ($errors as $error) {
   	   header("Content-Type: application/json");
	   echo json_encode(array('status'=>0, 'message'=>$error));
	   exit();
	}	
	}
 
}

if ($action == 'remove_author') {
	$remove = $crud->remove_author($itemId);
	if ($remove) {
		echo $remove;
	}
}

if ($action == 'save_post') {	
	if (isset($_POST["post"]) && empty($_POST["post"])) {
		header("Content-Type: application/json");
		echo json_encode(array('status'=>0, 'message'=>'post field missing.'));
		exit();		
	}
	if (isset($_POST["authors"])) {
		if (empty($_POST["author_id"])) {
	 	   header("Content-Type: application/json");
		   echo json_encode(array('status'=>0, 'message'=>'author field missing.'));
		   exit();		
	   }
	} 
	if (!isset($_POST["authors"])) {
		if (empty($_POST['first_name']) || empty($_POST['last_name'])) {
            header("Content-Type: application/json");
		    echo json_encode(array('status'=>0, 'message'=>'author field missing.'));
		    exit();	
		}
	}
	if (empty($_POST['name']) || empty($_POST['category_id'])) {
		header("Content-Type: application/json");
		echo json_encode(array('status'=>0, 'message'=>'missing field(s).'));
		exit();		
	} else { 
	    $save = $crud->save_post();
	    if ($save) {
	       echo $save;
        }
    }	
}

if ($action == 'settings') { 
    $save = false; 
    //use check password class namespace
    require_once __DIR__ . '/./PhpSolutions/Authenticate/CheckPassword.php';
    $result2 = [];
     /*if (!hash_equals($itemId, $_POST['hotel_sess_token'])) {
        die("Token validation failed.");
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
   }*/

   //sanitize, validate and filter POST value
   $old_password = trim($crud->safe($_POST['old_password']));
   $old_password = filter_var( $old_password, FILTER_SANITIZE_STRING);
   $old_password = (filter_var($old_password, FILTER_SANITIZE_STRIPPED));

    if (empty($old_password)) {
        $errors[] = 'You forgot to enter your old password.';
    }

   $u_pass1 = $_POST['new_password'];
   $u_pass2 = $_POST['comfirm_password'];

    if ($u_pass2 !== $u_pass1) {
		header("Content-Type: application/json");
		echo json_encode(array('status'=>3, 'message'=>"passwords don't match"));
	}
       
   //call function to sanitize and filter POST values
    $password = $crud->validatePassword($u_pass1, $u_pass2, 'new_password', 'comfirm_password');
    $errors1 = $crud->getErrors();

    //create object and call methods
	$new_password = $_POST['new_password'];
    $checkPwd = new CheckPassword($new_password, 8);
    $checkPwd->requireMixedCase(true);
    $checkPwd->requireNumbers(1);
    $checkPwd->requireSymbols(1);
    if ($checkPwd->check()) {
        $result1 = ['Password OK'];
    } else {
        $result2 = $checkPwd->getErrors();
    }

    //get errors   
    $errors = array_merge($errors1, $result2);
     
     if (empty($errors1)) {
	    $save = $crud->change_password($old_password, $password);
	 }
	if ($save) {
	   echo $save;
    }	
}
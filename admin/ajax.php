<?php

include 'admin_class.php';

$action = $_GET['action'];

if (isset($_GET['id'])) {
   $itemId = (int) $_GET['id'];
}

$crud = new Action();

if ($action == 'register') {
	$register = false;

	//sanitize, validate and filter user input
	$name = $_POST['name'];
	$name = $crud->validateName($name, 'name');
 
	$username = $_POST['username'];
	$username = $crud->validateUsername($username, 'username');
 
	$email = $_POST['email'];
	$email = $crud->validateEmail($email, 'email');
 
	$u_pass1 = $_POST['password'];
	$u_pass2 = $_POST['password_confirmation'];
	$password = $crud->validatePassword($u_pass1, $u_pass2, 'password', 'password_confirmation');
	
   //get errors 
   $errors = $crud->getErrors();
 
}

//call register function 
if ($action == 'register') {
	
	//call function if errors are empty
	if (empty($errors)) {
		$register = $crud->registerUser($name, $username, $email, $password);
	} else {
		foreach ($errors as $error) {
			echo $error;
		}		
	}
	if ($register) {
		echo 'registered. redirecting to login page.';
		?>
        <meta http-equiv="refresh" content="3;url=../login.php" />
        <?php
	}
		//header("location:http://localhost:8080/blog_site/admin/login.php");
}


//call login function
if ($action == 'login') {	
	$login = false;

	$errors = $crud->getErrors();

	//check if empty and store error in $errors ????
	$emailUsername = $crud->safe($_POST['emailUsername']);
	$password = $crud->safe($_POST['password']);
 
 //check if input is empty
 if (empty($_POST['emailUsername']) || empty($_POST['password'])) {
	 $error = 'Username/Password is missing';
 }
 
 
 //call function if errors are empty
 if (empty($error)) {
	$login = $crud->login($emailUsername, $password);
 } else {
	 foreach ($errors as $err) {
		echo $err;
	 }	
	 echo $error.'<br>';	
 }
 if($login) {
 
	 echo 'logging in..';
 }
	
}


if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_settings'){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == 'save_category'){
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
	$remove = $crud->remove_category();
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

if ($action == 'save_author') {
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
 }
 
}



if ($action == 'save_post') {
	$save = $crud->save_post();
	if ($save) {
	   echo $save;
	   /*$response = json_decode($save, true); 
	   if ($response['status'] == 1) {
		   echo "<script>
		      alert_toast('Data successfully updated.','success');
				        	setTimeout(function(){
				        	location.replace('index.php?page=posts)

				        },1500) 
				        </script>";
	    }*/
    }

	
}
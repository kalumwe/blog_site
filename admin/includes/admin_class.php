<?php
/** admin class **/

define('ERROR_LOG','C:/Temp/logs/errors.log');
try { 

$Errors = [];

Class Action {
	private $db;
	protected $img_max_size = 700500;
	protected array $errors = [];
	protected  $permitted = [
		'image/gif',
		'image/jpeg',
		'image/pjpeg',
		'image/png',
		'image/webp'
	  ];

	//constructor 
	public function __construct() {
   	    include 'db_connect.php';
        $conn = dbConnect('master','pdo');
        $this->db = $conn;
	}

	//destructor
	function __destruct() {
	    $this->db = null;
	}

    //get errors function
	public function getErrors() {
		return $this->errors;
	}

	//validate and sanitize 'name' value
	public function validateName($name, $fieldname) {
		$name = trim($this->safe($_POST[$fieldname]));         
		if ((!empty($name)) && (preg_match('/[a-z\-\s\']/i',$name)) && (strlen($name) <= 45)) {                   
		   //Sanitize the trimmed last name
		  $name = filter_var( $_POST[$fieldname], FILTER_SANITIZE_STRING);
		  $name = (filter_var($name, FILTER_SANITIZE_STRIPPED));           
		} else {    
		   $this->errors[] = 'Last name missing or not alphabetic, dash, quote or space, Max 30.';
		  // return false;
		}
		return $name; 
	}

	//validate and sanitize 'first name' value 
	public function validateFirstname($first_name, $fieldname) {
		$first_name = trim($this->safe($_POST[$fieldname]));           
		if ((!empty($first_name)) && (preg_match('/[a-z\s]/i',$first_name)) && (strlen($first_name) <= 75)) {               
			//Sanitize the trimmed first name
			$first_name = filter_var( $_POST[$fieldname], FILTER_SANITIZE_STRING);
			$first_name = (filter_var($first_name, FILTER_SANITIZE_STRIPPED));   
		} else {    
			$this->errors[] = 'First Name missing or not alphabetic and space characters, Max 30.';
		   // return false;
		}
		return $first_name;

	}

   //validate and sanitize 'last name' value
	public function validateLastname($last_name, $fieldname) {
		$last_name = trim($this->safe($_POST[$fieldname]));         
		if ((!empty($last_name)) && (preg_match('/[a-z\-\s\']/i',$last_name)) && (strlen($last_name) <= 75)) {                   
		   //Sanitize the trimmed last name
		  $last_name = filter_var( $_POST[$fieldname], FILTER_SANITIZE_STRING);
		  $last_name = (filter_var($last_name, FILTER_SANITIZE_STRIPPED));           
		} else {    
		   $this->errors[] = 'Last name missing or not alphabetic, dash, quote or space, Max 30.';
		  // return false;
		}
		return $last_name; 
	}

	//validate and sanitize 'username' value
	public function validateUsername($username, $fieldname) {
		$username = trim($this->safe($_POST[$fieldname]));   
		if ((!empty($username)) && (preg_match('/^[-_\p{L}\d]+$/ui',$username)) && (strlen($username) <= 15)) {              
		   //Sanitize the trimmed first name
		   $username = filter_var( $_POST[$fieldname], FILTER_SANITIZE_STRING);
		   $username = (filter_var($username, FILTER_SANITIZE_STRIPPED));               
		} else { 
		   $this-> errors[] = "field is empty";
		   $this->errors[] .= 'Or must contain Only alphanumeric characters, hyphens, and underscores are permitted in username.';
		   //return false;
		}
		return $username;
	}

	//validate and sanitize 'email' value
	public function validateEmail($email, $fieldname) {
		$email = trim($_POST[$fieldname]);
		if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
			$this->errors[] = 'You forgot to enter your email address';
			$this->errors[] .= ' or the e-mail format is incorrect.';
		   // return false;
		} else {
		   $email = filter_var( $_POST[$fieldname], FILTER_SANITIZE_EMAIL);
		}
		return $email;
	}

	//validate and sanitize 'password' value
	public function validatePassword($u_pass1, $u_pass2, $fieldname1, $fieldname2) {
		$u_pass1 = trim($this->safe($_POST[$fieldname1]));
		$u_pass1 = filter_var($_POST[$fieldname1], FILTER_SANITIZE_STRING);
		$u_pass1 = (filter_var($u_pass1, FILTER_SANITIZE_STRIPPED));
		$string_length = strlen($u_pass1);    

		if (empty($u_pass1) && ($string_length > 50)) {   
		   $this->errors[] = 'Please enter a valid password.';
		   return false;
		 } else {
			if (!preg_match( '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,12}$/', $u_pass1)) {            
			   $this->errors[] = 'Invalid password, 8 to 12 chars, one upper, one lower, one number, one special.';
			   return false;
			} else {
		  $u_pass2 = trim($this->safe($_POST[$fieldname2]));
		  $u_pass2 = filter_var( $_POST[$fieldname2], FILTER_SANITIZE_STRING); 

		  if($u_pass1 === $u_pass2) { 
			 $password = $u_pass1;
			 return $password;
		   } else {
			   $this->errors[] = 'Your two password do not match.';
			   $this->errors[] .= 'Please try again.';
			   return false;
		   }
	   }
	  }

	}

	 //function to sanitize value or input 
	 public function safe($text) {
		$text = trim($text);                     
		return htmlspecialchars($text, ENT_COMPAT|ENT_HTML5, 'UTF-8', false);
		}

	//function to register users
    public function registerUser($first_name, $last_name, $username, $email, $password) {
			//$password=md5($password);
			
			   $sql="SELECT * FROM users WHERE username=:uname OR email=:email";
			   $stmt = $this->db->prepare($sql);
			   // bind parameters and insert the details into the database
			   $stmt->bindParam(':uname', $username, PDO::PARAM_STR);
			   $stmt->bindParam(':email', $email, PDO::PARAM_STR);
			   $stmt->execute();

			//insert data if email doesn't exist
			if ($stmt->rowCount() == 0) {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT); 					
			  // $sql1="INSERT INTO users (first_name, last_name, u_name, email, pass, street, zip, state, country, tel) 
			  // VALUES (:firstname, :lastname, :uname, :uemail,  AES_ENCRYPT(:pwd, :ky), :addrss, :zcode, :cty, :cntry, :phne)";

			   $sql1="INSERT INTO users (first_name, last_name, username, email, password) 
			   VALUES (:fnme, :lnme, :uname, :uemail, :pwd)";
			   $stmt = $this->db->prepare($sql1);
			   // bind parameters and insert the details into the database
			   $stmt->bindParam(':uname', $username, PDO::PARAM_STR);
			   $stmt->bindParam(':uemail', $email, PDO::PARAM_STR);
			   $stmt->bindParam(':pwd', $hashed_password, PDO::PARAM_STR);
			   // $stmt->bindParam(':ky', $KEY, PDO::PARAM_STR);
			   $stmt->bindParam(':fnme', $first_name, PDO::PARAM_STR);
			   $stmt->bindParam(':lnme', $last_name, PDO::PARAM_STR);
			   $result= $stmt->execute();
			   $id = $this->db->lastInsertId();
				//return $result;
				// Close the PDO connection at the end of the script or when it's no longer needed
				$this->db = null;			  
			} else {  
					$this->errors[] = htmlentities($email) .' is already in use.
					        Please choose another username.';
					header("Content-Type: application/json");
				    return json_encode(array('status'=>2, 'message'=>htmlentities($username) . " or " 
					        . htmlentities($email) ." is already in use. Please choose another username."));
			}

			if ($result) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"User registered succesfully"));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t register user. Please try again.'));
			}

		}

		public function updateUser($firstname, $lastname, $username, $uemail) {
			extract($_POST);
			if ($_FILES['img']['tmp_name'] != '') {
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				//check image size and file name length
				if (($_FILES['img']['size'] > $this->img_max_size) || (strlen($fname) > 100)) {
                    header("Content-Type: application/json");
				    return json_encode(array('status'=>0, 'message'=>'Can\'t update details. Image size/name too large.'));
				}
				//allow image type only
				if (!in_array($_FILES['img']['type'], $this->permitted)) {
					header("Content-Type: application/json");
				    return json_encode(array('status'=>0, 'message'=>'Can\'t update details. Not Image type.'));
				}
				$move = move_uploaded_file($_FILES['img']['tmp_name'], "C:/xampp/htdocs/blog_site/admin/assets/img/". $fname); 				
			 }          
			    //get old profile pic file name to delete after new one updated
				$sql = "SELECT profile_picture FROM users WHERE id =:id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();
				$oldFilename = $row['profile_picture'];
				
			$sql = "UPDATE users SET first_name=:fname, last_name=:lname, email=:email, username=:uname, profile_picture=:pic WHERE id=:id";
			$stmt = $this->db->prepare($sql);
			if (isset($fname)) {
				$stmt->bindParam(':pic', $fname, PDO::PARAM_STR);
				//delete old image 
				$imagePath = "C:/xampp/htdocs/blog_site/admin/assets/img/".$oldFilename;
				if (file_exists($imagePath)) {
	                unlink($imagePath);
				}	
			} else {
				// set image_id to NULL
				$stmt->bindParam(':pic', $oldFilename, PDO::PARAM_STR);
			}
			//$insert  = $this->db->query($sql);
			$stmt->bindParam(':fname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lastname, PDO::PARAM_STR);
			$stmt->bindParam(':uname', $username, PDO::PARAM_STR);
			$stmt->bindParam(':email', $uemail, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$update = $stmt->execute();

			if ($update) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"Details updated succesfully"));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t update details. Please try again.'));
			}
			$this->db = null;
	        
	  }
	
	public function change_password($oldpassword, $newpassword) {
		extract($_POST);
		$result = false;
		$sql = "SELECT password FROM users WHERE ( id=:uid )";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':uid', $id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		$count_row = $stmt->rowCount(); 
		//proceed to change password if current password is correct
		if (($count_row == 1) && password_verify($oldpassword, $row['password'])) {
			$hashed_passcode = password_hash($newpassword, PASSWORD_DEFAULT);
			$sql = "UPDATE users SET password=:pwd WHERE id=:uid";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':uid', $id, PDO::PARAM_INT);
			$stmt->bindParam(':pwd', $hashed_passcode, PDO::PARAM_STR);
			$result = $stmt->execute();
			$changed = $stmt->rowCount();

			if ($changed == 1) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"Password changed succesfully"));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t change password. Please try again.'));
			}                
		 } else {
			header("Content-Type: application/json");
				return json_encode(array('status'=>2, 'message'=>'Username and/or Password is incorrect.'));
		        $this->errors[] = "Username and/or Password is incorrect.";

		 }
		 return $result;
		 // Close the PDO connection at the end of the script or when it's no longer needed
		 $this->db = null;

	}

	public function login($emailusername, $password) {		
		//$KEY = 'Trav3lw@rldwitTh@nd33';
		//$sql = "SELECT user_id, u_name, email, user_level, AES_ENCRYPT(pass, :ky) AS pwd from users
		// WHERE (email=:emailuser OR u_name=:emailuser) AND pass = AES_ENCRYPT(:pwd, :ky)";
		$sql = "SELECT id, username, CONCAT(first_name, ' ', last_name) AS name, email, password, user_type FROM users WHERE email=:emailuser OR username=:emailuser";
		$stmt = $this->db->prepare($sql);
		//$stmt->execute([$emailusername, $emailusername, $password, $KEY]);
		$stmt->bindParam(':emailuser', $emailusername, PDO::PARAM_STR);              
		//$stmt->bindParam(':pwd', $password, PDO::PARAM_STR);
		//$stmt->bindParam(':ky', $KEY, PDO::PARAM_STR);
		$stmt->execute();
		$user_data = $stmt->fetch();
		$count_row = $stmt->rowCount(); 

		//set session variables if login is successful
		if ($count_row > 0) {
			if (password_verify($password, $user_data['password'])) {
				session_start();
				$_SESSION['login'] = true;
				$_SESSION['userId'] = $user_data['id'];
				$_SESSION['name'] = $user_data['name'];
				$_SESSION['username'] =  $user_data['username'];
				$_SESSION['email'] =  $user_data['email'];
				$_SESSION['user_type'] =  $user_data['user_type'];
				$_SESSION['start'] = time();
				$_SESSION['sessionId'] = session_regenerate_id();
				//$url = ($_SESSION['user_type'] == 1) ? '//localhost:8080/blog_site/admin/index.php' : '//localhost:8080/blog_site/index.php';
				//$redirect = header('Location: ' . $url);
				//return $redirect;   
				if ($_SESSION['user_type'] == 1) {
					$url = "//localhost:8080/blog_site/admin/index.php";
				    header("Content-Type: application/json");
			        return json_encode(array('status'=>1, 'url'=>$url));
				} else {
					$url = "//localhost:8080/blog_site/index.php";
				    header("Content-Type: application/json");
			        return json_encode(array('status'=>1, 'url'=>$url));
				}
			} else {
				//$this->errors[] = "Username, email is incorrect.";
				//$this->errors[] .= "Or password is incorrect";
				$errors = "Username/email or password is incorrect.";
				header("Content-Type: application/json");
			    return json_encode(array('status'=>0, 'message'=>$errors));
				//$this->errors[] = 'Perhaps you need to register, click the Register ';
			}
		} else {
			//$this->errors[] = "Username Or email is incorrect";
			//$this->errors[] .= "Or password is incorrect";
			//$this->errors[] .= 'Perhaps you need to register, just click the Register ';
			$errors = "Username/email or password is incorrect.";
			$errors .= ' Perhaps you need to register. ';
			header("Content-Type: application/json");
			return json_encode(array('status'=>0, 'message'=>$errors));
		}
		$this->db = null;

	}

	//get session variable 'login'
	public function get_session() {
        $_SESSION['login'] = true;
		$loggedIn = $_SESSION['login'];
		return $loggedIn;
	}

	//logout function
	public function logout() {
		$_SESSION['login'] = false;
		$_SESSION = [];
		// invalidate the session cookie
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), "", time()-86400, '/');
		}
		session_destroy();
		header("location://localhost:8080/blog_site/login.php");
	}
	
	function save_settings(){
		extract($_POST);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		$data = " site_name = '".$this->safe($site_name)."' ";
		$data .= ", email = '".$this->safe($email)."' ";
		$data .= ", about = '".htmlentities(str_replace("'","&#x2019;",$content))."' ";
		$data .= ", contact = '".$this->safe($contact)."' ";
		$chk = $this->db->query("SELECT * from site_settings ");
		if($chk->rowCount() > 0){
			$id = $chk->fetch()['id'];
			$save = $this->db->query("UPDATE site_settings SET ".$data." WHERE id = ".(int) $id);
			if ($save) {
				header("Content-Type: application/json");
			    return json_encode(array('status'=>1, 'message'=>"Site settings updated successfuly"));
			}
		} else {
			//echo "INSERT INTO site_settings set ".$data;
			$save = $this->db->query("INSERT INTO site_settings SET ".$data);
			if ($save) {
				header("Content-Type: application/json");
			    return json_encode(array('status'=>1, 'message'=>"Site settings added successfuly"));
			}
		}
		$this->db = null;
	}
 
	//save category function
	function save_category(){
		extract($_POST);
		if(empty($id)){
			$chk = $this->db->query("SELECT * FROM category WHERE name ='".$name."' ")->rowCount();
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Category already exist'));
			}else{
				$save = $this->db->query("INSERT INTO category SET name='".$name."' , description ='".$description."' ");
				if($save)
					return json_encode(array('status'=>1,'msg'=>'Category Added'));
			}
		} else {
			$chk = $this->db->query("SELECT * from category WHERE name ='".$name."' and id !='".$id."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Category already exist'));
			}else{
				$save = $this->db->query("UPDATE category set name='".$name."' , description ='".$description."' WHERE id=".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
		}
		$this->db = null;
	}

	public function load_postCategory() {
		$qry = $this->db->query("SELECT p.*, a.profile_picture, c.name AS category, DATE_FORMAT(p.date_published, '%b %D \'%y') AS published, 
		 CONCAT(a.first_name, ' ', a.last_name) AS author_name FROM posts p INNER JOIN category c ON c.id = p.category_id 
		 INNER JOIN author a ON a.id = p.author_id "); 
		$data = array();
		//while ($row=$qry->fetch()) {
		//	$data[] = $row;
		//}
		$row=$qry->fetch();		
		return $row;
   }

   //get total posts function
   public function getTotalPosts () {
	// prepare SQL to get total records
       $getTotal = 'SELECT COUNT(*) FROM posts';

    // submit query and store result as $totalPix
       $total = $this->db->query($getTotal);
       return $total->fetch()[0];
	   $this->db = null;
   }

    //get total authors function
	public function getTotalAuthor () {
		// prepare SQL to get total records
		   $getTotal = 'SELECT COUNT(*) FROM author';
	
		// submit query and store result as $totalPix
		   $total = $this->db->query($getTotal);
		   return $total->fetch()[0];
		   $this->db = null;
	   }

   //get total categories function 
   public function getTotalCategory () {
	// prepare SQL to get total records
       $getTotal = 'SELECT COUNT(*) FROM category';

    // submit query and store result as $totalPix
       $total = $this->db->query($getTotal);
       return $total->fetch()[0];
	   $this->db = null;
   }

   //get total comments function
   public function getTotalComments () {
	// prepare SQL to get total records
       $getTotal = 'SELECT COUNT(*) FROM comments';

    // submit query and store result as $totalPix
       $total = $this->db->query($getTotal);
       return $total->fetch()[0];
	   $this->db = null;
   }

   //get total Users function
   public function getTotalUsers () {
	// prepare SQL to get total records
       $getTotal = 'SELECT COUNT(*) FROM users';
    // submit query and store result as $totalPix
       $total = $this->db->query($getTotal);
       return $total->fetch()[0];
	   $this->db = null;
   }

	function load_category(){
		$qry = $this->db->query("SELECT * from category WHERE status = 1");
		$data = array();
		while($row=$qry->fetch_assoc()){
			$data[] = $row;
		}
		echo json_encode($data);
	}

	function load_post(){
		$qry = $this->db->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id ");
		$data = array();
		while($row=$qry->fetch_assoc()){
			$data[] = $row;
		}
		echo json_encode($data);
	}

	function remove_category($item_id){
		extract($_POST);
		$item_id = (int) $item_id;
		$remove = $this->db->query("UPDATE category SET status = 0 WHERE id =".$item_id);
		if ($remove)
			return 1;
			$this->db = null;
	}

	//function to publish post
	function publish_post($Item_id){
		extract($_POST);
		$Item_id = (int) $Item_id;
		$date = date('Y-m-d H:i'); 
		$sql = "UPDATE posts SET status = 1, date_published = '$date' WHERE id =$Item_id";
		$publish = $this->db->query($sql);
		if ($publish)
			return 1;
			$this->db = null;
	}

	//function to delete post
	function remove_post($id){
		extract($_POST);
		$id = (int) $id;
		//get old profile pic file name to delete after new one updated
		$sql = "SELECT img_path FROM posts WHERE id =:id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		if ($row['img_path'] != null) {
		   $oldFilename = $row['img_path'];
		}
		//delete old image 
		$imagePath = "C:/xampp/htdocs/blog_site/assets/img/".$oldFilename;
		if (file_exists($imagePath)) {
			unlink($imagePath);
		}
		$remove = $this->db->query("DELETE FROM posts WHERE id =".$id);
		if ($remove)
			return 1;
			$this->db = null;
	}

	//function to delete author
	function remove_author($item_id) {
		extract($_POST);
		$item_id = (int) $item_id;
		//get old profile pic file name to delete after new one updated
		$sql = "SELECT profile_picture FROM author WHERE id =:id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $item_id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		if (!empty($row['profile_picture'])) {
		   $oldFilename = $row['profile_picture'];
		
		   //delete old image 
		   $imagePath = "C:/xampp/htdocs/blog_site/admin/assets/img/".$oldFilename;
		   if (file_exists($imagePath)) {			
			  unlink($imagePath);
		    }
	    }		
		$sql1 = "DELETE FROM post_author WHERE author_id =$item_id";
		$this->db->query($sql1);
		$sql2 = "DELETE FROM author WHERE id =$item_id";
		$remove = $this->db->query($sql2);
		if ($remove) {
			return 1;
		}
		$this->db = null;
	}

	//function to save new author and update
	public function save_author() {
		extract($_POST);
		$data = " first_name = :fname ";
		$data .= ", last_name = :lname ";
		
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
		    if(isset($fname)) {
			   $fname = $this->safe($fname);
		    }
			if (!in_array($_FILES['img']['type'], $this->permitted)) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>' Not Image type.'));
			}
			if (($_FILES['img']['size'] > $this->img_max_size) || (strlen($fname) > 100)) {
			   header("Content-Type: application/json");
			   return json_encode(array('status'=>0, 'message'=>'Image size/name too large.'));
			}
		    $move = move_uploaded_file($_FILES['img']['tmp_name'], "C:/xampp/htdocs/blog_site/admin/assets/img/". $fname);
		    $data .= ", profile_picture = :pic ";	
            
		} else {
			$data .= ", profile_picture = :pic ";
		}

		if (empty($id)) {
			//insert data
			$sql = "INSERT INTO author SET ".$data;
			$stmt = $this->db->prepare($sql);
			if ($_FILES['img']['tmp_name'] != '') {
				$stmt->bindParam(':pic', $fname, PDO::PARAM_STR);
			} else {
				// set image_id to NULL
				$stmt->bindValue(':pic', NULL, PDO::PARAM_NULL);
			}
			//$insert  = $this->db->query($sql);
			$stmt->bindParam(':fname', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $last_name, PDO::PARAM_STR);
			$insert = $stmt->execute();

			$authorId = $this->db->lastInsertId();
			$authorId = (int) $authorId;
			foreach ($name as $post_id) {
				if (is_numeric($post_id)) {
					$values[] = "($authorId, " . (int) $post_id . ')';
					//$post_id = (int) $post_id;
				}
			}
            if ($values)  {
			   //$sql = "UPDATE posts SET author_id = $authorId WHERE id=$name";
			    $sql = "INSERT INTO post_author (author_id, post_id) VALUES ". implode(',', $values);
			    $query = $this->db->query($sql);
			}

			if ($insert) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$authorId, 'message'=>'Author added succesfully', 
				                'url'=>"//localhost:8080/blog_site/admin/index.php?page=author"));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t add author. Please try again.'));
			}

		} else {
			//else update data
			$id = (int) $id;
			$date = date('Y-m-d H:i');
			//retrieve image path
			$sql  = "SELECT profile_picture FROM author WHERE id=$id";
			$query = $this->db->query($sql);
			$row = $query->fetch();	
			$oldFilename = $row['profile_picture'];
			
			//$update  = $this->db->query("UPDATE author set".$data." , date_published='".date('Y-m-d H:i')."' WHERE id=".$id);
			$sql = "UPDATE author SET first_name=:fname, last_name=:lname, profile_picture=:pic, updated_at=:pdate WHERE  id=:id";
			$stmt = $this->db->prepare($sql);
			if ($_FILES['img']['tmp_name'] != '') {
				$stmt->bindParam(':pic', $fname, PDO::PARAM_STR);
				//delete old image 
			    $imagePath = "C:/xampp/htdocs/blog_site/admin/assets/img/".$oldFilename;
			    if (file_exists($imagePath)) {
				 unlink($imagePath);
			   }
			} else {
				// set image_id to NULL
				$stmt->bindParam(':pic', $oldFilename, PDO::PARAM_STR);
			}
			//$insert  = $this->db->query($sql);
			$stmt->bindParam(':fname', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $last_name, PDO::PARAM_STR);
			$stmt->bindParam(':pdate', $date, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$update = $stmt->execute();
	        
			if (!empty($name) && is_array($name)) {
			$updated_posts = $name;
			}
			//retrieve existing post values
			$sql_existing_posts = "SELECT post_id FROM post_author WHERE author_id=$id";
			$result = $this->db->query($sql_existing_posts);
			$existing_posts = [];
			while ($row = $result->fetch()) {
				$existing_posts[] = $row['post_id'];
			}
			//compare existing and updated post_id values
			$posts_remove = array_diff($existing_posts, $updated_posts);
			$posts_add = array_diff($updated_posts, $existing_posts);
			//remove rows 
			foreach ($posts_remove as $post_id) {
				$sql_remove = "DELETE FROM post_author WHERE author_id=$id AND post_id=$post_id";
				$this->db->query($sql_remove);
			}		
			//add rows 
			foreach ($posts_add as $post_id) {
				$sql_add = "INSERT INTO post_author (author_id, post_id)VALUES ($id, $post_id)";
				$this->db->query($sql_add);
			}

			if ($update) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"Author updated succesfully",
				                       'url'=>"//localhost:8080/blog_site/admin/index.php?page=author"));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t update author. Please try again.'));
			}
		}		
		$this->db = null;		
		
	}

	//function to save new post creation and update
	public function save_post() {
		extract($_POST);
		$date = date('Y-m-d H:i');		
		$data = " title = :ttle ";
		$data .= ", post = :pst ";
		$data .= ", category_id = :cat_id ";
		$data .= ", author_id = :authId ";
		$data .= ", date_published = :pdate ";

		$name = $this->safe($name);
		//$post = htmlentities(str_replace("'","&#x2019;",$post));
		if (!empty($post)) {
		   $post = $this->safe($post);
		} else {
			header("Content-Type: application/json");
			return json_encode(array('status'=>0, 'message'=>'post field missing'));
		}
		$category_id = (int) $category_id;
		$date = $this->safe($date);
		
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
		    if(isset($fname)) {
			   $fname = $this->safe($fname);
		    } 
			if (!in_array($_FILES['img']['type'], $this->permitted)) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t update details. Not Image type.'));
			 }
			 if (($_FILES['img']['size'] > $this->img_max_size) || (strlen($fname) > 100)) {
			   header("Content-Type: application/json");
			   return json_encode(array('status'=>0, 'message'=>'Can\'t update details. Image size/name too large.'));
			 }
		   $move = move_uploaded_file($_FILES['img']['tmp_name'], "C:/xampp/htdocs/blog_site/assets/img/". $fname);
		   $data .= ", img_path = :imgpath ";
		   
		} else {
			$data .= ", img_path = :imgpath ";
		}
			
		if (empty($id)) {
			//insert data
			$post = htmlentities(str_replace("'","&#x2019;",$post));	    
			if (!empty($last_name) || !empty($first_name)) {
				$firstName = $this->safe($first_name);
		        $lastName = $this->safe($last_name);
			   $sql = "INSERT INTO author SET first_name= :fname, last_name=:lname";
			   $stmt = $this->db->prepare($sql);
			   $stmt->bindParam(':fname', $firstName, PDO::PARAM_STR);
               $stmt->bindParam(':lname', $lastName, PDO::PARAM_STR);
			   $stmt->execute();
			   $authorId = $this->db->lastInsertId();
			}
			if (!empty($author_id)) {
				$authorId = (int) $author_id;
			}						
			$sql = "INSERT INTO posts SET ".$data;
			$stmt = $this->db->prepare($sql);
			if (isset($authorId)) {
				$stmt->bindParam(':authId', $authorId, PDO::PARAM_INT);
			} else {
				// set image_id to NULL
				$stmt->bindValue(':authId', NULL, PDO::PARAM_NULL);
			}
			//$insert  = $this->db->query($sql);
			if (isset($fname)) {
				$stmt->bindParam(':imgpath', $fname, PDO::PARAM_STR);
			} else {
				// set image_id to NULL
				$stmt->bindValue(':imgpath', NULL, PDO::PARAM_NULL);
			}
            $stmt->bindParam(':ttle', $name, PDO::PARAM_STR);
            $stmt->bindParam(':pst', $post, PDO::PARAM_STR);
            $stmt->bindParam(':cat_id', $category_id, PDO::PARAM_INT);
			$stmt->bindParam(':pdate', $date, PDO::PARAM_STR);
            // execute query
            $insert = $stmt->execute();
            $id = $this->db->lastInsertId();

			if ($insert) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"Post added succesfully",
				                         'url'=>"//localhost:8080/blog_site/admin/index.php?page=preview_post&id=".$id.""));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t add post. Please try again.'));
			}			
		} else {
			//else update data
			$id = (int) $id;
			//get old profile pic file name to delete after new one updated and id
			$sql  = "SELECT img_path, author_id FROM posts WHERE id=".$id;
			$query = $this->db->query($sql);
			$row = $query->fetch();
			if ($row['img_path'] != null) {
				$oldFilename = $row['img_path'];
			 } 
			 $authorId = $row['author_id'];
	    
			 //update author table
			if (!empty($last_name) || !empty($first_name)) {
			   $firstName = $this->safe($first_name);
		       $lastName = $this->safe($last_name);
			   $sql = "UPDATE author SET first_name= :fname, last_name=:lname WHERE id=".$authorId;
			   $stmt = $this->db->prepare($sql);
			   $stmt->bindParam(':fname', $firstName, PDO::PARAM_STR);
               $stmt->bindParam(':lname', $lastName, PDO::PARAM_STR);
			   $stmt->execute();
			   //$authorId = $this->db->lastInsertId();
			}

			//get selected id
			if (!empty($author_id)) {
				$authorId = (int) $author_id;
				$id = (int) $id;
				$sql = "UPDATE posts SET author_id=$authorId WHERE id=$id";
				$query = $this->db->query($sql);

			}									
			$sql  = "UPDATE posts SET title=:ttle, post=:pst, category_id = :cat_id, img_path = :imgpath WHERE id=:id";			
			$stmt = $this->db->prepare($sql);
			if ($_FILES['img']['tmp_name'] != '') {
				$stmt->bindParam(':imgpath', $fname, PDO::PARAM_STR);
				//delete old image 
			    $imagePath = "C:/xampp/htdocs/blog_site/assets/img/".$oldFilename;
			    if (file_exists($imagePath)) {
	               unlink($imagePath);
			    }
			} else {
				// set image_id to current 
				$stmt->bindParam(':imgpath', $oldFilename, PDO::PARAM_STR);
			}
			//$insert  = $this->db->query($sql);
			//$stmt->bindParam(':imgpath', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':ttle', $name, PDO::PARAM_STR);
            $stmt->bindParam(':pst', $post, PDO::PARAM_STR);
            $stmt->bindParam(':cat_id', $category_id, PDO::PARAM_INT);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // execute query
            $update = $stmt->execute();
			if ($update) {
				header("Content-Type: application/json");
				return json_encode(array('status'=>1, 'id'=>$id, 'message'=>"Post updated succesfully",
				                         'url'=>"//localhost:8080/blog_site/admin/index.php?page=preview_post&id=".$id.""));
			} else {
				header("Content-Type: application/json");
				return json_encode(array('status'=>0, 'message'=>'Can\'t update post. Please try again.'));
			}
		}
		$this->db = null;
		
	}

}


} catch (PDOException $e) {
	$Errors = $e->getMessage();
	$Errors = "Data can't be retrieved";
	// print "An Exception occurred. Message: " . $e->getMessage();
	//print "The system is busy please again try later";
	//$date = date('m.d.y h:i:s');                
	//$eMessage = $date . " | Exception Error | ,"  . $errormessage . ". |\n";
	// error_log($eMessage,3,ERROR_LOG);
	// e-mail support person to alert there is a problem
	//error_log("Date/Time: $date - Exception Error, Check error log for
	//details", 1, kalukav55@gmail.com.com, "Subject: Exception Error \nFrom:
	//Error Log <kalukav55@gmail.com>" . "\r\n");

} catch (PDOError $e) {
	$Errors = $e->getMessage();
	$Errors = "Data cannot be retrieved";
	// print "An Error occurred. Message: " . $e->getMessage();
	// print "The system is busy please try later";
	// $date = date('m.d.y h:i:s');        
	 //$eMessage = $date . " | Error |  , " . $errormessage . ". |\n";
	// error_log($eMessage,3,ERROR_LOG);
	// e-mail support person to alert there is a problem
	// error_log("Date/Time: $date - Error, Check error log for
	//", 1, kalukav55@gmail.com, "Subject: Error \nFrom: Error Log
	// <kalukav55@gmail.com>" . "\r\n");
	//mail($to, $subject, $message);

}
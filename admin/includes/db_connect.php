<?php


function dbConnect($usertype, $connectionType = 'mysqli') {
    $host = 'localhost';
    $db = 'blog_db';
    $port = '3307';
    if ($usertype == 'read') {
        $user = 'psread';
        $pwd = 'K1yoMizu^dera';
    } elseif ($usertype == 'write') {
        $user = 'pswrite';
        $pwd = '0Ch@Nom1$u';
	} elseif ($usertype == 'master') {
        $user = 'kalumba';
        $pwd = 'C0ffeep0t';
    } else {
        exit('Unrecognized user');
    }
    if ($connectionType == 'mysqli') {
	try {
            $conn = @ new mysqli($host, $user, $pwd, $db, $port);
        if ($conn->connect_error) {
            exit($conn->connect_error);
        }
		return $conn;
	} catch(Exception $e) {
		echo $e->getMessage();
	}	
    } else {
		if ($connectionType == 'pdo') {
    try {
            return new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pwd);
    } catch (PDOException $e) {
            echo $e->getMessage();
			// print "An Exception occurred. Message: " . $e->getMessage();
                //print "The system is busy please again try later";
                // $date = date('m.d.y h:i:s');                
                // $eMessage = $date . " | Exception Error | " , $errormessage . |\n";
                // error_log($eMessage,3,ERROR_LOG);
                // e-mail support person to alert there is a problem
                // error_log("Date/Time: $date - Exception Error, Check error log for
                //details", 1, noone@helpme.com, "Subject: Exception Error \nFrom:
                // Error Log <errorlog@helpme.com>" . "\r\n");
    }
        }
	}
}
?>
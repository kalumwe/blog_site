<?php 

        //function to sanitize value or input 
         function safe($text) {
                $text = trim($text);               
                $bad_chars = array( "{", "}", "(", ")", ";", ":", "<", ">", "/", "$" );
                $text = str_ireplace($bad_chars, "", $text);        
                return htmlspecialchars($text, ENT_COMPAT|ENT_HTML5, 'UTF-8', false);
                }

       //validate and sanitize 'message' value
         function validateMessage($message) {
            $message = trim(safe($message)); 
            if ((!empty($message)) && (strlen($message) <= 500)) {
               // remove ability to create link in email
               $patterns = array("/http/", "/https/", "/\:/","/\/\//","/www./");
               $message = preg_replace($patterns," ", $message);
               $message = filter_var( $message, FILTER_SANITIZE_STRING);
               $message = (filter_var($message, FILTER_SANITIZE_STRIPPED));
            }
            return $message;
        }


  //validate and sanitize 'email' value
         function validateEmail($email) {
            $email = trim($email);
            $email = safe($email)        
            $email = filter_var( $email, FILTER_SANITIZE_EMAIL);
            //}
            return $email;
        }
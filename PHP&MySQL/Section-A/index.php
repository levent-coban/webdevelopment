<?php 

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $method = 'GET';
}elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = 'POST';
}

if ( $method == 'GET') {
    include __DIR__ . '/view/top.html';
    include __DIR__ . '/view/contentsubscribe.php';
    include __DIR__ . '/view/bottom.html';
}



if ( $method == 'POST') {

    require "config.php";

    include __DIR__ . '/view/top.html';


    /* === check is JavaScript enable =========================== */
    if (!isset($_POST['check'])) { 
        $javascript_not_enable = FALSE;
    }



    function input_clean($input_data) {
        $input_data = str_replace(' ', '', $input_data);
        $input_data = strtolower($input_data);
        $input_data = stripslashes($input_data);
        $input_data = htmlspecialchars($input_data);
        return $input_data;
    }
    
    function is_email_valid($emailstr){
        $exp = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
        if(preg_match($exp,$emailstr)){
            return true;
        }else{
            return false;
        }   
    }
    
    function isDotCo($email_str) {
        return substr($email_str, -3) === ".co";
    }
    
    $errors = array();

    $email = input_clean( $_POST["email"] );

    if( empty($email) ){
        $errors['email'] = '* Email address is required';
    } elseif ( !is_email_valid($email) ) {
        $errors['emailvalidation'] = '* Please provide a valid e-mail address';
    }

    if (is_email_valid($email) && isDotCo($email)) {
        $errors['isdotco'] = '* We are not accepting subscriptions from Colombia emails';
    }

    if ( !isset( $_POST['terms']) ) { 
        $errors['terms'] = '* You must accept the terms and conditions';
    } 

    /* ======================================================== */


    if( isset($errors) ){
        if(count($errors) > 0){
            include __DIR__ . '/view/contentsubscribe.php';
        } else {
            
            $addEmail = $email;

            try {
                $connection = new PDO($dsn, $username, $password, $options);
                $query = "INSERT INTO subscribers (email_address) VALUES (:email)";
                $statement = $connection->prepare($query);
                $statement->bindValue(':email', $addEmail, PDO::PARAM_STR);

                if($statement->execute()){
                    include __DIR__ . '/view/contentthank.html';
                } else {
                    $errors['insertError'] = 'An error occurred, please try again later';
                    include __DIR__ . '/view/contentsubscribe.php';
                }

            } catch(PDOException $e) {
                $errors['insertError'] = 'An error occurred, please try again later';
                include __DIR__ . '/view/contentsubscribe.php';
            }

            $connection = null; 
        }
    }

    include __DIR__ . '/view/bottom.html';

} 
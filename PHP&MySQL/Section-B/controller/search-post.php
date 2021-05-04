<?php 

$search = '';

if(isset($_POST['search'])) $search = $_POST['search'];

if ($search != '' || !empty($search)){
    
    require_once DOC_ROOT.'/database/dbconfig.php';

    try {

        $emailprovider = '';
        if(isset($_POST['email_provider'])) $emailprovider = $_POST['email_provider'];

        $sort_by = ' subscription_date DESC ';
        if(isset($_POST['sort_by'])) $sort_by = $_POST['sort_by'];

        if( $sort_by == 'sortbyname'){
            $sort_by = ' email_address ASC ';
        } elseif( $sort_by == 'sortbydate') {
            $sort_by = ' subscription_date DESC ';
        }

        if( $emailprovider  == 'all') {
            $query = "SELECT * FROM subscribers WHERE email_address REGEXP '~*" .   $search    . "' ORDER BY ".$sort_by;
        } else {
            $query = "SELECT * FROM subscribers WHERE email_address REGEXP '~*" .   $search    . "' AND email_address LIKE '%". $emailprovider . "%' ORDER BY ".$sort_by;
        }
        
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        $result = $connection->prepare( $query );
        $result->execute();

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    
}
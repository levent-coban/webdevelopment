<?php 

if ( METHOD != 'POST') NotFound();


if( isset($_POST['id']) && !empty($_POST['id']) ) {

    $ids = array();

    $id = $_POST['id'];

    foreach($id as $x){
        $ids[] = $x;
    }

    require_once DOC_ROOT.'/database/dbconfig.php';

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }  

    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=subscribers.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo 'email_id,email_adress,subscription_date' . "\n";

    foreach ($ids as $value){ 
        $query = "SELECT * FROM subscribers WHERE email_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $value, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_OBJ);
        echo $row->email_id.','.$row->email_address.','.$row->subscription_date."\n";
    }
    $connection = null;

} else {
    echo 'Selection is required! <br><br> <a href="/subscribers/sortbydate/all/1">Subscribers</a>';
}
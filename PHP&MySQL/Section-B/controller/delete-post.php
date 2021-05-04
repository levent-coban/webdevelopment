<?php 

if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    NotFound('404');
}

require_once DOC_ROOT.'/database/dbconfig.php';

try {

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $connection = new PDO($dsn, DB_USER, DB_PASS, $options);

    $email_id = $id;

    $query = "DELETE FROM subscribers WHERE email_id = :id";
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $email_id, PDO::PARAM_INT);
    $statement->execute();

    echo 'email deleted <br><br> <a href="/subscribers/sortbydate/all/1">Subscribers</a>';

} catch(PDOException $e) {
    echo $e->getMessage();
}

$connection = null;
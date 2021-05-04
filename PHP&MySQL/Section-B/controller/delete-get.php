<?php 

if(isset(explode('/', REQUEST)[2])) {
    $id = explode('/', REQUEST)[2];
} else {
    NotFound('404');
}


require_once DOC_ROOT.'/database/dbconfig.php';


try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch(PDOException $e) {
    echo $e->getMessage();
}


if ($id != '') {
    $checkId_query = 'SELECT count(*) FROM subscribers WHERE email_id=' . $id;
    $checkId_statement = $connection->prepare($checkId_query);
    $checkId_statement->execute();
    $checkId = $checkId_statement->fetch();
    if ($checkId[0] == 0) NotFound('404');
}


$email_id = $id;
$del_query = "SELECT * FROM subscribers WHERE email_id = :id";
$statement = $connection->prepare($del_query);
$statement->bindParam(':id', $email_id, PDO::PARAM_INT);
$statement->execute();

$row = $statement->fetch(PDO::FETCH_OBJ) ;

?>

<h1>Delete Confirmation</h1>

<h3>Are you sure to delete this email?</h3>

<br><br>

<div>
<table>
    <thead>
        <tr>
            <th>email_address</th>
            <th>subscription_date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $row->email_address; ?></td>
            <td><?php echo $row->subscription_date; ?></td>
        </tr>
    </tbody>
</table> 
</div>

<br><br><br>

<a href="/subscribers">CANCEL</a>

<br><br><br>

<form action="" method="POST">
  <input type="hidden" name="id" value="<?php echo $row->email_id; ?>">
  <input type="submit" value="DELETE">
</form>
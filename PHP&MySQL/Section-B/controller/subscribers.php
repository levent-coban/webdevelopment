<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ( isset($_POST['sort_by']) && isset($_POST['emailprovider']) ) {
        $location = 'subscribers/' . $_POST['sort_by'] . '/' . strtolower($_POST['emailprovider']) . '/1';
        header('Location: /' . $location);
    } 

}


define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','subscriptiondb');
define('RECORD_PER_PAGE', 10);



# sortby
if(!isset(explode('/', REQUEST)[2])) { 
    $sortby = 'sortbydate'; 
} else { 
    $sortby = explode('/', REQUEST)[2]; 
}

# emailprovider
if(!isset(explode('/', REQUEST)[3])) { 
    $emailprovider = 'all'; 
} else { 
    $emailprovider = explode('/', REQUEST)[3]; 
}

# page
if(!isset(explode('/', REQUEST)[4])) { 
    $page_number = 1; 
} else { 
    $page_number = explode('/', REQUEST)[4]; 
}


try {

    if( $sortby == 'sortbyname'){
        $sortby = ' email_address ASC ';
        $sortby_url = 'sortbyname';
    } else {
        $sortby = ' subscription_date DESC ';
        $sortby_url = 'sortbydate';
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $connection = new PDO($dsn, DB_USER, DB_PASS, $options);

    if ( $emailprovider  == 'all'){
        $total_record = $connection->query('SELECT * FROM subscribers')->rowCount();
    } else {
        $total_record = $connection->query("SELECT * FROM subscribers WHERE email_address LIKE '%@".$emailprovider."%'")->rowCount();
    }

    $current_page_no = $page_number;
    $record_per_page = RECORD_PER_PAGE;
    $total_page = ceil($total_record / $record_per_page);

    if ($current_page_no > $total_page) $current_page_no = $total_page;
    $limit = $record_per_page;
    $offset = ($current_page_no - 1) * $limit;

    if( $emailprovider  == 'all') {
        $query = 'SELECT * FROM subscribers ORDER BY ' .$sortby. ' LIMIT ' .$limit. ' OFFSET ' .$offset;
    } else {
        $query = "SELECT * FROM subscribers WHERE email_address LIKE '%@".$emailprovider."%' ORDER BY ".$sortby.' LIMIT '.$limit.' OFFSET '.$offset;
    }

    $statement = $connection->prepare($query);
    $statement->execute();


# email providers 
$email_providers_query = <<<'EOT'
SELECT (SUBSTRING_INDEX(SUBSTR(email_address, INSTR(email_address, '@') + 1),'.',1)) emaildomain
FROM  `subscribers` 
WHERE LENGTH(email_address) > 0
GROUP BY SUBSTRING_INDEX( email_address,  '@', -1 ) 
EOT;

    $email_providers_statement = $connection->prepare( $email_providers_query );
    $email_providers_statement->execute();

    } catch(PDOException $e) {
        echo $e->getMessage();
}
?>

<br><br>

<nav>

<?php echo '<a href="/">Homepage</a><br><br><a href="/search">Search</a><br><br>'?>

    <br><br>

    <div>
        <form action="" method="POST">

            Sort by: 
            <select name="sort_by">
                <option value="sortbydate">Date</option>
                <option value="sortbyname">Name</option>
            </select>

            <input type="submit" value="All" name="emailprovider">
            <?php 

            // email providers
            while( $email_providers = $email_providers_statement->fetch() ){
                echo '<input type="submit" value="'.$email_providers[0].'" name="emailprovider">';
            }

            ?>
        </form>
    </div>
</nav>

<br>

<table>
    <thead>
    <tr>
        <th>Select</th><th>Email Address</th><th>Subscription Date</th><th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <form action="/export-to-csv" method="POST">
    <span>To export as CSV </span><input type="submit" value="Click Here">
    <br><br><br>
        <?php while( $row = $statement->fetch(PDO::FETCH_ASSOC) ){ ?>
            <tr>
                <td>
                    <input type="checkbox" name="id[]" value="<?php echo $row["email_id"] ?>">
                </td>
                <td>
                    <label for="<?php echo $row["email_id"] ?>"><?php echo $row["email_address"] ?></label>
                </td>
                <td>
                    <?php echo $row["subscription_date"] ?>
                </td>
                <td>
                <a href="/delete/<?php echo $row["email_id"]?>" class="del_btn">DELETE</a>
                </td>
            </tr>
        <?php } ?>
        
    </form>
    </tbody>
</table>

<table>
    <tr>
        <?php  for ($i = 1; $i <= $total_page; $i++) { ?>
            <td>
                [ <a href="/subscribers/<?php echo $sortby_url . '/' . $emailprovider . '/' . $i  ?>">List <?php echo $i ?></a> ]
            </td>
        <?php } ?>
    </tr>
</table>
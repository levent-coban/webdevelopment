<?php 

if (METHOD == 'POST') {
    require_once DOC_ROOT.'/controller/search-post.php';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body>
<?php  echo '<a href="/">Homepage</a><br><br><a href="/subscribers">Subscribers</a><br><br><br><br>'; ?>
<form action="" method="post">

    <label for="search">Search:</label><br>
    <input type="search" id="search" name="search">

    <br><br>

    <select name="sort_by">
        <option value="sortbydate" selected="">Sort By Date</option>
        <option value="sortbyname">Sort By Name</option>
    </select>

    <br><br>

    <select name="email_provider">
        <option value="all" selected="">Filter All</option>
        <option value="gmail">Filter by Gmail</option>
        <option value="yahoo">Filter by Yahoo</option>
        <option value="outlook">Filter by Outlook</option>
    </select>

    <br><br>

    <input type="submit" value="Search">

</form>

<div>
<?php 

if (METHOD == 'POST') {
    if ($search != '' || !empty($search)){
        while( $row = $result->fetch(PDO::FETCH_ASSOC) ){
            echo $row['email_address'];
            echo '<br>';
        }
    } else {
        echo 'Search Box is EMPTY!';
    }
}

?>
</div>
</body>
</html>
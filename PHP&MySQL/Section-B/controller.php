<?php 

define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT'], true);
require_once DOC_ROOT.'/router/Router.php';
require_once DOC_ROOT.'/helpers/helpers.php';

$route = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 

define("REQUEST", $route->request, true); 
define("METHOD", $_SERVER['REQUEST_METHOD'], true); 
define("CONTROLLER", $route->controller(), true); 
 



# Index
if (controller == 'index') {
    echo '<h1>HomePage</h1><a href="/subscribers">Subscribers</a><br><br><a href="/search">Search</a>';
    exit();
}

# Subscribers
if (controller == 'subscribers') {
    include DOC_ROOT . '/controller/subscribers.php';
    exit();
}


# Delete
if (controller == 'delete') {
    include DOC_ROOT . '/controller/delete.php';    
    exit();
}


# Export to CSV
if (controller == 'export-to-csv') {
    include DOC_ROOT . '/controller/export-to-csv.php';
    exit();
}


# Search
if (controller == 'search') { 
    include DOC_ROOT . '/controller/search.php';   
    exit();
}

# If no match
NotFound();
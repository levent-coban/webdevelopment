<?php 
function redirect($path) {
    $location = 'Location: ' . $path;
    header("Expires: Tue, 01 Jan 2019 05:00:00 GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header($location);
}

function NotFound($e = null){
    echo '<a href="/subscribers/sortbydate/all/1">Subscribers</a><br><br>';
    http_response_code(404);
    if($e != null){ echo $e; } else {echo '404';}
    exit();
}
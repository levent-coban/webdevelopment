<?php 

if (METHOD == 'POST') {
    require_once DOC_ROOT.'/controller/delete-post.php';
    exit();
} 

require_once DOC_ROOT.'/controller/delete-get.php';
exit();

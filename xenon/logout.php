<?php
$_SESSION = array();
setcookie(DBNAME . "_admin_cookie", "", time()-3600*24);
@header('Location: index.php');
?>
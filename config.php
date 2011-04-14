<?php
$_PROFILES['D:/xampp/htdocs'] = '/zynga/_profiles/local.php';
$_PROFILES['/home/jumping4/public_html/titan'] = '/_profiles/live.php';

$root = $_SERVER['DOCUMENT_ROOT'];

if (file_exists($root.$_PROFILES[$root])){
	require_once($root.$_PROFILES[$root]);
}
else {

	exit('Your $_PROFILES array is wrong. Use '.$_SERVER['DOCUMENT_ROOT'].' as your doc root');
}


// library classes
$_AUTOLOAD[] = "_library/mimemail/";

// helper classes
$_AUTOLOAD[] = "_buttons/";
$_AUTOLOAD[] = "_messages/";
$_AUTOLOAD[] = "_tools/";

// framework classes
$_AUTOLOAD[] = "Application/";
$_AUTOLOAD[] = "Models/";
$_AUTOLOAD[] = "Controllers/";
?>
<?php 
session_start();  

require_once('Application/__autoload.php');
require_once('config.php');

if(site::debug)log::error("Error with route. You might have config problems. Make sure your doc root is correct in the config");
$route = new route();

if(site::debug)log::error("Factory error. Perhaps this controller doesn't exist. Check Applications/factory.php. ");
$controller = factory::build($route);

if(site::debug)log::error("There was an error running this controller. ");
$controller->run($route);

if(site::debug)log::error("The application finished without any errors.");
site::debug?log::set(mysql_error()):'';
echo log::write();


unset($_SESSION['message']);

// now gtfo
exit;
?>
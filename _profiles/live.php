<?php
class  site{
	const url = 'http://titan.jumpingness.com/';
	const root = '/home/jumping4/public_html/titan/';
	
	const user = 'thilo';
	const password = 'chicken';

	const fbapp_id = 'ad229d5fd1f3d8897f01af1eae69e9a5';
	const fbapp_secret = '22ae594e7076f7c2518e81c03f0b0565';
	
	const controller = 'index';
	const action = 'index';
	const id = '1';
	const layout = '_default';
	
	const db_user = 'jumping4_zynga';
	const db_pass = 'zynga123';
	const db_name = 'jumping4_zynga';
	const db_url = 'localhost';
	
	const debug = 1;
	
	function __construct(){
		ini_set('display_errors', 1);
		error_reporting(E_STRICT);
		error_reporting(E_ALL);
	}
}
?>
<?php

// Connecting to the MySQL database
$user = 'turbevillm1';
$password = 'Vu9OXi7?';

$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_fall18_turbevillm1', $user, $password);

function my_autoloader($class){
	include('class.'. $class . '.php');
}

spl_autoload_register('my_autoloader');

// Start the session
session_start();

$current_url = basename($_SERVER['REQUEST_URI']);

if (isset($_SESSION["adminID"])) {
	
	$admin = new Admin($_SESSION["adminID"], $database);
}
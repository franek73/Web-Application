<?php
session_start();
require_once 'functions.php';

if (($_SERVER['REQUEST_METHOD'] === 'GET') && isset($_GET['uid'])){
	$userId =$_GET['uid'];
	$potwierdzenie = DeleteUser($userId);
	if ($potwierdzenie){
	  header("Location:AllUsers.php");
	}
	else { 
	  echo $potwierdzenie;
	  echo "nie usunięto użytkownika o id". $userId;
	}
}
?>
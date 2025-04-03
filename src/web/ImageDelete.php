<?php
session_start();
require_once 'functions.php';

if (($_SERVER['REQUEST_METHOD'] === 'GET') && isset($_GET['uid'])){
	$imageId =$_GET['uid'];
	$potwierdzenie = DeleteImage($imageId);
	if ($potwierdzenie){
	  header("Location:AllImages.php");
	}
	else { 
	  echo $potwierdzenie;
	  echo "nie usunięto użytkownika o id". $imageId;
	}
}
?>
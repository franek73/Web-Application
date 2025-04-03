<?php

session_start();
require_once 'functions.php';

$error="";

if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['login']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['repeat_pass']) )
{  
  $login = $_POST['login'];
  $email = $_POST['email'];
  $password = $_POST['pass'];
  $repeat_password = $_POST['repeat_pass'];
    
  if ($password===$repeat_password)
  {
	if  (!LoginExist($login))
  {
	  $hash = password_hash($password, PASSWORD_DEFAULT);

	  if (AddNewUser($login,$hash, $email,0))
    {
		 header("Location: Login.php");
        exit;
	  }
	   else {
		 $error ="problem z bazą na etapie dodawania użytkownika :("; 
	   }
	}
	else 
  {
    $error = "login zajęty :(";
  }
  } 
  else {
	  $error = "hasła nie są zgodne :(";
  }
}
?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rejestracja</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

 <body>
 
<?php
include 'menu.php';
?>

<div id="glowny">
<header>
	<h1>Rejestracja</h1>
</header>

<div id="tresc">

<div id="formularz">
  <form  method="POST">
   <label for="login">Login:</label><br>
   <input type="text" name="login" required /><br />
   <label for="email">E-mail:</label><br>
   <input type="text" name="email" required /><br />
   <label for="pass">Hasło:</label><br>
   <input type="password" name="pass" required /><br />
   <label for="repeat_pass">Powtórz hasło:</label><br>
   <input type="password" name="repeat_pass" required /><br />
   <input type="submit" value="Zarejestruj się">
  </form>
  </div>

  <?= '<p style="color:red">'. $error . '</p >' ?>

</div>
</div>

</body>
</html>
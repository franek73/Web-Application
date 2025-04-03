<?php

session_start();

require_once 'functions.php';

$error="";

if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['login']) && isset($_POST['pass']) )
{
$login = $_POST['login'];
$password = $_POST['pass'];

$done = ReadUser($login, $password);

if ($done !== true) 
{
$error = "problem z logowaniem";
}
else {
    if (isset($_SESSION['rule']) )
    {
        switch($_SESSION['rule']) 
        {
        case 0: header("Location: LoginAccepted.php"); 
        break;
        default: header("Location: AllUsers.php");
        break;
        }
        }
        exit;
}
}
?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logowanie</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<?php
include 'menu.php';
?>

<div id="glowny">
<header>
	<h1>Logowanie</h1>
</header>

<div id="tresc">

<div id="formularz">
  
  <form method="POST">
  <label for="login">Login:</label><br>
  <input type="text" name="login" required /><br />
  <label for="pass">Hasło:</label><br>
  <input type="password" name="pass" required /><br />
  <input type="submit" value="Zaloguj się">
  </form>

  <?= "<p style='color:red'>". $error . "</p >" ?>

</div>

</div>
</div>

</body>
</html>
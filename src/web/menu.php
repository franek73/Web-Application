<hr>

&nbsp;&nbsp;&nbsp;<a href="Home.php">Home</a>&nbsp;&nbsp;&nbsp;
<a href="History.php">Historia saksofonu</a>&nbsp;&nbsp;&nbsp;
<a href="Types.php">Rodzaje saksofonu</a>&nbsp;&nbsp;&nbsp;
<a href="ImageUpload.php">Przeysłanie zdjęć</a>&nbsp;&nbsp;&nbsp;
<a href="Gallery.php?idf=1">Galeria</a>&nbsp;&nbsp;&nbsp;

<?php
if (!empty($_SESSION['user_id']))
{
echo '<a href="LogOut.php">Wyloguj się</a>';
}
else echo '<a href="Login.php">Logowanie</a>&nbsp;&nbsp;&nbsp;<a
href="Register.php">Rejestracja</a>';
?>

<hr>

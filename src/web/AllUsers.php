<?php

session_start();
require_once 'functions.php';

$users = AllUsers();

if ( isset($_SESSION['rule']) && ($_SESSION['rule'] ==0) ) 
{
  header("Location: ImageUpload.php");
  exit;
}
?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All_Users</title>
</head>

<body>

<?php
include 'menu.php';
?>

<?php if ($users): ?>
   <ol>
    <?php foreach ($users as $user): ?>
      <li>
        <?= $user['login'] ?> [ <?= $user['rule'] ?> ]<a href="UserDelete.php?uid=<?= $user['_id'] ?>">Usuń</a>
      </li>
    <?php endforeach ?>
   </ol>

<?php else: ?>
 <p >Brak użytkowników</p>
<?php endif ?>

</body>
</html>



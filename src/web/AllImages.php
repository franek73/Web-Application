<?php

session_start();
require_once 'functions.php';

$images = AllImages();

?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All_Images</title>
</head>

<body>

<?php
include 'menu.php';
?>

<?php if ($images): ?>

<ol>

<?php foreach ($images as $image): ?>
   <li>
    <?= $image['name'] ?> | <?= $image['title'] ?> | <?= $image['author'] ?> | <?= $image['typeofimage'] ?> | <a href="ImageDelete.php?uid=<?= $image['_id'] ?>">Usuń</a>
   </li>
<?php endforeach ?>

</ol>

<?php else: ?>
  <p >Brak zdjęć</p>
<?php endif ?>
  
</body>
</html>



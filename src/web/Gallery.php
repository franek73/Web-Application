<?php

session_start();
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	if (isset($_GET['idf'])) 
  {
    $page = $_GET['idf'];
  }
  else $page = 1;
}

$pageSize=3;
$images=FindImages($page, $pageSize);
$pagesnumber=CountImages()/$pageSize;

?>  

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Galeria Zdjęć</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<?php
include 'menu.php';
?>

<div id="glowny">
<header>
	<h1>Galeria</h1>
</header>

<div id="tresc">

<?php if($pagesnumber>0): ?>
<div id="tabela">
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Autor</th>
            <th>Zdjęcie</th>
            <?php if (!empty($_SESSION['user_id'])) echo '<th>Rodzaj zdjęcie</th>'?>   
      </tr>

      <?php foreach ($images as $image): ?>
    
        <?php if ($image['typeofimage']==='public') $typeofimage='Publiczne';
          else $typeofimage='Prywatne';
          ?>
        
        <tr>
          <td><?=$image['title'] ?></td>
          <td><?=$image['author'] ?></td><td>
          <a href="./images_watermarked/<?=$image['name']?>"><img src="./images_miniatures/<?=$image['name'] ?>"/></a>
        </td>
        
       <?php if (!empty($_SESSION['user_id'])) echo '<td>'.$typeofimage .'</td></tr>'; else echo '</tr>'?>

        <?php endforeach ?>
  </table> 
  </div>
  
  <?php endif ?>

  <?php if($pagesnumber===0): ?>
 <h3>Brak zdjęć</h3>
  <?php endif ?>
  
  <?php if ($page>1) 
  {
    $pagedown=$page-1; echo  '<a href="Gallery.php?idf='.$pagedown.'"><h1 class="center"><</h1></a>'; 
  } 
    ?>
  <?php if ($page<$pagesnumber) 
  {
    $pageup=$page+1; echo  '<a href="Gallery.php?idf='.$pageup.'"><h1 class="center">></h1></a>'; 
    } 
    ?>

</div>
</div>

</body>
</html>

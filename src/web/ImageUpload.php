<?php

session_start();
require_once 'functions.php';

$user = FindUser($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["image"]) && isset($_POST['author']) && isset($_POST['watermark']) && isset($_POST['title'])) {
	
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $file_name = $_FILES['image']['tmp_name'];
  $mime_type = finfo_file($finfo, $file_name);
  $file_size=$_FILES["image"]["size"];


	if (($mime_type === 'image/png' || $mime_type === 'image/jpeg' ) && $file_size<=1048576){ 

	  if ($_FILES["image"]["error"] == UPLOAD_ERR_OK ){
	   
       $title = $_POST['title'];
       $author = $_POST['author'];
       $name=basename($_FILES['image']['name']);
       
       if (isset($_POST['typeofimage']))
       {
       if ($_POST['typeofimage']==='private')
       {
        $typeofimage = $_SESSION['user_id'];
       }
       else $typeofimage = $_POST['typeofimage'];
       }

      else $typeofimage ='public';

      if (AddNewImage($name, $title, $author,  $typeofimage)) {
		     
         $uploadfile = './images/'.  basename($_FILES['image']['name']);
	   
         if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
          
          $komunikat = "<p style='color:green' >Plik przesłany poprawnie<p>";

          $source = $uploadfile;

          list($width, $height) = getimagesize($source);
          $newwidth = 200;
          $newheight = 125;

          $target_watermarked = './images_watermarked/'. basename($_FILES['image']['name']);
          $target_resized = './images_miniatures/'. basename($_FILES['image']['name']);

          if ($mime_type === 'image/png')
          {
           $image_watermarked = imagecreatefrompng($source);
           $image_min = imagecreatefrompng($source);
          }
         elseif ($mime_type === 'image/jpeg')
         {
           $image_watermarked = imagecreatefromjpeg($source);
           $image_min = imagecreatefromjpeg($source);
         }
 
         $destination = imagecreatetruecolor($newwidth, $newheight);
         imagecopyresampled($destination, $image_min, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

         $text=htmlspecialchars($_POST['watermark']);
         $fontfile = "./arial.ttf";
         $fontsize = imagesx($image_watermarked)/10;
         $fontcolor = imagecolorallocatealpha($image_watermarked, 255,255,255, 45);
         
         imagettftext($image_watermarked, $fontsize, 0, imagesx($image_watermarked)/2, imagesy($image_watermarked)/2, $fontcolor, $fontfile, $text);

       if ($mime_type === 'image/png')
       {
        imagepng($image_watermarked, $target_watermarked);
        imagepng($destination, $target_resized);
      }
      elseif ($mime_type === 'image/jpeg')
      {
       imagejpeg($image_watermarked, $target_watermarked);
      imagejpeg($destination, $target_resized);
      }

      $url = "Gallery.php";
      header("Location: $url");

         } 
		 else 
     { 
      $komunikat = "<p style='color:red' >Problem z plikiem<p>";
    }
	 }
    else 
    {
      $komunikat = "<p style='color:red' >Problem z zapisem do bazy<p>";
    }
  } 
		else 
    { 
       $komunikat = "<p style='color:red' >Jest problem z tym plikiem<p>";
	   }
	}
  elseif ($file_size>1048576)
  {
    $komunikat = "<p style='color:red' >Plik za duży </p>";
  }
  elseif ($mime_type !== 'image/png' || $mime_type !== 'image/jpeg' )
  {
    $komunikat = "<p style='color:red' >Zły rodzaj pliku </p>";
  }
  else	
  { 
      $komunikat = "<p style='color:red' >Plik jest za duży i jest złego rodzaju </p>";
		}
}
else 
{

}
?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Przesyłanie Zdjęć</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<?php
include 'menu.php';
?>

<div id="glowny">
<header>
	<h1>Przesyłanie zdjęć</h1>
</header>

<div id="tresc">
 
<div id="formularz">
 <form enctype="multipart/form-data" action="ImageUpload.php" method="POST">

 <label for="title" >Tytuł:</label><br>
 <input type="text" name="title"  required /><br />

 <label for="author">Autor:</label><br>
   <?php if (!empty($_SESSION['user_id'])) $value=$user['login'];
     else  $value='';
  ?>
<input type="text" name="author" value="<?= $value ?>" required><br />
    
 <label for="watermark">Znak wodny:</label><br>
 <input type="text" name="watermark" required /><br />

  <?php if (!empty($_SESSION['user_id']))
    {
      echo ' <label for="public">Publiczne</label>  
      <input type="radio" name="typeofimage" id="public" value="public" checked>
      <label for="private">Prywatne</label>  
      <input type="radio" name="typeofimage" id="private" value="private"><br/>';
    }
  ?>
    
  <label for="image">Wybierz zdjęcie:</label><br><br>
  <input name="image" type="file" required/><br>
    
  <input type="submit" value="Wyślij zdjęcie" />
 
  </form>
</div>
 
<?php 
  if (isset($komunikat)) { echo $komunikat; }
?>
 
</div>
</div>

</body>
</html>
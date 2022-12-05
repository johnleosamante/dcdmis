<?php
session_start();

$text =preg_replace("#.*youtube\.com/watch\?v=#","",$_GET['v']);
echo '<iframe width="100%" height="480" src="https://www.youtube.com/embed/'.$text.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
$_SESSION['doctype']="Youtube";
$_SESSION['link']=$text;
?>	
<?php
session_start();
include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
$target_dir = "memo/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["Save"])) {
 // Check if file already exists
if (file_exists($target_file)) {
   // echo "Sorry, file already exists.";
    unlink($target_file);
   $uploadOk = 1;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 2000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
//{
  //  echo "Sorry, only JPG, JPEG, PNG,ICO & GIF files are allowed.";
   // $uploadOk = 0;
//}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], '../'.$target_file)) {
       mysqli_query($con,"UPDATE tbl_seminar SET Training_Memo='".$target_file."' WHERE tbl_seminar.Training_Code='".$_SESSION['Memo']."'");
		header("location:list_of_activity.php?link=".sha1("Deped Pagadian Data Management System"));
		} else {
        echo "Sorry, there was an error uploading your file.";
    }
}}

?> 

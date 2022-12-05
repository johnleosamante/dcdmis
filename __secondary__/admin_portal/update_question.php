<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
<?php
session_start();
include("../vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$_SESSION['No']=$code;
?>
<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Update Question</h4>
			</div>
			 <form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<?php
			$result=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE SubCode='".$_SESSION['SubCode']."' AND QNumber='".$_SESSION['No']."'");
			$row=mysqli_fetch_assoc($result);
			if ($row['Link_picture']=="")
			{
			 echo '<input type="text" name="QUP" class="form-control" placeholder="Enter question Number '.$_GET['No'].'">';	
			}else{
				echo '<label>Select to update questionnairs for number '.$_GET['No'].'</label><hr/>
				<img src="'.$row['Link_picture'].'" style="width:100%;" id="pic"><hr/>';
			echo '<input type="file" name="image" onchange="loadFile(event)">';
			}
		   	?>
			</div>
           <div class="modal-footer">
		   <button type="submit" class="btn btn-success" name="UpdateData">Update</button>
		 </div>	
		 </form>

<?php
session_start();
include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}	
?>  
<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
	   text-align:left;
   }
   
   .mybox{
	   width:30%;height:auto;margin-top:200px;margin-left:auto;margin-right:auto;
   }
   
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .mybox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					
					
			}
		
   </style>

<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <a href="#mymem" class="btn btn-primary" style="float:right;" data-toggle="modal">Add Memo</a>
		  <h3 class="modal-title"><center>MEMO</center></h3>
		  	
        </div>
        <div class="modal-body">
		<?php
		$_SESSION['Memo']=$_GET['code'];
		$mymemo=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$_GET['code']."' LIMIT 1");
		$row=mysqli_fetch_assoc($mymemo);
		if ($row['Training_Memo']<>"-")
		{
		echo '<iframe src="../'.$row['Training_Memo'].'" width="100%" height="550" id="pic"></iframe>';
		}else{
			echo '<iframe src="nomemo.php" width="100%" height="550" id="pic"></iframe>';
		}
		?>		
		</div>
<!-- Modal for Re-assign-->
    <div class="modal fade" id="mymem" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="mybox">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>SELECT MEMO</center></h3>
		  	
        </div>
        <div class="modal-body">
			<form action="update_memo.php" method="POST" enctype="multipart/form-data">
				<input type="file" name="fileToUpload"  style="cursor:pointer;" onchange="loadFile(event)">
				<input type="submit" name="Save" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</form>
		</div>
		
		
		      </div>
			  </div></div>
  <?php
  session_start();
 include("../vendor/jquery/function.php");
  mysqli_query($con,"UPDATE tbl_messages SET Message_status='Read' WHERE No='".$_GET['code']."'");
  
  echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
		   <h3 class="modal-title"><center>Message Information</center></h3>
        </div>
        <div class="modal-body">
		<label>TITLE OF TRAINING: </label><br/>';
		$result=mysqli_query($con,"SELECT * FROM tbl_school_participant INNER JOIN tbl_seminar ON tbl_school_participant.Training_Code =tbl_seminar.Training_Code WHERE tbl_school_participant.SchoolID='".$_SESSION['school_id']."' AND tbl_school_participant.Training_Code='".$_GET['TCode']."'");
		$row=mysqli_fetch_assoc($result);	
		echo '<input type="text" class="form-control" value="'.$row['Title_of_training'].'" disabled>
		<label>MEMO </label><br/>';
		if ($row['Training_Memo']<>"-")
		{
		echo '<iframe src="../'.$row['Training_Memo'].'" width="100%" height="450"></iframe>'; 		
		}else{
		echo '<iframe src="nomemo.php" width="100%" height="450"></iframe>'; 		
		}
		echo  '<hr/><a href="my_participant.php?TCode='.$_GET['TCode'].'" class="btn btn-primary" data-target="#parti" data-toggle="modal">Add</a>';
       
		echo '</div>';
		 
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
   }
   .box{
	   width:50%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .box{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
		}
		th{
			text-align:center;
		}
   </style>


 <!-- Modal for Re-assign-->
 <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="parti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>  

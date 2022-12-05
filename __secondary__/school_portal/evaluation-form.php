<?php
session_start();
include("../vendor/jquery/function.php");
$_SESSION['TransactionCode']=$_GET['id'];
?>
<style>
input{
	cursor:pointer;
	
}
</style>

		<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>QUATAME</center></h3>
		 </div>
        <form action="view-log.php??link=bcead8efbf9d3ebfc554f2017c141e37533b9af8&&id=<?php echo $_GET['id']; ?>" Method="POST" enctype="multipart/form-data"> 
		<div class="modal-body">
		 <label style="padding:4px;margin:4px;">SECTION VISITED: </label>
		<label style="padding:4px;margin:4px;">RECORDS</label><br/>
		<label style="padding:4px;margin:4px;">NAME OF PERSON/SECTIONS VISITED/TO BE EVALUATED*</label>
		<input type="text" name="incharge" class="form-control">
		<label style="padding:4px;margin:4px;">Are you satisfied the service/s rendered to you?*</label>
		<input type="radio" name="service" value="YES" style="padding:4px;margin:4px;" required> YES
		<input type="radio" name="service" value="NO" style="padding:4px;margin:4px;" required> NO
		<br/>
		<label style="padding:4px;margin:4px;">Satisfaction Rate Rendered*</label><br/>
		<input type="radio" name="rate" value="Outstanding" style="padding:4px;margin:4px;" required> Outstanding
		<input type="radio" name="rate" value="Very Satisfactory" style="padding:4px;margin:4px;" required>Very Satisfactory
		<input type="radio" name="rate" value="Satisfactory" style="padding:4px;margin:4px;" required>Satisfactory
		<input type="radio" name="rate" value="Needs Improvement" style="padding:4px;margin:4px;" required>Needs Improvement

		<br/>
		<label style="padding:4px;margin:4px;">Please give your feedback/comments from the services you have received from us.*</label>
		<textarea rows="3" class="form-control" name="feedback" required></textarea>
	
		<?php
		$evaluation=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE SchoolID='".$_SESSION['school_id']."' AND TransactionCode='".$_GET['id']."' AND Destination_section <>''");
		while ($row=mysqli_fetch_array($evaluation))
		{
	  echo '<label style="padding:4px;margin:4px;">SECTION VISITED: </label>
		<label style="padding:4px;margin:4px;">'.$row['Destination_section'].'</label><br/>
		<label style="padding:4px;margin:4px;">NAME OF PERSON/SECTIONS VISITED/TO BE EVALUATED*</label>
		<input type="text" name="incharge" class="form-control">
		<label style="padding:4px;margin:4px;">Are you satisfied the service/s rendered to you?*</label>
		<input type="radio" name="service" value="YES" style="padding:4px;margin:4px;" required> YES
		<input type="radio" name="service" value="NO" style="padding:4px;margin:4px;" required> NO
		<br/>
		<label style="padding:4px;margin:4px;">Satisfaction Rate Rendered*</label><br/>
		<input type="radio" name="rate" value="Outstanding" style="padding:4px;margin:4px;" required> Outstanding
		<input type="radio" name="rate" value="Very Satisfactory" style="padding:4px;margin:4px;" required>Very Satisfactory
		<input type="radio" name="rate" value="Satisfactory" style="padding:4px;margin:4px;" required>Satisfactory
		<input type="radio" name="rate" value="Needs Improvement" style="padding:4px;margin:4px;" required>Needs Improvement

		<br/>
		<label style="padding:4px;margin:4px;">Please give your feedback/comments from the services you have received from us.*</label>
		<textarea rows="3" class="form-control" name="feedback" required></textarea>';
		}
		?>
		</div>
		
		<div class="modal-footer">
		<input type="submit" name="submit" Value="SUBMIT" class="btn btn-success">
		</div>
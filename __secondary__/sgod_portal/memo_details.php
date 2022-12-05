<?php
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
if (isset($_POST['route']))
{
mysqli_query($con,"UPDATE tbl_memo_notification SET MemoStatus='Read' WHERE MemoNo='".$_GET['MemoNo']."' LIMIT 1");
if (mysqli_affected_rows($con)==1)
{
 mysqli_query($con,"INSERT INTO tbl_memo_notification VALUES (NULL,'".$dateposted."','".$_GET['MemoNo']."','".$_POST['section']."','Unread')");	
 ?>
	<script type="text/javascript">
		$(document).ready(function(){						
			$('#memover').modal({
			show: 'true'
			}); 				
		});
	</script>
								
						 
<?php   
}
}
?>
<h1></h1>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Memorandum Details
                        </div>
                        <!-- /.panel-heading -->
						<?php
						$result=mysqli_query($con,"SELECT * FROM tbl_communication WHERE MemoNo='".$_GET['MemoNo']."' LIMIT 1");
						$row=mysqli_fetch_assoc($result);
                        echo '<div class="panel-body">
                             <div class="col-lg-6">
								  <div class="panel panel-default" style="padding:4px;margin:4px;">
								  <a href="#forwardemail" style="float:right;" class="btn btn-info" title="Forward Email" data-toggle="modal"> <i class="fa fa-mail-forward"></i></a>
								   <p>FROM: '.$row['sourch_memo'].'</p>
								   <p>TO: '.$row['office_destination'].'</p>
								    <p>DATE AND TIME: '.$row['Date_created'].'</p>
								   <p>CONTENT: '.$row['Memo_Details'].'</p>
								   <p>REMARKS: '.$row['remarks'].'</p>
								   
                                 </div>
								 <hr/>
								  <div class="col-lg-12">
								  
								  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="text-align:center;" width="20%">Date Time Received</th>
												<th>FROM</th>
												<th>TO</th>
												<th style="text-align:center;" width="15%">Status</th>
											</tr>	
											
										</thead>
										<tbody>
										</tbody>
										</table>
                                   
                                 </div>
                            </div>
							<div class="col-lg-6">
								  <div class="panel panel-default">
								   <iframe src="'.$row['attachfiles'].'" style="width:100%;border:0px;height:550px;"></iframe>
                                 </div>
                            </div>
                        </div>';
						?>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
              

              <!-- Modal -->
	 <div class="modal fade" id="forwardemail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Action Taken</h4>
			</div>
			 <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<label>Forward to:</label><br/>
				<select name="section" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny4=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row4=mysqli_fetch_array($destiny4))
				{
					echo '<option value="'.$row4['Offices'].'">'.$row4['Offices'].'</option>';
				}
				?>
				</select>
				<label>Action Taken:</label>
				<textarea class="form-control" name="remarks" rows="3"></textarea>
		   	</div>
           <div class="modal-footer">
		   <input type="submit" name="route" class="btn btn-primary" value="Route..."/>
		   <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			
		 </div>	
</form>
	</div></div>
	</div>


              <!-- Modal -->
	 <div class="modal fade" id="memover" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Document Verifier</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../../pcdmis/logo/check.png" width="100%" height="50%">
			<center><h3>Memorandum Successfully Routed</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="./" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>

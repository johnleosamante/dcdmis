	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	
							<?php
							echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'" class="btn btn-success" style="float:right;">Back</a>
							<h4>Evaluation form</h4>';
                    
							
							?>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                         <form action="" Method="POST" enctype="multipart/form-data"> 
							<?php
							$evaluation=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE SchoolID='123131' AND TransactionCode='".$_GET['id']."' AND Destination_section <>''");
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
							<div class="modal-footer">
								<input type="submit" name="submit" Value="SUBMIT" class="btn btn-success">
							</div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               

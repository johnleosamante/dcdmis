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
							<h4>Canceled Transactions</h4>';
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['Canceled']))
							{
								$remark="Canceled - ".$_POST['remarks'];
								mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='".$remark."' WHERE TransCode='".$_GET['id']."' LIMIT 1");
							if (mysqli_affected_rows($con)==1)
							{
							mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','".$remark."','".$_GET['id']."','Done')");
							
							$Err = "Transaction Successfully Canceled!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';	
								
							}
							}	
							
							?>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <form action=""	Method="POST" enctype="multipart/form-data">
								<?php
									$query=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='".$_GET['id']."' LIMIT 1");
									$row=mysqli_fetch_assoc($query);
									echo '<h4>Title: '.$row['Title'].'</h4>';
									echo '<h4>From: '.$row['Trans_from'].'</h4>';
									echo '<h4>Status: '.$row['Trans_Stats'].'</h4>';
								?>
							<label>Remarks</label>    
							<textarea class="form-control" rows="5" name="remarks" required></textarea>      
                            <div class="modal-footer">
								<input type="submit" name="Canceled" value="Cancel" class="btn btn-success">
							 </div>    
								 </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               

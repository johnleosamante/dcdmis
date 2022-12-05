<?php 
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d h:i:s");
if (!empty($_SERVER["HTTP_CLIENT_IP"]))
	{
     $IP =$_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
	{
		$IP =$_SERVER["HTTP_X_FORWARDED_FOR"];
	}else{
		$IP =$_SERVER["REMOTE_ADDR"];
	}


mysqli_query($con,"INSERT INTO tbl_system_logs(SchoolID,Emp_ID,Time_Log,Status,IPAddress) VALUES('".$_SESSION['school_id']."','".$_SESSION['uid']."','".$dateposted."','Transaction','".$IP."')");

if (!is_dir('../../files/'.$_SESSION['SN'].'/'.date("Y-m-d"))) {
    mkdir('../../files/'.$_SESSION['SN'].'/'.date("Y-m-d"), 0777, true);
}
$_SESSION['pathlocation']='../../files/'.$_SESSION['SN'].'/'.date("Y-m-d");
?>
			<style>
			td{
				 text-transform:uppercase;
			 }
			</style>
			
			<script>
	
      window.addEventListener("load", function () 
      {
		var ans=0;
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadattachfile.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
            //width: 500,
            //height: 500,
            //quality: 90,
          },
          init: 
          {
            PostInit: function () 
            {
              document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files) 
            {
              plupload.each(files, function (file) 
              {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
              uploader.start();
            },
            UploadProgress: function (up, file) 
            {
				
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			  ans++;  
			  if ( file.percent==100)
			  {
				
			   document.getElementById("filedata").value =file.name;
			   document.getElementById("myBtn").disabled = false;
			   
			   	   
			  }
			 },
            Error: function (up, err) 
            {
              // DO YOUR ERROR HANDLING!
              console.log(err);
            }
          }
        });
        uploader.init();
		 
			 
      });
    </script>
			
			
			
<style>
th,td{
	text-transform:uppercase;
}
</style>	 
		 	<script type="text/javascript">
							$(document).ready(function(){						
							setInterval(function(){
								$("#data-refresh").load("transaction-flow.php")
							},1000);
							
							});</script>
							
				
						
						
			<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'insert.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('section').setFucos;
				return false;
				}
				</script>	
 
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 				
	            <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <a href="#newtrack" class="btn btn-primary" style="float:right;" data-toggle="modal">New Transaction</a>
							<h4>Transactions History</h4>
							<?php
							//date_default_timezone_set("Asia/Manila");
							//$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['new_qualification']))
							{
							$newloc=$_SESSION['pathlocation'].'/'.$_POST['filedata'];
							$getID=mb_strimwidth($_POST['Qualicode'],0,6);	
							$data=$_POST['Qualname'];
							$data=str_replace("'","\'",$data);
							mysqli_query($con,"INSERT INTO tbl_transactions VALUES ('".$_POST['Qualicode']."','".$data."','".$dateposted."','".$_SESSION['SN']."','For Approval','Unread','".$getID."','".$newloc."')");
							if (mysqli_affected_rows($con)==1)
							{
							mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['SN']."','".$_POST['officeTo']."','For Approval','".$_POST['Qualicode']."','New')");	
							if (isset($_POST['first']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'1','".$_POST['first']."','".$getID."','".$_POST['Qualicode']."')");
		
								 }
								 if (isset($_POST['second']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'2','".$_POST['second']."','".$getID."','".$_POST['Qualicode']."')");

								 }
								  if (isset($_POST['third']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'3','".$_POST['third']."','".$getID."','".$_POST['Qualicode']."')");

								 }
								  if (isset($_POST['fourth']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'4','".$_POST['fourth']."','".$getID."','".$_POST['Qualicode']."')");

								 } if (isset($_POST['fifth']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'5','".$_POST['fifth']."','".$getID."','".$_POST['Qualicode']."')");

								 } if (isset($_POST['six']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'6','".$_POST['six']."','".$getID."','".$_POST['Qualicode']."')");

								 }
							 ?>
											<script type="text/javascript">
											$(document).ready(function(){						
												 $('#access').modal({
													show: 'true'
												}); 				
											});
											</script>
											
									 
											<?php 
							}else{
								$Err = "Transaction has a problem!!!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}
							}elseif (isset($_POST['update_trans']))
							{
								$dataup=$_POST['Qualname'];
								$dataup=str_replace("'","\'",$dataup);
								mysqli_query($con,"UPDATE tbl_transactions SET Title='".$dataup."' WHERE TransCode='".$_SESSION['Trancode']."' LIMIT 1");
								if (isset($_POST['first']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['first']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='1' LIMIT 1");
								}
								if (isset($_POST['second']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['second']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='2' LIMIT 1");
								}
								if (isset($_POST['third']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['third']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='3' LIMIT 1");
								}
								if (isset($_POST['fourth']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['fourth']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='4' LIMIT 1");
								}
								if (isset($_POST['fifth']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['fifth']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='5' LIMIT 1");
								}
								if (isset($_POST['six']))
								{
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['six']."' WHERE TransactionCode='".$_SESSION['Trancode']."' AND SchoolID ='".$_SESSION['school_id']."' AND SequenceNo='6' LIMIT 1");
								}
								
								if (mysqli_affected_rows($con)==1)
									{
										?>
											<script type="text/javascript">
											$(document).ready(function(){						
												 $('#access').modal({
													show: 'true'
												}); 				
											});
											</script>
											
									 
											<?php 
									}
							}
							?>			
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
													
						
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="width:5%;text-align:center;">#</th>
												
												<th style="width:30%;">Description</th>
												<th style="text-align:center;width:15%;">Date Time Created</th>
												<th style="text-align:center;width:10%;">Status</th>
												<th width="10%"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_transactions.Date_time Desc");
											while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>';
													
													
													echo '<td>'.$row['Title'].'</td>';
													echo '
													<td style="text-align:center;">'.$row['Date_time'].'</td>
													<td style="text-align:center;">'.$row['Trans_Stats'].'</td>
													<td style="text-align:center;">';
														
														  echo '<a href="print-transaction.php?Code='.urlencode(base64_encode($row['TransCode'])).'" target="_blank" title="Print Transaction" class="btn btn-success" style="padding:4px;margin:4px;"> <i class="fa fa-print fa-fw"></i></a>';
														echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("view_log")).'" title="View Transaction Logs" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-desktop fa-fw"></i></a>
														<a href="edit-transaction.php?id='.urlencode(base64_encode($row['TransCode'])).'" data-toggle="modal" data-target="#Mylog" title="Edit Transaction" class="btn btn-danger" style="padding:4px;margin:4px;"> <i class="fa fa-pencil fa-fw"></i></a>';
													
													echo '</td>
											</tr>';
										}
										
										
										echo '</tbody>
									</table>';
						
							
							
							?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           
	<style>
	input{
		cursor:pointer;
	}
	</style>


    <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
         
          <h3 class="modal-title"><center>New Transaction</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<input type="hidden" name="filedata" id="filedata" class="form-control" >
		<?php
		$num=0;
		$code="";
		$result=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.SchoolID='".$_SESSION['school_id']."'");
		$num=mysqli_num_rows($result)+date("his");
		if ($num>=0 AND $num<=9)
		{
		$code=$_SESSION['school_id'].'-000'.$num;
		}elseif ($num>=10 AND $num<=99)
		{
		$code=$_SESSION['school_id'].'-00'.$num;
		}elseif ($num>=100 AND $num<=999)
		{
		$code=$_SESSION['school_id'].'-0'.$num;
		}elseif ($num>=1000)
		{
		$code=$_SESSION['school_id'].'-'.$num;
		}
		echo '<label>Transaction Code</label>
		<input type="text" class="form-control" value="'.$code.'"disabled>
		<input type="hidden" name="Qualicode"  class="form-control"  value="'.$code.'">';
		?>
		<label>Transaction Details</label>
		<textarea name="Qualname"  class="form-control" rows="5" required></textarea>
		 <input type="hidden" name="officeTo" value="RECORD" class="form-control" >
		 <label style="padding:4px;">Transaction Flow (1st Destination: RECORD)</label><br/>
		   <div class="row">
				
                <div class="col-lg-4">
				<label>1st Destination</label><br/>
				<select name="first" class="form-control" required>
				<option value="RECORD">RECORDS</option>
				
				</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>2nd Destination</label><br/>
				 <select name="second" class="form-control" required>
				<option value="">--select--</option>
				<?php
				$destiny2=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row2=mysqli_fetch_array($destiny2))
				{
					echo '<option value="'.$row2['Offices'].'">'.$row2['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				<div class="col-lg-4">
				 <label>3rd Destination</label><br/>
				<select name="third" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny3=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row3=mysqli_fetch_array($destiny3))
				{
					echo '<option value="'.$row3['Offices'].'">'.$row3['Offices'].'</option>';
				}
				?>
				</select>
				
				</div>
			
	
			 <div class="col-lg-4">
				<label>4th Destination</label><br/>
				<select name="fourth" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny4=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row4=mysqli_fetch_array($destiny4))
				{
					echo '<option value="'.$row4['Offices'].'">'.$row4['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>5th Destination</label><br/>
				 <select name="fifth" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny6=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row6=mysqli_fetch_array($destiny6))
				{
					echo '<option value="'.$row6['Offices'].'">'.$row6['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				<div class="col-lg-4">
				 <label>6th Destination</label><br/>
				<select name="six" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny7=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row7=mysqli_fetch_array($destiny7))
				{
					echo '<option value="'.$row7['Offices'].'">'.$row7['Offices'].'</option>';
				}
				?>
				</select>
				
				</div>
				</div>
				
					
			</div>
			<div class="modal-footer">
			<label style="float:left;">
			<div id="container">
												
					<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose Attach File as PDF format</button></span>
														
				</div>
				<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
				</label>
				<input type="submit" name="new_qualification" id="myBtn" value="Save" class="btn btn-primary">
				 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			</div>
			   </form>
			   
		</div>
		
      

		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->



						 
						 <div class="panel-body">
                            
                            <!-- Modal -->
                            <div class="modal fade" id="Mylog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
										
										
										
										
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- .panel-body -->
					
 <script>
 function change_quarter(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtstrand").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","change_quarter.php?id="+str,false);
  xmlhttp.send();
}
 </script>
<?php
if ( $_SESSION['Grade_Level']>=1 AND  $_SESSION['Grade_Level']<=6)
	{
	$areas=mysqli_query($con,"SELECT * FROM tbl_element_subject WHERE SubNo='".$_GET['code']."' ORDER BY SubNo Desc");
	}elseif ( $_SESSION['Grade_Level']>=7 AND  $_SESSION['Grade_Level']<=10)
	{	
	$areas=mysqli_query($con,"SELECT * FROM tbl_jhs_subject WHERE SubNo='".$_GET['code']."' ORDER BY LearningAreas Asc");
	}elseif ( $_SESSION['Grade_Level']>=11 AND  $_SESSION['Grade_Level']<=12)
	{
	$areas=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand WHERE SubGradeLevel='".$_SESSION['Grade_Level']."' ORDER BY StrandsubCode Asc");
								 		
	}
	$row=mysqli_fetch_assoc($areas);
?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      	<?php
						if(isset($_POST['addmodule']))
						{
							$mytitle=$_POST['filename'];
							$mytitle=str_replace("'","\'",$mytitle);
							mysqli_query($con,"INSERT INTO tbl_list_of_module_activity VALUES(NULL,'".$mytitle."','".$_SESSION['Grade_Level']."','".$_SESSION['Quarter']."','10','".$_SESSION['SubCode']."','')");
							if (mysqli_affected_rows($con)==1)
							{
								$Err = "Module Successfully Saved";
										echo '<script type="text/javascript">
											$(document).ready(function(){						
											$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
											});</script>
											';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
							}
						}
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&&Grade='.urlencode(base64_encode($_SESSION['Grade_Level'])).'&v='.urlencode(base64_encode("subject_list")).'" style="float:right;" class="btn btn-secondary">Back to course</a>';
						?>
						<p>LIST OF MODULE (<?php 
												if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
												{
													echo $row['SubStrandDescription'].' - '.$_SESSION['Quarter'].' Quarter';
												}else{
												    echo $row['LearningAreas'].' - '.$_SESSION['Quarter'].' Quarter'; 
												}
												?>)</p>
				  		   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								 <thead>
									<tr>
										<th width="5%" style="text-align:center;">#</th>
										<th>TITLE</th>											
										<th width="10%"># OF ACTIVITY</th>
										<th width="10%"># OF ITEMS</th>
										<th width="5%"></th>
									</tr>
																				
								</thead>
							<tbody>
							<?php
							$_SESSION['SubCode']=$_GET['code'];
							 $no=0;
							 $result=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE SubCode='".$_GET['code']."' AND Quarter ='".$_SESSION['Quarter']."' AND Grade_Level='". $_SESSION['Grade_Level']."' ORDER BY Filename Asc");
							 while ($row=mysqli_fetch_array($result))
							 {
								 $no++;
								$totalitem=0;
									 $activity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE ModuleCode='".$row['ModuleCode']."' AND Grade_Level='".$_SESSION['Grade_Level']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND SubCode='".$_GET['code']."'");
									 while ($rowactive=mysqli_fetch_assoc($activity))
									 {
									  $totalitem=$totalitem+$rowactive['ItemNo'];
									 }
								echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Filename'].'</td>											
										<td style="text-align:center;" >'.mysqli_num_rows($activity).'</td>
											<td style="text-align:center;" >'.$totalitem.'</td>
										<td style="text-align:center;">
										<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($row['ModuleCode'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("addreadingmaterial")).'">VIEW</a>
										<a style="cursor:pointer;" id="'.$row['ModuleCode'].'" onclick="delete_dub(this.id)">Del</a>
										</td>
									</tr>'; 
							 }
							?>
						</tbody>
						</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-4">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      	
						<p style="text-align:center;"> Enter Module Filename <br/>(Grade 11 - TVL -Q2 - Module 1 <br/>Food Processing)</p>
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="" Method="POST" enctype="multipart/form-data">
						<label>Filename:</label>
                        <textarea rows="3" name="filename" class="form-control"></textarea>
						<hr/>
						<input type="submit" name="addmodule" class="btn btn-primary" style="float:right;">
						</form>
						<!--<label>Select Quarter</label>
						<form action="" method="POST">
						<label style="width:270px;">
						<select name="quarter" class="form-control" onchange="change_quarter(this.value)">
						   <option value="">--select--</option>
						   <option value="First">First Quarter</option>
						   <option value="Second">Second Quarter</option>
						   <option value="Third">Third Quarter</option>
						   <option value="Fourth">Fourth Quarter</option>
						</select>
						</label>
						<label>
						 <input type="submit" name="quartersave" value="SET" class="btn btn-primary">
						</label>	-->					</form>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				
                <!-- /.col-lg-12 -->
            </div>
           
		   	

 <form action="" id="frmBox" method="POST" onsubmit="return formSubmit();">
 <input type="hidden" id="filedata" name="filename" required>
 <input type="hidden" id="fileNo" name="Myno" required>

 </form>
 
 
	<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'save_upload.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('filedata').setFucos;
				return false;
				}
	</script>	
	
	
	<script>
	function delete_dub(id)
	{
		if(confirm("Are you sure you want to delete this row?"))
		{
			window.location.href='delete_duplicate.php?id='+id;
		}
	}
	</script>
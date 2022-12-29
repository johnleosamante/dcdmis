<script>
		function viewdata(str){
					
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("signate").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","view-signature.php?id="+str,false);
		  xmlhttp.send();
		}
	</script>
<?php
date_default_timezone_set("Asia/Manila");

if (isset($_POST['savelocator']))
{
	mysqli_query($con,"INSERT INTO tbl_locator_passslip VALUES('".date("ydms")."','".$_POST['category']."','".date("Y-m-d")."','".$_POST['purpose']."','".$_POST['timeleaving']."','".$_POST['timereturn']."','".$_POST['signature']."','For Approval','".$_SESSION[GetSiteAlias() . '_EmpID']."')");
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
<style>
	td,th{
		text-align:center;
	}
</style>
         <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>LOCATOR/PASS SLIP</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
                           <div class="col-lg-8">
						     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="10%">Category</th>
												<th width="15%">Date</th>
												<th>Purpose / Distination</th>
												<th width="15%">Time to leave</th>
												<th width="15%">Time to return</th>
												<th width="15%">Approved by</th>
												<th width="7%">Status</th>
											</tr>
										</thead>
									<tbody>	
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_locator_passslip WHERE Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."'");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Category'].'</td>
											<td>'.$row['dateout'].'</td>
											<td>'.$row['Purpose'].'</td>
											<td>'.$row['TimeLeaving'].'</td>
											<td>'.$row['TimeReturn'].'</td>
											<td>'.$row['Approvedby'].'</td>
											<td>'.$row['RequestStatus'].'</td>
										</tr>';
									}
									?>
									</tbody>
								</table>									
						   </div>
						   
						   <div class="col-lg-4">
						   <form action="" Method="POST" enctype="multipart/form-data">
						        <div class="form-group" style="font-weight: bold;">
                                        <label class="radio-inline" style="margin-left:50px">
                                            <input type="radio" name="category" id="optionsRadiosInline1" value="Official" required>Official
                                        </label>
                                         <label class="radio-inline" style="margin-left:150px">
                                                <input type="radio" name="category" id="optionsRadiosInline2" value="Personal" required>Personal
                                         </label>
                                           
                                 </div>
						   <label>Purpose / Distination:</label>
						   <textarea name="purpose" class="form-control" rows="3" required></textarea>
						    <label>Time to leave:</label>
							<input type="time" name="timeleaving" class="form-control" required>
							<label>Time to return:</label>
							<input type="time" name="timereturn" class="form-control" required>
							<label>Section:</label>
							<select  class="form-control" onchange="viewdata(this.value)" required>
								<option value="">--select--</option>
								<?php
								$sig=mysqli_query($con,"SELECT * FROM tbl_office WHERE Office_Name <>'SCHOOL' ORDER BY Office_Name Asc");
								while($rowsig=mysqli_fetch_array($sig))
								{
									echo '<option value="'.$rowsig['Office_Name'].'">'.$rowsig['Office_Name'].'</option>';
								}
								?>
							</select>
							<div id="signate"></div>
							<hr/>
							<input type="submit" name="savelocator" class="btn btn-primary">
							
							
						   </form>
						   </div>
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-12 -->
          
   
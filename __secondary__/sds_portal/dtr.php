	<script>
		function view_record(str){
					
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("txtdata").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","view_record.php?id="+str,false);
		  xmlhttp.send();
		}
	</script>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<a href="print_dtr_now.php" style="float:right;" class="btn btn-success" target="_blank">PRINT RECORD</a>
							Personnel Daily Time Record Masterlist 
							<div style="width:20%">
							<label>Select date to print</label>
							<input type="date" name="newdate" class="form-control" value="<?php echo date("Y-m-d");?>" onchange="view_record(this.value)">
							</div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div id="txtdata">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">NAME</th>
									<th rowspan="2">DATE</th>
									<th colspan="2" style="text-align:center;">MORNING LOG</th>
									<th colspan="2" style="text-align:center;">AFTERNOON LOG</th>
								</tr>
								<tr>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
			
								</tr>
                                </thead>
                                <tbody>
								
								<?php
								date_default_timezone_set("Asia/Manila");
									$no=0;
									$_SESSION['currentdate']=date("Y-m-d");
									$mydtrrecord=mysqli_query($con,"SELECT * FROM tbl_dtr INNER JOIN tbl_employee ON tbl_dtr.Emp_ID=tbl_employee.Emp_ID WHERE tbl_dtr.DTRDate = '".date("Y-m-d")."' ORDER BY tbl_dtr.TimeINAM Asc");
									while($DTRRow=mysqli_fetch_array($mydtrrecord))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$DTRRow['Emp_LName'].', '.$DTRRow['Emp_FName'].'</td>
												<td style="text-align:center;">'.$DTRRow['DTRDate'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeINAM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeOUTAM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeINPM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeOUTPM'].'</td>
										</tr>';
									}
									?>
									
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
              

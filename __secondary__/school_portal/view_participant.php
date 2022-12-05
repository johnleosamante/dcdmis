	<script>
		function view_data(str){
					
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("viewdata").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","viewdataquery.php?id="+str,false);
		  xmlhttp.send();
		}
	</script>
	<style>
	td{
		text-transform:uppercase;
	}
	</style>
             
            <!-- /.row -->
				
                <div class="col-lg-12">
                    <h1></h1>
                </div>
                <!-- /.col-lg-12 -->
          <div class="col-lg-12">
                    <h1></h1>
                </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
					     <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cGlzYQ%3D%3D" style="float:right;" class="btn btn-secondary" >Back</a>
					     <a href="printlist.php" style="float:right;" class="btn btn-primary" target="_blank">Print</a>
					<?php
					$_SESSION['CurrentDate']=date("Y-m-d");
					$_SESSION['SubCode']=$_GET['SubCode'];
					
					$mysub=mysqli_query($con,"SELECT * FROM tbl_pisa_subject WHERE SubCode='".$_GET['SubCode']."' LIMIT 1");
					$rowsub=mysqli_fetch_assoc($mysub);
						echo '<h4>Students’ Learning Progress Tracking Report  > ('.$rowsub['LearningAreas'].')</h4>';
						$_SESSION['Subject']=$rowsub['LearningAreas'];
					
					?>	
					<label>
						<select name="batch" class="form-control" onchange="view_data(this.value)">
							<option value="">--Select Date--</option>
							<option value="2022-04-04">April 4, 2022</option>
							<option value="2022-04-05">April 5, 2022</option>
							<option value="2022-04-06">April 6, 2022</option>
							<option value="2022-04-07">April 7, 2022</option>
							<option value="2022-04-08">April 8, 2022</option>
							<option value="2022-04-09">April 9, 2022</option>
							<option value="2022-04-11">April 11, 2022</option>
							<option value="2022-04-12">April 12, 2022</option>
							<option value="2022-04-13">April 13, 2022</option>
							<option value="2022-04-14">April 14, 2022</option>
							<option value="2022-04-15">April 15, 2022</option>
						</select>
					</label>
					
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div id="viewdata">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>NAME</th>
                                        <th width="10%" style="text-align:center;">Grade Level</th>
                                        <th width="10%" style="text-align:center;">Date Taken</th>
                                        <th width="10%" style="text-align:center;">No. of Item</th>
                                        <th width="10%" style="text-align:center;">Score</th>
                                                                               
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_pisa_participant WHERE SchoolID ='".$_SESSION['school_id']."' ORDER BY ParticipantName Asc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								 $mon=mysqli_query($con,"SELECT * FROM tbl_pisa_monitoring WHERE LRN='".$row['LRN']."' AND SubCode='".$_GET['SubCode']."' AND SchoolID='".$_SESSION['school_id']."' AND date_taken ='".date("Y-m-d")."'");
									$rowscore=mysqli_fetch_assoc($mon);	
								 echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['ParticipantName'].'</td>
											<td style="text-align:center;">'.$row['Grade_Level'].'</td>
											<td style="text-align:center;">'.$rowscore['date_taken'].'</td>
											<td style="text-align:center;">'.$rowscore['ItemNo'].'</td>
											<td style="text-align:center;">'.$rowscore['Score'].'</td>
											
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
                <!-- /.col-lg-12 -->

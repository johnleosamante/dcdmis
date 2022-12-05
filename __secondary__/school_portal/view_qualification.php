<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'save-report.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('no_of_module').setFucos;
				return false;
				}
				</script>	
<style>
th,td{
	text-transform:uppercase;
}
</style>
<div class="panel-body">
	<!-- Tab panes -->
                           							
	<div class="col-lg-12">
		<div class="panel panel-default">
            <div class="panel-heading">
			<?php
				
				$str=sha1("Pagadian City Division Data Management Information System");
				echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("lrmds")).'" class="btn btn-secondary" style="float:right;">Back</a>';
					if(isset($_POST['Addsubject']))
							 {
								
									mysqli_query($con,"INSERT tbl_shs_subject VALUES(NULL,'".$_POST['LA']."','".$_SESSION['SubGrade']."','".$_SESSION['Sem']."','".$_SESSION['school_id']."','".$_SESSION['SpCode']."')");
								
								if(mysqli_affected_rows($con)==1)
									{
									 $Err="Senior high Subject successfully Save!";	
										
									 echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
									});</script>';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
									} 
								
							 }elseif(isset($_POST['submit_report']))
							 {
								 
								   $myreport=mysqli_query($con,"SELECT * FROM tbl_shs_report WHERE tbl_shs_report.SubCode='".$_SESSION['SubNo']."' AND tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.SpecCode='".$_SESSION['SpCode']."'");
								   
								   if(mysqli_num_rows($myreport)==0)
								   {
									 date_default_timezone_set("Asia/Manila");
									mysqli_query($con,"INSERT INTO tbl_shs_report VALUES(NULL,'".$_SESSION['SubGrade']."','".$_POST['no_of_learner']."','".$_SESSION['SubNo']."','".$_POST['no_of_module']."','".$_SESSION['school_id']."','".date('Y-m-d')."','".$_SESSION['week']."','-','".$_SESSION['SubType']."','".$_SESSION['quarter']."','".$_GET['code']."')");
									if(mysqli_affected_rows($con)==1)
										{
										 $Err="LRMDS Senior high report successfully submitted!";	
											
										 echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
												
										});</script>';	
										echo '<div class="alert alert-success">'.$Err.'</div>';
										}  
								   }	
							 }elseif(isset($_POST['upreport'])){
									mysqli_query($con,"UPDATE tbl_shs_report SET No_of_copies='".$_POST['no_of_module']."',No_of_learner='".$_POST['no_of_learner']."' WHERE SubCode='".$_SESSION['SubNo']."' AND GradeLevel='".$_SESSION['SubGrade']."' AND SchoolID='".$_SESSION['school_id']."' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."' AND SpecCode='".$_GET['code']."'");
										   if(mysqli_affected_rows($con)==1)
												{
												 $Err="LRMDS Senior high report successfully Updated!";	
													
												 echo '<script type="text/javascript">
												$(document).ready(function(){						
												$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
														
												});</script>';	
												echo '<div class="alert alert-success">'.$Err.'</div>';
												}  
								   }	
							 
			 ?>
										<a href="#seniorreport" class="btn btn-primary" data-toggle="modal" style="float:right;">Add new Subject</a>
										<h4>Module Distribution for <i style="color:red;"><?php echo $_SESSION['quarter'].' Quarter - '.$_SESSION['week']; ?></i></h4>
									</div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;">
											<?php
											$_SESSION['SpCode']=$_GET['code'];
											$result=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode=tbl_qualification.SpCode WHERE tbl_qualification_by_school.QualCode='".$_GET['code']."' AND tbl_qualification_by_school.SchoolID ='".$_SESSION['school_id']."' AND tbl_qualification_by_school.QualSem ='".$_SESSION['Sem']."' LIMIT 1");
											$row=mysqli_fetch_assoc($result);
											echo '<label width="30%">TRACK:</label><label> '.$row['Track'].'</label><br/>
											<label width="30%">GRADE LEVEL:</label><label> GRADE '.$row['Grade'].'</label><br/>
											<label width="30%">STRAND:</label><label> '.$row['Strand'].'</label><br/>
											<label width="30%">QUALIFICATION:</label><label> '.$row['Description'].'</label><br/>';
											$_SESSION['SubGrade']=$row['Grade'];
											?>
											 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							
												<thead>
													<tr>
														<th width="5%" style="text-align:center;">#</th>
														<th width="40%">LEARNING AREAS</th>
														<th width="10%"  style="text-align:center;"># OF LEARNERS</th>
														<th width="10%"  style="text-align:center;"># OF MODULE</th>
														<th width="7%"  style="text-align:center;"></th>
														
													</tr>
												</thead>
												<tbody>
												<?php
												$no=$totalLearn=$totalmodule=$learner=0;
												if ($_SESSION['Sem']=='First Semester')
												{
												$learner=mysqli_query($con,"SELECT * FROM first_semester WHERE SpCode='".$_GET['code']."' AND school_year='".$_SESSION['year']."' AND Grade='".$_GET['g']."' AND SchoolID='".$_SESSION['school_id']."'");	
												}elseif ($_SESSION['Sem']=='Second Semester'){
												$learner=mysqli_query($con,"SELECT * FROM second_semester WHERE SpCode='".$_GET['code']."' AND school_year='".$_SESSION['year']."' AND Grade='".$_GET['g']."' AND SchoolID='".$_SESSION['school_id']."'");
												}
												$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_subject.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_subject.Grade='".$_GET['g']."' AND tbl_shs_subject.SpCode='".$_GET['code']."' AND tbl_shs_subject.Semester='".$_SESSION['Sem']."'");
												while($rowsubject=mysqli_fetch_array($mysubject))
												{
													$no++;
													
													$module=mysqli_query($con,"SELECt * FROM tbl_shs_report WHERE tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.SubCode='".$rowsubject['SubNo']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.SpecCode='".$_GET['code']."' ");
													$no_of_module=mysqli_fetch_assoc($module);
													echo ' <form action="save-report.php?SubNo='.$rowsubject['SubNo'].'"  method="POST" enctype="multipart/form-data"><tr>
														<td style="text-align:center;">'.$no.'</td>
														<td>'.$rowsubject['LearningAreas'].'</td>
														<td style="text-align:center;">'.mysqli_num_rows($learner).'</td>
														<td style="text-align:center;"><input type="text" value="'.$no_of_module['No_of_copies'].'" name="no_of_module" class="form-control" style="text-align:center;"></td>
														<td style="text-align:center;">Enter to save.</td>
														
													</tr></form>';
													$totalLearn=$totalLearn+$no_of_module['No_of_learner'];
													$totalmodule=$totalmodule+$no_of_module['No_of_copies'];
												}
												echo '<tr><th colspan="2">Total:</th><td style="text-align:center;">'.$totalLearn.'</td><td style="text-align:center;">'.$totalmodule.'</td></tr>';
												?>
												</tbody>
											</table>
											
									
											</div>
								
						
          
         </div>										
											
</div>
								
 <script>
	
		function delete_date(id)
		{
			if(confirm("Are you sure you want to deleted?"))
			{
				window.location.href='remove.php?id='+id;
			}
		}
	
	
	</script>   
            
   

 <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="seniorreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h4>ADD NEW SUBJECT</h4>
        </div>
			<form action="" Method="POST" enctype="multipart/form-data">
          
        <div class="modal-body">
					<label>SUBJECT TYPE</label>
					<select name="SubType" class="form-control" onchange="showsubStrand(this.value)"required>
						<option value="">--Select--</option>
						<?php
						$subtype=mysqli_query($con,"SELECT * FROM tbl_senior_strand_type ORDER BY StrandDescription Asc ");
						while($rowsub=mysqli_fetch_array($subtype))
						{
							echo '<option value="'.$rowsub['StrandCode'].'">'.$rowsub['StrandDescription'].'</option>';
						}
						?>
					</select>
					
		          <label>LEARNING AREAS</label>
					<select name="LA" class="form-control" id="txtsubstrand" required>
								<option value="">--select--</option>
								
							</select>
              
			    <label>SEMESTER</label>
				 <input type="text" name="semester" class="form-control" value="<?php echo $_SESSION['Sem']; ?>" required>
								
      
      </div>
	   <div class="modal-footer">
	   <input type="submit" name="Addsubject" class="btn btn-primary" value="SUBMIT">
	   </div>
	      </form>
    </div>
  </div>
  </div>
  </div>
  
   
  <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="updatereport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
       
    </div>
  </div>
  </div>
  </div>
  
   <script>
 function showsubStrand(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtsubstrand").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","subject_strand.php?id="+str,false);
  xmlhttp.send();
}
 </script>
 

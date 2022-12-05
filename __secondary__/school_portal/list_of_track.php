 <div class="col-lg-12">
                    <h3></h3>
                </div>               
			   <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <a href="#newtrack" class="btn btn-primary" style="float:right;" data-toggle="modal">Add New Qualification</a>
							<h4>List of Strands / Tracks</h4>
							<?php
							if(isset($_POST['AddQualification']))
							 {
								 mysqli_query($con,"INSERT INTO tbl_qualification_by_school VALUES(NULL,'".$_POST['qualification']."','".$_SESSION['Sem']."','".$_SESSION['school_id']."')");
								if(mysqli_affected_rows($con)==1)
									{
									 $Err="Senior high qualification successfully submitted!";	
									 echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
									});</script>';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
									}  
			 }
							?>			
                        </div>
                         <!-- /.panel-heading -->
                        <div class="panel-body">
													
							
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table class="table table-striped table-bordered table-hover">
										<thead>
										<tr>
											<th colspan="7">Grade 11 - Qualification offers for First Semester</th>
										</tr>
											<tr>
												<th>#</th>
												<th>Track</th>
												<th>Description</th>
												<th style="text-align:center;">Male</th>
												<th style="text-align:center;">Female</th>
												<th style="text-align:center;">Total</th>
												<th></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=$total11=$total12=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode =tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification.Grade ='11' AND tbl_qualification_by_school.QualSem ='First Semester' ORDER BY tbl_qualification.Strand Asc");
											while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											
											$male=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Male' AND first_semester.Grade='11'AND first_semester.school_year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc");
											$female=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Female' AND first_semester.Grade='11' AND first_semester.school_year='".$_SESSION['year']."'AND first_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc");
											
											
											echo '<tr>
													<td>'.$no.'</td>';
													
													echo '<td>'.$row['Track'].'</td>';
													echo '<td>'.$row['Description'].'</td>';
														
													$total11=mysqli_num_rows($male)+mysqli_num_rows($female);
													echo '
													<td style="text-align:center;">'.mysqli_num_rows($male).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($female).'</td>
													<td style="text-align:center;">'.$total11.'</td>
													<td style="text-align:center;">
															<a href="print-list-by-track.php?Grade='.urlencode(base64_encode('11')).'&Code='.urlencode(base64_encode($row['QualCode'])).'&Sem='.urlencode(base64_encode('First Semester')).'" target="_blank" title="View Students" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-print fa-fw"></i></a>
															<a onclick="removedata(this.id)" id="'.$row['QualNo'].'"  class="btn btn-warning" style="padding:4px;margin:4px;cursor:pointer;"><i class="fa fa-trash-o fa-fw"></i></a>
													</td>
											</tr>';
										}
											echo '<tr>
											<th colspan="7">Grade 11 - Qualification offers for Second Semester</th>
										</tr>';
										//$no=$total11Sec=$total12Sec=$male11=$female11=0;
										$no=$total11=$total12=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode =tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification.Grade ='11' AND tbl_qualification_by_school.QualSem ='Second Semester' ORDER BY tbl_qualification.Strand Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											
											$male=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Male' AND second_semester.Grade='11'AND second_semester.school_year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."'");
											$female=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Female' AND second_semester.Grade='11' AND second_semester.school_year='".$_SESSION['year']."'AND second_semester.SchoolID='".$_SESSION['school_id']."'");
											
											echo '<tr>
													<td>'.$no.'</td>';
													
													echo '<td>'.$row['Track'].'</td>';
													echo '<td>'.$row['Description'].'</td>';
														
													
													
													$total12=mysqli_num_rows($male)+mysqli_num_rows($female);
													echo '
													<td style="text-align:center;">'.mysqli_num_rows($male).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($female).'</td>
													<td style="text-align:center;">'.$total12.'</td>
													<td style="text-align:center;">
															<a href="print-list-by-track.php?Grade='.urlencode(base64_encode('11')).'&Code='.urlencode(base64_encode($row['QualCode'])).'&Sem='.urlencode(base64_encode('First Semester')).'" target="_blank" title="View Students" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-print fa-fw"></i></a>
															<a onclick="removedata(this.id)" id="'.$row['QualNo'].'"  class="btn btn-warning" style="padding:4px;margin:4px;cursor:pointer;"><i class="fa fa-trash-o fa-fw"></i></a>
													
														</td>
											</tr>';
										}
										
										echo '<tr>
											<th colspan="7">Grade 12 - Qualification offers for First Semester</th>
										</tr>';
										$no=$total11=$total12=0;
											$datereg=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode =tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification.Grade ='12' AND tbl_qualification_by_school.QualSem ='First Semester' ORDER BY tbl_qualification.Strand Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											
											$male12Sec=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Male' AND first_semester.Grade='12'AND first_semester.school_year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."'");
											$female12Sec=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Female' AND first_semester.Grade='12' AND first_semester.school_year='".$_SESSION['year']."'AND first_semester.SchoolID='".$_SESSION['school_id']."'");
											
											echo '<tr>
													<td>'.$no.'</td>';
													
													echo '<td>'.$row['Track'].'</td>';
													echo '<td>'.$row['Description'].'</td>';
														
													
													
													$total12Sec=mysqli_num_rows($male12Sec)+mysqli_num_rows($female12Sec);
													echo '
													<td style="text-align:center;">'.mysqli_num_rows($male12Sec).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($female12Sec).'</td>
													<td style="text-align:center;">'.$total12Sec.'</td>
													<td style="text-align:center;">
															<a href="print-list-by-track.php?Grade='.urlencode(base64_encode('12')).'&Code='.urlencode(base64_encode($row['QualCode'])).'&Sem='.urlencode(base64_encode('First Semester')).'" target="_blank" title="View Students" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-print fa-fw"></i></a>
															<a onclick="removedata(this.id)" id="'.$row['QualNo'].'"  class="btn btn-warning" style="padding:4px;margin:4px;cursor:pointer;"><i class="fa fa-trash-o fa-fw"></i></a>
													
													</td>
											</tr>';
										}
										echo '<tr>
											<th colspan="7">Grade 12 - Qualification offers for Second Semester</th>
										</tr>';
										$no=$total11=$total12=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode =tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['school_id']."' AND tbl_qualification.Grade ='12' AND tbl_qualification_by_school.QualSem ='Second Semester' ORDER BY tbl_qualification.Strand Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											
											$male=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Male' AND second_semester.Grade='12'AND second_semester.school_year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."'");
											$female=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SpCode='".$row['QualCode']."' AND tbl_student.Gender='Female' AND second_semester.Grade='12' AND second_semester.school_year='".$_SESSION['year']."'AND second_semester.SchoolID='".$_SESSION['school_id']."'");
											
											echo '<tr>
													<td>'.$no.'</td>';
													
													echo '<td>'.$row['Track'].'</td>';
													echo '<td>'.$row['Description'].'</td>';
														
													
													
													$total12=mysqli_num_rows($male)+mysqli_num_rows($female);
													echo '
													<td style="text-align:center;">'.mysqli_num_rows($male).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($female).'</td>
													<td style="text-align:center;">'.$total12.'</td>
													<td style="text-align:center;">
															<a href="print-list-by-track.php?Grade='.urlencode(base64_encode('12')).'&Code='.urlencode(base64_encode($row['QualCode'])).'&Sem='.urlencode(base64_encode('First Semester')).'" target="_blank" title="View Students" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-print fa-fw"></i></a>
															<a onclick="removedata(this.id)" id="'.$row['QualNo'].'"  class="btn btn-warning" style="padding:4px;margin:4px;cursor:pointer;"><i class="fa fa-trash-o fa-fw"></i></a>
													
													</td>
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
          
<script>
{
	function removedata(id)
	{
		if (confirm("Are you sure you want to delete entire row?"))
		{
			
			window.location.href='removespcode.php?Code='+id;
		}
	}
}
</script>



   <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
    
    
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4>SENIOR HIGH QUALIFICATION OFFERED</h4>
        </div>
			<form action="" Method="POST" enctype="multipart/form-data">
          
        <div class="modal-body">
		 <label>GRADE LEVEL</label>
			   <select name="Grade_Level" class="form-control" onchange="showGrade(this.value)"required>
				<option value="">--Select--</option>
				<option value="11">Grade 11</option>
				<option value="12">Grade 12</option>
				
			   </select>
		     <label>TRACK</label>
			   <select name="track" class="form-control" onchange="showQualification(this.value)" required>
				<option value="">--Select--</option>
				<option value="ACADEMIC">ACADEMIC</option>
				<option value="AGRI-FISHERIES ARTS">AGRI-FISHERIES ARTS</option>
				<option value="HOME ECONOMICS">HOME ECONOMICS</option>
				<option value="INDUSTRIAL ARTS">INDUSTRIAL ARTS</option>
				<option value="ICT">ICT</option>
			   </select>
			   
               <label>QUALIFICATION</label>
			   <select name="qualification" id="txtstrand"class="form-control" required>
				<option value="">--Select--</option>
				
			   </select>
            			   
			        
      </div>
	   <div class="modal-footer">
	   <input type="submit" name="AddQualification" class="btn btn-primary" value="SUBMIT">
	    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
	   </div>
	      </form>
    </div>
			  
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->



   <script>
 function showQualification(str) {
 
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
  xmlhttp.open("GET","list_of_strand.php?id="+str,false);
  xmlhttp.send();
}
 </script>
 
  <script>
 function showGrade(str) {
 
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
  xmlhttp.open("GET","subgrade.php?id="+str,false);
  xmlhttp.send();
}
 </script>
  
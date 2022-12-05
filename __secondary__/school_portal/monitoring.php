<?php
$result=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_status LIMIT 1");
$rows=mysqli_fetch_assoc($result);
?>
	<style>
	td{
		text-transform:uppercase;
	}
	</style>
             
            <!-- /.row -->
				<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
					
						<h4>Assessment Learner's Monitoring</h4>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Learner's Name</th>
                                        <th width="20%">Grade & Section</th>
                                        <th width="20%">Progress</th>
                                       <th width="5%">Status</th>
                                       <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$examinee=mysqli_query($con,"SELECT * FROM tbl_assessment_rat  INNER JOIN tbl_student ON tbl_assessment_rat.LRN = tbl_student.lrn INNER JOIN tbl_learners ON tbl_assessment_rat.LRN=tbl_learners.lrn INNER JOIN tbl_section ON tbl_learners.SecCode=tbl_section.SecCode WHERE tbl_assessment_rat.SchoolID='".$_SESSION['school_id']."'");
								while ($rowexam=mysqli_fetch_array($examinee))
								{
									$no++;
									 //Check Subject
									  $item=$percent=$rowanswer=0;
									  $mysubject=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Grade_Level='".$rowexam['Grade']."' AND Exam_Status='".$rows['Exam_Status']."'");
									  while ($myitem=mysqli_fetch_array($mysubject))
									  {
										$item=$item+$myitem['No_of_Items'];  
									  }
									  //Check my status
									  $answer=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_learner_answer WHERE LRN='".$rowexam['lrn']."'");
									  $rowanswer=mysqli_num_rows($answer);
									  //Percent
									  $percent=($rowanswer/ $item)* 100;
									echo '<tr>
                                        <td>'.$no.'</td>
                                        <td>'.$rowexam['Lname'].', '.$rowexam['FName'].'</td>
                                        <td>GRADE '.$rowexam['Grade'].' - '.$rowexam['SecDesc'].'</td>
                                        <td><div class="progress thin">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width:'.$percent.'%;background-color:green;color:black;font-size:14px;">'.$rowanswer.'/'.$item.'
											</div>
									  </td>';
									 
									  
									  $logstatus=mysqli_query($con,"SELECT * FROM tbl_student_user WHERE username='".$rowexam['lrn']."' AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");
									  $rowstatus=mysqli_fetch_assoc($logstatus);
									  if ($rowanswer==$item)
									  {
										 echo '<td><div style="background-color:blue;width:30px;height:30px;border-radius:50%;cursor:pointer;" title="Completed"></td>';
									    
									  }else{
									  if ($rowstatus['LoginStatus']=='Offline')
									  {
                                       echo '<td><div style="background-color:red;width:30px;height:30px;border-radius:50%;cursor:pointer;text-align:center;" title="Offline"></td>';
									  }elseif ($rowstatus['LoginStatus']=='Online')
									  {
										 echo '<td><div style="background-color:green;width:30px;height:30px;border-radius:50%;cursor:pointer;text-align:center;" title="Online"></td>';  
									  }elseif ($rowstatus['LoginStatus']=='Ongoing')
									  {
										 echo '<td><div style="background-color:yellow;width:30px;height:30px;border-radius:50%;cursor:pointer;text-align:center;" title="Ongoing"></td>';  
									  }
									  }
                                     echo '<td style="text-align:center;"><a href="test_paper.php?YLevel='.urlencode(base64_encode($rowexam['Grade'])).'&id='.urlencode(base64_encode($rowexam['lrn'])).'" target="_blank"><i class="fa fa-download fa-fw"></i></a></td>
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
                <!-- /.col-lg-12 -->

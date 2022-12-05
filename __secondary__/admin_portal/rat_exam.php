<?php
$_SESSION['assessment']=$_GET['Code'];
$result=mysqli_query($con,"SELECT * FROM tbl_assessment_type_of_exam WHERE ExamCode='".$_GET['Code']."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($result);
$_SESSION['CurrentExam']=$rowdata['Exam_Name'];
//Assessment Status
$rat=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_status LIMIT 1");
$rowstatus=mysqli_fetch_assoc($rat);
$_SESSION['rat_status']=$rowstatus['Exam_Status'];
?>
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

          
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
						<h4>BUREAU OF EDUCATION ASSESSMENT > PAGADIAN CITY DIVISION > <?php echo $_SESSION['CurrentExam']; ?></h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-book  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mygrade=mysqli_query($con,"SELECT * FROM tbl_assessment_grade_level_recipient WHERE Exam_type='".$_GET['Code']."' AND School_Year='".$_SESSION['year']."'");				
									echo '<div class="huge">'.mysqli_num_rows($mygrade).'</div>
                                    <div>Grade Level</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("my_division")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
						
                   <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-users  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn WHERE tbl_assessment_rat.School_Year='".$_SESSION['year']."' AND Exam_Code='".$_GET['Code']."'ORDER BY tbl_student.Lname Asc");
													
									echo '<div class="huge">'.mysqli_num_rows($myinfo).'</div>
                                    <div>List of Examinee</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_examinee")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                           

				 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-book  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
													
									echo '<div class="huge">-</div>
                                    <div>List of Subjects</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_subject")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-book  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
													
									echo '<div class="huge">-</div>
                                    <div>Region Reports</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("my_report")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
						 
                   
						 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              

<!-- Modal for Re-assign-->
<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="setaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>

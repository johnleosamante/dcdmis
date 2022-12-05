<?php
$_SESSION['CurrentDate']="";
$_SESSION['SubCode']="";

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
                                        <th>Learning Areas</th>
                                        <th width="20%"># of Item</th>
                                        <th width="20%">Time Limit</th>
                                        <th width="20%">Participant</th>
                                       <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$myparticipant=mysqli_query($con,"SELECT * FROM tbl_pisa_participant WHERE SchoolID='".$_SESSION['school_id']."'");
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_pisa_subject WHERE SchoolID='".$_SESSION['school_id']."'");
								while($rowsub=mysqli_fetch_array($mysubject))
								{
									$no++;
									
									echo '<tr>
                                           <td style="text-align:center;">'.$no.'</td>
                                           <td>'.$rowsub['LearningAreas'].'</td>
                                            <td>'.$rowsub['ItemNo'].'</td>
                                            <td>'.$rowsub['TimeLimit'].'</td>
                                            <td>'.mysqli_num_rows($myparticipant).'</td>
                                           <td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&SubCode='.urlencode(base64_encode($rowsub['SubCode'])).'&Item='.urlencode(base64_encode($rowsub['ItemNo'])).'&v='.urlencode(base64_encode("view_participant")).'">VIEW</a></td>
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

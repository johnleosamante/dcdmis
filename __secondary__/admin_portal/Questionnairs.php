<?php
if (!is_dir('../quiz/'.$_GET['Code'])) {
    mkdir('../quiz/'.$_GET['Code'], 0777, true);
}

$subject=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE RATSubCode ='".$_GET['Code']."' AND Exam_Status='".$_SESSION['rat_status']."'LIMIT 1");
$rowsub=mysqli_fetch_assoc($subject);
$_SESSION['SubCode']=$_GET['Code'];
$_SESSION['GLevel']=$_GET['GLevel'];

if (isset($_POST['AddOption']))
{
	
	//Option Letter A   
								$queryA=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='A'");
								$dataA=$_POST['A'];
								$dataA=str_replace("'","\'",$dataA);
								if (mysqli_num_rows($queryA)==1)
								 {
									$opA=mysqli_fetch_assoc($queryA);
									if ($opA['QOption']<>"")
									{									
										mysqli_query($con,"UPDATE tbl_assessment_rat_option SET QOption = '".$dataA."' WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='A'");
									}
								 }else{
									 mysqli_query($con,"INSERT tbl_assessment_rat_option VALUES(NULL,'".$_SESSION['No']."','".$dataA."','A','".$_SESSION['SubCode']."','')");    
								 }
								 //Option Letter B  
								$queryB=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='B'");
								$dataB=$_POST['B'];
								$dataB=str_replace("'","\'",$dataB);
								if (mysqli_num_rows($queryB)==1)
								 {
									 $opB=mysqli_fetch_assoc($queryB);
									if ($opB['QOption']<>"")
									{
									mysqli_query($con,"UPDATE tbl_assessment_rat_option SET QOption = '".$dataB."' WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='B'");
									}
								 }else{
									 mysqli_query($con,"INSERT tbl_assessment_rat_option VALUES(NULL,'".$_SESSION['No']."','".$dataB."','B','".$_SESSION['SubCode']."','')");    
								 }
								 
								 //Option Letter C  
								$queryC=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='C'");
								 $dataC=$_POST['C'];
								$dataC=str_replace("'","\'",$dataC);
								 if (mysqli_num_rows($queryC)==1)
								 {
									  $opC=mysqli_fetch_assoc($queryC);
									if ($opC['QOption']<>"")
									{
									mysqli_query($con,"UPDATE tbl_assessment_rat_option SET QOption = '".$dataC."' WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='C'");
									}
								}else{
									 mysqli_query($con,"INSERT tbl_assessment_rat_option VALUES(NULL,'".$_SESSION['No']."','".$dataC."','C','".$_SESSION['SubCode']."','')");    
								 }
								 //Option Letter D  
								$queryD=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='D'");
								 $dataD=$_POST['D'];
								$dataD=str_replace("'","\'",$dataD);
								 if (mysqli_num_rows($queryD)==1)
								 {
									   $opD=mysqli_fetch_assoc($queryD);
									if ($opD['QOption']<>"")
									{
									mysqli_query($con,"UPDATE tbl_assessment_rat_option SET QOption = '".$dataD."' WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='D'");
									}
								 }else{
									 mysqli_query($con,"INSERT tbl_assessment_rat_option VALUES(NULL,'".$_SESSION['No']."','".$dataD."','D','".$_SESSION['SubCode']."','')");    
								 }
								 //Option Letter E 
								 if ($_POST['E']<>"")
								 {
										$queryE=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='E'");
										 $dataE=$_POST['E'];
										$dataE=str_replace("'","\'",$dataE);
										 if (mysqli_num_rows($queryE)==1)
										 {
											   $opE=mysqli_fetch_assoc($queryE);
												if ($opE['QOption']<>"")
												{
												mysqli_query($con,"UPDATE tbl_assessment_rat_option SET QOption = '".$dataE."' WHERE tbl_assessment_rat_option.QNumber='".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter='E'");
												}
										 }else{
											 mysqli_query($con,"INSERT tbl_assessment_rat_option VALUES(NULL,'".$_SESSION['No']."','".$dataE."','E','".$_SESSION['SubCode']."','')");    
										 }
								 }
							 
						mysqli_query($con,"UPDATE tbl_assessment_rat_questionaires SET tbl_assessment_rat_questionaires.Answer ='".$_POST['Answer']."' WHERE tbl_assessment_rat_questionaires.QNumber ='".$_SESSION['No']."' AND tbl_assessment_rat_questionaires.SubCode='".$_SESSION['SubCode']."' LIMIT 1");
    
 
 
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



$_SESSION['No']="";
$_SESSION['NoOp']="";
echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_subject")).'" class="btn btn-secondary" style="float:right;">Back</a>';
if ($rowsub['Status']=='Closed')
{
echo '<a href="update_status.php?Code='.urlencode(base64_encode("Closed")).'" class="btn btn-success" style="float:right;">Subject is Closed! Click to Open</a>';
}else{
	echo '<a href="update_status.php?Code='.urlencode(base64_encode("Opened")).'" class="btn btn-success" style="float:right;">Subject is Open! Click to Close</a>';
}


echo '<label> Grade Level: Grade '.$_GET['GLevel'].'</label><br/>

<label>Learning Area: '.$rowsub['Learning_Areas'].' Subject </label><br/>
<label># of Item: '.$rowsub['No_of_Items'].' Items </label><hr/>';

echo '<a href="view_reports.php?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($_SESSION['SubCode'])).'" style="float:right;" class="btn btn-primary" target="_blank">View Report</a>';

$myQA=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE SubCode='".$_SESSION['SubCode']."' ORDER BY QNumber Asc");
if (mysqli_num_rows($myQA)<>$rowsub['No_of_Items'])
{
echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&subcode='.urlencode(base64_encode($_SESSION['SubCode'])).'&v='.urlencode(base64_encode("addquestion")).'" style="float:right;" class="btn btn-success" >Add Question</a>';
}
echo '<h3>Multiple choice</h3>';



	echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                           
							<thead>
								<tr>
									<th width="5%" rowspan="2" style="text-align:center;">#</th>
									<th rowspan="2">List of Competencies</th>																
									<th rowspan="2" width="10%"></th>																
								</tr>
								
							</thead>
							<tbody>';
	while ($myQrow=mysqli_fetch_array($myQA))
	{
		if ($myQrow['Link_picture']=="")
		{
	
		echo '<tr>
			<td style="text-align:center;">'.$myQrow['QNumber'].'.</td>
			<td>'.$myQrow['Questionnairs'].'<hr/>';
			
			
			$myoption=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$myQrow['QNumber']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' ORDER BY tbl_assessment_rat_option.Letter Asc"); 
  
				echo '<div class="radios">';
			   while($rowoption=mysqli_fetch_array($myoption))	
			   {
				   if($rowoption['QOption']<>"")
				   {
					   if ($rowoption['Letter']==$myQrow['Answer'])
					   {
						  echo '<label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" checked title="'.$rowoption['Letter'].'"/> '.$rowoption['Letter'].'. '.$rowoption['QOption'].'</label><br/>';  
					   }else{
					   echo '<label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" title="'.$rowoption['Letter'].'"/> '.$rowoption['Letter'].'. '.$rowoption['QOption'].'</label><br/>';
						}
				   }else{
					    if ($rowoption['Letter']==$myQrow['Answer'])
					   {
					   echo '<div class="col-lg-6">
							<label style="font-weight: bold;">
								<input type="radio" name="'.$rowoption['QNumber'].'" checked title="'.$rowoption['Letter'].'"/>'.$rowoption['Letter'].'. </label>  <img src="'.$rowoption['Picture_link'].'" style="padding:4px;margin:4px;width:250px;border:solid 1px black;height:50px;"><hr/>
								</div>';
					   }else{
						  echo '<div class="col-lg-6"><label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" title="'.$rowoption['Letter'].'"/> '.$rowoption['Letter'].'. </label> <img src="'.$rowoption['Picture_link'].'" style="padding:4px;margin:4px;width:250px;border:solid 1px black;height:50px;"></div>';
					    
					   }
				   }
			   }
	
			
			echo '</td>
			<td style="text-align:center;">
			<a href="myoption.php?No='.$myQrow['QNumber'].'" title="Click to browsed" data-toggle="modal" data-target="#myexam">Set Answer</a>
			</td>
		</tr>';
	 
		}else{
		 echo  '<tr>
					<td style="text-align:center;">'.$myQrow['QNumber'].'.</td> 
					
					<td><a href="update_question.php?No='.urlencode(base64_encode($myQrow['QNumber'])).'" title="Click to Edit" data-toggle="modal" data-target="#myexam">
					<img src="'.$myQrow['Link_picture'].'" style="width:100%;height:100px;"></a>';
					
					if ($myQrow['Questionnairs']<>"")
					{
						echo '<h4>'.$myQrow['Questionnairs'].'</h4>';
					}
					echo '<hr/>';
			$myoption=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='".$myQrow['QNumber']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' ORDER BY tbl_assessment_rat_option.Letter Asc"); 
  
				echo '<div class="radios">';
			   while($rowoption=mysqli_fetch_array($myoption))	
			   {
				   if($rowoption['QOption']<>"")
				   {
				   if ($rowoption['Letter']==$myQrow['Answer'])
				   {
					  echo '<label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" checked /> '.$rowoption['Letter'].'. </label>'.$rowoption['QOption'].'</label><br/>';  
				   }else{
					echo '<label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'"/> '.$rowoption['Letter'].'. '.$rowoption['QOption'].'</label><br/>';
					}
					}else{
					    if ($rowoption['Letter']==$myQrow['Answer'])
					   {
					   echo '<div class="col-lg-6"><label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" checked title="'.$rowoption['Letter'].'"/>'.$rowoption['Letter'].'. </label>  <img src="'.$rowoption['Picture_link'].'" style="padding:4px;margin:4px;width:250px;border:solid 1px black;height:50px;"></div>';
					   }else{
						  echo '<div class="col-lg-6"><label style="font-weight: bold;"><input type="radio" name="'.$rowoption['QNumber'].'" title="'.$rowoption['Letter'].'"/> '.$rowoption['Letter'].'.</label>  <img src="'.$rowoption['Picture_link'].'" style="padding:4px;margin:4px;width:250px;border:solid 1px black;height:50px;"></div>';
					    
					   }
				   }
				
			   }
	
			
			echo '</td>
					<td style="text-align:center;">
						<a href="myoption.php?No='.$myQrow['QNumber'].'" title="Click to browsed" data-toggle="modal" data-target="#myexam">Set Answer</a>
					</td>
				</tr>';
					
		}
		
	}
	

?>



		<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myexam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  </div>
	  </div>
	  </div>
	  </div>
	  

                 <!-- Modal -->
	 <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="margin-left:auto;margin-right:auto;width:30%; height:25%;margin-top:50px;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Save!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <center>
		    <?php
			 echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($_SESSION['SubCode'])).'&GLevel='.urlencode(base64_encode($_SESSION['GLevel'])).'&v='.urlencode(base64_encode("Questionnairs")).'" class="btn btn-success" style="float:right;">OK</a>';
			?>
			</center>
		 </div>	

	</div></div>
	</div>
  	  
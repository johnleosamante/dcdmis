<?php
$_SESSION['ApplicanNo']=$_GET['account'];
if (isset($_POST['save_score']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$_GET['account']."'");
	if (mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"INSERT INTO tbl_applicant_rating VALUES(NULL,'".$_POST['GWA']."','".$_POST['Equivalent']."','".$_POST['MA_PhD']."','".$_POST['EducTotal']."','".$_POST['GTE']."','".$_POST['KVT']."','".$_POST['TeachTotal']."','".$_POST['LETRating']."','".$_POST['LETEquivalent']."','".$_POST['LETCert']."','".$_POST['LETDemo']."','".$_POST['SpecialTotal']."','".$_POST['Interview']."','".$_POST['DemoTeach']."','".$_POST['EngRating']."','".$_POST['EngEquivalent']."','".$_GET['account']."','".$_POST['MotherTongue']."','')");
	}else{
		mysqli_query($con,"UPDATE tbl_applicant_rating SET One='".$_POST['GWA']."',EdEquiv='".$_POST['Equivalent']."',Three='".$_POST['MA_PhD']."',EdSubTotal='".$_POST['EducTotal']."',Five='".$_POST['GTE']."',Six='".$_POST['KVT']."',TeachSubTotal='".$_POST['TeachTotal']."',Eight='".$_POST['LETRating']."',RateEquive='".$_POST['LETEquivalent']."',Ten='".$_POST['LETCert']."',Eleven='".$_POST['LETDemo']."',SpecialSubTotal='".$_POST['SpecialTotal']."',Thirteen='".$_POST['Interview']."',Fourteen='".$_POST['DemoTeach']."',Fifteen='".$_POST['EngRating']."',EngEval='".$_POST['EngEquivalent']."',MotherTongue='".$_POST['MotherTongue']."',OverALL='".$_POST['GTotal']."' WHERE ApplicanNo='".$_GET['account']."' LIMIT 1");
	}
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
<script>
 function addEdTotal()
 {
	 var a = parseFloat(document.getElementById("eguiv").value);
	 var b = parseFloat(document.getElementById("master").value);
	 var c= a + b;
	 document.getElementById("EdSub").value = c;
	 document.getElementById("EdSubTot").value = c;
 }
 
 function addTeach()
 {
	
	 var d = parseFloat(document.getElementById("GenTE").value);
	 var e = parseFloat(document.getElementById("KVT").value);
	  
	 var f= d + e;
	 document.getElementById("TeacSub").value = f;
	 document.getElementById("TeacSubTotal").value = f;
 }
 
  function addSpecial()
 {
	
	 var g = parseFloat(document.getElementById("cert").value);
	 var h = parseFloat(document.getElementById("dem").value);
	  
	 var i= g + h;
	 document.getElementById("SpecSub").value = i;
	 document.getElementById("SpecSubTotal").value = i;
 }
 function addMother()
 {
	
	 var k = parseFloat(document.getElementById("demoteach").value);
	 var l = parseFloat(document.getElementById("mt").value);
	  
	 var m= k + l;
	 document.getElementById("dmtsub").value = m;
	 
 }
</script>

 <h2></h2>
				 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
					 <?php
					  $result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Appl_No='".$_GET['account']."' LIMIT 1");
					  $row=mysqli_fetch_assoc($result);
							if($row['Category']=='KINDER')
						   {
							echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("kinder_level")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						    echo '<a href="print_kinder_result/" style="float:right;" class="btn btn-success" target="_blank">PRINT PREVIEW</a>';	
						  }elseif($row['Category']=='ELEMENTARY')
						   {
							echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("elementary_level")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						     echo '<a href="print_elementary_result/" style="float:right;" class="btn btn-success" target="_blank">PRINT PREVIEW</a>';	
						   }elseif($row['Category']=='SECONDARY')
						   {
							    
							echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("secondary_level")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						   echo '<a href="print_result/" style="float:right;" class="btn btn-success" target="_blank">PRINT PREVIEW</a>';	
						  }elseif($row['Category']=='SENIOR')
						   {
							   
							 	echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("senior_high_level")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						     echo '<a href="print_result/" style="float:right;" class="btn btn-success" target="_blank">PRINT PREVIEW</a>';	
						   }
						  $_SESSION['ApplicantCat'] =$row['Category'];
					  
					 
						 ?>
						<h4>Applicant Individual Information</h4>
				  						   
					   </div>
                        <!-- /.panel-heading -->
					  <form action="" Method="POST" enctype="multipart/form-data">
                        <div class="panel-body">
					
						 <div class="col-lg-3">
                          <?php
						  $grandtotal=0;
						 
						   if($row['Category']=='ELEMENTARY' || $row['Category']=='KINDER')
						   {
							echo '<label>APPLICANT NAME:</label>
									<input type="text" value="'.$row['Last_Name'].', '.$row['First_Name'].' '.$row['Middle_Name'].'" class="form-control" disabled>';
							
						   }elseif($row['Category']=='SECONDARY')
						   {
							  echo '<label>APPLICANT NAME:</label>
									<input type="text" value="'.$row['Last_Name'].', '.$row['First_Name'].' '.$row['Middle_Name'].'" class="form-control" disabled>';
							  echo '<label>MAJOR SUBJECT:</label>
									<input type="text" value="'.$row['Major'].'" class="form-control" disabled>';	
																
						   }elseif($row['Category']=='SENIOR')
						   {
							  echo '<label>APPLICANT NAME:</label>
									<input type="text" value="'.$row['Last_Name'].', '.$row['First_Name'].' '.$row['Middle_Name'].'" class="form-control" disabled>';
							  echo '<label>TRACK/STRAND:</label>
									<input type="text" value="'.$row['Major'].'" class="form-control" disabled>';	
																
						   }
						   $myscore=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$_GET['account']."' LIMIT 1");
						   $rowscore=mysqli_fetch_assoc($myscore);
						   $demtotal= $rowscore['Fourteen']+$rowscore['MotherTongue'];
						   $grandtotal= $rowscore['EdSubTotal'] + $rowscore['TeachSubTotal'] + $rowscore['RateEquive'] + $rowscore['SpecialSubTotal'] + $rowscore['EngEval']+ $rowscore['Thirteen']+ $rowscore['Fourteen']+ $rowscore['MotherTongue'];
						     echo '<label>GRAND TOTAL:</label>
									<input type="hidden" value="'.number_format($grandtotal,2).'" name="GTotal" class="form-control">
									<input type="text" value="'.number_format($grandtotal,2).'" class="form-control" disabled>';	
						  ?>
						  <br/>
                            	<input type="submit" name="save_score" value="SAVE SCORE" class="btn btn-primary" style="width:100%;">
                        </div>
					
						<div class="col-lg-3">
						<h4><b>EDUCATION (20)</b></h4>
						<label>GWA Rating</label>
						<input type="text" name="GWA" class="form-control" value="<?php echo $rowscore['One']; ?>" required>
						<label>Equivalent (18)</label>
						<input type="text" name="Equivalent" class="form-control" id="eguiv" value="<?php echo $rowscore['EdEquiv']; ?>" onkeyup="addEdTotal(this.value)" required>
						<label>MA/PhD (2)</label>
						<input type="text" name="MA_PhD" class="form-control" id="master" value="<?php echo $rowscore['Three']; ?>" onkeyup="addEdTotal(this.value)" required>
						<label>Sub Total (20)</label>
						<input type="text" class="form-control" id="EdSub" disabled value="<?php echo $rowscore['EdSubTotal']; ?>">
						<input type="hidden" name="EducTotal" class="form-control" id="EdSubTot"  value="<?php echo $rowscore['EdSubTotal']; ?>">
						<h4><b>TEACHING EXPERIENCE (15)</b></h4>
						<label>Gen T E.(12)</label>
						<input type="text" name="GTE" class="form-control" value="<?php echo $rowscore['Five']; ?>" id="GenTE" onkeyup="addTeach(this.value)" required>
						<label>KVT/ LGU (3)</label>
						<input type="text" name="KVT" class="form-control" value="<?php echo $rowscore['Six']; ?>" id="KVT" onkeyup="addTeach(this.value)" required>
						<label>Sub Total (15)</label>
						<input type="text"  class="form-control" id="TeacSub" disabled value="<?php echo $rowscore['TeachSubTotal']; ?>">
						<input type="hidden" name="TeachTotal" class="form-control" id="TeacSubTotal" value="<?php echo $rowscore['TeachSubTotal']; ?>">
                        </div>
						
						<div class="col-lg-3">
						<h4><b>LET/PBET (15)</b></h4>
						<label>Rating</label>
						<input type="text" name="LETRating" class="form-control" value="<?php echo $rowscore['Eight']; ?>" required>
						<label>Equivalent (15)</label>
						<input type="text" name="LETEquivalent" class="form-control" value="<?php echo $rowscore['RateEquive']; ?>" required>
						<h4><b>Specialized T&S (10)</b></h4>
						<label>Certificate (5)</label>
						<input type="text" name="LETCert" class="form-control" value="<?php echo $rowscore['Ten']; ?>" id="cert" onkeyup="addSpecial(this.value)" required>
						<label>Demo (5)</label>
						<input type="text" name="LETDemo" class="form-control" value="<?php echo $rowscore['Eleven']; ?>" id="dem" onkeyup="addSpecial(this.value)" required>
						<label>Sub Total (10)</label>
						<input type="text"  class="form-control" id="SpecSub" disabled value="<?php echo $rowscore['SpecialSubTotal']; ?>">
						<input type="hidden" name="SpecialTotal" class="form-control" id="SpecSubTotal" value="<?php echo $rowscore['SpecialSubTotal']; ?>">
                        </div>
						
						<div class="col-lg-3">
						
						<label>Interview (10)</label>
						<input type="text" name="Interview" class="form-control" value="<?php echo $rowscore['Thirteen']; ?>" required>
						<label>Demo Teachng (15)</label>
						<input type="text" name="DemoTeach" id="demoteach" class="form-control" onkeyup="addMother(this.value)" value="<?php echo $rowscore['Fourteen']; ?>" required>
						
						<label>Mother Tongue (5)</label>
						<input type="text" name="MotherTongue" id="mt" class="form-control"  onkeyup="addMother(this.value)" value="<?php echo $rowscore['MotherTongue']; ?>" required>
						<label>Sub Total </label>
						<input type="text" name="dmtsubtotal" id="dmtsub" class="form-control" value="<?php echo  $demtotal; ?>" required disabled>
						
						<h4><b>Eng. Com Skls (15)</b></h4>
						<label>Rating </label>
						<input type="text" name="EngRating" class="form-control" value="<?php echo $rowscore['Fifteen']; ?>" required>
						<label>Equivalent (15)</label>
						<input type="text" name="EngEquivalent" class="form-control" value="<?php echo $rowscore['EngEval']; ?>" required>
					
                        </div>
						
						
                        </div>
						
					
						</form>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
			  
			
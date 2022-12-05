
 
 <script>
 function view_data(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtbatchno").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","batchno.php?id="+str,false);
  xmlhttp.send();
}
 </script>
  <div class="col-lg-12">				   
	
	<div class="alert alert-info" style="color:black;border-radius:.3em;width:100%;font-size:20px;">
	          <label style="float:right;">
					<select name="batch" class="form-control" onchange="view_data(this.value)">
						<option value="">--Select--</option>
						<?php
						$mybatch =mysqli_query($con,"SELECT * FROM tbl_pisa_batch ORDER BY BatchName Asc");
						while($rowba=mysqli_fetch_array($mybatch))
						{
							echo '<option value="'.$rowba['BatchCode'].'">'.$rowba['BatchName'].'</option>';
						}
						?>
						
					</select>
					</label>
				   <p>Learning Areas Coverage Information*</p>
				   <div id="txtbatchno"></div>
				  </div> 
				  </div> 
				  
                 <div class="col-lg-6">
				  
				
				   <div class="alert alert-success" style="color:black;border-radius:.3em;width:100%;font-size:20px;">
				   <h2>Pagadian City National High School</h2><hr/>
				     <?php
					 //Batches status
					 $openbatch=mysqli_query($con,"SELECT * FROM tbl_pisa_batch WHERE BatchStatus='Open' LIMIT 1");
					 $rowbatch=mysqli_fetch_assoc($openbatch);
					 $_SESSION['Batchno']=$rowbatch['BatchCode'];
					 
					//Learning Areas
				   $mysubject=mysqli_query($con,"SELECT * FROM tbl_pisa_subject WHERE SchoolID='303908' ORDER BY SchoolID Asc");
				   while ($rowsub=mysqli_fetch_array($mysubject))
				   {
					   echo ' <p><i class="fa fa-play"></i> '.$rowsub['LearningAreas'].'</p>
					    <p>'.$rowsub['ItemNo'].' Items '.$rowsub['TimeLimit'].'
					    <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode("1")).'&Item='.urlencode(base64_encode($rowsub['ItemNo'])).'&SubCode='.urlencode(base64_encode($rowsub['SubCode'])).'&SchoolID='.urlencode(base64_encode($rowsub['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" title="'.$rowsub['ItemNo'].' Items and '.$rowsub['TimeLimit'].' Time Limit." class="btn btn-warning" style="float:right;">SET QUESTION</a></p><hr/>
						';
				   }
				   ?>
				  </div>
            </div>
			<div class="col-lg-6">
				  
				
				   <div class="alert alert-success" style="color:black;border-radius:.3em;width:100%;font-size:20px;">
				   <h2>Zamboanga del Sur National High School</h2><hr/>
				     <?php
					//Learning Areas
				   $mysubject=mysqli_query($con,"SELECT * FROM tbl_pisa_subject WHERE SchoolID='303910' ORDER BY SchoolID Asc");
				   while ($rowsub=mysqli_fetch_array($mysubject))
				   {
					   echo ' <p><i class="fa fa-play"></i> '.$rowsub['LearningAreas'].'</p>
					    <p>'.$rowsub['ItemNo'].' Items '.$rowsub['TimeLimit'].'
					    <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode("1")).'&Item='.urlencode(base64_encode($rowsub['ItemNo'])).'&SubCode='.urlencode(base64_encode($rowsub['SubCode'])).'&SchoolID='.urlencode(base64_encode($rowsub['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" title="'.$rowsub['ItemNo'].' Items and '.$rowsub['TimeLimit'].' Time Limit." class="btn btn-warning" style="float:right;">SET QUESTION</a></p><hr/>
						';
				   }
				   ?>
				  </div>
            </div>
			<div class="col-lg-12">
			<img src="../../pisa/images/pisa.PNG" style="padding:4px;width:100%;">
			</div>
			
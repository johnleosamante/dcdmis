
 
 <script>
 function showStrand(str) {
 
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
 
<?php
if (isset($_POST['week'])){
$_SESSION['week']=$_POST['week'];
$_SESSION['quarter']=$_POST['quarter'];
}else{
		
$mysched=mysqli_query($con,"SELECT * FROM tbl_distribution_schedule");
$rowdata=mysqli_fetch_assoc($mysched);
$_SESSION['quarter']=$rowdata['QuarterNo'];					 		
$_SESSION['week']=$rowdata['WeekNo'];	
}	 
			 if (isset($_POST['add']))
			 {
				
			
				 if ($_SESSION['Category']=='Elementary')
					{
						
					$queryelem=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='".$_POST['GLevel']."' AND WeekNo = '".$_POST['No_of_week']."'AND QuarterNo='".$_POST['QuarterNo']."' AND SchoolID='".$_SESSION['school_id']."'");
					if (mysqli_num_rows($queryelem)==0)
					{
						
						mysqli_query($con,"INSERT INTO tbl_elementary_subject VALUES(NULL,'".$_POST['GLevel']."','".$_POST['No_of_learner']."','".$_POST['English']."','".$_POST['Science']."','".$_POST['Math']."','".$_POST['Filipino']."','".$_POST['AralPan']."','".$_POST['ESP']."','".$_POST['TLE']."','".$_POST['MAPEH']."','".$_POST['Mother_Tongue']."','".$_POST['ROThematic']."','".$_POST['ProjRush']."','".$_SESSION['school_id']."','".$_POST['datesub']."','".$_POST['No_of_week']."','".$_POST['QuarterNo']."')"); 
					}else{
						$Err="Wala nakasulod ang data";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
						}
					}elseif ($_SESSION['Category']=='Secondary')
					{
						
					$query=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='".$_POST['GLevel']."' AND WeekNo = '".$_POST['No_of_week']."'AND QuarterNo='".$_POST['QuarterNo']."' AND SchoolID='".$_SESSION['school_id']."'");
					if (mysqli_num_rows($query)==0)
					{	
					mysqli_query($con,"INSERT INTO tbl_secondary_subject VALUES(NULL,'".$_POST['GLevel']."','".$_POST['No_of_learner']."','".$_POST['English']."','".$_POST['Science']."','".$_POST['Math']."','".$_POST['Filipino']."','".$_POST['AralPan']."','".$_POST['ESP']."','".$_POST['TLE']."','".$_POST['Music']."','".$_POST['Arts']."','".$_POST['PE']."','".$_POST['Health']."','".$_POST['ROThematic']."','".$_POST['Elec1']."','".$_POST['Elec2']."','".$_POST['Elec3']."','".$_SESSION['school_id']."','".$_POST['datesub']."','".$_POST['No_of_week']."','".$_POST['QuarterNo']."')"); 
					}
					}else{
						$Err="Wala nakasulod ang data";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}
				if(mysqli_affected_rows($con)==1)
					{
					 $Err="LRMDS Report successfully submitted";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}else{
						 $Err="Wala nakasulod ang data";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}
			 }elseif (isset($_POST['update']))
			 {
				 if ($_SESSION['Category']=='Elementary')
					{
					mysqli_query($con,"UPDATE tbl_elementary_subject SET No_of_learner='".$_POST['No_of_learner']."',English='".$_POST['English']."',Science='".$_POST['Science']."',Math='".$_POST['Math']."',Filipino='".$_POST['Filipino']."',AralPan='".$_POST['AralPan']."',ESP='".$_POST['ESP']."',TLE='".$_POST['TLE']."',MAPEH='".$_POST['MAPEH']."',Mother_tongue='".$_POST['Mother_Tongue']."',RO_Thematic='".$_POST['ROThematic']."',Project_Rush='".$_POST['ProjRush']."' WHERE SchoolID = '".$_SESSION['school_id']."' AND SubNo='".$_SESSION['SubNo']."' LIMIT 1"); 
					}elseif ($_SESSION['Category']=='Secondary')
					{
					mysqli_query($con,"UPDATE tbl_secondary_subject SET No_of_learner='".$_POST['No_of_learner']."',English='".$_POST['English']."',Science='".$_POST['Science']."',Math='".$_POST['Math']."',Filipino='".$_POST['Filipino']."',AralPan='".$_POST['AralPan']."',ESP='".$_POST['ESP']."',TLE='".$_POST['TLE']."',Music='".$_POST['Music']."',Arts='".$_POST['Arts']."',PE='".$_POST['PE']."',Health='".$_POST['Health']."',RO_Thematic='".$_POST['ROThematic']."' WHERE SchoolID = '".$_SESSION['school_id']."' AND SubNo='".$_SESSION['SubNo']."' LIMIT 1"); 
					}
				if(mysqli_affected_rows($con)==1)
					{
					 $Err="LRMDS Report updated successfully!";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					} 
			 }elseif(isset($_POST['AddQualification']))
			 {
				 mysqli_query($con,"INSERT INTO tbl_qualification_by_school VALUES(NULL,'".$_POST['qualification']."','".$_SESSION['school_id']."')");
				if(mysqli_affected_rows($con)==1)
					{
					 $Err="Senior high qualification successfully submitted!";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}  
			 }elseif (isset($_POST['upstrand'])) 
				{
					mysqli_query($con,"UPDATE tbl_qualification SET Description='".$_POST['qualification']."',Grade='".$_POST['Grade_Level']."' WHERE SpCode='".$_SESSION['SpCode']."' LIMIT 1");
					if(mysqli_affected_rows($con)==1)
					{
					 $Err="Strand successfully updated!";	
						
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}
				}
			?>
			<div class="row">
                <div class="col-lg-12">
                    <h3 ></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
 <a href="print-module-submission.php?link=10a638b057cff7770c37024121ccb27e2f18f791" style="float:right;" class="btn btn-success" target="_blank">Print Copy</a>  		
						<ul class="nav nav-tabs">
                                <li class="active">
									<a href="#mdpw" data-toggle="tab">Module Distribution Per Week</a>
                                </li>
                                                                
                        </ul>
						 <!-- Tab panes -->
                            <div class="tab-content">
							 <div class="tab-pane fade in active" id="mdpw">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
												 
									<form action="" Method="POST" enctype="multipart/form-data">
									<label style="float:right;padding:2px;margin:2px;">
									<input type="submit" name="search"  class="btn btn-success" value="Search">
									 </label >
									 <label style="float:right;padding:2px;margin:2px;">
										<select name="week" class="form-control" required>
											<option value="">--Select Week--</option>
											<option value="Week 1">Week 1</option>
											<option value="Week 2">Week 2</option>
											<option value="Week 3">Week 3</option>
											<option value="Week 4">Week 4</option>
											<option value="Week 5">Week 5</option>
											<option value="Week 6">Week 6</option>
											<option value="Week 7">Week 7</option>
											<option value="Week 8">Week 8</option>
											<option value="Week 9">Week 9</option>
											<option value="Week 10">Week 10</option>
											
										</select>
									 </label>
									<label style="float:right;padding:2px;margin:2px;">
										<select name="quarter" class="form-control" required>
											<option value="">--Select Quarter--</option>
											<option value="First">First Quarter</option>
											<option value="Second">Second Quarter</option>
											<option value="Third">Third Quarter</option>
											<option value="Fourth">Fourth Quarter</option>
											
										</select>
									 </label>	
									</form>									 
						          
										<h4>LRMDS CORNER (<?php echo '<b> '.$_SESSION['week'].' | '.$_SESSION['quarter'].' Quarter</b>'; ?>)</h4>
										</div>
											<!-- /.panel-heading -->
											<div class="panel-body" >
											
											<?php 
											
												if ($_SESSION['Category']=='Elementary' AND  $_SESSION['SchoolType']=='Elementary')
													{	
														require("elementary_level.php");		
													}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Junior'){
														require("secondary_level.php");	
													}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Senior'){	
														require("senior_strand.php");	
													}elseif ($_SESSION['Category']=='Secondary' AND  $_SESSION['SchoolType']=='Integrated'){
														
														require("secondary_level.php");	
														require("senior_strand.php");	
													}elseif ($_SESSION['Category']=='Elementary' AND  $_SESSION['SchoolType']=='Integrated'){
														require("elementary_level.php");	
														require("secondary_level.php");	
														require("senior_strand.php");	
													}				
													?>
									
								 </div>
								




<style>
   .modal-header, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:40%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
		}
		td,th{
			text-transform:uppercase;
		}
   </style>





 <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="newreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
       
          <h4>LRMDS SUMMARY REPORT </h4>
        </div>
        <div class="modal-body">
            <div class="row">
				<form action="" Method="POST" enctype="multipart/form-data">
               
                      <div class="panel-body" >
					  <?php
					  date_default_timezone_set("Asia/Manila");
					 if ($_SESSION['Category']=='Elementary')
							{
								 echo  '<div class="col-lg-6">
                           <label>Date submitted:</label>
	                        <input type="date" class="form-control" value="'.date('Y-m-d').'" disabled>
                            <input type="hidden" name="datesub"  class="form-control" value="'.date('Y-m-d').'" required>
                            <label>Current Week #:</label>					       
                            <input type="text" value="'.$_SESSION['week'].'" class="form-control" disabled>
                            <input type="hidden" name="No_of_week" value="'.$_SESSION['week'].'"class="form-control" placeholder="Grade Level" required>
                             </div>
							 <div class="col-lg-6">
							 <label>Grade Level :</label>					       
                            <select  name="GLevel" class="form-control" required>
							<option value="">--Select--</option>
							<option value="Kinder">Kinder</option>
							<option value="1">Grade 1</option>
							<option value="2">Grade 2</option>
							<option value="3">Grade 3</option>
							<option value="4">Grade 4</option>
							<option value="5">Grade 5</option>
							<option value="6">Grade 6</option>
							
							</select>
							<label># of Learners:</label>					       
                            <input type="number" id="NoOfLearner" name="No_of_learner" class="form-control" placeholder="# of Learners" required>
                            <br/>  </div>
							<input type="text" value="Number of Printed Modules Distributed" class="form-control" style="text-align:center;"disabled>
							 <div class="col-lg-6">
							<label>English:</label>					       
                            <input type="number" name="English" id="English" onkeyup="searchdata(this.value)"class="form-control"  required>
                            <label>Science:</label>					       
                            <input type="number" name="Science" id="Science" onkeyup="searchdata(this.value)"class="form-control"  required>
                            <label>Math:</label>					       
                            <input type="number" name="Math" id="Math" onkeyup="searchdata(this.value)" class="form-control"  required>
                            <label>Filipino:</label>					       
                            <input type="number" name="Filipino" id="Filipino" onkeyup="searchdata(this.value)" class="form-control"  required>
                            <label>Aral. Pan.:</label>					       
                            <input type="number" name="AralPan" id="AralPan" onkeyup="searchdata(this.value)" class="form-control"  required>
                            
							</div>
							 <div class="col-lg-6">
							 <label>E.S.P:</label>					       
                            <input type="number" name="ESP" id="ESP" onkeyup="searchdata(this.value)" class="form-control"  required>
							<label>T.L.E/E.P.P:</label>					       
                            <input type="number" name="TLE" id="TLE" onkeyup="searchdata(this.value)" class="form-control"  required>
                            <label>MAPEH:</label>					       
                            <input type="number" name="MAPEH" id="MAPEH" onkeyup="searchdata(this.value)" class="form-control"  required>
							<label>MOTHER TONGUE:</label>					       
                            <input type="number" name="Mother_Tongue" id="Mother_Tongue" onkeyup="searchdata(this.value)" class="form-control"  required>
											       
                            <input type="hidden" name="ROThematic" id="ROThematic" value="0" onkeyup="searchdata(this.value)" class="form-control"  required>
							<label>PROJECT RUSH:</label>					       
                            <input type="text" name="ProjRush" id="ProjRush"   onkeyup="searchdata(this.value)" class="form-control"  required>
							
							</div>';
								
							}elseif ($_SESSION['Category']=='Secondary')
							{
					  echo  '<div class="col-lg-6">
                           <label>Date submitted:</label>
	                        <input type="date" class="form-control" value="'.date('Y-m-d').'" disabled>
                            <input type="hidden" name="datesub"  class="form-control" value="'.date('Y-m-d').'" required>
                            
						   <label>Current Week #:</label>					       
                            <input type="text"  value="'.$_SESSION['week'].'" class="form-control" disabled>
                            <input type="hidden" name="No_of_week" value="'.$_SESSION['week'].'" class="form-control" placeholder="Grade Level" required>
                             </div>
							 <div class="col-lg-6">
							 <label>Grade Level :</label>					       
                            <select  name="GLevel" class="form-control" required>
							<option value="">--Select--</option>
							<option value="7">Grade 7</option>
							<option value="8">Grade 8</option>
							<option value="9">Grade 9</option>
							<option value="10">Grade 10</option>
							
							</select>
							<label># of Learners:</label>					       
                            <input type="number" name="No_of_learner" class="form-control" placeholder="# of Learners" required>
                            <br/>  </div>
							<input type="text" value="Number of Printed Modules Distributed" class="form-control" style="text-align:center;"disabled>
							 <div class="col-lg-6">
							<label>English:</label>					       
                            <input type="number" name="English" class="form-control"  required>
                            <label>Science:</label>					       
                            <input type="number" name="Science" class="form-control"  required>
                            <label>Math:</label>					       
                            <input type="number" name="Math" class="form-control"  required>
                            <label>Filipino:</label>					       
                            <input type="number" name="Filipino" class="form-control"  required>
                            <label>Aral. Pan.:</label>					       
                            <input type="number" name="AralPan" class="form-control"  required>
                            <label>E.S.P:</label>					       
                            <input type="number" name="ESP" class="form-control"  required>
							 <label>ELECTIVE 1:</label>					       
                            <input type="number" name="Elec1" class="form-control"  required>
							</div>
							 <div class="col-lg-6">
							<label>T.L.E:</label>					       
                            <input type="number" name="TLE" class="form-control"  required>
                            <label>Music:</label>					       
                            <input type="number" name="Music" class="form-control"  required>
							<label>Arts:</label>					       
                            <input type="number" name="Arts" class="form-control"  required>
							<label>P.E:</label>					       
                            <input type="number" name="PE" class="form-control"  required>
							<label>Health:</label>					       
                            <input type="number" name="Health" class="form-control"  required>
												       
                            <input type="hidden" name="ROThematic" value="0"class="form-control"  required>
							 <label>ELECTIVE 2:</label>					       
                            <input type="number" name="Elec2" class="form-control"  required>
							 <label>ELECTIVE 3:</label>					       
                            <input type="number" name="Elec3" class="form-control"  required>
							</div>';
							}
							echo '
					 </div>
				<div class="modal-footer">
				<label style="float:left;">Current Quarter:</label>					       
                <input type="text"  value="'.$_SESSION['quarter'].' Quarter" class="form-control" disabled>
                <input type="hidden"  name="QuarterNo" value="'.$_SESSION['quarter'].'" class="form-control" ><br/>
				<input type="submit" class="btn btn-primary" name="add" value="SUBMIT">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							';
							
                 ?> 
				 
				</form>
				  
				</div>
            
        </div>
      </div>
    </div>
  </div>
  </div>
  
  
 
  
  
  <!--Senior high-->
  

 <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="seniorreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
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
  
    
  <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="updatestrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
       
    </div>
  </div>
  </div>
  </div>
  
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
  
<?php
$_SESSION['SubCode']=$_GET['SubCode'];
$_SESSION['QNo']=$_GET['No'];

if (!is_dir('../../pisa/images/'.$_SESSION['Batchno'])) {
    mkdir('../../pisa/images/'.$_SESSION['Batchno'], 0777, true);
}
$_SESSION['pathlocation']='../../pisa/images/'.$_SESSION['Batchno'];

if (isset($_POST['addquestion']))
{
	$Quiz=$_POST['question'];
	$Quiz=str_replace("'","\'",$Quiz);
	mysqli_query($con,"INSERT INTO tbl_pisa_questions VALUES(NULL,'".$_GET['No']."','".$Quiz."','".$_GET['SubCode']."','-','".$_SESSION['Batchno']."','0','','')");
	if(mysqli_affected_rows($con)==1)
	{
	//Option A details
	$dataA=$_POST['A'];
	$dataA=str_replace("'","\'",$dataA);
	mysqli_query($con,"INSERT INTO tbl_pisa_option VALUES(NULL,'".$_GET['No']."','".$dataA."','A','".$_GET['SubCode']."','".$_SESSION['Batchno']."')");	
	//Option B details
	$dataB=$_POST['B'];
	$dataB=str_replace("'","\'",$dataB);
	mysqli_query($con,"INSERT INTO tbl_pisa_option VALUES(NULL,'".$_GET['No']."','".$dataB."','B','".$_GET['SubCode']."','".$_SESSION['Batchno']."')");	
	//Option C details
	$dataC=$_POST['C'];
	$dataC=str_replace("'","\'",$dataC);
	mysqli_query($con,"INSERT INTO tbl_pisa_option VALUES(NULL,'".$_GET['No']."','".$dataC."','C','".$_GET['SubCode']."','".$_SESSION['Batchno']."')");	
	//Option D details
	$dataD=$_POST['D'];
	$dataD=str_replace("'","\'",$dataD);
	mysqli_query($con,"INSERT INTO tbl_pisa_option VALUES(NULL,'".$_GET['No']."','".$dataD."','D','".$_GET['SubCode']."','".$_SESSION['Batchno']."')");	
	
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
}elseif (isset($_POST['save_instruction']))
{
  mysqli_query($con,"UPDATE tbl_pisa_questions SET link_title='".$_POST['instruction']."' WHERE QNo = '".$_SESSION['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' LIMIT 1");
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
}elseif(isset($_POST['Save_Aswer']))
{
	mysqli_query($con,"UPDATE tbl_pisa_questions SET Answer_keys='".$_POST['answer']."' WHERE QNo = '".$_SESSION['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' LIMIT 1");
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
}elseif(isset($_POST['pathlocation']))
{
	mysqli_query($con,"UPDATE tbl_pisa_questions SET question_link='".$_POST['location']."' WHERE QNo = '".$_SESSION['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' LIMIT 1");

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
}elseif(isset($_POST['save_question']))
{
	mysqli_query($con,"UPDATE tbl_pisa_questions SET Questions='".$_POST['question']."' WHERE QNo = '".$_SESSION['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' LIMIT 1");

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
	
      window.addEventListener("load", function () 
      {
		
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadlink.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
           // width: 500,
            //height: 500,
            //quality: 90,
          },
          init: 
          {
            PostInit: function () 
            {
              document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files) 
            {
              plupload.each(files, function (file) 
              {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
              uploader.start();
            },
            UploadProgress: function (up, file) 
            {
				
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			 
			  if ( file.percent==100)
			  {
				var loc =document.getElementById("loc").value ;
			   document.getElementById("filedata").value =loc + '/' + file.name;
			  
			  }
			 },
            Error: function (up, err) 
            {
              // DO YOUR ERROR HANDLING!
              console.log(err);
            }
          }
        });
        uploader.init();
		 
			 
      });
    </script>
	

 <script>
		
	   function my_answer(id){
		   
		var a =document.getElementById("A").value;
		var b =document.getElementById("B").value;
		var c =document.getElementById("C").value;
		var d =document.getElementById("D").value;
			
		document.getElementById("answer").value = id;
				
			if ( a == id)
			{
			   document.getElementById("A").style.background = "blue";	 
			   document.getElementById("A").style.color = "white";	 
			}else{
			   document.getElementById("A").style.background = "white";
			    document.getElementById("A").style.color = "black";	
			}
			
			if ( b == id)
			{
			   document.getElementById("B").style.background = "blue";	 
			   document.getElementById("B").style.color = "white";	 
			}else{
			   document.getElementById("B").style.background = "white";
			    document.getElementById("B").style.color = "black";	
			}
			
			if ( c == id)
			{
			   document.getElementById("C").style.background = "blue";	 
			   document.getElementById("C").style.color = "white";	 
			}else{
			   document.getElementById("C").style.background = "white";
			    document.getElementById("C").style.color = "black";	
			}
			
			if ( d == id)
			{
			   document.getElementById("D").style.background = "blue";	 
			   document.getElementById("D").style.color = "white";	 
			}else{
			   document.getElementById("D").style.background = "white";
			    document.getElementById("D").style.color = "black";	
			}
		
	   }
	    
   
   </script>
	
	
	
<div class="row">
			<br/>
                <div class="col-lg-12">
				 <div class="panel panel-default">
				  <div class="panel-body">
				   <?php
				  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("pisa_exam")).'" style="float:right;" class="btn btn-secondary">Back</a>';
				 $myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='".$_GET['SchoolID']."' LIMIT 1");
				 $rowschool=mysqli_fetch_assoc($myschool);
				 echo '<h2>'.$rowschool['SchoolName'].'</h2>';
				 $_SESSION['SchoolName']=$rowschool['SchoolName'];
				 $_SESSION['SchoolID']=$_GET['SchoolID'];
				 $_SESSION['Item']=$_GET['Item'];
				 
				  ?>
				 <a href="printlist.php" class="btn btn-primary" style="float:right;" target="_blank">Print List</a>
				
					</div>
				   </div>
				</div>
				 
						<?php
						$mystate=mysqli_query($con,"SELECT * FROM tbl_pisa_questions WHERE SubCode='".$_GET['SubCode']."' AND QNo='".$_GET['No']."' AND BatchNo='".$_SESSION['Batchno']."'");
						if (mysqli_num_rows($mystate)==0)
						{
						  echo ' <div class="col-lg-2">
								  <div class="panel panel-default">
									<div class="panel-body">
										<center><a href="#newquestion" class="btn btn-primary" data-toggle="modal" style="width:150px;height:50px;">Add Question</a></center>
										</div>				  
									</div>				  
								</div>';
						} 
						?>
										  
                 <div class="col-lg-6">
				
				  <div class="panel panel-default">
				  <div class="panel-body">
				    <div class="alert alert-danger" style="color:black;border-radius:.3em;width:100%;font-size:20px;">
					  <?php
					    $nextNo=$_GET['No'] + 1;
					    $PreNo=$_GET['No'] - 1;
						if ($_GET['No']==1)
						{
					     echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode($nextNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&SubCode='.urlencode(base64_encode($_GET['SubCode'])).'&SchoolID='.urlencode(base64_encode($_GET['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Next Number"><img src="../../pisa/images/next.png" style="border-radius:50%;width:30px;height:30px;"></a>';
					     echo '<a  style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Previous Number" disabled><img src="../../pisa/images/back.png" style="border-radius:50%;width:30px;height:30px;"></a>';
						}elseif ($_GET['No']==$_GET['Item']){
						 echo '<a  style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Next Number" disabled><img src="../../pisa/images/next.png" style="border-radius:50%;width:30px;height:30px;"></a>';
					     echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode($PreNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&SubCode='.urlencode(base64_encode($_GET['SubCode'])).'&SchoolID='.urlencode(base64_encode($_GET['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Previous Number"><img src="../../pisa/images/back.png" style="border-radius:50%;width:30px;height:30px;"></a>';
						
						}else{
						 echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode($nextNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&SubCode='.urlencode(base64_encode($_GET['SubCode'])).'&SchoolID='.urlencode(base64_encode($_GET['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Next Number"><img src="../../pisa/images/next.png" style="border-radius:50%;width:30px;height:30px;"></a>';
					     echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&'.sha1("Pagadian City Division BUREAU of EDUCATION assessment!").'&No='.urlencode(base64_encode($PreNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&SubCode='.urlencode(base64_encode($_GET['SubCode'])).'&SchoolID='.urlencode(base64_encode($_GET['SchoolID'])).'&v='.urlencode(base64_encode("pisa_question")).'" style="padding:4px;margin:4px;float:right;" class="btn btn-primary" title="Previous Number"><img src="../../pisa/images/back.png" style="border-radius:50%;width:30px;height:30px;"></a>';
							
						}	
					$currentBatchNo=mysqli_query($con,"SELECT * FROM tbl_pisa_batch WHERE BatchCode='".$_SESSION['Batchno']."' LIMIT 1");	
					$rowbatch=mysqli_fetch_assoc($currentBatchNo);
					  $mysubject=mysqli_query($con,"SELECT * FROM tbl_pisa_subject WHERE SubCode='".$_GET['SubCode']."' LIMIT 1");
					  $rowsub=mysqli_fetch_assoc($mysubject);
					  $_SESSION['Subject']=$rowsub['LearningAreas'];
					  echo '<p>'.$rowsub['LearningAreas'].' ('.$rowbatch['BatchName'].')</p>';
					  
					  echo '<p style="font-size:16px;">Question '.$_GET['No'].' / '.$_GET['Item'].' </p>';
                      ?>					  
				  </div>
				  <div class="alert alert-default" style="color:black;border-radius:.3em;width:100%;font-size:20px;text-align:justify;">
				   
				  <?php
				  $myquiz=mysqli_query($con,"SELECT * FROM tbl_pisa_questions WHERE SubCode='".$_GET['SubCode']."' AND QNo='".$_GET['No']."' AND BatchNo='".$_SESSION['Batchno']."'LIMIT 1");
				  $rowquiz=mysqli_fetch_assoc($myquiz);
				  echo '<a href="#editquestion" style="float:right;" title="Edit File" data-toggle="modal"><i class="fa fa-pencil"></i></a>
				  <p>'.$_GET['No'].'.	'.$rowquiz['Questions'].'</p><br/>';
				  $myoption=mysqli_query($con,"SELECT * FROM tbl_pisa_option WHERE QNo='".$_GET['No']."' AND SubCode='".$_GET['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' ORDER BY Letter Asc");
				 while($rowoption=mysqli_fetch_array($myoption))
				 {
					 if ($rowquiz['Answer_keys']==$rowoption['Letter'])
					 {
					   echo '<input type="submit" class="btn btn-primary" style="border-radius:50%;font-size:25px;width:50px;padding:4px;margin:4px;" id="'.$rowoption['Letter'].'" onclick="my_answer(this.value)" value="'.$rowoption['Letter'].'"> '.$rowoption['Option_Details'].'<br/>';	
					 }else{
						  echo '<input type="submit" class="btn btn-default" style="border-radius:50%;font-size:25px;width:50px;padding:4px;margin:4px;" id="'.$rowoption['Letter'].'" onclick="my_answer(this.value)" value="'.$rowoption['Letter'].'"> '.$rowoption['Option_Details'].'<br/>';	
					 }
				 }
				?>	<hr/>
					  <!-- /#page-wrapper -->
					 <form action="" Method="POST" enctype="multipart/form-data">
					  <input type="hidden" class="form-control" id="answer" name="answer">
					  <input type="submit" class="btn btn-primary"  name="Save_Aswer" value="SET ANSWER" style="float:right;">
					 
				   </form>        	
				 
				 </div>
            </div>
            </div>
            </div>
			 <div class="col-lg-6">
			
			  <div class="panel panel-default">
				  <div class="panel-body">
				 <?php
			    if ($rowquiz['link_title']<>"")
				{
			    echo '<div class="alert alert-warning" style="color:black;border-radius:.3em;width:100%;font-size:20px;text-align:justify;">
				   <a href="#editfile" style="float:right;" title="Edit File" data-toggle="modal"><i class="fa fa-pencil"></i></a>
			    	       <p>'.$rowquiz['link_title'].'</p>
				     </div>';
			    }else{
					if (mysqli_num_rows($myquiz)<>0)
					{
					echo '
					<form action="" Method="POST" enctype="multipart/form-data"> <label>Set Instruction for this Item</label>
					<div class="form-group input-group">
					<textarea class="form-control" name="instruction" required></textarea>
					<span class="input-group-addon"><input type="submit" name="save_instruction" class="btn btn-secondary"></span>
					</div></div></form>';
					}
				}
			   ?>
			    <center>
				<?php
				if ($rowquiz['question_link']<>"")
				{
				  echo '
									
								<img src="'.$rowquiz['question_link'].'" style="padding:4px;width:100%;" title="Click to Update picture">
								
								';
				}else{
					 if ($rowquiz['link_title']<>"")
						{
						echo '<center><form action="" Method="POST" enctype="multipart/form-data">
						<div id="container">				
								<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose File to upload</button></span>					
								</div>
								<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
								 <input type="hidden" class="form-control" id="filedata" name="location">
								<input type="hidden" class="form-control" id="loc" value="'.$_SESSION['pathlocation'].'">
								<input type="submit" class="btn btn-info" name="pathlocation" style="float:right;" value="Continue..."></form></center>';
						}
				}
				?>	
				</center>
			    
			 </div>
			 </div>
			 </div>
			
		
      
	
	     <!-- Modal -->
	 <div class="modal fade" id="newquestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
			<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Add New Question</h4>
			</div>
			<form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			  <label>Question Details</label>
			 <textarea class="form-control" name="question" rows="2" required></textarea><hr/>
			   <div class="form-group input-group">
                <span class="input-group-addon">A</span>
                <input type="text" class="form-control" name="A" placeholder="Option A" required>
                </div>
				
				<div class="form-group input-group">
                <span class="input-group-addon">B</span>
                <input type="text" class="form-control" name="B" placeholder="Option B" required>
                </div>
				
				<div class="form-group input-group">
                <span class="input-group-addon">C</span>
                <input type="text" class="form-control" name="C" placeholder="Option C" required>
                </div>
				
				<div class="form-group input-group">
                <span class="input-group-addon">D</span>
                <input type="text" class="form-control" name="D" placeholder="Option D" required>
                </div>
		   	</div>
           <div class="modal-footer">
		   <input type="submit" name="addquestion" value="SUBMIT" class="btn btn-primary">
		  <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			
		 </div>	
		 </form>
		 </div>	

	</div></div>
	
	
	   <!-- Modal -->
	 <div class="modal fade" id="editfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
   
      <!-- Modal content-->
      <div class="modal-content">
			<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Update Instruction</h4>
			</div>
			 <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			     <label>Set Instruction for this Item</label>
				 <textarea class="form-control" name="instruction" required></textarea>	
		   	</div>
           <div class="modal-footer">
		    <input type="submit" name="save_instruction" value="SUBMIT" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
		   </div>	
		 </form>
		 </div>	
		
	</div></div>
	
	
	
	   <!-- Modal -->
	 <div class="modal fade" id="editquestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
   
      <!-- Modal content-->
      <div class="modal-content">
			<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Update Question</h4>
			</div>
			 <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			     <label>Question:</label>
				 <textarea class="form-control" name="question" required></textarea>	
		   	</div>
           <div class="modal-footer">
		    <input type="submit" name="save_question" value="SUBMIT" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
		   </div>	
		 </form>
		 </div>	
		
	</div></div>
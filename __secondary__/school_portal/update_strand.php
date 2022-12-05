 <?php
 session_start();
include("../vendor/jquery/function.php");
 $result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE SpCode='".$_GET['id']."' LIMIT 1");
 $row=mysqli_fetch_assoc($result);
 $_SESSION['SpCode']=$_GET['id'];
 echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h4>UPDATE STRAND</h4>
        </div>
			<form action="" Method="POST" enctype="multipart/form-data">
          
        <div class="modal-body">
			 <label>GRADE LEVEL</label>
			   <select name="Grade_Level" class="form-control" required>
				<option value="'.$row['Grade'].'">Grade '.$row['Grade'].'</option>
				<option value="11">Grade 11</option>
				<option value="12">Grade 12</option>
				
			   </select>		  
               <label>QUALIFICATION</label>
              <input type="text" name="qualification" value="'.$row['Description'].'" class="form-control" required> 
			   
			 
      
      </div>
	  
      </div>
	   <div class="modal-footer">
	   <input type="submit" name="upstrand" class="btn btn-primary" value="SAVE">
	   </div>
	      </form>';
		?>  
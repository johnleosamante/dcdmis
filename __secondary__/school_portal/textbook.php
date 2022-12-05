
	<style>
	td{
		text-transform:uppercase;
	}
	</style>
              <?php
			  if (isset($_POST['save']))
			  {
				  mysqli_query($con,"INSERT INTO tbl_textbook VALUE (NULL,'".$_POST['ISBN']."','".$_POST['GradeLevel']."','".$_POST['BookDescription']."','".$_POST['BookAuthor']."','".$_POST['QTY']."','".$_POST['BookYear']."','".$_SESSION['school_id']."')");
					if (mysqli_affected_rows($con)==1)
						{
					$Err="Textbook information successfully submitted!";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
				}
			  }
			  ?>
              
            </div>
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
						<a href="#mybook" style="float:right;" class="btn btn-primary" data-toggle="modal">Add book</a>	
						<h4>List of Books</h4>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="14%">ISBN</th>
                                        <th width="14%">GRADE LEVEL</th>
                                        <th width="14%">DECRIPTION</th>
                                        <th width="10%">AUTHOR</th>
                                        <th width="10%">YEAR PUBLISHED</th>
                                        <th width="10%">QTY</th>
                                       <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_textbook WHERE SchoolID ='".$_SESSION['school_id']."'ORDER BY BookDescription Asc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['ISBN'].'</td>
											<td>'.$row['Grade_Level'].'</td>
											<td>'.$row['BookDescription'].'</td>
											<td>'.$row['BookAuthor'].'</td>
											<td>'.$row['YearPublish'].'</td>
											<td>'.$row['QTY'].'</td>
											<td><a href=""></a></td>
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
            
<style>
  
	
	 th,td{
		text-align:center;
	}	
		
   </style>



   <!-- Modal for Re-assign-->
 
 <div class="panel-body">
   <div class="modal fade" id="mybook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   
      <div class="modal-dialog">
   
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4>Add new book information </h4>
        </div>
			<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
           
              	
				<label>Grade Level</label>
					<select name="GradeLevel" class="form-control" required>
						<option value="">--select--</option>
						<?php
						if ($_SESSION['Category']=='Elementary')
						{
							echo '<option value="Kinder">Kinder</option>
							<option value="1">Grade 1</option>
							<option value="2">Grade 2</option>
							<option value="3">Grade 3</option>
							<option value="4">Grade 4</option>
							<option value="5">Grade 5</option>
							<option value="6">Grade 6</option>';
						}else{
							echo '<option value="7">Grade 7</option>
							<option value="8">Grade 8</option>
							<option value="9">Grade 9</option>
							<option value="10">Grade 10</option>
							<option value="11">Grade 11</option>
							<option value="12">Grade 12</option>
							';
						}
						?>
				 </select>
				 <label>ISBN</label>
					<input type="text" name="ISBN" class="form-control" required>
				<label>Book Description</label>
					<textarea name="BookDescription" rows="4" class="form-control" required></textarea>
					<label>Author</label>
					<input type="text" name="BookAuthor" class="form-control" required>
					<label>Year Publish</label>
					<input type="text" name="BookYear" class="form-control" required>
					<label>QTY</label>
					<input type="text" name="QTY" class="form-control" required>
					
				
         </div>
		 <div class="modal-footer">
           <input type="submit" name="save" value="SUBMIT" class="btn btn-primary">
		    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		   </div>
					
            </form>
        </div>
        </div>
     </div>
  </div>
			  
<!-- Ending Modal for re-assign->
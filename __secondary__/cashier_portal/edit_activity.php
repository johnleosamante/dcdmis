
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <?php
						echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_activity")).'" class="btn btn-success" style="float:right;">Back</a>';
						
						?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="" Method="POST">
								<?php
								
								$_SESSION['code']=$_GET['code'];
								$updata=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$_GET['code']."' LIMIT 1");
							   $row=mysqli_fetch_assoc($updata);
							   echo '<label>TRAININGS CODE:</label>
								<input type="text" name="Tcode" class="form-control" value="'.$_GET['code'].'" required disabled>
								<label>TITLE OF TRAININGS / ACTIVITIES:</label>
								<textarea name="TTitle" class="form-control" rows="3" required>'.$row['Title_of_training'].'</textarea>
								
								<label>FROM:</label>
								<input type="date" name="TFrom" class="form-control" value="'.$row['covered_from'].'" required>
								<label>TO:</label>
								<input type="date" name="TTo" class="form-control" value="'.$row['covered_to'].'" required>
								
								<label>VENUE:</label>
								<input type="text" name="TVenue" class="form-control" value="'.$row['TVenue'].'" required>';
								
								?><hr/>
								 <input type="submit" class="btn btn-primary" name="update_training" value="SUBMIT">
								</form> 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
          

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">	
						<?php
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("lmupload")).'" style="float:right;" class="btn btn-secondary">Back to course</a>';
					 ?>
						<p><?php echo $_GET['cat']; ?></p>
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
						<?php
						$_SESSION['Category']=$_GET['cat'];
						if ($_GET['cat']=='ELEMENTARY LEVEL')
						{
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('1')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 1</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('2')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 2</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('3')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 3</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('4')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 4</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('5')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 5</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('6')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 6</a><br/>';
							
						}elseif ($_GET['cat']=='JUNIOR HIGH SCHOOL LEVEL')
						{
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('7')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 7</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('8')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 8</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('9')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 9</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('10')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 10</a><br/>';
							
						}elseif ($_GET['cat']=='SENIOR HIGH SCHOOL LEVEL')
						{
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('11')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 11</a><br/>';
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode('12')).'&v='.urlencode(base64_encode("subject_list")).'" class="btn btn-success" style="padding:4px;margin:4px;width:250px;height:50px;">Grade 12</a><br/>';
							
						}
						?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12</td>
												-->
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">	
						<p>CATEGORY LEVEL</p>
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<center>
						 <?php
						  $result=mysqli_query($con,"SELECT * FROM tbl_school_category ORDER BY Cat_Code Asc");
						  while($row=mysqli_fetch_array($result))
						  {
							  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&cat='.urlencode(base64_encode($row['Category_Level'])).'&v='.urlencode(base64_encode("category")).'" class="btn btn-success" style="padding:4px;margin:4px;height:50px;width:250px;">'.$row['Category_Level'].'</a><br/>';
						  }
						 ?></center>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12</td>
												-->
            </div>
			
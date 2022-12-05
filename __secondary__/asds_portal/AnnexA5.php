	<style>
	td{
		text-transform:uppercase;
	}
	</style>
             
            <!-- /.row -->
				
                <!-- /.col-lg-12 -->
          <div class="col-lg-12">
                    <h1></h1>
                </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['current_id'])).'&v='.urlencode(base64_encode("asds_report")).'" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>';
						?>
					
					     <h4>INVENTORY TRANSFER REPORT (ANNEX A5)<h4>
					
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th  width="15%" style="text-align:center;">Date</th>
                                        <th  width="20%" style="text-align:center;">Fund Cluster</th>
                                        <th width="15%">ITR No.</th>
                                        <th width="20%">From Accountable Officer /Agency /Fund Cluster</th>
                                        <th width="20%">To Accountable Officer /Agency /Fund Cluster</th>
                                        <th width="30%">Transfer Type</th>
                                         <th width="7%" style="text-align:center;"></th>                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa5 WHERE SEP_SchoolID ='".$_SESSION['current_id']."' ORDER BY CardCode Desc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								
								 echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td style="text-align:center;">'.$row['Date_Received'].'</td>
											<td style="text-align:center;">'.$row['Fund_cluster'].'</td>
											<td>'.$row['ITRNo'].'</td>
											<td style="text-align:center;">'.$row['FAOAF'].'</td>
											<td style="text-align:center;">'.$row['TAOAF'].'</td>
											<td style="text-align:center;">'.$row['Transfer_type'].'</td>
											<td style="text-align:center;"><a href="print_annexA5.php?code='.urlencode(base64_encode($row['CardCode'])).'" target="_blank">VIEW</a></td>
											
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
				
                </div>
                <!-- /.col-lg-12 -->





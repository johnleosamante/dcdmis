	<style>
	td{
		text-transform:uppercase;
	}
	</style>
             
            <!-- /.row -->
			
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['current_id'])).'&v='.urlencode(base64_encode("asds_report")).'" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>';
						?>
						
					     <h4>INVENTORY CUSTODIAN SLIP (ANNEX A3)<h4>
					
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                 <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th  width="15%" style="text-align:center;">Date</th>
                                        <th  width="50%" style="text-align:center;">Fund Cluster</th>
                                        <th width="50%">ICS No.</th>
                                         <th width="7%" style="text-align:center;"></th>                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa3 WHERE SEP_SchoolID ='".$_SESSION['current_id']."' ORDER BY CardCode Desc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								
								 echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td style="text-align:center;">'.$row['Date_created'].'</td>
											<td style="text-align:center;">'.$row['Fund_cluster'].'</td>
											<td>'.$row['SEP_ICSNo'].'</td>
											<td style="text-align:center;"><a href="print_annexA3.php?code='.urlencode(base64_encode($row['CardCode'])).'" target="_blank">VIEW</a></td>
																						
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





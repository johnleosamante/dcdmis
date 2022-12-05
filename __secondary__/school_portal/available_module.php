
	<style>
	td{
		text-transform:uppercase;
	}
	</style>
             
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
					
						<h4>Available Modules</h4>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Module Title</th>
                                        <th width="10%">Pages</th>
                                        <th width="5%"></th>
                                      </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								if ($_SESSION['Category']=='Elementary')
								{
								$mod=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE Grade_Level<='6'  AND Quarter='".$_SESSION['Quarter']."'");
									
								}else{
								$mod=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE Grade_Level>='7' AND Quarter='".$_SESSION['Quarter']."'");
								}	
								while($rowmod=mysqli_fetch_array($mod))
								{
									$no++;
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowmod['Filename'].'</td>
											<td style="text-align:center;">'.$rowmod['PagesNo'].'</td>
											<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($rowmod['Grade_Level'])).'&SubCode='.urlencode(base64_encode($rowmod['SubCode'])).'&Access='.urlencode(base64_encode($rowmod['ModuleCode'])).'&v='.urlencode(base64_encode("activity_sheets")).'" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-desktop fa-fw"></i></a></td>
											
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

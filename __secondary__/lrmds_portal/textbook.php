

	<style>
	td{
		text-transform:uppercase;
	}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
					
						<h4>List of Books</h4>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="14%">SCHOOL</th>
                                        <th width="14%">ISBN</th>
                                        <th width="14%">GRADE LEVEL</th>
                                        <th width="14%">LEARNING AREAS</th>
                                        <th width="10%">AUTHOR</th>
                                        <th width="10%">YEAR PUBLISHED</th>
                                        <th width="10%">QTY</th>
                                       <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_textbook INNER JOIN tbl_school ON  tbl_textbook.SchoolID =  tbl_school.SchoolID ORDER BY BookDescription Asc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['SchoolName'].'</td>
											<td>'.$row['ISBN'].'</td>
											<td>'.$row['Grade_Level'].'</td>
											<td>'.$row['BookDescription'].'</td>
											<td>'.$row['BookAuthor'].'</td>
											<td>'.$row['YearPublish'].'</td>
											<td>'.$row['QTY'].'</td>
											<td></td>
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
               
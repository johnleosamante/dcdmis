<?php
if (!is_dir('../../pcdmis/201_files/')) {
    mkdir('../../pcdmis/201_files/', 0777, true);
}
$filelocation='../../pcdmis/201_files/';
if (isset($_POST['newdir']))
{
	 $folder_name=$filelocation.$_POST['newfolder'];
	
	if (!file_exists($folder_name))/* Check folder exists or not */
	{
		  mkdir('../../pcdmis/201_files/'.$_POST['newfolder'], 0777, true);/* Create folder by using mkdir function */
		   echo '<div class="alert alert-danger alert-dismissable">Folder Created</div>';/* Success Message */
	}else{
		 echo '<div class="alert alert-danger alert-dismissable">Already Created</div>';/* Success Message */
	}
    
}
?>
			
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="#createfolder" style="float:right;" class="btn btn-info" data-toggle="modal">Create Folder</a>
							<h4>PCDMIS CLOUD BACKUP</h4>
						
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
                         $dir=$filelocation; // Directory where files are stored

								if ($dir_list = opendir($dir))
								{
								while(($filename = readdir($dir_list)) != false)
								{
								?>
								<a href="<?php echo $filelocation.$filename; ?>" target="_blank"><div class="col-lg-2" style="border:solid 1px black;border-radius:.3em;padding:4px;margin:4px;"><?php echo $filename;
								?></div></a>
								<?php
								}
								closedir($dir_list);
								}
						 ?>
									
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
      <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="createfolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	       <div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Create new folder</h4>
			</div>
			<form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				
					<input type="text" name="newfolder" class="form-control" placeholder="Name of Folder" required>
				
			</div>
			<div class="modal-footer">
			<input type="submit" name="newdir" class="btn btn-primary" value="Create">
			 <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			</div>
			</form>
	</div>
	</div>
  </div>      


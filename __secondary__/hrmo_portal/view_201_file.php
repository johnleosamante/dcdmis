<?php 
date_default_timezone_set("Asia/Manila");

if (!is_dir('../../pcdmis/201_files/'.$_GET['c'])) {
    mkdir('../../pcdmis/201_files/'.$_GET['c'], 0777, true);
}
$_SESSION['pathlocation']='../../pcdmis/201_files/'.$_GET['c'];
if(isset($_POST['save_201']))
{
	$query=mysqli_query($con,"SELECt * FROM tbl_201_file WHERE Emp_ID='".$_GET['c']."'");
	if(mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"INSERT INTO tbl_201_file VALUES(NULL,'".date("Y-m-d")."','".$_GET['c']."')");
	}
	if (mysqli_affected_rows($con)==1)
	{
		?>
			<script type="text/javascript">
				$(document).ready(function(){						
				 $('#access').modal({
						show: 'true'
					}); 				
				});
			</script>
								
						 
		<?php   
	}
}
?>
<script>
	
      window.addEventListener("load", function () 
      {
		var ans=0;
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'upload201.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
           width: 500,
           height: 500,
           quality: 90,
          },
          init: 
          {
            PostInit: function () 
            {
              document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files) 
            {
              plupload.each(files, function (file) 
              {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
              uploader.start();
            },
            UploadProgress: function (up, file) 
            {
				
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			  
			 },
            Error: function (up, err) 
            {
              // DO YOUR ERROR HANDLING!
              console.log(err);
            }
          }
        });
        uploader.init();
		 
			 
      });
    </script>    
           <div class="row">
                <div class="col-lg-12">
                   	
					<?php
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['c']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					   echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
					 echo '<h3>Employee ID: '.$_GET['c'].'</h3>';
					 echo '<h3>Employee Name: '.utf8_encode($data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName']).'</h3>';
					 echo '<h3>Station: '.$data['SchoolName'].'</h3>';
					 echo '<h3>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</h3>';
					 $_SESSION['surname']=$data['Emp_LName'];
					 $_SESSION['given']=$data['Emp_FName'];
					 $_SESSION['middle']=mb_strimwidth($data['Emp_MName'],0,1);
					 $_SESSION['birth']=$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'];
					 $_SESSION['place']=$data['Emp_place_of_birth'];
					?>
					<hr/>
                </div>
                <!-- /.col-lg-12 -->
					
                <div class="col-lg-12">
                     
                        <div class="panel-body">
						<?php
                          $dir=$_SESSION['pathlocation']; // Directory where files are stored

								if ($dir_list = opendir($dir))
								{
								while(($filename = readdir($dir_list)) != false)
								{
								?>
								<p><a href="<?php echo $_SESSION['pathlocation'].'/'.$filename; ?>" target="_blank"><?php echo $filename;
								?></a></p>
								<?php
								}
								closedir($dir_list);
								}
							?>
                        </div>
						<form action="" method="POST" >
						 <div id="container">		
						<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-secondary">Choose File to upload</button> </span>		
						<input type="submit" class="btn btn-primary" name="save_201"value="SAVE">	
					</div>
					<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div><br/>
					</form>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				
		


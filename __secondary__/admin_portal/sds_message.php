<?php 
if (!is_dir('../../images/slider/')) {
    mkdir('../../images/slider/', 0777, true);
}
$_SESSION['pathlocation']='../../images/slider/';

?>
<style>
th,td{
	text-transform:uppercase;
}
</style>
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
          url: 'uploadslider.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
            //width: 500,
           // height: 500,
           // quality: 90,
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
			  var location = document.getElementById("loc").value
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			 
			  if ( file.percent==100)
			  {
				
			   document.getElementById("filedata").value =location + file.name;
			  
			  
			  }
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
				<form action="" Method="POST" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       	<input type="submit" name="save" value="SAVE" class="btn btn-success" style="float:right;">					
				      <h4>SDS Messages</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                          <img src="../../images/cordova.png" style="width:300px;400px;padding:4px;margin:4px;" align="left">
						  <label>SDS Name:</label>
						  <label style="width:64%;">
						  <input type="text" name="sdsname" class="form-control"></label>
						  <label>SDS Messages:</label>
						  <textarea class="form-control" name="sdsmessage" rows="30" style="width:70%;padding:4px;margin:4px;text-align:justify;">
						  <?php
						   $sdsmessage=mysqli_query($con,"SELECT * FROM sds_messages");
							$rowmessages=mysqli_fetch_assoc($sdsmessage);
							echo $rowmessages['sds_messages'];
						   ?>						  
						  </textarea>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				</form>
                <!-- /.col-lg-12 -->
            </div>
  
  
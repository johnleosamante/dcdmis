<?php
session_start();

if ($_SESSION['ActType']=='MULTIPLE CHOICE')
{
	if ($_GET['id']=='Text')
	{
		echo '<br/><br/><form action="" Method="POST" enctype="multipart/form-data">
		                <div class="form-group">
                        <div class="form-group input-group">
                            <span class="input-group-addon">A</span>
                            <input type="text" name="A" class="form-control" placeholder="Option A">
                        </div>';
						
                       echo '<div class="form-group input-group">
                            <span class="input-group-addon">B</span>
                            <input type="text" name="B" class="form-control" placeholder="Option B">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">C</span>
                            <input type="text" name="C" class="form-control" placeholder="Option C">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">D</span>
                            <input type="text" name="D" class="form-control" placeholder="Option D">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">E</span>
                            <input type="text" name="E" class="form-control" placeholder="Option E">
                        </div>
						</div><hr/>
						<input type="submit" name="addoption" value="SUBMIT" class="btn btn-primary"></form>';
		
	}else{
		echo '<form action="" Method="POST" enctype="multipart/form-data">
		      <img src="" id="pic" style="width:100%;height:50%;">
			  <input type="file" name="images" onchange="loadFile(event)"><hr/>
			  <input type="submit" name="addimage" value="SAVE" class="btn btn-primary">
			  </form>';
	}
}else{
if ($_GET['id']=='Text')
	{
		echo '<br/><a href="" class="btn btn-primary"> Add Option</a>';
		
	}else{
		echo '<form action="" Method="POST" enctype="multipart/form-data"><br/>
				<img src="" id="pic"><input type="file" name="images" onchange="loadFile(event)"><hr/>
				<input type="submit" name="addoption" value="SUBMIT" class="btn btn-primary">
			  </form>';
	}	
}
?>
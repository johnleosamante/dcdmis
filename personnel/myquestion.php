<?php
session_start();

	if ($_GET['id']=='Text')
	{
		echo '<br/><form action="" Method="POST" enctype="multipart/form-data">
		                <div class="form-group">
                        <div class="form-group input-group">
                            <span class="input-group-addon">'.$_SESSION['ItemNo'].'</span>
                            <textarea name="question" class="form-control" rows="2" placeholder="Type question no. '.$_SESSION['ItemNo'].' "></textarea>
                        </div>                      
						</div><hr/>
						<input type="submit" name="addquestion" value="SUBMIT" class="btn btn-primary"></form>';
		
	}else{
		echo '<form action="" Method="POST" enctype="multipart/form-data">
		      <img src="" id="pic" style="width:100%;height:50%;">
		      <input type="file" name="image" onchange="loadFile(event)"><hr/>
		     <input type="submit" name="addimage" value="SAVE" class="btn btn-primary">
		  </form>';
	}
?>
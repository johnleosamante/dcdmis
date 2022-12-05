  <?php
 if (isset($_POST['searchdata']))
 {
	 $lrn=$_POST['lrn'];
	 $lrn=str_replace(" ","",$lrn);
	 $_SESSION['current_lrn']=$lrn;
	 echo '<script>
				{
					window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")).'";
				}
		</script>';
	
	 
 }elseif(isset($_POST['search']))
 {
	 $query=mysqli_query($con,"SELECT * FROM tbl_student WHERE Lname='".$_POST['family_name']."' AND FName='".$_POST['given_name']."' AND MName='".$_POST['middle_name']."' AND Gender ='".$_POST['sex']."' LIMIT 1");
	 if (mysqli_num_rows($query)<>0)
	 {
		 $rowquery=mysqli_fetch_assoc($query);
	 $lrn=$rowquery['lrn'];
	 $lrn=str_replace(" ","",$lrn);
	 $_SESSION['current_lrn']=$lrn;
	 echo '<script>
				{
					window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")).'";
				}
		</script>';	 
	 }else{
		 $_SESSION['current_lrn']=date("ymds");
		 echo '<script>
				{
					window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")).'";
				}
		</script>'; 
	 }
 }
 ?>
 <div class="wizard" style="margin-bottom: 50px;">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active">
                    <a aria-controls="step1" role="tab" title="Select Learner Name" href="">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="disabled">
                    <a aria-controls="step2" role="tab" title="Search Learner"  href=""
                       onclick="event.preventDefault(); el = document.getElementById('clicked_button_full_name'); el.remove(); document.getElementsByTagName('form')[0].submit() "  >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                    </a>
                </li>
                <li role="presentation" class="disabled">
                    <a   aria-controls="complete" role="tab" title="Educational History" href="#"
                         onclick="event.preventDefault(); el = document.getElementById('enrol_date_form_continue'); el.remove();  document.getElementsByTagName('form')[0].submit() "                        >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                    </a>
                </li>

                 <li role="presentation" class="disabled">
                    <a   aria-controls="step3" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
	
	<div class="row">
	 <div class="col-lg-3"></div>
	 <div class="col-lg-4" style="padding:10px;">
           <form action="" Method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">SEARCH BY LRN</div>
					
                    <div class="list-group">
                                <div class="list-group-item">

                                    <label class="control-label required" for="search_form_lrn">LEARNER REFERENCE NUMBER:</label>
                                    <div class="form-group " >
										<input type="text" name="lrn" required class="form-control" autofocus style="text-align:center;"/><hr/>
                                       <span class="input-group-btn">
									   <input type="submit" name="searchdata" class="btn btn-primary" value="Search">
									   </span>
									</div>
                                </div>
                    </div>
					
                </div>
				</form>
            </div>
		<div class="col-lg-4" style="padding:10px;">
           
                <div class="panel panel-default">
                    <div class="panel-heading">SEARCH BY LEARNER NAME</div>
					<form action="" Method="POST" enctype="multipart/form-data">
                    <div class="list-group">
                                <div class="list-group-item">

                                
                                    <div class="form-group">
									  <label class="control-label required" for="search_form_lrn">FAMILY NAME</label>
                                      <input type="text" name="family_name" required class="form-control"/><br/>
									 <label class="control-label required" for="search_form_lrn">GIVEN NAME</label>
                                      <input type="text" name="given_name" required class="form-control"/><br/>
									   <label class="control-label required" for="search_form_lrn">MIDDLE NAME</label>
                                      <input type="text" name="middle_name" required class="form-control"/><br/>
									   <label class="control-label required" for="search_form_lrn">SEX</label>
                                      <select name="sex" required class="form-control"/>
										<option value="">--Select--</option>
										<option value="MALE">MALE</option>
										<option value="FEMALE">FEMALE</option>
									  </select>
									  <hr/>
									 
                                       <span class="input-group-btn">
									   <input type="submit" name="search" class="btn btn-primary" value="Search">
									   </span>
									   
									</div>
                                </div>
                               </div>
							   
							   </form>
					
               
                </div>
            </div>
        </div>
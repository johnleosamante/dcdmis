<div class="col-lg-6" style="float:right;">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						          		<h4>Quick Responce Output</h4>		 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;height:300px;">
											  <?php
													require('../pcdmis/code128.php');
													if(isset($_POST['QR_GEN']))
													{

													$pdf=new PDF_Code128('P','mm','Letter');

													//set it to writable location, a place for temp generated PNG files
														$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
														//html PNG location prefix
														$PNG_WEB_DIR = 'temp/';
														include "../pcdmis/qrlib.php";    
														//ofcourse we need rights to create temp dir
														if (!file_exists($PNG_TEMP_DIR))
															mkdir($PNG_TEMP_DIR);
														$finame = $PNG_TEMP_DIR.$_POST['codenumber'].'.png';
														//remember to sanitize user input in real-life solution !!!
														$errorCorrectionLevel = 'L';
														$matrixPointSize = 5;
													   $_REQUEST['data']=$_POST['codenumber'];
														if (isset($_REQUEST['data'])) {        
															// user data
															$finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
															QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
														} else {    
															QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
														}    

													$img3=$PNG_WEB_DIR.basename($finame);

													echo '<img src="'.$img3.'" title="'.$_POST['codenumber'].'">';
													}
													?>
											</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-6">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						          		<h4>Quick Responce Generator</h4>		 
                                     </div>
									    <form action="" method="POST" enctype="multipart/form-data">
											<!-- /.panel-heading -->
											<div class="panel-body">
											  <label>Enter Code number:</label>
											  <input type="text" name="codenumber" placeholder="Enter a code" class="form-control"><hr/>
											   <input name="QR_GEN" type="submit" class="btn btn-success" style="float:right;" value="Generate">
											</div>
											
											  
											
										</form>	
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
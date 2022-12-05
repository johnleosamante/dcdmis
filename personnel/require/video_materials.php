<?php
echo '<div class="col-lg-8">';
   	// echo '<video  autoplay loop id="myVideo" style="width:100%;height:450px;"> <source src="../../files/videos/DPEK 3-8-21 Science 8.mp4" type="video/mp4">Your browser does not support HTML5 video.</video>';
		echo '<iframe width="100%" height="400" src="https://www.youtube.com/embed/38XyBuC6KuM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
echo '<hr/><label>Preschool Learning Videos for 3 Year Olds | Kids Learning Videos | Educational Videos For Kids</label>
<button id="myBtn" onclick="myFunction()" style="float:right;" class="btn btn-success">Pause</button>

</div>

<div class="col-lg-4">
<div class="panel panel-default">
<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&SubNo='.urlencode(base64_encode($_SESSION['SubCode'])).'&SecCode='.urlencode(base64_encode($_SESSION['SecCode'])).'&v='.urlencode(base64_encode("class_list")).'" style="float:right;" class="btn btn-secondary">Back</a>
		
        <div class="panel-heading">
		 Video Materials Available
         </div>
																
			<div class="panel-body" style="overflow-x:auto;">
			<a href="#newvideo" class="btn btn-info" style="float:right;" data-toggle="modal">Upload Video</a>
			  <a href=""><video src="../../files/videos/DEPEK 3-13-21 Science 7.mp4" style="width:100%;height:150px;padding:4px;margin:4px;"></video></a>
			  <a href=""><video src="../../files/videos/DPEK 3-8-21 Grade 1 Math.mp4" style="width:100%;height:150px;padding:4px;margin:4px;"></video></a>
			</div>
</div>
</div>';
?>


<script>
var video = document.getElementById("myVideo");
var btn = document.getElementById("myBtn");

function myFunction() {
  if (video.paused) {
    video.play();
    btn.innerHTML = "Pause";
  } else {
    video.pause();
    btn.innerHTML = "Play";
  }
}
</script>
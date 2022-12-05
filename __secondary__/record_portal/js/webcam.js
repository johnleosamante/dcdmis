var video =document.getElementById('video');
			vendorURL =window.URL || window.webkitURL;
		navigator.getUserMedia= navigator.getUserMedia || navigator.webkitUserMedia || navigator.mozUserMedia || navigator.msUserMedia;
						
		navigator.mediaDevices.getUserMedia({
							audio: true,
							video: true
							
							})
							.then (stream=>{
							
							document.getElementById("vid").srcObject=stream;
													
							})
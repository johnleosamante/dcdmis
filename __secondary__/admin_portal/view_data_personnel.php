<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
	<h4 class="modal-title text-center">ACCOUNT SELECTION</h4>
</div>
<?php

foreach ($_GET as $key => $data) {
	$uid = $_GET[$key] = base64_decode(urldecode($data));
}
echo  '<div class="modal-body">
			<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=' . urlencode(base64_encode($uid)) . '&v=' . urlencode(base64_encode("mydate")) . '"target="_blank""><h4>VIEW DAILY TIME RECORDS</h4></a>		
			<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=' . urlencode(base64_encode($uid)) . '&v=' . urlencode(base64_encode("deployment_history")) . '"><h4>DEPLOYMENT RECORDS</h4></a>		
			<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=' . urlencode(base64_encode($uid)) . '&v=' . urlencode(base64_encode("account_history")) . '"><h4>ACCOUNT RECORDS</h4></a>		
				</div>';
?>
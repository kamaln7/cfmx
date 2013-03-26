<?php
require('lib/class_cloudflare.php');

if(isset($_POST['email'], $_POST['key'])){
	if(empty($_POST['email']))
		die(json_encode(['status' => 'false', 'message' => 'Empty email.']));

	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		die(json_encode(['status' => 'false', 'message' => 'Invalid email.']));

	if(empty($_POST['key']))
		die(json_encode(['status' => 'false', 'message' => 'Empty token.']));

	$cf = new cloudflare_api($_POST['email'], $_POST['key']);
	$zones = $cf->zone_list();
	
	if($zones == false)
		echo json_encode(['status' => 'false', 'message' => 'Invalid token or email.']);
	else
		echo json_encode(['status' => 'true', 'zones' => $zones]);
}

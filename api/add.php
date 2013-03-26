<?php
require('lib/class_cloudflare.php');

if(isset($_POST['email'], $_POST['key'], $_POST['domain'])){
	if(empty($_POST['email']))
		die(json_encode(['status' => 'false', 'message' => 'Empty email.']));

	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		die(json_encode(['status' => 'false', 'message' => 'Invalid email.']));

	if(empty($_POST['key']))
		die(json_encode(['status' => 'false', 'message' => 'Empty token.']));

	if(empty($_POST['domain']))
		die(json_encode(['status' => 'false', 'message' => 'Empty domain.']));


	$cf = new cloudflare_api($_POST['email'], $_POST['key']);
	$recs = [
		[
			'content' => 'ASPMX.L.GOOGLE.COM',
			'prio' => 1
		],
		[
			'content' => 'ALT1.ASPMX.L.GOOGLE.COM',
			'prio' => 5
		],
		[
			'content' => 'ALT2.ASPMX.L.GOOGLE.COM',
			'prio' => 5
		],
		[
			'content' => 'ASPMX2.GOOGLEMAIL.COM',
			'prio' => 10
		],
		[
			'content' => 'ASPMX3.GOOGLEMAIL.COM',
			'prio' => 10
		],
	];

	foreach($recs as $rec){
		$add = $cf->add_mx_record($_POST['domain'], $rec['content'], $rec['prio']);
		if($add == false || $add->result != 'success'){
			die(json_encode(['status' => false, 'message' => $add->msg]));
		}
	}

	echo json_encode(['status' => true]);
}

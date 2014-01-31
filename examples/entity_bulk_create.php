<?php

require_once '_helper.php';

$client = getClient();

$params = array(
	'type_name'  => (isset($_REQUEST['type_name'])) ? $_REQUEST['type_name'] : 'user',
	'all_attributes' => array(
		array(
			'familyName' => 'Test',
			'givenName'  => 'First',
			'email'      => 'test.first@example.com',
		),
		array(
			'familyName' => 'Test',
			'givenName'  => 'Second',
			'email'      => 'test.second@example.com',
		),
	),
);
$result = $client->api('entity')->bulkCreate($params);

printf('<pre>%s</pre>', print_r($result, true));
